<?php

namespace App\Http\Controllers\Auth\Internal;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Services\Supports\Alert;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function index()
    {
        return view('auth.internal.register.index');
    }

    public function store(Request $request)
    {
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->role = 'internal';

        $user->save();
        Alert::success('Pendaftaran berhasil. Silahkan masuk menggunakan email dan kata sandi yang telah dibuat.');
        return redirect()->route('auth.internal.login.index');
    }
}
