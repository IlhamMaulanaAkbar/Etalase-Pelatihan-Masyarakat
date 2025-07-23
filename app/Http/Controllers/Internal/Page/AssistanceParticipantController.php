<?php

namespace App\Http\Controllers\Internal\Page;

use App\Http\Controllers\Controller;
use App\Models\Assistance;
use App\Models\AssistanceUser;
use App\Services\Supports\Alert;
use Illuminate\Http\Request;

class AssistanceParticipantController extends Controller
{
    public function index()
    {
        $assistances = Assistance::withCount('assistance_users')->get()->sortByDesc('created_at');
        return view('internal.participants.assistance.index', compact('assistances'));
    }

    public function show(Assistance $assistance)
    {
        $participants = $assistance->assistance_users()->with('user')->get();

        return view('internal.participants.assistance.show', compact('assistance', 'participants'));
    }

    public function status(Request $request, AssistanceUser $assistanceUser)
    {
        if ($assistanceUser->status !== 'DAFTAR') {
            return back()->with(Alert::error('Status tidak dapat diubah karena sudah diproses.'));
        }

        $request->validate([
            'status' => 'required|in:LULUS,TIDAK_LULUS',
        ]);

        $assistanceUser->status = $request->status;
        $assistanceUser->is_approved = $request->status === 'LULUS';

        if ($request->status === 'LULUS' && !$assistanceUser->verified_at) {
            $assistanceUser->verified_at = now();
        }
        $assistanceUser->save();

        return back()->with(Alert::success('Status peserta berhasil diubah.'));
    }
}
