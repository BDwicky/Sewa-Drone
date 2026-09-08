<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    protected $fillable = [
        'code', 'type', 'value', 'max_uses', 'used_count', 'valid_until', 'is_active',
    ];

    protected function casts(): array
    {
        return [
            'value' => 'decimal:2',
            'valid_until' => 'date',
            'is_active' => 'boolean',
        ];
    }
}
