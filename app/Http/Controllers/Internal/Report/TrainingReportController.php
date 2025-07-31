<?php

namespace App\Http\Controllers\Internal\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Training;
use App\Models\Category;
use Barryvdh\DomPDF\Facade\Pdf;

class TrainingReportController extends Controller
{
    public function index(Request $request)
    {
        $query = Training::with('category')->withCount('training_users');

        // Filter berdasarkan status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter berdasarkan tahun
        if ($request->filled('year')) {
            $query->whereYear('start_date', $request->year);
        }

        // Filter berdasarkan bulan
        if ($request->filled('month')) {
            $query->whereMonth('start_date', $request->month);
        }

        $trainings = $query->get();
        $categorys = Category::select('id', 'name')->get();

        // Tahun unik dari data pelatihan
        $years = Training::selectRaw('YEAR(start_date) as year')->distinct()->pluck('year');

        return view('internal.report.training-report.index', [
            'trainings' => $trainings,
            'categorys' => $categorys,
            'years' => $years,
        ]);
    }

    public function print(Request $request)
    {
        $query = Training::with('category')->withCount('training_users');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('year')) {
            $query->whereYear('start_date', $request->year);
        }

        if ($request->filled('month')) {
            $query->whereMonth('start_date', $request->month);
        }

        $trainings = $query->get();
        $categorys = Category::select('id', 'name')->get();
        $years = Training::selectRaw('YEAR(start_date) as year')->distinct()->pluck('year');

        $pdf = Pdf::loadView('internal.report.training-report.print', [
            'trainings' => $trainings,
            'categorys' => $categorys,
            'years' => $years,
        ])->setPaper('a4', 'landscape');

        return $pdf->stream('laporan-pelatihan.pdf');
    }
}
