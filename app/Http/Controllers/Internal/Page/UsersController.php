<?php

namespace App\Http\Controllers\Internal\Page;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UsersController extends Controller
{
    public function index()
    {
        // Ambil user yang memiliki relasi ke training_users dan berperan sebagai 'user'
        $users = User::where('role', 'user')
            ->get();
            // ->whereHas('training_users')
            // ->with('training_users.training')
            // ->with('assistance_users.assistance')
            // ->get();

        return view('internal.users.index', compact('users'));
    }
}
