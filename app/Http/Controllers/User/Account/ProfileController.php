<?php

namespace App\Http\Controllers\User\Account;

use App\Http\Controllers\Controller;
use App\Models\Training;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\TrainingUser;
use App\Models\User;

class ProfileController extends Controller
{
    public function index(Request $request, Training $training)
    {
        $user = $request->user();

        // Ambil data pendaftaran pelatihan user yang statusnya "DAFTAR"
        $trainingUser = $user->training_users()
            ->with('training') // jika ingin akses data pelatihan terkait
            ->where('status', 'DAFTAR')
            ->get();

        return view('public.account.profile.index', [
            'user' => $user,
            'trainingUser' => $trainingUser,
        ]);
    }


    public function update(Request $request)
    {
        $user = $request->user();

        // Kunci agar field hanya bisa diisi sekali
        $request->merge([
            'name' => $user->name ?? $request->name,
            'email' => $user->email ?? $request->email,
            'phone' => $user->phone ?? $request->phone,
            'gender' => $user->gender ?? $request->gender,
            'date_of_birth' => $user->date_of_birth ?? $request->date_of_birth,
        ]);

        // Validasi
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:255',
            'gender' => 'nullable|in:Laki-laki,Perempuan',
            'date_of_birth' => 'nullable|date',
            'place_of_birth' => 'nullable|string|max:255',
            'province' => 'nullable|string|max:128',
            'city' => 'nullable|string|max:128',
            'district' => 'nullable|string|max:128',
            'village' => 'nullable|string|max:255',
            'job' => 'nullable|string|max:128',
            'education' => 'nullable|string|max:128',
            'education_institutions' => 'nullable|string|max:255',
            'religion' => 'nullable|string|max:128',
            'photo' => 'nullable|image|max:2048',
        ]);

        // Update user
        $user->update($validated);

        return redirect()->back()->with('success', 'Profil berhasil diperbarui.');
    }
}
