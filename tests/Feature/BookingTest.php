<?php

namespace Tests\Feature;

use App\Models\Booking;
use App\Models\Drone;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookingTest extends TestCase
{
    use RefreshDatabase;

    private function drone(): Drone
    {
        return Drone::factory()->create(['daily_rate' => 350000, 'slug' => 'test-drone-'.uniqid()]);
    }

    public function test_menghitung_days_dan_total_price_dengan_benar(): void
    {
        $d = $this->drone();

        $resp = $this->post(route('bookings.store', $d), [
            'renter_name' => 'Bagus', 'phone' => '081234567890',
            'start_date' => '2026-10-01', 'end_date' => '2026-10-03',
        ]);

        $resp->assertRedirect();
        $b = Booking::first();
        $this->assertEquals(3, $b->days);
        $this->assertEquals(1050000.0, (float) $b->total_price);
        $this->assertEquals('pending', $b->status);
        $this->assertStringStartsWith('DRN-', $b->code);
    }

    public function test_menolak_booking_tumpang_tindih(): void
    {
        $d = $this->drone();
        Booking::create([
            'code' => 'DRN-EXIST1', 'drone_id' => $d->id, 'renter_name' => 'A', 'phone' => '08111',
            'start_date' => '2026-10-01', 'end_date' => '2026-10-03',
            'days' => 3, 'total_price' => 1050000, 'status' => 'confirmed',
        ]);

        $this->from(route('bookings.create', $d))
            ->post(route('bookings.store', $d), [
                'renter_name' => 'B', 'phone' => '08122',
                'start_date' => '2026-10-03', 'end_date' => '2026-10-05',
            ])
            ->assertSessionHasErrors('start_date');
    }

    public function test_mengizinkan_booking_back_to_back(): void
    {
        $d = $this->drone();
        Booking::create([
            'code' => 'DRN-EXIST2', 'drone_id' => $d->id, 'renter_name' => 'A', 'phone' => '08111',
            'start_date' => '2026-10-01', 'end_date' => '2026-10-03',
            'days' => 3, 'total_price' => 1050000, 'status' => 'confirmed',
        ]);

        $this->post(route('bookings.store', $d), [
            'renter_name' => 'B', 'phone' => '08122',
            'start_date' => '2026-10-04', 'end_date' => '2026-10-05',
        ])->assertSessionHasNoErrors();
    }

    public function test_booking_cancelled_tidak_memblokir(): void
    {
        $d = $this->drone();
        Booking::create([
            'code' => 'DRN-EXIST3', 'drone_id' => $d->id, 'renter_name' => 'A', 'phone' => '08111',
            'start_date' => '2026-10-01', 'end_date' => '2026-10-03',
            'days' => 3, 'total_price' => 1050000, 'status' => 'cancelled',
        ]);

        $this->post(route('bookings.store', $d), [
            'renter_name' => 'B', 'phone' => '08122',
            'start_date' => '2026-10-02', 'end_date' => '2026-10-02',
        ])->assertSessionHasNoErrors();
    }

    public function test_menolak_end_date_sebelum_start_date(): void
    {
        $d = $this->drone();

        $this->post(route('bookings.store', $d), [
            'renter_name' => 'C', 'phone' => '08133',
            'start_date' => '2026-10-05', 'end_date' => '2026-10-01',
        ])->assertSessionHasErrors(['end_date']);
    }

    public function test_harga_mingguan_dipakai_untuk_sewa_7_hari(): void
    {
        $d = Drone::factory()->create(['daily_rate' => 350000, 'weekly_rate' => 1750000, 'slug' => 'weekly-'.uniqid()]);

        $this->post(route('bookings.store', $d), [
            'renter_name' => 'D', 'phone' => '08144',
            'start_date' => '2026-10-01', 'end_date' => '2026-10-07', // 7 hari
        ])->assertSessionHasNoErrors();

        $b = Booking::first();
        $this->assertEquals(7, $b->days);
        $this->assertEquals(1750000.0, (float) $b->total_price);
    }

    public function test_endpoint_availability_mengembalikan_tanggal_terblokir(): void
    {
        $d = $this->drone();
        Booking::create([
            'code' => 'DRN-BUSY01', 'drone_id' => $d->id, 'renter_name' => 'A', 'phone' => '081',
            'start_date' => '2026-10-01', 'end_date' => '2026-10-03',
            'days' => 3, 'total_price' => 1050000, 'status' => 'confirmed',
        ]);

        $this->getJson(route('drones.availability', $d))
            ->assertOk()
            ->assertJsonFragment(['from' => '2026-10-01', 'to' => '2026-10-03']);
    }
}
