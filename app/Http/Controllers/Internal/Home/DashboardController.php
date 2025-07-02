<?php

namespace App\Http\Controllers\Internal\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        return view('internal.home.dashboard.index');
    }
}
