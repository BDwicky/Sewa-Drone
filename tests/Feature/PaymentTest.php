<?php

namespace Tests\Feature;

use App\Mail\BookingConfirmedMail;
use App\Models\Booking;
use App\Models\Invoice;
use App\Models\Payment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class PaymentTest extends TestCase
{
    use RefreshDatabase;

    private function sign(array $payload): array
    {
        $payload['status_code'] = '200';
        $payload['signature_key'] = hash('sha512',
            $payload['order_id'].$payload['status_code'].$payload['gross_amount'].Config::get('midtrans.server_key')
        );

        return $payload;
    }

    public function test_webhook_settlement_mengubah_payment_booking_dan_membuat_invoice(): void
    {
        Mail::fake();

        $booking = Booking::factory()->create(['status' => 'pending', 'total_price' => 1050000]);
        $payment = Payment::create([
            'booking_id' => $booking->id, 'order_id' => $booking->code.'-1', 'gross_amount' => 1050000,
        ]);

        $payload = $this->sign([
            'order_id' => $payment->order_id,
            'transaction_status' => 'settlement',
            'payment_type' => 'qris',
            'fraud_status' => 'accept',
            'gross_amount' => '1050000.00',
        ]);

        $this->postJson(route('midtrans.webhook'), $payload)->assertNoContent();

        $this->assertEquals('settlement', $payment->fresh()->status);
        $this->assertEquals('confirmed', $booking->fresh()->status);

        $invoice = Invoice::where('booking_id', $booking->id)->first();
        $this->assertNotNull($invoice);
        $this->assertStringStartsWith('INV/', $invoice->number);
        $this->assertEquals(1050000.0, (float) $invoice->amount);
        $this->assertArrayHasKey('drone_name', $invoice->snapshot);

        Mail::assertSent(BookingConfirmedMail::class);
    }

    public function test_webhook_dengan_gross_amount_salah_ditolak(): void
    {
        $booking = Booking::factory()->create(['status' => 'pending', 'total_price' => 1050000]);
        $payment = Payment::create([
            'booking_id' => $booking->id, 'order_id' => $booking->code.'-1', 'gross_amount' => 1050000,
        ]);

        $payload = $this->sign([
            'order_id' => $payment->order_id,
            'transaction_status' => 'settlement',
            'gross_amount' => '999.00',
        ]);

        $this->postJson(route('midtrans.webhook'), $payload)->assertForbidden();
        $this->assertEquals('pending', $booking->fresh()->status);
    }

    public function test_webhook_settlement_ulang_tidak_membuat_invoice_ganda(): void
    {
        Mail::fake();

        $booking = Booking::factory()->create(['status' => 'pending', 'total_price' => 1050000]);
        $payment = Payment::create([
            'booking_id' => $booking->id, 'order_id' => $booking->code.'-1', 'gross_amount' => 1050000,
        ]);

        $payload = $this->sign([
            'order_id' => $payment->order_id,
            'transaction_status' => 'settlement',
            'payment_type' => 'qris',
            'gross_amount' => '1050000.00',
        ]);

        $this->postJson(route('midtrans.webhook'), $payload)->assertNoContent();
        $this->postJson(route('midtrans.webhook'), $payload)->assertNoContent();

        $this->assertEquals(1, Invoice::where('booking_id', $booking->id)->count());
    }

    public function test_halaman_tracking_menampilkan_status(): void
    {
        $booking = Booking::factory()->create(['status' => 'confirmed', 'total_price' => 1050000]);

        $this->get(route('track.show', $booking->code))
            ->assertOk()
            ->assertSee($booking->code)
            ->assertSee('Dikonfirmasi');

        $this->get(route('track.show', 'DRN-TIDAKADA'))->assertNotFound();
    }

    public function test_halaman_invoice_tampil_dengan_qr_dan_nomor(): void
    {
        $booking = Booking::factory()->create(['status' => 'confirmed', 'total_price' => 1050000]);
        $invoice = Invoice::create([
            'number' => 'INV/'.now()->format('Y-m').'/'.$booking->code,
            'booking_id' => $booking->id,
            'amount' => 1050000,
            'issued_at' => now(),
            'snapshot' => ['drone_name' => $booking->drone->name, 'days' => 3,
                'start_date' => $booking->start_date->toDateString(),
                'end_date' => $booking->end_date->toDateString(),
                'renter_name' => $booking->renter_name, 'phone' => $booking->phone,
                'payment_type' => 'qris', 'midtrans_order_id' => $booking->code.'-1'],
        ]);

        $this->get(route('invoice.show', $invoice->number))
            ->assertOk()
            ->assertSee($invoice->number)
            ->assertSee($booking->drone->name)
            ->assertSee('/track/'.$booking->code)
            ->assertSee('data:image/png;base64');
    }
}
