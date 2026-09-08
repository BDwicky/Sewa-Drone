@extends('layouts.store')

@section('title', 'Booking '.$booking->code)

@section('content')
    <div class="mx-auto max-w-3xl px-4 py-10">
        @if (session('status'))
            <div class="mb-4 rounded-lg border border-[#34D399]/30 bg-[#34D399]/10 px-4 py-3 text-sm text-[#34D399]">{{ session('status') }}</div>
        @endif

        <h1 class="text-2xl font-bold">Booking diterima</h1>

        <x-card class="mt-6 p-6">
            <div class="flex items-center justify-between gap-4">
                <div>
                    <span class="text-xs text-[#94A3B8]">Kode booking</span>
                    <div class="font-mono text-2xl font-bold tracking-wider">{{ $booking->code }}</div>
                </div>
                <div class="text-right">
                    <x-status :status="$booking->status" />
                    @if ($booking->payments->where('status', 'settlement')->isNotEmpty())
                        <div class="mt-1 text-xs text-[#94A3B8]">Lunas via {{ $booking->payments->firstWhere('status', 'settlement')->payment_type ?? 'midtrans' }}</div>
                    @endif
                </div>
            </div>

            <dl class="mt-6 space-y-2.5 text-sm border-t border-[#24334F] pt-5">
                <div class="flex justify-between"><dt class="text-[#94A3B8]">Drone</dt><dd class="font-medium">{{ $booking->drone->name }}@if($booking->with_pilot) <span class="text-[#94A3B8]">+ pilot</span>@endif</dd></div>
                <div class="flex justify-between"><dt class="text-[#94A3B8]">Periode</dt><dd class="font-medium">{{ $booking->start_date->translatedFormat('d M Y') }} — {{ $booking->end_date->translatedFormat('d M Y') }} ({{ $booking->days }} hari)</dd></div>
                @if ($booking->delivery)<div class="flex justify-between"><dt class="text-[#94A3B8]">Layanan</dt><dd class="font-medium">Antar-jemput unit</dd></div>@endif
                @if ((float) $booking->discount > 0)<div class="flex justify-between"><dt class="text-[#94A3B8]">Diskon</dt><dd class="font-medium text-[#34D399]">-Rp{{ number_format((float) $booking->discount, 0, ',', '.') }}</dd></div>@endif
                <div class="flex justify-between border-t border-[#24334F] pt-3 text-base"><dt>Total</dt><dd><x-price :amount="$booking->total_price" class="text-xl" /></dd></div>
            </dl>

            <div class="mt-7">
                @if ($booking->status === 'pending')
                    <x-btn id="pay-button" class="w-full">Bayar Sekarang — <x-price :amount="$booking->total_price" /></x-btn>
                    <p id="pay-error" class="mt-2 text-xs text-[#F87171] hidden"></p>
                @elseif ($booking->status === 'confirmed' && $booking->invoice)
                    <a href="{{ route('invoice.show', $booking->invoice->number) }}" target="_blank"
                       class="w-full inline-flex items-center justify-center gap-2 rounded-lg bg-[#38BDF8] px-4 py-2.5 text-sm font-semibold text-[#0B1220] hover:bg-[#0EA5E9] transition">
                        Lihat / Unduh Invoice (PDF)
                    </a>
                @elseif ($booking->status === 'cancelled')
                    <div class="rounded-lg border border-[#F87171]/30 bg-[#F87171]/10 px-4 py-3 text-sm text-[#F87171]">
                        Booking dibatalkan (kedaluwarsa atau dibatalkan admin). Silakan buat booking baru.
                    </div>
                @else
                    <div class="rounded-lg border border-[#24334F] px-4 py-3 text-sm text-[#94A3B8]">
                        Status: <x-status :status="$booking->status" class="ml-1" />
                    </div>
                @endif
            </div>

            <p class="mt-5 text-xs text-[#94A3B8] leading-relaxed">
                Simpan kode booking Anda. Lacak status kapan saja di
                <a href="{{ route('track.show', $booking->code) }}" class="text-[#38BDF8] hover:underline">{{ route('track.show', $booking->code) }}</a>.
                Pickup: bawa KTP/SIM asli atau deposit sesuai kebijakan.
            </p>
        </x-card>

        @if ($booking->status === 'pending' && $booking->payments->first()?->snap_token)
            <script src="https://app.sandbox.midtrans.com/snap/snap.js"
                    data-client-key="{{ config('midtrans.client_key') }}"></script>
            <script>
                document.getElementById('pay-button').addEventListener('click', function () {
                    snap.pay('{{ $booking->payments->first()->snap_token }}', {
                        onSuccess: function () { location.reload(); },
                        onPending: function () { location.reload(); },
                        onError: function () {
                            const el = document.getElementById('pay-error');
                            el.textContent = 'Pembayaran gagal. Silakan coba lagi.';
                            el.classList.remove('hidden');
                        }
                    });
                });
            </script>
        @endif
    </div>
@endsection
