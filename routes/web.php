<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;

require base_path('routes/web-internal.php');
require base_path('routes/web-public.php');

Route::get('/run-schedule/{token}', function ($token) {
    if ($token !== env('CRON_SECRET')) {
        abort(403);
    }
    Artisan::call('schedule:run');
    return 'Schedule dijalankan pada ' . now();
});
Route::get('/keep-alive', function () {
    return response()->noContent(); // 204 No Content
});
