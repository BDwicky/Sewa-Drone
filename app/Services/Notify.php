<?php

namespace App\Services;

use App\Models\Booking;

/**
 * Notifikasi ringkas: WA admin via Fonnte + helper lain.
 * No-op bila FONNTE_TOKEN belum diisi (sandbox/dev).
 */
class Notify
{
    public static function admin(string $text): void
    {
        $token = config('services.fonnte.token');
        if (! $token) {
            return;
        }

        try {
            \Illuminate\Support\Facades\Http::withHeaders(['Authorization' => $token])
                ->post('https://api.fonnte.com/send', [
                    'target' => config('services.wa.admin_number'),
                    'message' => $text,
                ]);
        } catch (\Throwable $e) {
            report($e);
        }
    }

    public static function bookingCreated(Booking $b): void
    {
        self::admin(sprintf(
            "Booking BARU %s\n%s — %s\n%s s/d %s (%d hari)%s\nTotal: Rp%s\nStatus: MENUNGGU PEMBAYARAN\nhttps://preview.primafam.me/track/%s",
            $b->code,
            $b->renter_name,
            $b->drone->name,
            $b->start_date->format('d M'),
            $b->end_date->format('d M Y'),
            $b->days,
            $b->with_pilot ? ' +pilot' : '',
            number_format((float) $b->total_price, 0, ',', '.'),
            $b->code,
        ));
    }

    public static function bookingPaid(Booking $b): void
    {
        self::admin(sprintf(
            "LUNAS %s — %s (%s)\nSudah dibayar. Siapkan pickup %s.\nInvoice: https://preview.primafam.me/track/%s",
            $b->code,
            $b->renter_name,
            $b->drone->name,
            $b->start_date->format('d M Y'),
            $b->code,
        ));
    }
}
