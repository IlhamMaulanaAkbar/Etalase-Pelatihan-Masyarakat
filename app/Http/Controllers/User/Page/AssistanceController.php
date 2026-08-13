<?php

namespace App\Http\Controllers\User\Page;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Assistance;
use App\Models\Training;
use App\Models\AssistanceUser;
use App\Models\AssistanceAttendance;
use App\Models\AssistanceSchedule;
use App\Services\Supports\Alert;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Carbon\Carbon;

class AssistanceController extends Controller
{
    public function index(Request $request)
    {
        $query = Assistance::with('training')->orderBy('created_at', 'desc');

        // Filter Keyword
        switch ($request->sort) {
            case 'oldest':
                $query->orderBy('start_date', 'asc');
                break;
            case 'az':
                $query->orderBy('assistance_name', 'asc');
                break;
            default:
                $query->orderBy('start_date', 'desc');
                break;
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by date
        if ($request->filled('date')) {
            $query->whereDate('start_date', $request->date);
        }

        // Filter by keyword
        if ($request->filled('keyword')) {
            $query->where(function ($q) use ($request) {
                $q->where('assistance_name', 'like', '%' . $request->keyword . '%')
                    ->orWhere('location', 'like', '%' . $request->keyword . '%');
            });
        }

        // Fetch filtered data and paginate
        $assistances = $query->paginate(9)->withQueryString();

        return view('public.assistance.index', [
            'assistances' => $assistances,
        ]);
    }

    public function show(Request $request, Assistance $assistance)
    {
        $user = Auth::guard('user')->user();

        $assistance->load(['training', 'assistance_users']);

        $schedules = $assistance->assistanceSchedules()
            ->orderBy('meeting_number')
            ->orderBy('date')
            ->get();

        $schedules->each(function ($schedule) use ($assistance) {
            $this->markMissingAttendancesAsAbsent($assistance, $schedule);
        });

        $totalJp = $schedules->sum('duration');
        $isAcceptedParticipant = false;
        $attendancesBySchedule = collect();
        $attendanceWindows = $schedules->mapWithKeys(function ($schedule) {
            return [$schedule->id => $this->attendanceWindow($schedule)];
        });

        if ($user) {
            $isAcceptedParticipant = AssistanceUser::where('assistance_id', $assistance->id)
                ->where('user_id', $user->id)
                ->where('status', 'LULUS')
                ->exists();

            $attendancesBySchedule = AssistanceAttendance::where('assistance_id', $assistance->id)
                ->where('participant_name', $user->name)
                ->get()
                ->keyBy('assistance_schedule_id');
        }

        $acceptedParticipants = AssistanceUser::with('user')->where('assistance_id', $assistance->id)->where('status', 'LULUS')->paginate(10);

        if (request()->ajax()) {
            return response()->json([
                'html' => view('public.assistance.participants', compact('acceptedParticipants'))->render()
            ]);
        }

        $sessionKey = 'viewed_assistance_' . $assistance->id;

        if (!session()->has($sessionKey)) {
            $assistance->increment('views');
            session()->put($sessionKey, true);
        }

        return view('public.assistance.show', compact(
            'assistance',
            'user',
            'acceptedParticipants',
            'schedules',
            'totalJp',
            'isAcceptedParticipant',
            'attendancesBySchedule',
            'attendanceWindows'
        ));
    }

    public function storeAttendance(Request $request, Assistance $assistance, AssistanceSchedule $schedule)
    {
        abort_if($schedule->assistance_id !== $assistance->id, 404);

        $request->validate([
            'status' => ['required', Rule::in(['Hadir', 'Izin', 'Sakit', 'Tidak Hadir'])],
            'note' => ['nullable', 'string', 'max:1000'],
        ]);

        $user = Auth::guard('user')->user();

        $isAcceptedParticipant = AssistanceUser::where('assistance_id', $assistance->id)
            ->where('user_id', $user->id)
            ->where('status', 'LULUS')
            ->exists();

        if (!$isAcceptedParticipant) {
            Alert::error('Anda belum dinyatakan lulus sebagai peserta pendampingan ini.');
            return back();
        }

        $attendanceWindow = $this->attendanceWindow($schedule);

        if (!$attendanceWindow['is_open']) {
            $this->markMissingAttendancesAsAbsent($assistance, $schedule);

            Alert::warning('Absensi hanya dibuka sesuai waktu pertemuan pendampingan.');
            return back()->withFragment('silabus');
        }

        $attendanceExists = AssistanceAttendance::where('assistance_id', $assistance->id)
            ->where('assistance_schedule_id', $schedule->id)
            ->where('participant_name', $user->name)
            ->exists();

        if ($attendanceExists) {
            Alert::warning('Anda sudah melakukan absensi untuk pertemuan ini.');
            return back()->withFragment('silabus');
        }

        AssistanceAttendance::create([
            'assistance_id' => $assistance->id,
            'assistance_schedule_id' => $schedule->id,
            'participant_name' => $user->name,
            'status' => $request->status,
            'attendance_time' => now()->format('H:i:s'),
            'note' => $request->note,
        ]);

        Alert::success('Absensi pendampingan berhasil disimpan.');
        return back()->withFragment('silabus');
    }

    public function register(Request $request, Assistance $assistance)
    {
        $user = Auth::guard('user')->user();

        if (AssistanceUser::where('assistance_id', $assistance->id)->where('user_id', $user->id)->exists()) {
            return back()->with(Alert::error('Anda sudah terdaftar di pendampingan ini.'));
        }

        $assistance_id_padded = str_pad($assistance->id, 8, '0', STR_PAD_LEFT);
        $user_id_padded = str_pad($user->id, 4, '0', STR_PAD_LEFT);
        $no_reg = 'PDM-' . $assistance_id_padded . '-' . $user_id_padded;

        AssistanceUser::create([
            'assistance_id' => $assistance->id,
            'user_id' => $user->id,
            'registration_number' => $no_reg,
            'status' => 'DAFTAR',
            'is_approved' => false,
        ]);

        session(['success_access_assistance_id' => $assistance->id]);
        Carbon::setLocale('id');
        session()->push('admin_notifications', [
            'type' => 'assistance_registration',
            'user_id' => $user->id,
            'user_name' => $user->name,
            'user_photo' => $user->photo,
            'assistance_name' => $assistance->assistance_name,
            'time' => now()->translatedFormat('d F Y H:i'),
        ]);

        return redirect()->route('public.assistance.success', ['assistance' => $assistance->id]);
    }

    public function destroy(AssistanceUser $assistanceUser)
    {
        $assistanceUser->status = 'BATAL';
        $assistanceUser->save();

        return redirect()->back()->with('success', 'Pendaftaran berhasil dibatalkan.');
    }

    public function success(Assistance $assistance)
    {
        $user = Auth::guard('user')->user();

        if (!$user || session('success_access_assistance_id') !== $assistance->id) {
            abort(403, 'Akses ditolak.');
        }

        if (!AssistanceUser::where('assistance_id', $assistance->id)->where('user_id', $user->id)->exists()) {
            abort(403, 'Anda tidak terdaftar di pendampingan ini.');
        }

        session()->forget('success_access_assistance_id');

        return view('public.assistance.success', [
            'assistance' => $assistance,
        ]);
    }

    private function attendanceWindow(AssistanceSchedule $schedule): array
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

    private function markMissingAttendancesAsAbsent(Assistance $assistance, AssistanceSchedule $schedule): void
    {
        if (!$this->attendanceWindow($schedule)['has_ended']) {
            return;
        }

        $participants = AssistanceUser::with('user')
            ->where('assistance_id', $assistance->id)
            ->where('status', 'LULUS')
            ->get();

        foreach ($participants as $participant) {
            if (!$participant->user) {
                continue;
            }

            AssistanceAttendance::firstOrCreate(
                [
                    'assistance_id' => $assistance->id,
                    'assistance_schedule_id' => $schedule->id,
                    'participant_name' => $participant->user->name,
                ],
                [
                    'status' => 'Tidak Hadir',
                    'attendance_time' => null,
                    'note' => 'Otomatis tidak hadir karena tidak melakukan absensi sampai jam pendampingan berakhir.',
                ]
            );
        }
    }
}
