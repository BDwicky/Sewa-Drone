<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Booking extends Model
{
    use HasFactory;

    public const ACTIVE_STATUSES = ['pending', 'confirmed', 'active'];

    protected $fillable = [
        'code', 'drone_id', 'renter_name', 'phone', 'email',
        'start_date', 'end_date', 'days', 'total_price', 'discount',
        'with_pilot', 'delivery', 'status', 'notes', 'payment_note',
    ];

    protected function casts(): array
    {
        return [
            'start_date' => 'date:Y-m-d',
            'end_date' => 'date:Y-m-d',
            'total_price' => 'decimal:2',
            'discount' => 'decimal:2',
            'with_pilot' => 'boolean',
            'delivery' => 'boolean',
        ];
    }

    public function drone(): BelongsTo
    {
        return $this->belongsTo(Drone::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function invoice()
    {
        return $this->hasOne(Invoice::class);
    }

    /** Booking yang menghalangi rentang [start..end] untuk drone tertentu. */
    public function scopeOverlapping(Builder $query, int $droneId, Carbon $start, Carbon $end): Builder
    {
        return $query->where('drone_id', $droneId)
            ->whereIn('status', self::ACTIVE_STATUSES)
            ->whereDate('start_date', '<=', $end->toDateString())
            ->whereDate('end_date', '>=', $start->toDateString());
    }

    public static function generateCode(): string
    {
        do {
            $code = 'DRN-'.strtoupper(Str::random(6));
        } while (self::where('code', $code)->exists());

        return $code;
    }

    public static function calcDays(Carbon $start, Carbon $end): int
    {
        return (int) $start->diffInDays($end) + 1; // inklusif kedua tanggal
    }

    /** Total sewa: tarif mingguan untuk blok 7 hari + harian untuk sisa. */
    public static function calcPrice(Drone $drone, int $days, bool $withPilot = false, bool $delivery = false): float
    {
        $base = 0.0;
        if ($days >= 7 && $drone->weekly_rate) {
            $base = floor($days / 7) * (float) $drone->weekly_rate + ($days % 7) * (float) $drone->daily_rate;
        } else {
            $base = $days * (float) $drone->daily_rate;
        }

        if ($withPilot && $drone->pilot_daily_rate) {
            $base += $days * (float) $drone->pilot_daily_rate;
        }
        if ($delivery && $drone->delivery_fee) {
            $base += (float) $drone->delivery_fee;
        }

        return round($base, 2);
    }
}
