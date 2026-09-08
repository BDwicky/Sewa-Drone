@extends('layouts.store')

@section('title', 'Reservasi ' . $drone->name . ' — SewaDrone')

@section('content')
    <div class="mx-auto max-w-4xl px-4 sm:px-6 py-12">
        <a href="{{ route('drones.show', $drone) }}" class="text-xs uppercase tracking-wider text-gray-400 hover:text-white transition flex items-center gap-1.5 mb-6">
            <span>&larr;</span> Kembali ke {{ $drone->name }}
        </a>

        <div class="border-b border-white/10 pb-6 mb-8">
            <span class="text-xs uppercase tracking-[0.2em] text-sky-400 font-bold block mb-1">Prosedur Reservasi Online</span>
            <h1 class="text-3xl font-extrabold text-white tracking-tight uppercase">FORMULIR SEWA ARMADA</h1>
            <p class="text-xs text-gray-400 mt-2">
                Unit akan direservasi selama 2 jam setelah formulir dikirimkan untuk penyelesaian transaksi via Midtrans Snap.
            </p>
        </div>

        <div class="grid md:grid-cols-[1.3fr_1fr] gap-8 items-start">
            <!-- Form Input Pro-Gear -->
            <div class="dji-card rounded-xl p-6 sm:p-8">
                <form action="{{ route('bookings.store', $drone) }}" method="POST" id="booking-form" class="space-y-5">
                    @csrf
                    <div>
                        <label class="block text-xs uppercase tracking-wider font-semibold text-gray-300 mb-1.5">Nama Lengkap Sesuai KTP *</label>
                        <input type="text" name="renter_name" required value="{{ old('renter_name') }}" placeholder="Contoh: Budi Santoso"
                               class="w-full rounded-lg bg-[#06080D] border border-white/15 px-3.5 py-2.5 text-sm text-white focus:border-sky-400 focus:outline-none focus:ring-1 focus:ring-sky-400 transition">
                    </div>

                    <div>
                        <label class="block text-xs uppercase tracking-wider font-semibold text-gray-300 mb-1.5">Nomor WhatsApp Aktif *</label>
                        <input type="tel" name="phone" required value="{{ old('phone') }}" placeholder="0812xxxxxxxx"
                               class="w-full rounded-lg bg-[#06080D] border border-white/15 px-3.5 py-2.5 text-sm text-white focus:border-sky-400 focus:outline-none focus:ring-1 focus:ring-sky-400 transition">
                    </div>

                    <div>
                        <label class="block text-xs uppercase tracking-wider font-semibold text-gray-300 mb-1.5">Alamat Email (Pengiriman E-Invoice)</label>
                        <input type="email" name="email" value="{{ old('email') }}" placeholder="nama@domain.com"
                               class="w-full rounded-lg bg-[#06080D] border border-white/15 px-3.5 py-2.5 text-sm text-white focus:border-sky-400 focus:outline-none focus:ring-1 focus:ring-sky-400 transition">
                    </div>

                    <div class="grid sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs uppercase tracking-wider font-semibold text-gray-300 mb-1.5">Mulai Sewa *</label>
                            <input type="date" id="start_date" name="start_date" required
                                   value="{{ old('start_date', $start_date) }}" min="{{ now()->toDateString() }}"
                                   class="w-full rounded-lg bg-[#06080D] border border-white/15 px-3 py-2.5 text-sm text-white focus:border-sky-400 focus:outline-none transition">
                        </div>
                        <div>
                            <label class="block text-xs uppercase tracking-wider font-semibold text-gray-300 mb-1.5">Selesai Sewa *</label>
                            <input type="date" id="end_date" name="end_date" required
                                   value="{{ old('end_date', $end_date) }}" min="{{ now()->toDateString() }}"
                                   class="w-full rounded-lg bg-[#06080D] border border-white/15 px-3 py-2.5 text-sm text-white focus:border-sky-400 focus:outline-none transition">
                        </div>
                    </div>

                    <!-- Add-ons Pro Section -->
                    <div class="pt-3 border-t border-white/10 space-y-3">
                        @if ($drone->pilot_daily_rate)
                            <label class="flex items-center gap-3 cursor-pointer p-3 rounded-lg bg-white/[0.02] border border-white/5 hover:border-white/20 transition">
                                <input type="checkbox" name="with_pilot" value="1" @checked(old('with_pilot')) class="accent-sky-400 h-4 w-4 rounded">
                                <div class="text-xs">
                                    <span class="text-white font-medium block">Tambahkan Pilot / Operator Resmi</span>
                                    <span class="text-gray-400">+Rp{{ number_format((float)$drone->pilot_daily_rate, 0, ',', '.') }}/hari (Pilot berpengalaman & berlisensi)</span>
                                </div>
                            </label>
                        @endif

                        @if ($drone->delivery_fee)
                            <label class="flex items-center gap-3 cursor-pointer p-3 rounded-lg bg-white/[0.02] border border-white/5 hover:border-white/20 transition">
                                <input type="checkbox" name="delivery" value="1" @checked(old('delivery')) class="accent-sky-400 h-4 w-4 rounded">
                                <div class="text-xs">
                                    <span class="text-white font-medium block">Layanan Antar-Jemput Lokasi</span>
                                    <span class="text-gray-400">+Rp{{ number_format((float)$drone->delivery_fee, 0, ',', '.') }} (Diantar langsung ke lokasi Anda)</span>
                                </div>
                            </label>
                        @endif
                    </div>

                    <div>
                        <label class="block text-xs uppercase tracking-wider font-semibold text-gray-300 mb-1.5">Kode Voucher Promosi</label>
                        <input type="text" name="voucher_code" value="{{ old('voucher_code') }}" placeholder="Ketik kode (opsional)"
                               class="w-full rounded-lg bg-[#06080D] border border-white/15 px-3.5 py-2.5 text-sm uppercase text-white tracking-widest focus:border-sky-400 focus:outline-none transition">
                    </div>

                    <div>
                        <label class="block text-xs uppercase tracking-wider font-semibold text-gray-300 mb-1.5">Catatan Keperluan Khusus (Opsional)</label>
                        <textarea name="notes" rows="2" placeholder="Tuliskan tujuan pemakaian (contoh: shooting wedding luar ruangan)"
                                  class="w-full rounded-lg bg-[#06080D] border border-white/15 px-3.5 py-2.5 text-sm text-white focus:border-sky-400 focus:outline-none transition">{{ old('notes') }}</textarea>
                    </div>

                    @if (config('services.turnstile.site_key'))
                        <div class="cf-turnstile" data-sitekey="{{ config('services.turnstile.site_key') }}"></div>
                    @endif

                    @error('start_date')<p class="text-xs text-red-400 font-medium">{{ $message }}</p>@enderror
                    @error('end_date')<p class="text-xs text-red-400 font-medium">{{ $message }}</p>@enderror
                    @error('renter_name')<p class="text-xs text-red-400 font-medium">{{ $message }}</p>@enderror
                    @error('phone')<p class="text-xs text-red-400 font-medium">{{ $message }}</p>@enderror
                    @error('cf-turnstile-response')<p class="text-xs text-red-400 font-medium">{{ $message }}</p>@enderror

                    <div class="pt-4 border-t border-white/10">
                        <button type="submit" class="w-full rounded-lg bg-sky-400 hover:bg-sky-300 text-black font-bold py-3.5 px-4 text-xs uppercase tracking-wider transition shadow-lg shadow-sky-500/20">
                            Konfirmasi & Bayar via Midtrans &rarr;
                        </button>
                    </div>
                </form>
            </div>

            <!-- Order Summary Floating Panel -->
            <div class="dji-card rounded-xl p-6 sticky top-20">
                <span class="text-[10px] tracking-widest text-sky-400 uppercase font-bold block mb-1">Rincian Perhitungan</span>
                <h3 class="text-lg font-bold text-white tracking-tight">{{ $drone->name }}</h3>
                <p class="text-xs text-gray-400 mt-1 mb-6">{{ $drone->camera }} · {{ $drone->flight_time_min }} Menit Terbang</p>

                <div class="space-y-3 text-xs border-y border-white/10 py-4">
                    <div class="flex justify-between">
                        <span class="text-gray-400">Tarif Dasar Harian</span>
                        <span class="text-white font-medium">Rp{{ number_format((float) $drone->daily_rate, 0, ',', '.') }}</span>
                    </div>
                    @if ($drone->weekly_rate)
                        <div class="flex justify-between">
                            <span class="text-gray-400">Tarif Paket 7 Hari</span>
                            <span class="text-white font-medium">Rp{{ number_format((float) $drone->weekly_rate, 0, ',', '.') }}</span>
                        </div>
                    @endif
                    <div class="flex justify-between">
                        <span class="text-gray-400">Durasi Terpilih</span>
                        <span id="summary-days" class="text-white font-semibold">—</span>
                    </div>
                </div>

                <div class="pt-4">
                    <span class="text-[11px] uppercase tracking-wider text-gray-400 block">Total Perkiraan Biaya</span>
                    <div id="estimate" class="text-2xl font-extrabold text-white tracking-tight mt-1">—</div>
                </div>

                <div class="mt-6 pt-4 border-t border-white/10 text-[11px] text-gray-400 space-y-2">
                    <p class="flex items-center gap-1.5"><span class="h-1.5 w-1.5 rounded-full bg-emerald-400"></span> Pembayaran aman dengan QRIS otomatis</p>
                    <p class="flex items-center gap-1.5"><span class="h-1.5 w-1.5 rounded-full bg-emerald-400"></span> E-Invoice resmi diterbitkan seketika</p>
                </div>
            </div>
        </div>
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
            const daysEl = document.getElementById('summary-days');

            function calculateDays() {
                if (!startEl.value || !endEl.value) return 0;
                const d = (new Date(endEl.value) - new Date(startEl.value)) / 86400000 + 1;
                return d > 0 ? d : 0;
            }

            function update() {
                const n = calculateDays();
                if (!n) {
                    estEl.textContent = '—';
                    daysEl.textContent = '—';
                    return;
                }
                daysEl.textContent = n + ' Hari';
                let total = (weekly && n >= 7)
                    ? Math.floor(n / 7) * weekly + (n % 7) * daily
                    : n * daily;
                if (document.querySelector('[name=with_pilot]')?.checked) total += n * pilot;
                if (document.querySelector('[name=delivery]')?.checked) total += delivery;
                estEl.textContent = 'Rp' + fmt.format(total);
            }

            [startEl, endEl].forEach(el => el.addEventListener('change', update));
            document.querySelectorAll('[name=with_pilot], [name=delivery]').forEach(el => el.addEventListener('change', update));
            update();

            // Availability verification
            fetch("{{ route('drones.availability', $drone) }}")
                .then(r => r.json())
                .then(ranges => {
                    const booked = new Set();
                    ranges.forEach(r => {
                        let d = new Date(r.from);
                        const end = new Date(r.to);
                        while (d <= end) {
                            booked.add(d.toISOString().slice(0, 10));
                            d.setDate(d.getDate() + 1);
                        }
                    });
                    [startEl, endEl].forEach(el => {
                        el.addEventListener('change', () => {
                            if (booked.has(el.value)) {
                                alert('Maaf, tanggal tersebut telah dibooking oleh penyewa lain. Silakan tentukan tanggal berbeda.');
                                el.value = '';
                                update();
                            }
                        });
                    });
                });
        })();
    </script>
@endsection
