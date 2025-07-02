<?php

namespace App\Services\Supports;

class Youtube
{
    public function getVideoId($url)
    {
        $parsedUrl = parse_url($url);

        if (!isset($parsedUrl['host'])) return '';

        if ($parsedUrl['host'] === 'youtu.be') {
            // Hapus parameter jika ada di path
            $path = ltrim($parsedUrl['path'], '/');
            $path = explode('?', $path)[0];
            return $path;
        }

        if (isset($parsedUrl['query'])) {
            parse_str($parsedUrl['query'], $query);
            return $query['v'] ?? '';
        }

        return '';
    }


    public function getThumbnail($url)
    {
        $id = $this->getVideoId($url);
        return $id ? "https://img.youtube.com/vi/{$id}/hqdefault.jpg" : '';
    }

    public function getEmbedUrl($url)
    {
        $id = $this->getVideoId($url);
        return $id ? "https://www.youtube.com/embed/{$id}" : '';
    }
}
