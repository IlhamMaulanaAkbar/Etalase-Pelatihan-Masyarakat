<?php

namespace App\Http\Controllers\User\Page;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Learning;
use App\Services\Supports\Youtube;


class LearningController extends Controller
{
    public function index()
    {
        $learnings = Learning::paginate(9);
        $youtube = new Youtube();

        foreach ($learnings as $learning) {
            $learning->thumbnail = $youtube->getThumbnail($learning->video_url);
            $learning->video_url = $youtube->getEmbedUrl($learning->video_url);
        }
        // dd($learnings);

        return view('public.learning.index', [
            'learnings' => $learnings,
            'youtube' => $youtube,
            'embedUrl' => $youtube->getEmbedUrl($learning->video_url),
            'videoId' => $youtube->getVideoId($learning->video_url),
            'thumbnail' => $youtube->getThumbnail($learning->video_url),
        ]);
    }
}
