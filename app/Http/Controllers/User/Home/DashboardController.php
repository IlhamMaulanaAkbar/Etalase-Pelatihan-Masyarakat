<?php

namespace App\Http\Controllers\User\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Training;
use App\Models\Category;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $trainings = Training::with('category')
            ->orderBy('created_at', 'desc')
            ->paginate(8);

        $categorys = Category::select('id', 'name')->get();
        return view('public.home.dashboard.index', [
            'trainings' => $trainings,
            'categorys' => $categorys,
        ]);
    }
}
