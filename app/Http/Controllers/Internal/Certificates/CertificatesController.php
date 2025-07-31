<?php

namespace App\Http\Controllers\Internal\Certificates;

use App\Http\Controllers\Controller;
use App\Models\Training;
use Illuminate\Http\Request;
use App\Models\Certificates;
use Illuminate\Support\Facades\Storage;
use App\Services\Supports\Alert;

class CertificatesController extends Controller
{
    public function index(Training $training)
    {
        $certificates = Certificates::where('training_id', $training->id)
            ->orderBy('created_at', 'desc')
            ->get();
            
        return view('internal.certificates.index', compact('certificates', 'training'));
    }

    public function create(Training $training)
    {
        return view('internal.certificates.create', compact('training'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'certificate_number' => 'required|string|max:255',
            'signature_file' => 'required|file|mimes:jpg,jpeg,png|max:2048',
            'name_of_leader' => 'required|string|max:255',
            'leadership_position' => 'required|string|max:255',
            'issue_date' => 'required|date',
            'identity_number' => 'required|string|max:255',
        ]);

        $signaturePath = $request->file('signature_file')->store('signatures', 'public');

        Certificates::create([
            'training_id' => $request->training_id,
            'certificate_number' => $request->certificate_number,
            'signature_file' => $signaturePath,
            'name_of_leader' => $request->name_of_leader,
            'leadership_position' => $request->leadership_position,
            'issue_date' => $request->issue_date,
            'identity_number' => $request->identity_number,
        ]);

        return redirect()->route('internal.certificates.index', ['training' => $request->training_id])
            ->with(Alert::success('Sertifikat berhasil dibuat.'));
    }

    public function edit(Training $training, Certificates $certificate)
    {
        return view('internal.certificates.edit', compact('training', 'certificate'));
    }

    public function update(Request $request, Training $training, Certificates $certificate)
    {
        $request->validate([
            'certificate_number' => 'required|string|max:255',
            'signature_file' => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
            'name_of_leader' => 'required|string|max:255',
            'leadership_position' => 'required|string|max:255',
            'issue_date' => 'required|date',
            'identity_number' => 'required|string|max:255',
        ]);

        if($request->hasFile('signature_file')) {
            // Hapus file lama jika ada
            if ($certificate->signature_file) {
                Storage::disk('public')->delete($certificate->signature_file);
            }
            $signaturePath = $request->file('signature_file')->store('signatures', 'public');
            $certificate->signature_file = $signaturePath;
        }

        $certificate->update([
            'certificate_number' => $request->certificate_number,
            'name_of_leader' => $request->name_of_leader,
            'leadership_position' => $request->leadership_position,
            'issue_date' => $request->issue_date,
            'identity_number' => $request->identity_number,
        ]);

        return redirect()->route('internal.certificates.index', ['training' => $training->id])
            ->with(Alert::success('Sertifikat berhasil diperbarui.'));
    }

    public function destroy(Training $training, Certificates $certificate)
    {
        if ($certificate->signature_file) {
            Storage::disk('public')->delete($certificate->signature_file);
        }
        
        $certificate->delete();

        return redirect()->route('internal.certificates.index', ['training' => $training->id])
            ->with(Alert::success('Sertifikat berhasil dihapus.'));
    }
}
