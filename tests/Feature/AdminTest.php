<?php

namespace Tests\Feature;

use App\Models\Drone;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminTest extends TestCase
{
    use RefreshDatabase;

    public function test_mengalihkan_guest_dari_admin_ke_login(): void
    {
        $this->get('/admin')->assertRedirect('/login');
        $this->get('/admin/drones')->assertRedirect('/login');
    }

    public function test_admin_login_bisa_membuat_drone(): void
    {
        $user = User::factory()->create();

        $resp = $this->actingAs($user)->post(route('admin.drones.store'), [
            'name' => 'DJI Neo',
            'daily_rate' => 250000,
            'stock' => 1,
            'is_active' => 1,
        ]);

        $resp->assertRedirect();
        $this->assertDatabaseHas('drones', ['name' => 'DJI Neo']);
        $this->assertTrue(Drone::where('name', 'DJI Neo')->first()->slug !== '');
    }

    public function test_admin_bisa_mengubah_status_booking(): void
    {
        $user = User::factory()->create();
        $booking = \App\Models\Booking::factory()->create(['status' => 'pending']);

        $this->actingAs($user)
            ->patch(route('admin.bookings.status', $booking), ['status' => 'active'])
            ->assertRedirect();

        $this->assertEquals('active', $booking->fresh()->status);
    }

    public function test_upload_foto_drone_tersimpan(): void
    {
        Storage::fake('public');
        $user = User::factory()->create();

        $this->actingAs($user)->post(route('admin.drones.store'), [
            'name' => 'DJI Photo',
            'daily_rate' => 300000,
            'stock' => 1,
            'is_active' => 1,
            'image' => UploadedFile::fake()->image('drone.jpg', 800, 600),
        ]);

        $drone = Drone::where('name', 'DJI Photo')->first();
        $this->assertNotNull($drone->image_path);
        Storage::disk('public')->assertExists($drone->image_path);
    }
}
