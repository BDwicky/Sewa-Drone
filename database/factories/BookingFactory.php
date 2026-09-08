<?php

namespace Database\Factories;

use App\Models\Drone;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class BookingFactory extends Factory
{
    public function definition(): array
    {
        $start = now()->addDays(rand(3, 20));

        return [
            'code' => 'DRN-'.strtoupper(Str::random(6)),
            'drone_id' => Drone::factory(),
            'renter_name' => $this->faker->name(),
            'phone' => '08'.rand(1111111111, 9999999999),
            'email' => $this->faker->safeEmail(),
            'start_date' => $start->toDateString(),
            'end_date' => $start->addDays(2)->toDateString(),
            'days' => 3,
            'total_price' => 1050000,
            'status' => 'pending',
        ];
    }
}
