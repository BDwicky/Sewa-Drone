<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Payment;
use App\Services\Notify;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SnapController extends Controller
{
    /** Buat/renew snap token untuk booking pending (atau yang expired cancel). */
    public function create(Booking $booking): JsonResponse
    {
        abort_unless(in_array($booking->status, ['pending', 'cancelled']), 403);
        if ($booking->status === 'cancelled') {
            $booking->update(['status' => 'pending']); // re-open dari expire
        }

        $orderId = $booking->code.'-'.time();

        $payload = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => (float) $booking->total_price,
            ],
            'customer_details' => array_filter([
                'first_name' => $booking->renter_name,
                'phone' => $booking->phone,
                'email' => $booking->email,
            ]),
            'item_details' => [[
                'id' => $booking->drone->slug,
                'price' => (float) $booking->total_price,
                'quantity' => 1,
                'name' => sprintf('Sewa %s %d hari', $booking->drone->name, $booking->days),
            ]],
        ];

        $apiBase = config('midtrans.is_production')
            ? 'https://app.midtrans.com/snap/v1/transactions'
            : 'https://app.sandbox.midtrans.com/snap/v1/transactions';

        $resp = \Illuminate\Support\Facades\Http::withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Authorization' => 'Basic '.base64_encode(config('midtrans.server_key').':'),
        ])->post($apiBase, $payload);

        abort_unless($resp->successful(), 502, 'Midtrans error: '.$resp->body());

        $payment = Payment::create([
            'booking_id' => $booking->id,
            'order_id' => $orderId,
            'snap_token' => $resp->json('token'),
            'gross_amount' => $booking->total_price,
        ]);

        return response()->json(['token' => $payment->snap_token, 'order_id' => $orderId]);
    }

    public function finish(Request $request)
    {
        $orderId = (string) $request->query('order_id', '');
        $code = explode('-', $orderId)[0] ?? '';
        $booking = Booking::where('code', $code)->first();

        return $booking
            ? redirect()->route('bookings.show', $booking->code)
            : redirect()->route('home');
    }

    /** Webhook server-to-server dari Midtrans. Verifikasi signature + integritas nominal. */
    public function webhook(Request $request)
    {
        $payload = $request->all();

        $expected = hash('sha512',
            ($payload['order_id'] ?? '').
            ($payload['status_code'] ?? '').
            ($payload['gross_amount'] ?? '').
            config('midtrans.server_key')
        );
        abort_unless(hash_equals($expected, (string) ($payload['signature_key'] ?? '')), 403);

        $payment = Payment::where('order_id', $payload['order_id'] ?? '')->firstOrFail();
        abort_unless(abs((float) ($payload['gross_amount'] ?? 0) - (float) $payment->gross_amount) < 0.001, 403);

        $map = [
            'settlement' => 'settlement',
            'capture' => 'settlement',
            'deny' => 'deny',
            'cancel' => 'cancel',
            'expire' => 'expire',
            'refund' => 'refund',
        ];
        $status = $map[$payload['transaction_status']] ?? 'pending';

        $payment->update([
            'status' => $status,
            'payment_type' => $payload['payment_type'] ?? null,
            'fraud_status' => $payload['fraud_status'] ?? null,
            'raw_payload' => $payload,
        ]);

        if ($status === 'settlement' && $payment->kind === 'rental' && $payment->booking->status === 'pending') {
            $booking = $payment->booking;
            $booking->update(['status' => 'confirmed']);

            // E-invoice otomatis (idempotent)
            \App\Models\Invoice::firstOrCreate(
                ['number' => 'INV/'.$booking->created_at->format('Y-m').'/'.$booking->code],
                [
                    'booking_id' => $booking->id,
                    'amount' => $booking->total_price,
                    'issued_at' => now(),
                    'snapshot' => [
                        'drone_name' => $booking->drone->name,
                        'days' => $booking->days,
                        'start_date' => $booking->start_date->toDateString(),
                        'end_date' => $booking->end_date->toDateString(),
                        'renter_name' => $booking->renter_name,
                        'phone' => $booking->phone,
                        'payment_type' => $payment->payment_type,
                        'midtrans_order_id' => $payment->order_id,
                    ],
                ],
            );

            Notify::bookingPaid($booking);

            if ($booking->email) {
                try {
                    \Illuminate\Support\Facades\Mail::to($booking->email)
                        ->send(new \App\Mail\BookingConfirmedMail($booking));
                } catch (\Throwable $e) {
                    report($e);
                }
            }
        }

        return response()->noContent();
    }
}
