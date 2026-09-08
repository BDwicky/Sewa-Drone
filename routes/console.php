<?php

use App\Console\Commands\CompleteFinishedBookings;
use App\Console\Commands\ExpireUnpaidBookings;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::command(ExpireUnpaidBookings::class)->everyFiveMinutes();
Schedule::command(CompleteFinishedBookings::class)->dailyAt('01:30');
