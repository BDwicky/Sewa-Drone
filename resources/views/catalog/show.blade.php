@extends('layouts.store')

@section('title', $drone->name . ' — Sewa Drone DJI Resmi')

@section('content')
    <!-- Product Hero Header (Inspirasi DJI Product Page) -->
    <div class="border-b border-white/10 bg-[#06080D]">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 py-4 flex items-center justify-between text-xs">
            <div class="flex items-center gap-3">
                <a href="{{ route('home') }}" class="text-gray-400 hover:text-white transition">&larr; Armada</a>
                <span class="text-gray-600">/</span>
                <span class="font-bold text-white tracking-wide uppercase">{{ $drone->name }}</span>
            </div>
            <div class="flex items-center gap-4">
                <span class="text-gray-400 hidden sm:inline">Mulai dari <strong class="text-white">Rp{{ number_format((float) $drone->daily_rate, 0, ',', '.') }}/hari</strong></span>
                <a href="#booking-section" class="rounded bg-sky-400 hover:bg-sky-300 text-black px-3 py-1.5 font-semibold uppercase tracking-wider text-[11px] transition">
                    Sewa Unit
                </a>
            </div>
        </div>
    </div>

    <div class="mx-auto max-w-7xl px-4 sm:px-6 py-12">
        <div class="grid gap-12 lg:grid-cols-[1.3fr_1fr] items-start">
            <!-- Left: Cinematic Media & Detailed Technical Specs -->
            <div>
                <!-- Main Aircraft Showcase Canvas -->
                <div class="relative rounded-2xl bg-gradient-to-b from-[#121826] to-[#080B11] border border-white/10 p-8 sm:p-12 overflow-hidden flex items-center justify-center min-h-[380px]">
                    <div class="absolute inset-0 bg-[radial-gradient(circle_at_top,rgba(56,189,248,0.08)_0%,transparent_60%)] pointer-events-none"></div>

                    @if ($drone->image_path)
                        <img src="{{ asset('storage/'.$drone->image_path) }}" alt="{{ $drone->name }}" class="max-h-[320px] w-auto object-contain z-10 drop-shadow-[0_25px_35px_rgba(0,0,0,0.8)]">
                    @else
                        <!-- Detailed Aerospace Schematic Emblem -->
                        <div class="text-center z-10 py-6">
                            <svg class="h-32 w-32 text-sky-400/80 mx-auto stroke-[1.1]" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <path d="M4 8h4V4M16 4v4h4M20 16h-4v4M8 20v-4H4" stroke-linecap="round"/>
                                <circle cx="12" cy="12" r="3"/>
                                <circle cx="6" cy="6" r="1.5"/>
                                <circle cx="18" cy="6" r="1.5"/>
                                <circle cx="6" cy="18" r="1.5"/>
                                <circle cx="18" cy="18" r="1.5"/>
                                <line x1="12" y1="9" x2="12" y2="6" stroke-dasharray="1 1"/>
                                <line x1="12" y1="15" x2="12" y2="18" stroke-dasharray="1 1"/>
                                <line x1="9" y1="12" x2="6" y2="12" stroke-dasharray="1 1"/>
                                <line x1="15" y1="12" x2="18" y2="12" stroke-dasharray="1 1"/>
                            </svg>
                            <span class="text-[11px] font-mono tracking-[0.25em] text-gray-400 uppercase mt-4 block">DJI AIRCRAFT SYSTEM ARCHITECTURE</span>
                        </div>
                    @endif

                    <div class="absolute bottom-4 left-6 text-[10px] font-mono text-gray-500 uppercase">
                        Unit ID: {{ strtoupper($drone->slug) }} // O4 TRANSMISSION
                    </div>
                </div>

                <!-- Product Statement Title -->
                <div class="mt-8">
                    <span class="text-xs uppercase tracking-[0.2em] text-sky-400 font-bold block mb-1">
                        @if ($drone->weight_g < 250)
                            Regulasi Aman: Di Bawah 249 Gram Bebas Sertifikasi
                        @else
                            Performa Kamera Sinematik Tingkat Lanjut
                        @endif
                    </span>
                    <h1 class="text-3xl sm:text-4xl font-extrabold text-white tracking-tight uppercase">{{ $drone->name }}</h1>
                    <p class="mt-4 text-sm text-gray-400 leading-relaxed font-light">
                        {{ $drone->description }}
                    </p>
                </div>

                <!-- Technical Specs HUD Matrix -->
                <div class="mt-10">
                    <h3 class="text-xs uppercase tracking-widest text-gray-400 font-semibold mb-4 border-b border-white/10 pb-2">Spesifikasi Kunci Pesawat</h3>
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                        <div class="rounded-lg bg-white/[0.03] border border-white/5 p-4">
                            <span class="text-[10px] uppercase tracking-wider text-gray-400 block">Sistem Kamera</span>
                            <span class="text-base font-bold text-white mt-1 block">{{ $drone->camera }}</span>
                        </div>
                        <div class="rounded-lg bg-white/[0.03] border border-white/5 p-4">
                            <span class="text-[10px] uppercase tracking-wider text-gray-400 block">Durasi Terbang</span>
                            <span class="text-base font-bold text-white mt-1 block">{{ $drone->flight_time_min }} Menit</span>
                        </div>
                        <div class="rounded-lg bg-white/[0.03] border border-white/5 p-4">
                            <span class="text-[10px] uppercase tracking-wider text-gray-400 block">Jangkauan Max</span>
                            <span class="text-base font-bold text-white mt-1 block">{{ $drone->range_km }} KM</span>
                        </div>
                        <div class="rounded-lg bg-white/[0.03] border border-white/5 p-4">
                            <span class="text-[10px] uppercase tracking-wider text-gray-400 block">Bobot Lepas Landas</span>
                            <span class="text-base font-bold text-white mt-1 block">{{ $drone->weight_g }} Gram</span>
                        </div>
                    </div>
                </div>

                <!-- Paket Kelengkapan Rental Box (Inspirasi DJI In The Box) -->
                <div class="mt-10 rounded-xl bg-white/[0.02] border border-white/5 p-6">
                    <h3 class="text-xs uppercase tracking-wider text-white font-bold mb-4 flex items-center gap-2">
                        <span class="h-2 w-2 rounded-full bg-sky-400"></span>
                        Kelengkapan Standar Sewa (In The Box)
                    </h3>
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-3 text-xs text-gray-300">
                        <div class="flex items-center gap-2"><span>&bull;</span> 1x Unit Drone {{ $drone->name }}</div>
                        <div class="flex items-center gap-2"><span>&bull;</span> 1x DJI Remote Controller (RC)</div>
                        <div class="flex items-center gap-2"><span>&bull;</span> 2x Intelligent Flight Battery</div>
                        <div class="flex items-center gap-2"><span>&bull;</span> 1x Two-Way Charging Hub</div>
                        <div class="flex items-center gap-2"><span>&bull;</span> 1x Set ND Filter Profesional</div>
                        <div class="flex items-center gap-2"><span>&bull;</span> 1x Waterproof Hard Case</div>
                    </div>
                </div>

                <!-- Aturan Sewa & Tanggung Jawab -->
                <div class="mt-8 hud-spec text-xs text-gray-400 space-y-2 border-sky-500/40">
                    <p class="text-white font-semibold uppercase tracking-wider">Ketentuan sewa & SOP keamanan</p>
                    <p>Wajib menitipkan KTP/SIM asli atau deposit uang saat serah terima unit di lokasi.</p>
                    <p>Keterlambatan pengembalian unit dikenakan penyesuaian denda 50%/jam, maksimal 1x tarif harian.</p>
                    <p>Kerusakan operasional ditanggung penyewa sesuai estimasi spare-part resmi DJI. Nilai unit baru: <x-price :amount="$drone->replacement_value ?? 0" class="text-white font-bold" />.</p>
                    @if ($drone->weight_g >= 250)
                        <p class="text-sky-400">Unit di atas 249g tunduk pada Permenhub PM 37/2020 untuk penerbangan komersial bersertifikasi.</p>
                    @endif
                </div>
            </div>

            <!-- Right: Sticky Booking & Availability Card -->
            <div id="booking-section" class="sticky top-20">
                <div class="dji-card rounded-2xl p-6 sm:p-8">
                    <div class="flex items-baseline justify-between border-b border-white/10 pb-5">
                        <div>
                            <span class="text-[10px] tracking-widest text-gray-400 uppercase block font-medium">Tarif Sewa Harian</span>
                            <div class="text-3xl font-extrabold text-white tracking-tight mt-1">
                                Rp{{ number_format((float) $drone->daily_rate, 0, ',', '.') }}
                                <span class="text-xs text-gray-400 font-normal">/ hari</span>
                            </div>
                        </div>
                        @if ($drone->weekly_rate)
                            <div class="text-right">
                                <span class="text-[10px] tracking-widest text-sky-400 uppercase block font-semibold">Paket Mingguan</span>
                                <span class="text-sm font-bold text-gray-200">Rp{{ number_format((float) $drone->weekly_rate, 0, ',', '.') }}</span>
                            </div>
                        @endif
                    </div>

                    <form action="{{ route('bookings.create', $drone) }}" method="GET" class="mt-6 space-y-4">
                        <div>
                            <label class="block text-xs font-semibold text-gray-300 uppercase tracking-wider mb-2">Tanggal Mulai Sewa</label>
                            <input type="date" name="start_date" required min="{{ now()->toDateString() }}"
                                   class="w-full rounded-lg bg-[#06080D] border border-white/15 px-3.5 py-3 text-sm text-white focus:border-sky-400 focus:outline-none focus:ring-1 focus:ring-sky-400 transition">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-300 uppercase tracking-wider mb-2">Tanggal Selesai Sewa</label>
                            <input type="date" name="end_date" required min="{{ now()->toDateString() }}"
                                   class="w-full rounded-lg bg-[#06080D] border border-white/15 px-3.5 py-3 text-sm text-white focus:border-sky-400 focus:outline-none focus:ring-1 focus:ring-sky-400 transition">
                        </div>

                        <div class="pt-2">
                            <button type="submit" class="w-full rounded-lg bg-sky-400 hover:bg-sky-300 text-black font-bold py-3.5 px-4 text-xs uppercase tracking-wider transition shadow-lg shadow-sky-500/20 flex items-center justify-center gap-2">
                                <span>Cek ketersediaan & Pesan</span> &rarr;
                            </button>
                        </div>
                    </form>

                    <div class="mt-6 pt-5 border-t border-white/10 text-[11px] text-gray-400 space-y-2">
                        <div class="flex items-center gap-2">
                            <svg class="h-4 w-4 text-emerald-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            <span>Pembayaran instan otomatis via Midtrans (QRIS/VA)</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <svg class="h-4 w-4 text-emerald-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            <span>E-Invoice sah diterbitkan seketika dengan QR verifikasi</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
