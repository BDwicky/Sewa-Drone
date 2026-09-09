<?php

namespace App\Console\Commands;

use App\Models\Booking;
use Illuminate\Console\Command;

class CompleteFinishedBookings extends Command
{
    protected $signature = 'bookings:complete-finished';

    protected $description = 'Menandai booking active yang sudah lewat end_date sebagai completed';

    public function handle(): int
    {
        $count = Booking::where('status', 'active')
            ->whereDate('end_date', '<', now()->toDateString())
            ->update(['status' => 'completed']);

        $this->info("Completed {$count} finished booking(s).");

        return self::SUCCESS;
    }
}
