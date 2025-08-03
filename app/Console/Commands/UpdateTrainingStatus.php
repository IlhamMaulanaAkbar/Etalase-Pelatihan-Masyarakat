<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Training;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class UpdateTrainingStatus extends Command
{
    // php artisan training:update-status
    protected $signature = 'training:update-status';
    protected $description = 'Update status pelatihan menjadi TUTUP atau SELESAI berdasarkan tanggal';

    public function handle()
    {
        $now = Carbon::now();

        // Update status ke TUTUP jika sudah lewat deadline
        Training::where('status', '!=', 'SELESAI')
            ->where('deadline_date', '<', $now)
            ->where('status', '!=', 'TUTUP')
            ->update(['status' => 'TUTUP']);

        // Update status ke SELESAI jika sudah lewat end_date
        Training::where('status', '!=', 'SELESAI')
            ->where('end_date', '<', $now)
            ->update(['status' => 'SELESAI']);

        Log::channel('scheduler')->info('Status pelatihan berhasil diperbarui.');
    }
}
