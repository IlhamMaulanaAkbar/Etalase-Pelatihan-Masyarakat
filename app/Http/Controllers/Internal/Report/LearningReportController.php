<?php

namespace App\Http\Controllers\Internal\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Learning;
use Barryvdh\DomPDF\Facade\Pdf;

class LearningReportController extends Controller
{
    public function index(Request $request)
    {
        $query = Learning::query();

        if ($request->filled('type')) {
            $query->where('type', $request->type); // bukan type_id
        }


        if ($request->filled('year')) {
            $query->whereYear('created_at', $request->year);
        }

        if ($request->filled('month')) {
            $query->whereMonth('created_at', $request->month);
        }

        $learnings = $query->get();
        $types = Learning::select('id', 'type')->get();

        $years = Learning::selectRaw('YEAR(created_at) as year')
            ->distinct()
            ->pluck('year');

        return view('internal.report.learning-report.index', [
            'learnings' => $learnings,
            'years' => $years,
            'types' => $types,
        ]);
    }

    public function print(Request $request)
    {
        $query = Learning::query();

        if ($request->filled('type')) {
            $query->where('type', $request->type); // bukan type_id
        }

        if ($request->filled('year')) {
            $query->whereYear('created_at', $request->year);
        }

        if ($request->filled('month')) {
            $query->whereMonth('created_at', $request->month);
        }

        $learnings = $query->get();
        $types = Learning::select('id', 'type')->get();
        $years = Learning::selectRaw('YEAR(created_at) as year')
            ->distinct()
            ->pluck('year');

        $pdf = Pdf::loadView('internal.report.learning-report.print', [
            'learnings' => $learnings,
            'types' => $types,
            'years' => $years,
        ])->setPaper('a4', 'landscape');

        return $pdf->stream('Laporan-Video-Pembelajaran.pdf');
    }
}
