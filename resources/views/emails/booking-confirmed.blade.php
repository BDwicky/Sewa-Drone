<!DOCTYPE html>
<html lang="id">
<body style="margin:0; padding:24px; background:#f1f5f9; font-family:system-ui,-apple-system,'Segoe UI',Roboto,sans-serif;">
    <div style="max-width:560px; margin:0 auto; background:#ffffff; border-radius:12px; overflow:hidden; border:1px solid #e2e8f0;">
        <div style="padding:24px 28px; background:#0f172a;">
            <span style="color:#38bdf8; font-size:18px; font-weight:700;">SewaDrone</span>
        </div>
        <div style="padding:28px;">
            <p style="margin:0 0 4px; color:#64748b; font-size:13px;">Halo {{ $booking->renter_name }},</p>
            <h2 style="margin:0 0 16px; font-size:20px; color:#0f172a;">Pembayaran diterima ✔</h2>
            <p style="margin:0 0 20px; color:#334155; font-size:14px; line-height:1.6;">
                Booking <strong>{{ $booking->code }}</strong> untuk <strong>{{ $booking->drone->name }}</strong>
                telah dikonfirmasi. Kami menunggu Anda pada <strong>{{ $booking->start_date->translatedFormat('d M Y') }}</strong>.
            </p>
            <table style="width:100%; border-collapse:collapse; font-size:14px; margin-bottom:20px;">
                <tr><td style="padding:8px 0; color:#64748b;">Periode</td><td style="text-align:right; font-weight:600;">{{ $booking->start_date->translatedFormat('d M') }} — {{ $booking->end_date->translatedFormat('d M Y') }} ({{ $booking->days }} hari)</td></tr>
                <tr><td style="padding:8px 0; color:#64748b;">Total dibayar</td><td style="text-align:right; font-weight:700; color:#0284c7;">Rp{{ number_format((float) $booking->total_price, 0, ',', '.') }}</td></tr>
            </table>
            <p style="margin:0 0 20px; color:#64748b; font-size:12px; line-height:1.7;">
                Saat pickup, bawa KTP/SIM asli atau deposit sesuai kebijakan. Telat kembali kena denda 50%/jam.
            </p>
            <a href="{{ route('invoice.show', $booking->invoice?->number ?? $booking->code) }}" style="display:inline-block; background:#0284c7; color:#ffffff; padding:11px 22px; border-radius:8px; text-decoration:none; font-weight:600; font-size:14px;">Lihat Invoice</a>
            <p style="margin:20px 0 0; font-size:12px; color:#94a3b8;">
                Lacak status: <a href="{{ route('track.show', $booking->code) }}" style="color:#0284c7;">{{ route('track.show', $booking->code) }}</a>
            </p>
        </div>
    </div>
</body>
</html>
