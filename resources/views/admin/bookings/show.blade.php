<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl font-mono">{{ $booking->code }}</h2>
            <a href="{{ route('track.show', $booking->code) }}" target="_blank" class="text-sm text-[#38BDF8] hover:underline">Lihat halaman publik ↗</a>
        </div>
    </x-slot>

    <div class="py-8 max-w-4xl mx-auto px-4 sm:px-6">
        @if (session('status'))
            <div class="mb-4 rounded-lg border border-emerald-500/30 bg-emerald-500/10 px-4 py-3 text-sm text-emerald-400">{{ session('status') }}</div>
        @endif

        <div class="grid md:grid-cols-2 gap-6">
            <div class="bg-white/5 border border-gray-700 rounded-lg p-6">
                <h3 class="font-semibold mb-4">Detail</h3>
                <x-status :status="$booking->status" />
                <dl class="mt-4 space-y-2 text-sm">
                    <div class="flex justify-between"><dt class="text-gray-400">Drone</dt><dd>{{ $booking->drone->name }}@if($booking->with_pilot) +pilot @endif@if($booking->delivery) · antar-jemput @endif</dd></div>
                    <div class="flex justify-between"><dt class="text-gray-400">Penyewa</dt><dd>{{ $booking->renter_name }}</dd></div>
                    <div class="flex justify-between"><dt class="text-gray-400">WhatsApp</dt><dd><a href="https://wa.me/{{ preg_replace('/^0/', '62', $booking->phone) }}" target="_blank" class="text-[#38BDF8]">{{ $booking->phone }}</a></dd></div>
                    @if ($booking->email)<div class="flex justify-between"><dt class="text-gray-400">Email</dt><dd>{{ $booking->email }}</dd></div>@endif
                    <div class="flex justify-between"><dt class="text-gray-400">Periode</dt><dd>{{ $booking->start_date->format('d M Y') }} – {{ $booking->end_date->format('d M Y') }} ({{ $booking->days }} hari)</dd></div>
                    <div class="flex justify-between"><dt class="text-gray-400">Total</dt><dd class="font-semibold">Rp{{ number_format((float) $booking->total_price, 0, ',', '.') }}</dd></div>
                    @if ((float) $booking->discount > 0)<div class="flex justify-between"><dt class="text-gray-400">Diskon</dt><dd class="text-emerald-400">-Rp{{ number_format((float) $booking->discount, 0, ',', '.') }}</dd></div>@endif
                    @if ($booking->notes)<div class="flex justify-between gap-8"><dt class="text-gray-400 shrink-0">Catatan</dt><dd class="text-right">{{ $booking->notes }}</dd></div>@endif
                </dl>

                @if ($booking->invoice)
                    <a href="{{ route('invoice.show', $booking->invoice->number) }}" target="_blank" class="mt-4 inline-block text-sm text-[#38BDF8] hover:underline">Invoice: {{ $booking->invoice->number }} ↗</a>
                @endif
            </div>

            <div class="space-y-6">
                <div class="bg-white/5 border border-gray-700 rounded-lg p-6">
                    <h3 class="font-semibold mb-3">Pembayaran (Midtrans)</h3>
                    @forelse ($booking->payments as $p)
                        <div class="text-sm py-2 border-b border-gray-800 last:border-0 flex justify-between gap-3">
                            <span class="font-mono text-xs text-gray-400">{{ $p->order_id }}</span>
                            <span class="flex gap-3 items-center">
                                <span class="text-xs text-gray-400">{{ strtoupper($p->kind) }} · {{ strtoupper($p->payment_type ?? '-') }}</span>
                                <span class="font-medium">Rp{{ number_format((float) $p->gross_amount, 0, ',', '.') }}</span>
                                <span class="text-xs px-2 py-0.5 rounded {{ $p->status === 'settlement' ? 'bg-emerald-500/20 text-emerald-400' : 'bg-gray-700 text-gray-300' }}">{{ $p->status }}</span>
                            </span>
                        </div>
                    @empty
                        <p class="text-sm text-gray-500">Belum ada pembayaran.</p>
                    @endforelse
                </div>

                <div class="bg-white/5 border border-gray-700 rounded-lg p-6">
                    <h3 class="font-semibold mb-3">Ubah status</h3>
                    <form method="POST" action="{{ route('admin.bookings.status', $booking) }}" class="space-y-3">
                        @csrf
                        @method('PATCH')
                        <select name="status" class="w-full rounded-lg bg-gray-900 border border-gray-700 px-3 py-2 text-sm">
                            @foreach (['pending', 'confirmed', 'active', 'completed', 'cancelled'] as $s)
                                <option value="{{ $s }}" @selected($booking->status === $s)>{{ $s }}</option>
                            @endforeach
                        </select>
                        <input type="text" name="payment_note" value="{{ $booking->payment_note }}" placeholder="Catatan pembayaran/deposit (opsional)"
                               class="w-full rounded-lg bg-gray-900 border border-gray-700 px-3 py-2 text-sm">
                        <x-small-button>Simpan status</x-small-button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
