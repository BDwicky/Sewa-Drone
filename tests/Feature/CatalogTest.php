<?php

namespace Tests\Feature;

use App\Models\Drone;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CatalogTest extends TestCase
{
    use RefreshDatabase;

    public function test_menampilkan_drone_aktif_di_katalog(): void
    {
        Drone::factory()->create(['name' => 'DJI Mini 4 Pro', 'slug' => 'dji-mini-4-pro-test', 'is_active' => true]);

        $this->get('/')->assertOk()->assertSee('DJI Mini 4 Pro');
    }

    public function test_menyembunyikan_drone_nonaktif_dari_katalog(): void
    {
        Drone::factory()->create(['name' => 'Drone Rusak', 'slug' => 'drone-rusak-test', 'is_active' => false]);

        $this->get('/')->assertOk()->assertDontSee('Drone Rusak');
    }
}
