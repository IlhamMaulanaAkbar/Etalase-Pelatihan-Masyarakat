<?php

namespace App\Http\Controllers\User\Certificates;

use App\Http\Controllers\Controller;
use App\Models\Training;
use Illuminate\Http\Request;
use App\Models\TrainingUser;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Str;
use App\Models\Certificates;


class CertificatesController extends Controller
{
    public function certificate($id)
    {
        $trainingUser = TrainingUser::with(['training', 'user'])->findOrFail($id);

        // Ambil data sertifikat dari admin
        $certificate = Certificates::where('training_id', $trainingUser->training_id)->latest()->firstOrFail();

        $pdf = Pdf::loadView('public.certificates.index', [
            'user' => $trainingUser->user,
            'training' => $trainingUser->training,
            'certificate' => $certificate, // atau generate secara dinamis jika diperlukan
        ])->setPaper('a4', 'landscape');

        return $pdf->stream('sertifikat-' . Str::slug($trainingUser->user->name) . '.pdf');
    }
}
