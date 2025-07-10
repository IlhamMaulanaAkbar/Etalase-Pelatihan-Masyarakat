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
        $youtube = new Youtube();

        // Default: hanya tampilkan umum & pengumuman
        $learnings = Learning::whereIn('type', ['umum', 'pengumuman'])->latest()->paginate(9);

        // Kategori per-type
        $umum = Learning::where('type', 'umum')->latest()->get();
        $pengumuman = Learning::where('type', 'pengumuman')->latest()->get();

        $pelatihan = collect();
        $pendampingan = collect();

        if (auth('user')->check()) {
            // Tambahkan jika login
            $learnings = Learning::latest()->paginate(9);
            $pelatihan = Learning::where('type', 'pelatihan')->latest()->get();
            $pendampingan = Learning::where('type', 'pendampingan')->latest()->get();
        }

        // Generate thumbnail dan embed URL untuk semua
        foreach ([$learnings, $umum, $pengumuman, $pelatihan, $pendampingan] as $collection) {
            foreach ($collection as $item) {
                $item->thumbnail = $youtube->getThumbnail($item->video_url);
                $item->video_url = $youtube->getEmbedUrl($item->video_url);
            }
        }

        return view('public.learning.index', [
            'learnings' => $learnings,
            'umum' => $umum,
            'pengumuman' => $pengumuman,
            'pelatihan' => $pelatihan,
            'pendampingan' => $pendampingan
        ]);
    }
}
