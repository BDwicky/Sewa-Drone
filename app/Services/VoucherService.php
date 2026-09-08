<?php

namespace App\Services;

use App\Models\Voucher as VoucherModel;

/**
 * Voucher sederhana (phase 4.5): percent|fixed, valid_until, max_uses.
 * Return nilai diskon (0 bila tidak valid). No-op bila tabel belum ada.
 */
class VoucherService
{
    public static function apply(string $code, float $total): float
    {
        try {
            $voucher = VoucherModel::where('code', strtoupper($code))
                ->where('is_active', true)
                ->where(fn ($q) => $q->whereNull('valid_until')->orWhere('valid_until', '>=', now()))
                ->where(fn ($q) => $q->whereNull('max_uses')->orWhereColumn('used_count', '<', 'max_uses'))
                ->first();
        } catch (\Throwable) {
            return 0.0;
        }

        if (! $voucher) {
            return 0.0;
        }

        $discount = $voucher->type === 'percent'
            ? $total * ((float) $voucher->value / 100)
            : (float) $voucher->value;

        $discount = min($discount, $total);

        $voucher->increment('used_count');

        return round($discount, 2);
    }
}
