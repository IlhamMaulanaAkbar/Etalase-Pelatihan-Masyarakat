<?php

namespace App\Http\Controllers\User\Page;

use App\Http\Controllers\Controller;
use App\Models\Training;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Str;
use App\Models\TrainingAttendance;
use App\Models\TrainingSchedule;
use App\Models\TrainingUser;
use App\Services\Supports\Alert;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\TrainingRegistrationMail;


class TrainingController extends Controller
{
    public function index(Request $request)
    {

        $query = Training::with('category')->orderBy('created_at', 'desc');

        // Filter berdasarkan kategori
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Filter berdasarkan status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter berdasarkan tanggal
        if ($request->filled('date')) {
            $query->whereDate('start_date', $request->date); // ganti 'start_date' sesuai kolom di DB-mu
        }

        // Filter berdasarkan kata kunci
        if ($request->filled('keyword')) {
            $query->where(function ($q) use ($request) {
                $q->where('training_name', 'like', '%' . $request->keyword . '%')
                    ->orWhere('location', 'like', '%' . $request->keyword . '%');
            });
        }

        // Ambil data terfilter dan paginate
        $trainings = $query->paginate(9)->withQueryString(); // withQueryString agar paginasi tetap membawa parameter filter

        // Ambil data kategori untuk dropdown
        $categorys = Category::select('id', 'name')->get();


        return view(
            'public.training.index',
            [
                'trainings' => $trainings,
                'categorys' => $categorys,
            ]
        );
    }

    public function show(Training $training)
    {
        $user = Auth::guard('user')->user();

        $training->load(['category', 'training_users']); // tidak perlu eager-load semua

        $schedules = $training->trainingSchedules()
            ->orderBy('meeting_number')
            ->orderBy('date')
            ->get();

        $schedules->each(function ($schedule) use ($training) {
            $this->markMissingAttendancesAsAbsent($training, $schedule);
        });

        $totalJp = $schedules->sum('duration');
        $isAcceptedParticipant = false;
        $attendancesBySchedule = collect();
        $attendanceWindows = $schedules->mapWithKeys(function ($schedule) {
            return [$schedule->id => $this->attendanceWindow($schedule)];
        });

        if ($user) {
            $isAcceptedParticipant = TrainingUser::where('training_id', $training->id)
                ->where('user_id', $user->id)
                ->where('status', 'LULUS')
                ->exists();

            $attendancesBySchedule = TrainingAttendance::where('training_id', $training->id)
                ->where('participant_name', $user->name)
                ->get()
                ->keyBy('training_schedule_id');
        }

        $acceptedParticipants = TrainingUser::with('user')
            ->where('training_id', $training->id)
            ->where('status', 'LULUS')
            ->paginate(10); // Sesuaikan jumlah per halaman

        if (request()->ajax()) {
            return response()->json([
                'html' => view('public.training.participants', compact('acceptedParticipants'))->render()
            ]);
        }

        // Gunakan session untuk mencegah duplikat hit dari user yang sama
        $sessionKey = 'viewed_training_' . $training->id;

        if (!session()->has($sessionKey)) {
            $training->increment('views');
            session()->put($sessionKey, true);
        }

        return view('public.training.show', compact(
            'training',
            'user',
            'acceptedParticipants',
            'schedules',
            'totalJp',
            'isAcceptedParticipant',
            'attendancesBySchedule',
            'attendanceWindows'
        ));
    }

    public function storeAttendance(Request $request, Training $training, TrainingSchedule $schedule)
    {
        abort_if($schedule->training_id !== $training->id, 404);

        $request->validate([
            'status' => ['required', Rule::in(['Hadir', 'Izin', 'Sakit', 'Tidak Hadir'])],
            'note' => ['nullable', 'string', 'max:1000'],
        ]);

        $user = Auth::guard('user')->user();

        $isAcceptedParticipant = TrainingUser::where('training_id', $training->id)
            ->where('user_id', $user->id)
            ->where('status', 'LULUS')
            ->exists();

        if (!$isAcceptedParticipant) {
            Alert::error('Anda belum dinyatakan lulus sebagai peserta pelatihan ini.');
            return back();
        }

        $attendanceWindow = $this->attendanceWindow($schedule);

        if (!$attendanceWindow['is_open']) {
            $this->markMissingAttendancesAsAbsent($training, $schedule);

            Alert::warning('Absensi hanya dibuka sesuai waktu pertemuan.');
            return back()->withFragment('silabus');
        }

        $attendanceExists = TrainingAttendance::where('training_id', $training->id)
            ->where('training_schedule_id', $schedule->id)
            ->where('participant_name', $user->name)
            ->exists();

        if ($attendanceExists) {
            Alert::warning('Anda sudah melakukan absensi untuk pertemuan ini.');
            return back()->withFragment('silabus');
        }

        TrainingAttendance::create([
            'training_id' => $training->id,
            'training_schedule_id' => $schedule->id,
            'participant_name' => $user->name,
            'status' => $request->status,
            'attendance_time' => now()->format('H:i:s'),
            'note' => $request->note,
        ]);

        Alert::success('Absensi berhasil disimpan.');
        return back()->withFragment('silabus');
    }

    private function attendanceWindow(TrainingSchedule $schedule): array
    {
        $startsAt = Carbon::parse($schedule->date->format('Y-m-d') . ' ' . $schedule->start_time);
        $endsAt = Carbon::parse($schedule->date->format('Y-m-d') . ' ' . $schedule->end_time);
        $now = now();

        return [
            'starts_at' => $startsAt,
            'ends_at' => $endsAt,
            'is_open' => $now->betweenIncluded($startsAt, $endsAt),
            'has_started' => $now->gte($startsAt),
            'has_ended' => $now->gt($endsAt),
        ];
    }

    private function markMissingAttendancesAsAbsent(Training $training, TrainingSchedule $schedule): void
    {
        if (!$this->attendanceWindow($schedule)['has_ended']) {
            return;
        }

        $participants = TrainingUser::with('user')
            ->where('training_id', $training->id)
            ->where('status', 'LULUS')
            ->get();

        foreach ($participants as $participant) {
            if (!$participant->user) {
                continue;
            }

            TrainingAttendance::firstOrCreate(
                [
                    'training_id' => $training->id,
                    'training_schedule_id' => $schedule->id,
                    'participant_name' => $participant->user->name,
                ],
                [
                    'status' => 'Tidak Hadir',
                    'attendance_time' => null,
                    'note' => 'Otomatis tidak hadir karena tidak melakukan absensi sampai jam pelajaran berakhir.',
                ]
            );
        }
    }

    public function register(Request $request, Training $training)
    {
        $user = Auth::guard('user')->user();

        // Validasi file
        $request->validate([
            'letter_statement' => 'required|file|mimes:pdf|max:2048',
            'letter_recommendation' => 'required|file|mimes:pdf|max:2048',
            'komitmen_check' => 'required'
        ], [
            'letter_statement.max' => 'File surat pernyataan tidak boleh lebih dari 2MB.',
            'letter_recommendation.max' => 'File surat rekomendasi tidak boleh lebih dari 2MB.',
        ]);

        // Cek duplikat
        if (TrainingUser::where('user_id', $user->id)->where('training_id', $training->id)->exists()) {
            return back()->with(Alert::error('Anda sudah mendaftar pelatihan ini.'));
        }

        // Simpan file
        $statementPath = $request->file('letter_statement')->store('letters', 'public');
        $recommendationPath = $request->file('letter_recommendation')->store('letters', 'public');

        // Buat no registrasi
        $training_id_padded = str_pad($training->id, 8, '0', STR_PAD_LEFT);
        $user_id_padded = str_pad($user->id, 4, '0', STR_PAD_LEFT);
        $no_reg = 'PLT-' . $training_id_padded . '-' . $user_id_padded;

        // Simpan ke database
        TrainingUser::create([
            'user_id' => $user->id,
            'training_id' => $training->id,
            'registration_number' => $no_reg,
            'status' => 'DAFTAR',
            'is_approved' => false,
            'letter_statement' => $statementPath,
            'letter_recommendation' => $recommendationPath,
        ]);

        Mail::to($user->email)->queue(new TrainingRegistrationMail($user, $training, $no_reg));

        session(['success_access_training_id' => $training->id]);

        Carbon::setLocale('id');
        session()->push('admin_notifications', [
            'type' => 'training_registration',
            'user_id' => $user->id,
            'user_name' => $user->name,
            'user_photo' => $user->photo,
            'training_name' => $training->training_name,
            'time' => Carbon::now()->translatedFormat('d F Y H:i'),
        ]);

        return redirect()->route('public.training.success', ['training' => $training->id]);
    }

    public function destroy(TrainingUser $trainingUser)
    {
        $trainingUser->status = 'BATAL';
        $trainingUser->save();

        return redirect()->back()->with('success', 'Pendaftaran berhasil dibatalkan.');
    }

    public function success(Training $training)
    {
        $user = Auth::guard('user')->user();

        // Cegah akses jika belum login atau session tidak sesuai
        if (!$user || session('success_access_training_id') !== $training->id) {
            abort(403, 'Akses ditolak.');
        }

        // Tambahan: Cek apakah user benar-benar sudah mendaftar
        if (!TrainingUser::where('user_id', $user->id)->where('training_id', $training->id)->exists()) {
            abort(403, 'Akses ditolak.');
        }

        // Hapus session agar tidak bisa akses ulang
        session()->forget('success_access_training_id');

        return view('public.training.success', [
            'training' => $training,
        ]);
    }
}
