<?php

namespace App\Http\Controllers\Internal\Page;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Training;
use App\Services\TrainingAssessmentTemplateCopier;
use App\Services\Supports\Alert;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TrainingController extends Controller
{
    public function index()
    {
        $trainings = Training::all()->sortByDesc('created_at'); // Sort by created_at in descending order
        return view('internal.training.index', [
            'trainings' => $trainings,
        ]);
    }

    public function create()
    {
        $categorys = Category::query()->select('id', 'name')->get();
        return view('internal.training.create', [
            'categorys' => $categorys,
        ]);
    }

    public function store(Request $request, TrainingAssessmentTemplateCopier $templateCopier)
    {
        $request->validate([
            'training_name' => 'required|string|max:128',
            'category_id' => 'required|exists:category,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'deadline_date' => 'required|date',
            'location' => 'required|string|max:255',
            'status' => 'required|in:BUKA,TUTUP, SELESAI',
            'thumbnail_image' => 'required|image|mimes:jpg,jpeg,png',
            'description' => 'required|string',
            'target_audience' => 'required|string',
        ]);

        $training = new Training();
        $training->training_name = $request->training_name;
        $training->category_id = $request->category_id;
        $training->start_date = $request->start_date;
        $training->end_date = $request->end_date;
        $training->deadline_date = $request->deadline_date;
        $training->location = $request->location;
        $training->status = $request->status;
        $training->thumbnail_image = $request->file('thumbnail_image')->store('thumbnails', 'public');
        $training->description = $request->description;
        $training->target_audience = $request->target_audience;
        if ($training->save()) {
            $templateCopier->copyForTraining($training);
            Alert::success('Pelatihan berhasil disimpan.');
        } else {
            Alert::error('Gagal menyimpan Pelatihan.');
            return back();
        }

        return redirect()->route('internal.training.index');
    }

    public function edit(Training $training)
    {
        $categorys = Category::all();

        return view('internal.training.edit', [
            'training' => $training,
            'categorys' => $categorys,
        ]);
    }

    public function show(Training $training)
    {
        return view('internal.training.show', [
            'training' => $training,
        ]);
    }

    public function update(Request $request, Training $training)
    {
        $request->validate([
            'training_name' => 'required|string|max:128',
            'category_id' => 'nullable|exists:category,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'deadline_date' => 'required|date',
            'location' => 'required|string|max:255',
            'status' => 'required|in:BUKA,TUTUP, SELESAI',
            'thumbnail_image' => 'nullable|image|mimes:jpg,jpeg,png',
            'description' => 'required|string',
            'target_audience' => 'required|string',
        ]);

        $training->update([
            'training_name' => $request->training_name,
            'category_id' => $request->category_id,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'deadline_date' => $request->deadline_date,
            'location' => $request->location,
            'status' => $request->status,
            'description' => $request->description,
            'target_audience' => $request->target_audience,
        ]);

        if ($request->hasFile('thumbnail_image')) {
            // Hapus thumbnail lama (jika ada)
            if ($training->thumbnail_image && Storage::disk('public')->exists($training->thumbnail_image)) {
                Storage::disk('public')->delete($training->thumbnail_image);
            }

            // Simpan yang baru
            $training->thumbnail_image = $request->file('thumbnail_image')->store('thumbnails', 'public');
        }

        if ($training->save()) {
            Alert::success('Pelatihan berhasil diperbarui.');
        } else {
            Alert::error('Gagal memperbarui Pelatihan.');
            return back();
        }

        return redirect()->route('internal.training.index');
    }

    public function destroy(Training $training)
    {
        // Hapus file thumbnail jika ada
        if ($training->thumbnail_image && Storage::disk('public')->exists($training->thumbnail_image)) {
            Storage::disk('public')->delete($training->thumbnail_image);
        }

        // Hapus data pelatihan
        if ($training->delete()) {
            Alert::success('Pelatihan berhasil dihapus.');
        } else {
            Alert::error('Gagal menghapus Pelatihan.');
        }

        return redirect()->route('internal.training.index');
    }
}
