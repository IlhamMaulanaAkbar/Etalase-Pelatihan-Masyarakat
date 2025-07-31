<?php

namespace App\Http\Controllers\Internal\Report;

use App\Http\Controllers\Controller;
use App\Models\Assistance;
use App\Models\AssistanceUser;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class AssistanceParticipantsReportController extends Controller
{
    public function index(Request $request)
    {

        $query = AssistanceUser::with(['assistance', 'user.training_users.training'])
            ->when($request->status, function ($q) use ($request) {
                $q->where('status', $request->status);
            })
            ->when($request->year, function ($q) use ($request) {
                $q->whereHas('assistance', function ($tq) use ($request) {
                    $tq->whereYear('start_date', $request->year);
                });
            })
            ->when($request->month, function ($q) use ($request) {
                $q->whereHas('assistance', function ($tq) use ($request) {
                    $tq->whereMonth('start_date', $request->month);
                });
            });

        $participants = $query->get();

        $years = Assistance::selectRaw('YEAR(start_date) as year')->distinct()->pluck('year');
        $months = [1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'];


        return view('internal.report.assistance-participants-report.index', [
            'participants' => $participants,
            'years' => $years,
            'months' => $months,
        ]);
    }

    public function print(Request $request)
    {
        $query = AssistanceUser::with(['assistance', 'user.training_users.training'])
            ->when($request->status, function ($q) use ($request) {
                $q->where('status', $request->status);
            })
            ->when($request->year, function ($q) use ($request) {
                $q->whereHas('assistance', function ($tq) use ($request) {
                    $tq->whereYear('start_date', $request->year);
                });
            })
            ->when($request->month, function ($q) use ($request) {
                $q->whereHas('assistance', function ($tq) use ($request) {
                    $tq->whereMonth('start_date', $request->month);
                });
            });

        $participants = $query->get();
        $years = Assistance::selectRaw('YEAR(start_date) as year')->distinct()->pluck('year');
        $months = [1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'];

        $pdf = Pdf::loadView('internal.report.assistance-participants-report.print', [
            'participants' => $participants,
            'years' => $years,
            'months' => $months,
        ])->setPaper('a4', 'landscape');

        return $pdf->stream('laporan-peserta-pendampingan.pdf');
    }
}
