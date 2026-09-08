@extends('layouts.store')

@section('title', 'Booking '.$drone->name)

@section('content')
    <div class="mx-auto max-w-3xl px-4 py-10">
        <a href="{{ route('drones.show', $drone) }}" class="text-sm text-[#94A3B8] hover:text-white">&larr; {{ $drone->name }}</a>

        <h1 class="mt-4 text-2xl font-bold">Form booking</h1>
        <p class="mt-1 text-sm text-[#94A3B8]">Isi data, lanjut bayar via QRIS / VA / e-wallet.</p>

        <x-card class="mt-6 p-6">
            <form action="{{ route('bookings.store', $drone) }}" method="POST" id="booking-form" class="space-y-4">
                @csrf
                <div class="grid sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-medium text-[#94A3B8] mb-1.5">Nama lengkap *</label>
                        <input type="text" name="renter_name" required value="{{ old('renter_name') }}"
                               class="w-full rounded-lg bg-[#0B1220] border border-[#24334F] px-3 py-2.5 text-sm focus:border-[#38BDF8] focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-[#94A3B8] mb-1.5">No. WhatsApp *</label>
                        <input type="tel" name="phone" required value="{{ old('phone') }}" placeholder="08xxxxxxxxxx"
                               class="w-full rounded-lg bg-[#0B1220] border border-[#24334F] px-3 py-2.5 text-sm focus:border-[#38BDF8] focus:outline-none">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-medium text-[#94A3B8] mb-1.5">Email (untuk invoice)</label>
                    <input type="email" name="email" value="{{ old('email') }}"
                           class="w-full rounded-lg bg-[#0B1220] border border-[#24334F] px-3 py-2.5 text-sm focus:border-[#38BDF8] focus:outline-none">
                </div>

                <div class="grid sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-medium text-[#94A3B8] mb-1.5">Tanggal mulai *</label>
                        <input type="date" id="start_date" name="start_date" required
                               value="{{ old('start_date', $start_date) }}" min="{{ now()->toDateString() }}"
                               class="w-full rounded-lg bg-[#0B1220] border border-[#24334F] px-3 py-2.5 text-sm focus:border-[#38BDF8] focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-[#94A3B8] mb-1.5">Tanggal selesai *</label>
                        <input type="date" id="end_date" name="end_date" required
                               value="{{ old('end_date', $end_date) }}" min="{{ now()->toDateString() }}"
                               class="w-full rounded-lg bg-[#0B1220] border border-[#24334F] px-3 py-2.5 text-sm focus:border-[#38BDF8] focus:outline-none">
                    </div>
                </div>

                @if ($drone->pilot_daily_rate)
                    <label class="flex items-center gap-3 text-sm">
                        <input type="checkbox" name="with_pilot" value="1" @checked(old('with_pilot')) class="accent-[#38BDF8] h-4 w-4">
                        <span>Dengan pilot/operator <span class="text-[#94A3B8]">(+Rp{{ number_format((float)$drone->pilot_daily_rate, 0, ',', '.') }}/hari)</span></span>
                    </label>
                @endif

                @if ($drone->delivery_fee)
                    <label class="flex items-center gap-3 text-sm">
                        <input type="checkbox" name="delivery" value="1" @checked(old('delivery')) class="accent-[#38BDF8] h-4 w-4">
                        <span>Antar-jemput unit <span class="text-[#94A3B8]">(+Rp{{ number_format((float)$drone->delivery_fee, 0, ',', '.') }})</span></span>
                    </label>
                @endif

                <div>
                    <label class="block text-xs font-medium text-[#94A3B8] mb-1.5">Kode voucher (opsional)</label>
                    <input type="text" name="voucher_code" value="{{ old('voucher_code') }}" placeholder="Mis. HEBOH10"
                           class="w-full rounded-lg bg-[#0B1220] border border-[#24334F] px-3 py-2.5 text-sm uppercase focus:border-[#38BDF8] focus:outline-none">
                </div>

                <div>
                    <label class="block text-xs font-medium text-[#94A3B8] mb-1.5">Catatan (opsional)</label>
                    <textarea name="notes" rows="2" class="w-full rounded-lg bg-[#0B1220] border border-[#24334F] px-3 py-2.5 text-sm focus:border-[#38BDF8] focus:outline-none">{{ old('notes') }}</textarea>
                </div>

                @if (config('services.turnstile.site_key'))
                    <div class="cf-turnstile" data-sitekey="{{ config('services.turnstile.site_key') }}"></div>
                @endif

                <div class="border-t border-[#24334F] pt-4 flex items-center justify-between">
                    <div>
                        <span class="text-xs text-[#94A3B8]">Estimasi</span>
                        <div id="estimate" class="font-semibold text-lg text-[#38BDF8]">—</div>
                    </div>
                    <x-btn type="submit">Lanjut ke pembayaran</x-btn>
                </div>

                @error('start_date')<p class="text-sm text-[#F87171]">{{ $message }}</p>@enderror
                @error('end_date')<p class="text-sm text-[#F87171]">{{ $message }}</p>@enderror
                @error('renter_name')<p class="text-sm text-[#F87171]">{{ $message }}</p>@enderror
                @error('phone')<p class="text-sm text-[#F87171]">{{ $message }}</p>@enderror
                @error('cf-turnstile-response')<p class="text-sm text-[#F87171]">{{ $message }}</p>@enderror
            </form>
        </x-card>

        <p class="mt-4 text-xs text-[#94A3B8]">Dengan melanjutkan, Anda menyetujui <a href="{{ route('pages.kebijakan') }}" class="text-[#38BDF8] hover:underline">kebijakan sewa</a> (identitas/deposit saat pickup, denda keterlambatan, tanggung jawab kerusakan).</p>
    </div>

    <script src="https://challenges.cloudflare.com/turnstile/v0/api.js" defer></script>
    <script>
        (function () {
            const daily = {{ (float) $drone->daily_rate }};
            const weekly = {{ $drone->weekly_rate ? (float) $drone->weekly_rate : 'null' }};
            const pilot = {{ $drone->pilot_daily_rate ? (float) $drone->pilot_daily_rate : 0 }};
            const delivery = {{ $drone->delivery_fee ? (float) $drone->delivery_fee : 0 }};
            const fmt = new Intl.NumberFormat('id-ID');
            const startEl = document.getElementById('start_date');
            const endEl = document.getElementById('end_date');
            const estEl = document.getElementById('estimate');

            function days() {
                if (!startEl.value || !endEl.value) return 0;
                const d = (new Date(endEl.value) - new Date(startEl.value)) / 86400000 + 1;
                return d > 0 ? d : 0;
            }

            function update() {
                const n = days();
                if (!n) { estEl.textContent = '—'; return; }
                let total = (weekly && n >= 7)
                    ? Math.floor(n / 7) * weekly + (n % 7) * daily
                    : n * daily;
                if (document.querySelector('[name=with_pilot]')?.checked) total += n * pilot;
                if (document.querySelector('[name=delivery]')?.checked) total += delivery;
                estEl.textContent = n + ' hari · Rp' + fmt.format(total);
            }

            [startEl, endEl].forEach(el => el.addEventListener('change', update));
            document.querySelectorAll('[name=with_pilot], [name=delivery]').forEach(el => el.addEventListener('change', update));
            update();

            // Disable tanggal yang sudah dibooking (availability API)
            fetch("{{ route('drones.availability', $drone) }}")
                .then(r => r.json())
                .then(ranges => {
                    const booked = new Set();
                    ranges.forEach(r => {
                        let d = new Date(r.from);
                        const end = new Date(r.to);
                        while (d <= end) { booked.add(d.toISOString().slice(0, 10)); d.setDate(d.getDate() + 1); }
                    });
                    [startEl, endEl].forEach(el => {
                        el.addEventListener('change', () => {
                            if (booked.has(el.value)) { el.value = ''; el.reportValidity(); }
                        });
                    });
                });
        })();
    </script>
@endsection
