<?php

namespace App\Http\Controllers\Internal\Page;

use App\Http\Controllers\Controller;
use App\Models\Learning;
use Illuminate\Http\Request;
use App\Services\Supports\Alert;
use App\Services\Supports\Youtube;

class LearningController extends Controller
{
    public function index()
    {
        $learnings = Learning::all();
        $youtube = new Youtube();

        foreach ($learnings as $learning) {
            $learning->thumbnail = $youtube->getThumbnail($learning->video_url);
        }

        return view('internal.learning.index', compact('learnings'));
    }


    public function create()
    {
        return view('internal.learning.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'video_name' => 'required|string|max:255',
            'video_url' => 'required|string|max:255',
            'uploaded_at' => 'required|date',
        ]);

        $learning = new Learning();
        $learning->video_name = $request->video_name;
        $learning->video_url = $request->video_url;
        $learning->uploaded_at = $request->uploaded_at;
        $learning->save();
        if ($learning->save()) {
            Alert::success('Video berhasil disimpan.');
        } else {
            Alert::error('Gagal menyimpan video.');
        }
        return redirect()->route('internal.learning.index');
    }

    public function edit(Learning $learning)
    {
        return view('internal.learning.edit', [
            'learning' => $learning,
        ]);
    }

    public function show(Learning $learning)
    {
        $youtube = new Youtube();

        return view('internal.learning.show', [
            'learning' => $learning,
            'videoId' => $youtube->getVideoId($learning->video_url),
            'thumbnail' => $youtube->getThumbnail($learning->video_url),
            'embedUrl' => $youtube->getEmbedUrl($learning->video_url),
        ]);
    }


    public function update(Request $request, Learning $learning)
    {
        $request->validate([
            'video_name' => 'required|string|max:255',
            'video_url' => 'required|string|max:255',
            'uploaded_at' => 'required|date',
        ]);

        $learning->update([
            'video_name' => $request->video_name,
            'video_url' => $request->video_url,
            'uploaded_at' => $request->uploaded_at,
        ]);
        if ($learning->save()) {
            Alert::success('Video berhasil diperbarui.');
        } else {
            Alert::error('Gagal memperbarui video.');
        }
        return redirect()->route('internal.learning.index', [
            'learning' => $learning,
        ]);
    }

    public function destroy(Learning $learning)
    {
        if ($learning->delete()) {
            Alert::success('Video berhasil dihapus.');
            return redirect()->route('internal.learning.index');
        } else {
            Alert::error('Gagal menghapus video.');
            return back();
        }
    }
}
