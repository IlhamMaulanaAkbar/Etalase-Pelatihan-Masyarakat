<?php

namespace App\Http\Controllers\Internal\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;

class UsersReportController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('role', 'user')
            ->whereHas('training_users')
            ->with('training_users.training')
            ->with('assistance_users.assistance');

        // Filter by year
        if ($request->filled('year')) {
            $query->whereYear('created_at', $request->year);
        }

        // Filter by month
        if ($request->filled('month')) {
            $query->whereMonth('created_at', $request->month);
        }

        $users = $query->get();
        $years = User::selectRaw('YEAR(created_at) as year')
            ->distinct()
            ->pluck('year');

        return view('internal.report.users-report.index', [
            'users' => $users,
            'years' => $years,
        ]);
    }

    public function print(Request $request)
    {
        $query = User::where('role', 'user');
            // ->whereHas('training_users')
            // ->with('training_users.training')
            // ->with('assistance_users.assistance');

        if ($request->filled('year')) {
            $query->whereYear('created_at', $request->year);
        }

        if ($request->filled('month')) {
            $query->whereMonth('created_at', $request->month);
        }

        $users = $query->get();
        $years = User::selectRaw('YEAR(created_at) as year')
            ->distinct()
            ->pluck('year');

        $pdf = Pdf::loadView('internal.report.users-report.print', [
            'users' => $users,
            'years' => $years,
        ])->setPaper('a4', 'landscape');
        return $pdf->stream('users-report.pdf');
    }
}
