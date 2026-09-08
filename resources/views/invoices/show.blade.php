<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice {{ $invoice->number }}</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: -apple-system, system-ui, 'Segoe UI', Roboto, sans-serif; color: #111; background: #f1f5f9; }
        .page { max-width: 800px; margin: 24px auto; background: #fff; padding: 48px; box-shadow: 0 1px 4px rgb(0 0 0 / .1); }
        @media print { body { background: #fff; } .page { margin: 0; box-shadow: none; padding: 24px; } .no-print { display: none !important; } }
        .head { display: flex; justify-content: space-between; gap: 24px; }
        .brand { font-size: 20px; font-weight: 700; }
        .brand small { display: block; font-size: 11px; font-weight: 400; color: #64748b; margin-top: 4px; line-height: 1.5; }
        .inv-label { font-size: 28px; font-weight: 800; letter-spacing: 2px; }
        .inv-meta { font-size: 12px; color: #475569; text-align: right; line-height: 1.6; }
        .qr { text-align: right; margin-top: 8px; }
        .qr img { width: 96px; height: 96px; }
        .qr small { display: block; font-size: 9px; color: #64748b; max-width: 130px; word-break: break-all; margin-left: auto; }
        table.items { width: 100%; border-collapse: collapse; margin-top: 32px; font-size: 13px; }
        table.items th { text-align: left; border-bottom: 2px solid #0f172a; padding: 8px 6px; font-size: 11px; text-transform: uppercase; letter-spacing: .5px; }
        table.items td { padding: 10px 6px; border-bottom: 1px solid #e2e8f0; }
        .totals { margin-top: 16px; margin-left: auto; width: 260px; font-size: 13px; }
        .totals div { display: flex; justify-content: space-between; padding: 4px 6px; }
        .totals .grand { border-top: 2px solid #0f172a; font-weight: 700; font-size: 15px; padding-top: 8px; }
        .paid { display: inline-block; margin-top: 20px; padding: 6px 18px; border: 2px solid #16a34a; color: #16a34a; font-weight: 800; letter-spacing: 2px; transform: rotate(-4deg); font-size: 13px; }
        .parties { display: flex; gap: 40px; margin-top: 32px; font-size: 12px; line-height: 1.7; }
        .parties h4 { font-size: 11px; text-transform: uppercase; color: #64748b; margin-bottom: 4px; }
        .note { margin-top: 28px; font-size: 10.5px; color: #64748b; line-height: 1.7; border-top: 1px solid #e2e8f0; padding-top: 12px; }
        .btn-print { margin: 0 auto 16px; display: block; padding: 10px 22px; background: #0ea5e9; color: #fff; border: 0; border-radius: 8px; font-weight: 600; cursor: pointer; font-size: 14px; }
    </style>
</head>
<body>
    <button class="btn-print no-print" onclick="window.print()">Cetak / Simpan PDF</button>
    <div class="page">
        <div class="head">
            <div class="brand">
                {{ config('app.name') }}
                <small>Rental drone — {{ config('app.url') }}<br>WA: {{ config('services.wa.admin_number') }}</small>
            </div>
            <div>
                <div class="inv-label">INVOICE</div>
                <div class="inv-meta">
                    No: <strong>{{ $invoice->number }}</strong><br>
                    Terbit: {{ $invoice->issued_at->translatedFormat('d M Y, H:i') }} WIB<br>
                    Status: LUNAS
                </div>
                <div class="qr">
                    @if ($qrDataUri)
                        <img src="{{ $qrDataUri }}" alt="QR verifikasi">
                    @endif
                    <small>Scan untuk lacak status: {{ str_replace(['https://', 'http://'], '', $trackUrl) }}</small>
                </div>
            </div>
        </div>

        <div class="parties">
            <div>
                <h4>Kepada</h4>
                {{ $invoice->snapshot['renter_name'] ?? $invoice->booking->renter_name }}<br>
                {{ $invoice->snapshot['phone'] ?? $invoice->booking->phone }}<br>
                @if ($invoice->snapshot['email'] ?? $invoice->booking->email){{ $invoice->snapshot['email'] ?? $invoice->booking->email }}<br>@endif
            </div>
            <div>
                <h4>Transaksi</h4>
                Kode booking: <strong>{{ $invoice->booking->code }}</strong><br>
                Midtrans order: {{ $invoice->snapshot['midtrans_order_id'] ?? '-' }}<br>
                Metode: {{ strtoupper($invoice->snapshot['payment_type'] ?? '-') }}
            </div>
        </div>

        <table class="items">
            <thead>
                <tr>
                    <th>Deskripsi</th>
                    <th style="text-align:center">Qty</th>
                    <th style="text-align:right">Harga</th>
                    <th style="text-align:right">Jumlah</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        Sewa {{ $invoice->snapshot['drone_name'] }}<br>
                        <span style="color:#64748b; font-size:11px">
                            {{ \Carbon\Carbon::parse($invoice->snapshot['start_date'])->translatedFormat('d M Y') }}
                            s/d {{ \Carbon\Carbon::parse($invoice->snapshot['end_date'])->translatedFormat('d M Y') }}
                            @if ($invoice->booking->with_pilot) · termasuk pilot @endif
                            @if ($invoice->booking->delivery) · antar-jemput @endif
                        </span>
                    </td>
                    <td style="text-align:center">{{ $invoice->snapshot['days'] }} hari</td>
                    <td style="text-align:right">Rp{{ number_format((float) $invoice->booking->total_price / max(1, (int) $invoice->snapshot['days']), 0, ',', '.') }}/hari</td>
                    <td style="text-align:right">Rp{{ number_format((float) $invoice->amount + (float) $invoice->booking->discount, 0, ',', '.') }}</td>
                </tr>
                @if ((float) $invoice->booking->discount > 0)
                <tr>
                    <td>Diskon voucher</td>
                    <td></td><td></td>
                    <td style="text-align:right; color:#16a34a">-Rp{{ number_format((float) $invoice->booking->discount, 0, ',', '.') }}</td>
                </tr>
                @endif
            </tbody>
        </table>

        <div class="totals">
            <div class="grand"><span>TOTAL</span><span>Rp{{ number_format((float) $invoice->amount, 0, ',', '.') }}</span></div>
        </div>

        <div class="paid">LUNAS</div>

        <div class="note">
            Invoice ini sah tanpa tanda tangan. Pembayaran diverifikasi otomatis oleh Midtrans.<br>
            Ketentuan: identitas (KTP/SIM) atau deposit diserahkan saat pickup · telat kembali denda 50%/jam (maks 1x tarif harian) · kerusakan/hilang ditanggung penyewa.
            Lacak status sewa kapan saja: {{ $trackUrl }}
        </div>
    </div>
</body>
</html>
