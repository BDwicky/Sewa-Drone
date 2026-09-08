<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_id', 'order_id', 'snap_token', 'status', 'kind',
        'payment_type', 'fraud_status', 'gross_amount', 'raw_payload',
    ];

    protected function casts(): array
    {
        return ['gross_amount' => 'decimal:2', 'raw_payload' => 'array'];
    }

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}
