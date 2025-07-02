<?php

namespace App\Http\Controllers\User\Account;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index(Request $request)
    {
        // Ambil data user yang sedang login
        $user = $request->user();

        // Kembalikan view dengan data user
        return view('public.account.profile.index', [
            'user' => $user,
        ]);
    }
}
