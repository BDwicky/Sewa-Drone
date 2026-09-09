<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.bookings.index') }}" class="p-2 rounded-xl bg-slate-800/80 hover:bg-slate-700 text-slate-400 hover:text-white transition border border-slate-700/80" title="Kembali">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                </a>
                <div>
                    <div class="flex items-center gap-2.5">
                        <h1 class="font-mono font-bold text-2xl text-white tracking-tight">{{ $booking->code }}</h1>
                        <x-status :status="$booking->status" />
                    </div>
                    <p class="text-xs text-slate-400 mt-0.5">Dibuat pada {{ $booking->created_at->translatedFormat('d M Y, H:i') }} WIB</p>
                </div>
            </div>

            <div class="flex items-center gap-2.5">
                <a href="{{ route('track.show', $booking->code) }}" target="_blank"
                   class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl text-xs font-semibold text-[#38BDF8] bg-sky-500/10 hover:bg-sky-500/20 border border-sky-500/30 transition">
                    <span>Halaman Publik Tracking</span>
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                    </svg>
                </a>

                @if ($booking->invoice)
                    <a href="{{ route('invoice.show', $booking->invoice->number) }}" target="_blank"
                       class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl text-xs font-semibold text-slate-200 bg-slate-800 hover:bg-slate-700 border border-slate-700 transition">
                        <span>Lihat Invoice</span>
                        <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </a>
                @endif
            </div>
        </div>
    </x-slot>

    <div class="py-8 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
        @if (session('status'))
            <div class="rounded-xl border border-emerald-500/30 bg-emerald-500/10 p-4 text-sm text-emerald-400 flex items-center gap-2.5 shadow-lg shadow-emerald-950/20">
                <svg class="w-5 h-5 text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>{{ session('status') }}</span>
            </div>
        @endif

        <!-- Quick Status Progression Actions -->
        <div class="p-4 rounded-2xl bg-[#0F172A]/90 border border-slate-800/90 shadow-xl backdrop-blur flex flex-wrap items-center justify-between gap-4">
            <div class="flex items-center gap-2">
                <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Aksi Cepat Status:</span>
                <span class="text-xs text-slate-300">Saat ini: <strong class="text-white uppercase">{{ $booking->status }}</strong></span>
            </div>

            <div class="flex flex-wrap items-center gap-2">
                @if ($booking->status === 'pending')
                    <form method="POST" action="{{ route('admin.bookings.status', $booking) }}" class="inline">
                        @csrf @method('PATCH')
                        <input type="hidden" name="status" value="confirmed">
                        <button type="submit" class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-xl text-xs font-bold bg-emerald-500 text-slate-950 hover:bg-emerald-400 transition shadow-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <span>Konfirmasi Pesanan</span>
                        </button>
                    </form>
                @endif

                @if ($booking->status === 'confirmed')
                    <form method="POST" action="{{ route('admin.bookings.status', $booking) }}" class="inline">
                        @csrf @method('PATCH')
                        <input type="hidden" name="status" value="active">
                        <button type="submit" class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-xl text-xs font-bold bg-[#38BDF8] text-[#0B1220] hover:bg-[#7DD3FC] transition shadow-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                            <span>Mulai Sewa (Unit Diambil)</span>
                        </button>
                    </form>
                @endif

                @if ($booking->status === 'active')
                    <form method="POST" action="{{ route('admin.bookings.status', $booking) }}" class="inline">
                        @csrf @method('PATCH')
                        <input type="hidden" name="status" value="completed">
                        <button type="submit" class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-xl text-xs font-bold bg-emerald-500 text-slate-950 hover:bg-emerald-400 transition shadow-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>Selesaikan Sewa (Unit Kembali Baik)</span>
                        </button>
                    </form>
                @endif

                @if ($booking->status !== 'cancelled' && $booking->status !== 'completed')
                    <form method="POST" action="{{ route('admin.bookings.status', $booking) }}" class="inline" onsubmit="return confirm('Yakin ingin membatalkan pesanan ini?')">
                        @csrf @method('PATCH')
                        <input type="hidden" name="status" value="cancelled">
                        <button type="submit" class="inline-flex items-center gap-1 px-3 py-1.5 rounded-xl text-xs font-semibold bg-rose-500/10 text-rose-400 hover:bg-rose-500/20 border border-rose-500/30 transition">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            <span>Batalkan</span>
                        </button>
                    </form>
                @endif
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left 2 Cols: Details -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Unit Drone Card -->
                <div class="p-6 rounded-2xl bg-[#0F172A]/90 border border-slate-800/90 shadow-xl backdrop-blur">
                    <h2 class="text-sm font-bold text-white uppercase tracking-wider mb-4 flex items-center gap-2">
                        <svg class="w-4 h-4 text-[#38BDF8]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                        </svg>
                        <span>Armada Yang Dipesan</span>
                    </h2>

                    <div class="flex flex-col sm:flex-row items-start gap-4">
                        <div class="w-24 h-24 rounded-xl bg-slate-800/80 border border-slate-700/80 flex items-center justify-center overflow-hidden shrink-0">
                            @if ($booking->drone->image_path)
                                <img src="{{ asset('storage/'.$booking->drone->image_path) }}" alt="{{ $booking->drone->name }}" class="w-full h-full object-cover">
                            @else
                                <svg class="w-8 h-8 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                                </svg>
                            @endif
                        </div>
                        <div class="flex-1">
                            <h3 class="text-lg font-bold text-white">{{ $booking->drone->name }}</h3>
                            <p class="text-xs text-slate-400 mt-1 line-clamp-2">{{ $booking->drone->description ?? 'Unit drone sewa terawat dan siap terbang.' }}</p>

                            <div class="flex flex-wrap gap-2 mt-3">
                                @if ($booking->drone->camera)
                                    <span class="px-2 py-1 rounded-lg bg-slate-800/80 text-[11px] text-slate-300 border border-slate-700">
                                        📷 {{ $booking->drone->camera }}
                                    </span>
                                @endif
                                @if ($booking->drone->flight_time_min)
                                    <span class="px-2 py-1 rounded-lg bg-slate-800/80 text-[11px] text-slate-300 border border-slate-700">
                                        ⏱️ {{ $booking->drone->flight_time_min }} Menit / Batt
                                    </span>
                                @endif
                                @if ($booking->with_pilot)
                                    <span class="px-2 py-1 rounded-lg bg-sky-500/10 text-[11px] text-[#38BDF8] border border-sky-500/20 font-semibold">
                                        + Pilot Berlisensi APDI
                                    </span>
                                @else
                                    <span class="px-2 py-1 rounded-lg bg-slate-800/60 text-[11px] text-slate-400 border border-slate-700">
                                        Lepas Kunci (Self-fly)
                                    </span>
                                @endif
                                @if ($booking->delivery)
                                    <span class="px-2 py-1 rounded-lg bg-emerald-500/10 text-[11px] text-emerald-400 border border-emerald-500/20 font-semibold">
                                        Layanan Antar-Jemput Lokasi
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Detail Penyewa & Kontak Card -->
                <div class="p-6 rounded-2xl bg-[#0F172A]/90 border border-slate-800/90 shadow-xl backdrop-blur">
                    <h2 class="text-sm font-bold text-white uppercase tracking-wider mb-4 flex items-center gap-2">
                        <svg class="w-4 h-4 text-[#38BDF8]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        <span>Informasi Penyewa & Verifikasi Kontak</span>
                    </h2>

                    <div class="grid sm:grid-cols-2 gap-4">
                        <div class="p-3.5 rounded-xl bg-slate-900/60 border border-slate-800">
                            <span class="text-xs text-slate-400 block mb-1">Nama Lengkap</span>
                            <span class="font-semibold text-white">{{ $booking->renter_name }}</span>
                        </div>

                        <div class="p-3.5 rounded-xl bg-slate-900/60 border border-slate-800 flex items-center justify-between">
                            <div>
                                <span class="text-xs text-slate-400 block mb-1">Nomor WhatsApp</span>
                                <span class="font-semibold text-white font-mono">{{ $booking->phone }}</span>
                            </div>
                            <a href="https://wa.me/{{ preg_replace('/^0/', '62', $booking->phone) }}?text={{ urlencode('Halo Kak '.$booking->renter_name.', kami dari Sewa Drone mengonfirmasi pesanan Anda dengan kode '.$booking->code.'.') }}"
                               target="_blank"
                               class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-emerald-500/10 text-emerald-400 hover:bg-emerald-500/20 border border-emerald-500/30 text-xs font-semibold transition">
                                <span>Hubungi WA</span>
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                </svg>
                            </a>
                        </div>

                        @if ($booking->email)
                            <div class="p-3.5 rounded-xl bg-slate-900/60 border border-slate-800">
                                <span class="text-xs text-slate-400 block mb-1">Email</span>
                                <span class="font-medium text-white">{{ $booking->email }}</span>
                            </div>
                        @endif

                        <div class="p-3.5 rounded-xl bg-slate-900/60 border border-slate-800">
                            <span class="text-xs text-slate-400 block mb-1">Metode Serah Terima</span>
                            <span class="font-medium text-white">{{ $booking->delivery ? 'Antar-Jemput ke Alamat Penyewa' : 'Ambil Mandiri di Hub Sewa Drone' }}</span>
                        </div>
                    </div>

                    @if ($booking->notes)
                        <div class="mt-4 p-3.5 rounded-xl bg-slate-900/40 border border-slate-800">
                            <span class="text-xs text-slate-400 block mb-1">Catatan Tambahan Penyewa</span>
                            <p class="text-sm text-slate-200">{{ $booking->notes }}</p>
                        </div>
                    @endif
                </div>

                <!-- Rincian Biaya Sewa Card -->
                <div class="p-6 rounded-2xl bg-[#0F172A]/90 border border-slate-800/90 shadow-xl backdrop-blur">
                    <h2 class="text-sm font-bold text-white uppercase tracking-wider mb-4 flex items-center gap-2">
                        <svg class="w-4 h-4 text-[#38BDF8]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                        </svg>
                        <span>Rincian Biaya & Jadwal</span>
                    </h2>

                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between py-2 border-b border-slate-800">
                            <span class="text-slate-400">Jadwal Tanggal</span>
                            <span class="font-semibold text-white">{{ $booking->start_date->translatedFormat('d M Y') }} – {{ $booking->end_date->translatedFormat('d M Y') }} ({{ $booking->days }} Hari)</span>
                        </div>

                        <div class="flex justify-between py-2 border-b border-slate-800">
                            <span class="text-slate-400">Tarif Sewa Drone ({{ $booking->days }} hari)</span>
                            <span class="font-mono text-white">Rp{{ number_format((float) ($booking->drone->daily_rate * $booking->days), 0, ',', '.') }}</span>
                        </div>

                        @if ($booking->with_pilot)
                            <div class="flex justify-between py-2 border-b border-slate-800">
                                <span class="text-slate-400">Jasa Pilot ({{ $booking->days }} hari)</span>
                                <span class="font-mono text-white">Rp{{ number_format((float) (($booking->drone->pilot_daily_rate ?? 0) * $booking->days), 0, ',', '.') }}</span>
                            </div>
                        @endif

                        @if ($booking->delivery)
                            <div class="flex justify-between py-2 border-b border-slate-800">
                                <span class="text-slate-400">Biaya Antar-Jemput Armada</span>
                                <span class="font-mono text-white">Rp{{ number_format((float) ($booking->drone->delivery_fee ?? 0), 0, ',', '.') }}</span>
                            </div>
                        @endif

                        @if ((float) $booking->discount > 0)
                            <div class="flex justify-between py-2 border-b border-slate-800">
                                <span class="text-emerald-400">Potongan Diskon Promo</span>
                                <span class="font-mono text-emerald-400">-Rp{{ number_format((float) $booking->discount, 0, ',', '.') }}</span>
                            </div>
                        @endif

                        <div class="flex justify-between pt-3 text-base font-bold">
                            <span class="text-white">Total Tagihan Final</span>
                            <span class="text-xl text-[#38BDF8] font-mono">Rp{{ number_format((float) $booking->total_price, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right 1 Col: Status Update & Payment -->
            <div class="space-y-6">
                <!-- Status Update Card -->
                <div class="p-6 rounded-2xl bg-[#0F172A]/90 border border-slate-800/90 shadow-xl backdrop-blur">
                    <h2 class="text-sm font-bold text-white uppercase tracking-wider mb-4 flex items-center gap-2">
                        <svg class="w-4 h-4 text-[#38BDF8]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                        <span>Ubah Status Manual</span>
                    </h2>

                    <form method="POST" action="{{ route('admin.bookings.status', $booking) }}" class="space-y-4">
                        @csrf
                        @method('PATCH')

                        <div>
                            <label class="block text-xs font-semibold uppercase tracking-wider text-slate-400 mb-1.5">Status Booking</label>
                            <select name="status" class="w-full rounded-xl bg-[#0B1220] border border-slate-700 px-3.5 py-2.5 text-sm text-white focus:border-[#38BDF8] focus:ring-1 focus:ring-[#38BDF8]">
                                @foreach (['pending' => 'Pending (Menunggu Bayar)', 'confirmed' => 'Confirmed (Dikonfirmasi)', 'active' => 'Active (Sedang Disewa)', 'completed' => 'Completed (Selesai)', 'cancelled' => 'Cancelled (Dibatalkan)'] as $val => $label)
                                    <option value="{{ $val }}" @selected($booking->status === $val)>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold uppercase tracking-wider text-slate-400 mb-1.5">Catatan Pembayaran / Jaminan</label>
                            <input type="text" name="payment_note" value="{{ $booking->payment_note }}" placeholder="Contoh: KTP & Deposit Rp500k dititipkan"
                                   class="w-full rounded-xl bg-[#0B1220] border border-slate-700 px-3.5 py-2.5 text-sm text-white placeholder-slate-500 focus:border-[#38BDF8] focus:ring-1 focus:ring-[#38BDF8]">
                        </div>

                        <button type="submit" class="w-full py-2.5 rounded-xl font-bold text-xs bg-[#38BDF8] text-[#0B1220] hover:bg-[#7DD3FC] transition shadow-md shadow-sky-500/20 flex items-center justify-center gap-1.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <span>Simpan Perubahan Status</span>
                        </button>
                    </form>
                </div>

                <!-- Midtrans Payment Logs Card -->
                <div class="p-6 rounded-2xl bg-[#0F172A]/90 border border-slate-800/90 shadow-xl backdrop-blur">
                    <h2 class="text-sm font-bold text-white uppercase tracking-wider mb-4 flex items-center gap-2">
                        <svg class="w-4 h-4 text-[#38BDF8]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                        </svg>
                        <span>Log Midtrans Snap</span>
                    </h2>

                    @forelse ($booking->payments as $p)
                        <div class="p-3.5 rounded-xl bg-slate-900/60 border border-slate-800 mb-3 last:mb-0 space-y-2">
                            <div class="flex items-center justify-between">
                                <span class="font-mono text-xs text-slate-400">{{ $p->order_id }}</span>
                                <span class="text-xs px-2 py-0.5 rounded-full font-bold {{ $p->status === 'settlement' ? 'bg-emerald-500/10 text-emerald-400 border border-emerald-500/20' : 'bg-amber-500/10 text-amber-400 border border-amber-500/20' }}">
                                    {{ strtoupper($p->status) }}
                                </span>
                            </div>
                            <div class="flex items-center justify-between text-xs">
                                <span class="text-slate-400">{{ strtoupper($p->payment_type ?? 'MIDTRANS') }} · {{ strtoupper($p->kind) }}</span>
                                <span class="font-bold text-white font-mono">Rp{{ number_format((float) $p->gross_amount, 0, ',', '.') }}</span>
                            </div>
                            @if ($p->settled_at)
                                <div class="text-[11px] text-slate-500">
                                    Lunas: {{ $p->settled_at->translatedFormat('d M Y, H:i') }} WIB
                                </div>
                            @endif
                        </div>
                    @empty
                        <div class="text-center py-6 text-slate-500 text-xs">
                            Belum ada riwayat transaksi Midtrans untuk pesanan ini.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
