<?php

$publicPath = __DIR__ . '/public';

$uri = urldecode(
    parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?? ''
);

// Jika file fisik memang tersedia, biarkan PHP built-in server
// melayani file tersebut secara langsung.
if ($uri !== '/' && file_exists($publicPath . $uri)) {
    return false;
}

// Semua route Laravel diarahkan ke public/index.php.
require_once $publicPath . '/index.php';