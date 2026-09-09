<?php

namespace Database\Seeders;

use App\Models\Drone;
use Illuminate\Database\Seeder;

class DroneSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            [
                'name' => 'DJI Neo',
                'slug' => 'dji-neo',
                'description' => 'Drone ultra-ringan seukuran telapak tangan (135g) dengan fitur AI subject tracking dan lepas landas langsung dari telapak tangan (palm takeoff & landing). Sangat mudah diterbangkan tanpa remote kontrol tambahan, ideal untuk solo vlogger dan konten cepat.',
                'camera' => '4K/30fps RockSteady',
                'flight_time_min' => 18,
                'range_km' => 7,
                'weight_g' => 135,
                'daily_rate' => 175000,
                'weekly_rate' => 875000,
                'pilot_daily_rate' => 350000,
                'delivery_fee' => 35000,
                'replacement_value' => 4500000,
                'image_path' => 'drones/neo_front.jpg',
            ],
            [
                'name' => 'DJI Mini 3 Pro',
                'slug' => 'dji-mini-3-pro',
                'description' => 'Pilihan rental paling populer dan ekonomis untuk content creator dan traveling. Bobot di bawah 249g bebas izin terbang komersial dasar, sensor 1/1.3-inch CMOS f/1.7 tajam dengan mode True Vertical Shooting (rotasi fisik 90 derajat).',
                'camera' => '4K/60fps HDR 48MP',
                'flight_time_min' => 34,
                'range_km' => 12,
                'weight_g' => 249,
                'daily_rate' => 275000,
                'weekly_rate' => 1375000,
                'pilot_daily_rate' => 450000,
                'delivery_fee' => 40000,
                'replacement_value' => 9500000,
                'image_path' => 'drones/mini3_front.jpg',
            ],
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
                'image_path' => 'drones/mini4_front.jpg',
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
                'image_path' => 'drones/air3s_front.jpg',
            ],
            [
                'name' => 'DJI Mavic 3 Classic',
                'slug' => 'dji-mavic-3-classic',
                'description' => 'Flagship sinematik murni dengan kamera tunggal 4/3 CMOS Hasselblad L2D-20c legendaris. Menghasilkan rekaman 5.1K/50fps dan 4K/120fps dengan profil warna Hasselblad Natural Colour Solution (HNCS) dan transmisi O3+ 15KM.',
                'camera' => '5.1K Hasselblad 4/3 CMOS',
                'flight_time_min' => 46,
                'range_km' => 15,
                'weight_g' => 895,
                'daily_rate' => 850000,
                'weekly_rate' => 4250000,
                'pilot_daily_rate' => 700000,
                'delivery_fee' => 70000,
                'replacement_value' => 27000000,
                'image_path' => 'drones/m3classic_front.jpg',
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
                'image_path' => 'drones/avata2_front.jpg',
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
                'image_path' => 'drones/mavic3_front.jpg',
            ],
            [
                'name' => 'DJI Inspire 3',
                'slug' => 'dji-inspire-3',
                'description' => 'Standar emas perfilman Hollywood dan produksi komersial kelas atas. Kamera full-frame Zenmuse X9-8K Air dengan format CinemaDNG dan Apple ProRes RAW 8K/75fps, transmisi O3 Pro kontrol dual-pilot, dan akurasi posisi RTK sentimeter.',
                'camera' => '8K/75fps Full-Frame Zenmuse X9',
                'flight_time_min' => 28,
                'range_km' => 15,
                'weight_g' => 3995,
                'daily_rate' => 3500000,
                'weekly_rate' => 17500000,
                'pilot_daily_rate' => 1200000,
                'delivery_fee' => 150000,
                'replacement_value' => 175000000,
                'image_path' => 'drones/inspire3_front.jpg',
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
