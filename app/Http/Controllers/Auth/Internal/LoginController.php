<?php

namespace App\Http\Controllers\Auth\Internal;

use App\Http\Controllers\Controller;
use App\Services\Supports\Alert;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use function Laravel\Prompts\alert;

class LoginController extends Controller
{
    public function index()
    {
        return view('auth.internal.login.index');
    }

    public function store(Request $request)
    {
        $data = $request->only('email', 'password');

        if (Auth::guard('internal')->attempt($data)) {
            $request->session()->regenerate();
            Alert::success('Selamat datang, ' . auth('internal')->user()->name . '.');
            return redirect()->intended(route('internal.home.dashboard.index', absolute: false));
        } else {
            Alert::error('Email atau password salah.');
            return back();
        }
    }

    public function destroy(Request $request)
    {
        Auth::guard('internal')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        Alert::success('Berhasil logout.');
        return to_route('auth.internal.login.index');
    }
}
