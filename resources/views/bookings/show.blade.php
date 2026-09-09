@extends('layouts.store')

@section('title', 'Status Booking ' . $booking->code . ' — SewaDrone')

@section('content')
    <div class="mx-auto max-w-3xl px-4 sm:px-6 py-12">
        <a href="{{ route('home') }}" class="text-xs uppercase tracking-wider text-neutral-500 hover:text-black transition flex items-center gap-1.5 mb-6">
            <span>&larr;</span> Kembali ke Beranda
        </a>

        @if (session('status'))
            <div class="mb-6 rounded-lg border border-emerald-500/30 bg-emerald-50 px-4 py-3 text-xs text-emerald-800 flex items-center gap-2">
                <span class="h-1.5 w-1.5 rounded-full bg-emerald-600"></span>
                <span>{{ session('status') }}</span>
            </div>
        @endif

        <div class="rounded-2xl bg-white border border-neutral-200 p-6 sm:p-10 shadow-sm">
            <!-- Order Status Header -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-neutral-200 pb-6">
                <div>
                    <span class="text-[10px] tracking-widest text-neutral-500 font-mono uppercase font-bold block">Kode Reservasi Resmi</span>
                    <div class="font-mono text-3xl font-extrabold text-neutral-950 tracking-wider mt-1">{{ $booking->code }}</div>
                </div>
                <div class="text-left sm:text-right">
                    <x-status :status="$booking->status" />
                    @php $settled = $booking->payments->firstWhere('status', 'settlement'); @endphp
                    @if ($settled)
                        <span class="text-[11px] text-neutral-500 block mt-1">Lunas via {{ strtoupper($settled->payment_type ?? 'QRIS') }}</span>
                    @endif
                </div>
            </div>

            <!-- Booking Overview Details -->
            <dl class="mt-6 space-y-3 text-xs border-b border-neutral-200 pb-6">
                <div class="flex justify-between">
                    <dt class="text-neutral-500 uppercase tracking-wider">Unit Pesawat</dt>
                    <dd class="text-neutral-900 font-semibold">{{ $booking->drone->name }} @if($booking->with_pilot) <span class="text-neutral-600 font-mono text-[11px]">(Dengan Pilot)</span> @endif</dd>
                </div>
                <div class="flex justify-between">
                    <dt class="text-neutral-500 uppercase tracking-wider">Penyewa Terdaftar</dt>
                    <dd class="text-neutral-900 font-medium">{{ $booking->renter_name }} ({{ $booking->phone }})</dd>
                </div>
                <div class="flex justify-between">
                    <dt class="text-neutral-500 uppercase tracking-wider">Periode Penggunaan</dt>
                    <dd class="text-neutral-900 font-medium">{{ $booking->start_date->translatedFormat('d M Y') }} — {{ $booking->end_date->translatedFormat('d M Y') }} ({{ $booking->days }} Hari)</dd>
                </div>
                @if ($booking->delivery)
                    <div class="flex justify-between">
                        <dt class="text-neutral-500 uppercase tracking-wider">Layanan Logistik</dt>
                        <dd class="text-neutral-900 font-medium">Antar-Jemput Lokasi</dd>
                    </div>
                @endif
                @if ((float) $booking->discount > 0)
                    <div class="flex justify-between">
                        <dt class="text-neutral-500 uppercase tracking-wider">Potongan Voucher</dt>
                        <dd class="text-emerald-700 font-semibold">-Rp{{ number_format((float) $booking->discount, 0, ',', '.') }}</dd>
                    </div>
                @endif
                <div class="flex justify-between pt-2 border-t border-neutral-200 text-sm">
                    <dt class="text-neutral-900 font-bold uppercase tracking-wider">Total Pembayaran</dt>
                    <dd class="text-2xl font-extrabold text-neutral-950 font-mono tracking-tight">Rp{{ number_format((float) $booking->total_price, 0, ',', '.') }}</dd>
                </div>
            </dl>

            <!-- Action Section -->
            <div class="mt-8">
                @if ($booking->status === 'pending')
                    <button id="pay-button" class="w-full rounded-lg bg-black hover:bg-neutral-800 text-white font-extrabold py-4 px-6 text-xs uppercase tracking-wider transition shadow-lg border border-black flex items-center justify-center gap-2">
                        <span>Bayar Sekarang (Midtrans Snap)</span> &rarr;
                    </button>
                    <p id="pay-error" class="mt-3 text-xs text-red-600 text-center hidden"></p>
                @elseif ($booking->status === 'confirmed' && $booking->invoice)
                    <a href="{{ route('invoice.show', $booking->invoice->number) }}" target="_blank"
                       class="w-full rounded-lg bg-black hover:bg-neutral-800 text-white font-extrabold py-4 px-6 text-xs uppercase tracking-wider transition shadow-lg border border-black flex items-center justify-center gap-2">
                        <span>Buka E-Invoice Resmi & Cetak PDF</span> ↗
                    </a>
                @elseif ($booking->status === 'cancelled')
                    <div class="rounded-lg border border-red-200 bg-red-50 p-4 text-xs text-red-700 text-center">
                        Reservasi ini telah dibatalkan karena batas waktu pembayaran habis (2 jam) atau pembatalan admin.
                    </div>
                @else
                    <div class="rounded-lg border border-neutral-200 bg-neutral-50 p-4 text-xs text-neutral-700 text-center">
                        Status saat ini: <span class="text-neutral-950 font-semibold uppercase">{{ $booking->status }}</span>
                    </div>
                @endif
            </div>

            <!-- Public Track Link & Verification QR Info -->
            <div class="mt-8 pt-6 border-t border-neutral-200 text-xs text-neutral-500 flex flex-col sm:flex-row justify-between items-center gap-4">
                <p>
                    Lacak perkembangan pesanan kapan saja di:
                    <a href="{{ route('track.show', $booking->code) }}" class="text-neutral-900 font-semibold hover:underline underline-offset-4 block sm:inline font-mono">{{ route('track.show', $booking->code) }}</a>
                </p>
                @if ($booking->invoice)
                    <span class="text-[11px] text-neutral-500 font-mono">Invoice: {{ $booking->invoice->number }}</span>
                @endif
            </div>
        </div>

        @if ($booking->status === 'pending')
            <script src="https://app.sandbox.midtrans.com/snap/snap.js"
                    data-client-key="{{ config('midtrans.client_key') }}"></script>
            <script>
                document.getElementById('pay-button')?.addEventListener('click', function () {
                    const btn = this;
                    btn.disabled = true;
                    btn.innerText = 'Memuat Gerbang Pembayaran...';

                    fetch("{{ route('pay.create', $booking->code) }}")
                        .then(r => {
                            if (!r.ok) throw new Error('Gagal mendapatkan token transaksi Midtrans');
                            return r.json();
                        })
                        .then(data => {
                            btn.disabled = false;
                            btn.innerText = 'Bayar Sekarang (Midtrans Snap) →';
                            snap.pay(data.token, {
                                onSuccess: function () { location.reload(); },
                                onPending: function () { location.reload(); },
                                onError: function () {
                                    const err = document.getElementById('pay-error');
                                    err.textContent = 'Pembayaran dibatalkan atau mengalami kegagalan teknis.';
                                    err.classList.remove('hidden');
                                }
                            });
                        })
                        .catch(e => {
                            btn.disabled = false;
                            btn.innerText = 'Coba Lagi Pembayaran';
                            const err = document.getElementById('pay-error');
                            err.textContent = e.message;
                            err.classList.remove('hidden');
                        });
                });
            </script>
        @endif
    </div>
@endsection
