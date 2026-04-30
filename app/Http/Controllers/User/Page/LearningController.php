<?php

namespace App\Http\Controllers\User\Page;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Learning;
use App\Services\Supports\Youtube;


class LearningController extends Controller
{
    public function index(Learning $learning, Request $request)
    {
        $youtube = new Youtube();
        $perPage = 9;
        $isLoggedIn = auth('user')->check();

        $tabs = [
            'all' => 'All',
            'umum' => 'Kegiatan',
            'pengumuman' => 'Pengumuman',
        ];

        if ($isLoggedIn) {
            $tabs['pelatihan'] = 'Pelatihan';
            $tabs['pendampingan'] = 'Pendampingan';
        }

        $activeType = $request->query('type', 'all');

        if (!array_key_exists($activeType, $tabs)) {
            $activeType = 'all';
        }

        $query = Learning::latest();

        if ($activeType === 'all') {
            if (!$isLoggedIn) {
                $query->whereIn('type', ['umum', 'pengumuman']);
            }
        } else {
            $query->where('type', $activeType);
        }

        $learnings = $query->paginate($perPage)->withQueryString();
        $learnings->getCollection()->transform(function ($item) use ($youtube) {
            $item->thumbnail = $youtube->getThumbnail($item->video_url);
            $item->video_url = $youtube->getEmbedUrl($item->video_url);

            return $item;
        });

        $sessionKey = 'viewed_learnings_' . $learning->id;

        if (!session()->has($sessionKey)) {
            $learning->increment('views');
            session()->put($sessionKey, true);
        }

        return view('public.learning.index', [
            'learnings' => $learnings,
            'tabs' => $tabs,
            'activeType' => $activeType,
        ]);
    }
}
