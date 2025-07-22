<?php

namespace App\Http\Controllers\User\Page;

use App\Http\Controllers\Controller;
use App\Models\Training;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Str;
use App\Models\TrainingUser;
use App\Services\Supports\Alert;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;


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

        $training->load('category'); // tidak perlu eager-load semua

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

        return view('public.training.show', compact('training', 'user', 'acceptedParticipants'));
    }

    public function register(Request $request, Training $training)
    {
        $user = Auth::guard('user')->user();

        // Validasi file
        $request->validate([
            'letter_statement' => 'required|file|mimes:pdf|max:2048',
            'letter_recommendation' => 'required|file|mimes:pdf|max:2048',
            'komitmen_check' => 'required'
        ]);

        // Cek duplikat
        if (TrainingUser::where('user_id', $user->id)->where('training_id', $training->id)->exists()) {
            return back()->with(Alert::error('Anda sudah mendaftar pelatihan ini.'));
        }

        // Simpan file
        $statementPath = $request->file('letter_statement')->store('letters', 'public');
        $recommendationPath = $request->file('letter_recommendation')->store('letters', 'public');

        // Buat no registrasi
        $training_id_padded = str_pad($training->id, 8, '1', STR_PAD_LEFT);
        $user_id_padded = str_pad($user->id, 4, '0', STR_PAD_LEFT);
        $no_reg = 'UID-' . $training_id_padded . '-' . $user_id_padded;

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

        session(['success_access_training_id' => $training->id]);

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
