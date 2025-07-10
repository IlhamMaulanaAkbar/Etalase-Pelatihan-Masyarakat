<?php

namespace App\Http\Controllers\Internal\Page;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Training;
use App\Models\TrainingUser;
use App\Services\Supports\Alert;

class TrainingParticipantController extends Controller
{
    public function index()
    {
        $trainings = Training::withCount('training_users')->get();
        return view('internal.participants.index', compact('trainings'));
    }

    public function show(Training $training)
    {
        $participants = $training->training_users()->with('user')->get();
        return view('internal.participants.show', compact('training', 'participants'));
    }

    public function status(Request $request, TrainingUser $training_user)
    {
        $request->validate([
            'status' => 'required|in:LULUS,TIDAK_LULUS',
        ]);

        $training_user->status = $request->status;
        $training_user->is_approved = $request->status === 'LULUS';

        // Set verified_at hanya jika status diubah menjadi LULUS dan belum pernah diverifikasi
        if ($request->status === 'LULUS' && !$training_user->verified_at) {
            $training_user->verified_at = now();
        }
        $training_user->save();

        return back()->with(Alert::success('Status peserta berhasil diperbarui.'));
    }
}
