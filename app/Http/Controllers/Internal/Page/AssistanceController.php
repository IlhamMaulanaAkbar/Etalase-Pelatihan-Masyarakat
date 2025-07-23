<?php

namespace App\Http\Controllers\Internal\Page;

use App\Http\Controllers\Controller;
use App\Models\Assistance;
use App\Models\Training;
use Illuminate\Http\Request;
use App\Services\Supports\Alert;
use Illuminate\Support\Facades\Storage;


class AssistanceController extends Controller
{
    public function index()
    {
        $assistances = Assistance::all()->sortByDesc('created_at');

        return view('internal.assistance.index', [
            'assistances' => $assistances,
        ]);
    }

    public function create()
    {
        $trainings = Training::query()->select('id', 'training_name')->get();

        return view('internal.assistance.create', [
            'trainings' => $trainings,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'assistance_name' => 'required|string|max:128',
            'training_id' => 'required|exists:trainings,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'deadline_date' => 'required|date',
            'location' => 'required|string|max:255',
            'status' => 'required|in:BUKA,TUTUP,SELESAI',
            'thumbnail_image' => 'required|image|mimes:jpg,jpeg,png',
            'description' => 'required|string',
            'target_audience' => 'required|string',
        ]);

        $assistance = new Assistance();
        $assistance->fill($request->all());
        $assistance->thumbnail_image = $request->file('thumbnail_image')->store('thumbnails', 'public');

        if ($assistance->save()) {
            Alert::success('Pendampingan berhasil disimpan.');
        } else {
            Alert::error('Gagal menyimpan Pendampingan.');
            return back();
        }

        return redirect()->route('internal.assistance.index');
    }

    public function edit(Assistance $assistance)
    {
        $trainings = Training::all();

        return view('internal.assistance.edit', [
            'assistance' => $assistance,
            'trainings' => $trainings,
        ]);
    }

    public function show(Assistance $assistance)
    {
        return view('internal.assistance.show', [
            'assistance' => $assistance,
        ]);
    }

    public function update(Request $request, Assistance $assistance)
    {
        $request->validate([
            'assistance_name' => 'required|string|max:128',
            'training_id' => 'required|exists:trainings,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'deadline_date' => 'required|date',
            'location' => 'required|string|max:255',
            'status' => 'required|in:BUKA,TUTUP,SELESAI',
            'thumbnail_image' => 'nullable|image|mimes:jpg,jpeg,png',
            'description' => 'required|string',
            'target_audience' => 'required|string',
        ]);

        $assistance->update([
            'assistance_name' => $request->assistance_name,
            'training_id' => $request->training_id,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'deadline_date' => $request->deadline_date,
            'location' => $request->location,
            'status' => $request->status,
            'description' => $request->description,
            'target_audience' => $request->target_audience,
        ]);

        if ($request->hasFile('thumbnail_image')) {
            if ($assistance->thumbnail_image && Storage::disk('public')->exists($assistance->thumbnail_image)) {
                Storage::disk('public')->delete($assistance->thumbnail_image);
            }

            $assistance->thumbnail_image = $request->file('thumbnail_image')->store('thumbnails', 'public');
        }

        if ($assistance->save()) {
            Alert::success('Pendampingan berhasil diperbarui.');
        } else {
            Alert::error('Gagal memperbarui Pendampingan.');
            return back();
        }

        return redirect()->route('internal.assistance.index');
    }

    public function destroy(Assistance $assistance)
    {
        if ($assistance->thumbnail_image && Storage::disk('public')->exists($assistance->thumbnail_image)) {
            Storage::disk('public')->delete($assistance->thumbnail_image);
        }

        if ($assistance->delete()) {
            Alert::success('Pendampingan berhasil dihapus.');
        } else {
            Alert::error('Gagal menghapus Pendampingan.');
            return back();
        }

        return redirect()->route('internal.assistance.index');
    }
}
