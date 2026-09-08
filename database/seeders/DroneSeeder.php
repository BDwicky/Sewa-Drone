<?php

namespace Database\Seeders;

use App\Models\Drone;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DroneSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            [
                'name' => 'DJI Mini 4 Pro',
                'slug' => 'dji-mini-4-pro',
                'description' => 'Drone kompak di bawah 250 gram — tidak perlu izin pilot untuk penggunaan rekreasi (cukup registrasi DRONEID). Sensor 1/1.3-inch, obstacle avoidance, ideal untuk travel dan konten sosial media.',
                'camera' => '4K/60fps HDR',
                'flight_time_min' => 34,
                'range_km' => 20,
                'weight_g' => 249,
                'daily_rate' => 350000,
                'weekly_rate' => 1750000,
                'pilot_daily_rate' => 500000,
                'delivery_fee' => 50000,
                'replacement_value' => 12000000,
            ],
            [
                'name' => 'DJI Air 3S',
                'slug' => 'dji-air-3s',
                'description' => 'Kelas menengah dengan kamera ganda (wide + tele), 45 menit terbang. Favorit videografer profesional dan produksi korporat. Wajib sertifikat pilot untuk penggunaan komersial.',
                'camera' => '4K/60fps dual cam',
                'flight_time_min' => 45,
                'range_km' => 20,
                'weight_g' => 724,
                'daily_rate' => 600000,
                'weekly_rate' => 3000000,
                'pilot_daily_rate' => 600000,
                'delivery_fee' => 50000,
                'replacement_value' => 17000000,
            ],
            [
                'name' => 'DJI Mavic 3 Pro',
                'slug' => 'dji-mavic-3-pro',
                'description' => 'Flagship dengan kamera Hasselblad 5.1K, tiga lensa. Untuk pekerjaan serius: film, properti premium, survei. Wajib sertifikat pilot untuk komersial.',
                'camera' => '5.1K Hasselblad',
                'flight_time_min' => 43,
                'range_km' => 15,
                'weight_g' => 958,
                'daily_rate' => 1000000,
                'weekly_rate' => 5000000,
                'pilot_daily_rate' => 750000,
                'delivery_fee' => 75000,
                'replacement_value' => 38000000,
            ],
            [
                'name' => 'DJI Avata 2',
                'slug' => 'dji-avata-2',
                'description' => 'FPV dengan goggles dan motion controller — footage sinematik low-altitude. Hanya untuk penyewa berpengalaman atau dibarengi pilot.',
                'camera' => '4K/60fps FPV',
                'flight_time_min' => 23,
                'range_km' => 13,
                'weight_g' => 377,
                'daily_rate' => 900000,
                'weekly_rate' => 4500000,
                'pilot_daily_rate' => 750000,
                'delivery_fee' => 75000,
                'replacement_value' => 11000000,
            ],
        ];

        foreach ($items as $item) {
            Drone::updateOrCreate(
                ['slug' => $item['slug']],
                $item + ['stock' => 1, 'is_active' => true]
            );
        }
    }
}
