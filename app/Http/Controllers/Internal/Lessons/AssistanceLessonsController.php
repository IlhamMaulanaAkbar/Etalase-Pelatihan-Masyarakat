<?php

namespace App\Http\Controllers\Internal\Lessons;

use App\Http\Controllers\Controller;
use App\Models\Assistance;
use App\Models\LessonsAssistance;
use Illuminate\Http\Request;
use App\Services\Supports\Alert;
use Illuminate\Support\Facades\Storage;

class AssistanceLessonsController extends Controller
{
    public function index(Assistance $assistance)
    {
        $lessons = LessonsAssistance::where('assistance_id', $assistance->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('internal.schedules.assistance.index', compact('lessons', 'assistance'));
    }

    public function create(Assistance $assistance)
    {
        return view('internal.schedules.assistance.create', compact('assistance'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'file' => 'required|file|mimes:pdf,doc,docx,ppt,pptx,xlsx|max:2048',
            'duration' => 'required|string|max:50',
        ]);

        $filePath = $request->file('file')->store('lessons', 'public');

        $lessons = LessonsAssistance::create([
            'assistance_id' => $request->assistance_id,
            'name' => $request->name,
            'file' => $filePath,
            'duration' => $request->duration,
        ]);

        return redirect()->route('internal.schedules.assistance.index', ['assistance' => $request->assistance_id])
            ->with(Alert::success('Materi Pendampingan berhasil disimpan.'));
    }

    public function edit(Assistance $assistance, LessonsAssistance $lesson)
    {
        return view('internal.schedules.assistance.edit', compact('lesson', 'assistance'));
    }

    public function update(Request $request, Assistance $assistance, LessonsAssistance $lesson)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'file' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx,xlsx|max:2048',
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

        return redirect()->route('internal.schedules.assistance.index', ['assistance' => $assistance->id])
            ->with(Alert::success('Materi Pendampingan berhasil diperbarui.'));
    }

    public function destroy(Assistance $assistance, LessonsAssistance $lesson)
    {
        // Hapus materi dan file terkait
        if ($lesson->file && Storage::disk('public')->exists($lesson->file)) {
            Storage::disk('public')->delete($lesson->file);
        }
        $lesson->delete();

        return redirect()->route('internal.schedules.assistance.index', ['assistance' => $assistance->id])
            ->with(Alert::success('Materi Pendampingan berhasil dihapus.'));
    }
}
