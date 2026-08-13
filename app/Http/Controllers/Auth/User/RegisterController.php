<?php

namespace App\Http\Controllers\Auth\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Services\Supports\Alert;

class RegisterController extends Controller
{
    public function index()
    {
        return view('auth.user.register.index');
    }

    public function store(Request $request)
    {
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->role = 'user';

        $user->save();

        Alert::success('Pendaftaran berhasil. Silahkan masuk menggunakan email dan kata sandi yang telah dibuat.');
        return redirect()->route('auth.user.login.index');
    }
}
