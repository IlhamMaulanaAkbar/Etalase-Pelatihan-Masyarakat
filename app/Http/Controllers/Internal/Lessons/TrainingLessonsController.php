<?php

namespace App\Http\Controllers\Internal\Lessons;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Training;
use App\Models\LessonsTraining;
use Illuminate\Support\Facades\Storage;
use App\Services\Supports\Alert;

class TrainingLessonsController extends Controller
{
    public function index(Training $training)
    {
        $lessons = LessonsTraining::where('training_id', $training->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('internal.lessons.training.index', compact('lessons', 'training'));
    }

    public function create(Training $training)
    {
        return view('internal.lessons.training.create', compact('training'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'file' => 'required|file|mimes:pdf,doc,docx,ppt,pptx,xlsx|max:2048',
            'duration' => 'required|string|max:50',
        ]);

        $filePath = $request->file('file')->store('lessons', 'public');

        $lessons = LessonsTraining::create([
            'training_id' => $request->training_id,
            'name' => $request->name,
            'file' => $filePath,
            'duration' => $request->duration,
        ]);

        return redirect()->route('internal.lessons.training.index', ['training' => $request->training_id])
            ->with(Alert::success('Materi Pelatihan berhasil disimpan.'));
    }

    public function edit(Training $training, LessonsTraining $lesson)
    {
        return view('internal.lessons.training.edit', compact('lesson', 'training'));
    }

    public function update(Request $request, Training $training, LessonsTraining $lesson)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'file' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx|max:2048',
            'duration' => 'required|string|max:50',
        ]);

        $lesson->update([
            'name' => $request->name,
            'duration' => $request->duration,
        ]);

        if ($request->hasFile('file')) {
            if ($lesson->file && Storage::disk('public')->exists($lesson->file)) {
                Storage::disk('public')->delete($lesson->file);
            }
            $lesson->file = $request->file('file')->store('lessons', 'public');
        }

        $lesson->save();

        return redirect()->route('internal.lessons.training.index', ['training' => $training->id])
            ->with(Alert::success('Materi Pelatihan berhasil diperbarui.'));
    }

    public function destroy(Training $training, LessonsTraining $lesson)
    {
        if ($lesson->file && Storage::disk('public')->exists($lesson->file)) {
            Storage::disk('public')->delete($lesson->file);
        }

        $lesson->delete();

        return redirect()->route('internal.lessons.training.index', ['training' => $training->id])
            ->with(Alert::success('Materi Pelatihan berhasil dihapus.'));
    }
}
