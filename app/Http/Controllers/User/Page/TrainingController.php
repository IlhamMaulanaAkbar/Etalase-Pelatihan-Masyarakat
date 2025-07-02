<?php

namespace App\Http\Controllers\User\Page;

use App\Http\Controllers\Controller;
use App\Models\Training;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Str;

class TrainingController extends Controller
{
    public function index(Request $request)
    {

        $query = Training::with('category');

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
        $training->load('category'); // load relasi langsung

        $sessionKey = 'viewed_training_' . $training->id;

        if (!session()->has($sessionKey)) {
            $training->increment('views');
            session()->put($sessionKey, true);
        }

        return view('public.training.show', [
            'training' => $training,
        ]);
    }
}
