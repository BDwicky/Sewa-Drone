<?php

namespace Tests\Feature;

use App\Console\Commands\CompleteFinishedBookings;
use App\Console\Commands\ExpireUnpaidBookings;
use App\Models\Booking;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SchedulerTest extends TestCase
{
    use RefreshDatabase;

    public function test_melepas_booking_pending_yang_tidak_dibayar_lebih_dari_2_jam(): void
    {
        $b = Booking::factory()->create([
            'status' => 'pending',
            'start_date' => '2026-10-01',
            'end_date' => '2026-10-03',
            'created_at' => Carbon::now()->subHours(3),
        ]);

        \Artisan::call(ExpireUnpaidBookings::class);

        $this->assertEquals('cancelled', $b->fresh()->status);

        // tanggalnya bisa dibooking lagi
        $this->post(route('bookings.store', $b->drone), [
            'renter_name' => 'X', 'phone' => '081',
            'start_date' => '2026-10-02', 'end_date' => '2026-10-02',
        ])->assertSessionHasNoErrors();
    }

    public function test_tidak_menyentuh_booking_pending_yang_baru_dibuat(): void
    {
        $b = Booking::factory()->create([
            'status' => 'pending',
            'start_date' => '2026-10-01',
            'end_date' => '2026-10-03',
            'created_at' => Carbon::now()->subMinutes(30),
        ]);

        \Artisan::call(ExpireUnpaidBookings::class);

        $this->assertEquals('pending', $b->fresh()->status);
    }

    public function test_booking_active_yang_lewat_end_date_otomatis_completed(): void
    {
        $b = Booking::factory()->create([
            'status' => 'active',
            'start_date' => now()->subDays(5)->toDateString(),
            'end_date' => now()->subDay()->toDateString(),
        ]);

        \Artisan::call(CompleteFinishedBookings::class);

        $this->assertEquals('completed', $b->fresh()->status);
    }
}
