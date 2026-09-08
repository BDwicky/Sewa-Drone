<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class DroneFactory extends Factory
{
    public function definition(): array
    {
        $name = 'DJI Mini 4 Pro';

        return [
            'name' => $name,
            'slug' => Str::slug($name.'-'.Str::random(4)),
            'description' => 'Drone kompak dengan sensor 1/1.3-inch, cocok untuk travel dan konten.',
            'camera' => '4K/60fps HDR',
            'flight_time_min' => 34,
            'range_km' => 20,
            'weight_g' => 249,
            'daily_rate' => 350000,
            'weekly_rate' => 1750000,
            'pilot_daily_rate' => null,
            'delivery_fee' => null,
            'replacement_value' => 12000000,
            'stock' => 1,
            'is_active' => true,
        ];
    }
}
