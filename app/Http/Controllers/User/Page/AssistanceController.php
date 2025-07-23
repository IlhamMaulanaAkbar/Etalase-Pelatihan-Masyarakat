<?php

namespace App\Http\Controllers\User\Page;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Assistance;
use App\Models\Training;
use App\Models\AssistanceUser;
use App\Services\Supports\Alert;
use Illuminate\Support\Facades\Storage;

class AssistanceController extends Controller
{
    public function index(Request $request)
    {        
        $query = Assistance::with('training')->orderBy('created_at', 'desc');

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by date
        if ($request->filled('date')) {
            $query->whereDate('start_date', $request->date);
        }

        // Filter by keyword
        if ($request->filled('keyword')) {
            $query->where(function ($q) use ($request) {
                $q->where('assistance_name', 'like', '%' . $request->keyword . '%')
                    ->orWhere('location', 'like', '%' . $request->keyword . '%');
            });
        }

        // Fetch filtered data and paginate
        $assistances = $query->paginate(9)->withQueryString();

        return view('public.assistance.index', [
            'assistances' => $assistances,
        ]);
    }


}
