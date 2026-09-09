<?php

namespace App\Console\Commands;

use App\Models\Booking;
use Illuminate\Console\Command;

class ExpireUnpaidBookings extends Command
{
    protected $signature = 'bookings:expire-unpaid';

    protected $description = 'Melepas (cancel) booking pending yang tidak dibayar lebih dari 2 jam';

    public function handle(): int
    {
        $count = Booking::where('status', 'pending')
            ->where('created_at', '<', now()->subHours(2))
            ->update(['status' => 'cancelled']);

        $this->info("Expired {$count} unpaid booking(s).");

        return self::SUCCESS;
    }
}
