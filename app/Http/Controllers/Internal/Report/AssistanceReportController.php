<?php

namespace App\Http\Controllers\Internal\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Assistance;
use App\Models\Training;
use Barryvdh\DomPDF\Facade\Pdf;

class AssistanceReportController extends Controller
{
    public function index(Request $request)
    {
        $query = Assistance::withCount('assistance_users');

        // Filter by training_id
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by year
        if ($request->filled('year')) {
            $query->whereYear('start_date', $request->year);
        }

        // Filter by month
        if ($request->filled('month')) {
            $query->whereMonth('start_date', $request->month);
        }

        $assistance = $query->get();

        $trainings = Training::select('id', 'training_name')->get();

        // Buat daftar tahun unik dari tabel assistance
        $years = Assistance::selectRaw('YEAR(start_date) as year')
            ->distinct()
            ->pluck('year');

        return view('internal.report.assistance-report.index', [
            'assistance' => $assistance,
            'trainings' => $trainings,
            'years' => $years,
        ]);
    }

    public function print(Request $request)
    {
        $query = Assistance::withCount('assistance_users');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('year')) {
            $query->whereYear('start_date', $request->year);
        }

        if ($request->filled('month')) {
            $query->whereMonth('start_date', $request->month);
        }

        $assistance = $query->get();

        $trainings = Training::select('id', 'training_name')->get();

        // Buat daftar tahun unik dari tabel assistance
        $years = Assistance::selectRaw('YEAR(start_date) as year')
            ->distinct()
            ->pluck('year');

        $pdf = Pdf::loadView('internal.report.assistance-report.print', [
            'assistance' => $assistance,
            'trainings' => $trainings,
            'years' => $years,
        ])->setPaper('a4', 'landscape');

        return $pdf->stream('laporan-pendampingan.pdf');
    }
}
