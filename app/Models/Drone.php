<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Drone extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'slug', 'description', 'camera', 'flight_time_min',
        'range_km', 'weight_g', 'daily_rate', 'weekly_rate',
        'pilot_daily_rate', 'delivery_fee', 'replacement_value',
        'stock', 'image_path', 'is_active',
    ];

    protected function casts(): array
    {
        return [
            'daily_rate' => 'decimal:2',
            'weekly_rate' => 'decimal:2',
            'pilot_daily_rate' => 'decimal:2',
            'delivery_fee' => 'decimal:2',
            'replacement_value' => 'decimal:2',
            'is_active' => 'boolean',
        ];
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
