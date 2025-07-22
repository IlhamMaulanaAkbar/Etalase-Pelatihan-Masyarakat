<?php

namespace App\Http\Controllers\User\Home;

use App\Http\Controllers\Controller;
use App\Models\Learning;
use Illuminate\Http\Request;
use App\Models\Training;
use App\Models\User;
use App\Models\Category;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $trainings = Training::with('category')
            ->orderBy('created_at', 'desc')
            ->paginate(8);

        $totalTrainings = Training::count();
        $totalLearnings = Learning::count();
        $totalUsers = User::where('role', 'user')->count();

        $categorys = Category::select('id', 'name')->get();
        return view('public.home.dashboard.index', [
            'trainings' => $trainings,
            'categorys' => $categorys,
            'totalTrainings' => $totalTrainings,
            'totalLearnings' => $totalLearnings,
            'totalUsers' => $totalUsers,
        ]);
    }
}
