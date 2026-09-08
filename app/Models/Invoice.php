<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = [
        'number', 'booking_id', 'status', 'amount', 'snapshot', 'issued_at',
    ];

    protected function casts(): array
    {
        return ['amount' => 'decimal:2', 'snapshot' => 'array', 'issued_at' => 'datetime'];
    }

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}
