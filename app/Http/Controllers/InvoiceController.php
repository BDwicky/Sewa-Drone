<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Illuminate\View\View;

class InvoiceController extends Controller
{
    public function show(string $number): View
    {
        $invoice = Invoice::where('number', $number)->with('booking.drone')->firstOrFail();

        $trackUrl = route('track.show', $invoice->booking->code);
        $qrDataUri = null;
        try {
            $result = (new PngWriter)->write(
                new QrCode(data: $trackUrl, size: 220, margin: 2)
            );
            $qrDataUri = $result->getDataUri();
        } catch (\Throwable $e) {
            report($e); // invoice tetap tampil tanpa QR bila lib gagal
        }

        return view('invoices.show', [
            'invoice' => $invoice,
            'qrDataUri' => $qrDataUri,
            'trackUrl' => $trackUrl,
        ]);
    }
}
