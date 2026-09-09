@extends('layouts.store')

@section('title', 'Sewa Drone DJI Resmi — Armada Lengkap Harian & Mingguan')

@section('content')
    <!-- DJI Hero Cinematic Section -->
    <section class="relative min-h-[75vh] flex items-center justify-center overflow-hidden border-b border-white/10 bg-[#06080D]">
        <!-- Radial atmospheric glow -->
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_center,rgba(14,165,233,0.12)_0%,rgba(6,8,13,0)_70%)] pointer-events-none"></div>

        <div class="relative z-10 mx-auto max-w-5xl px-4 sm:px-6 py-20 text-center">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full border border-sky-500/30 bg-sky-500/10 text-sky-400 text-xs tracking-wider uppercase mb-6 font-medium">
                <span class="h-1.5 w-1.5 rounded-full bg-sky-400 animate-ping"></span>
                Ready To Fly · Unit Resmi Terawat
            </div>

            <h1 class="text-4xl sm:text-6xl md:text-7xl font-extrabold tracking-tight text-white uppercase leading-[1.05]">
                TANGKAP SETIAP SUDUT<br>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-sky-400 via-white to-sky-200">SINEMATIK UDARA</span>
            </h1>

            <p class="mt-6 text-base sm:text-lg text-gray-400 max-w-2xl mx-auto font-light leading-relaxed">
                Penyewaan armada drone DJI flagship di Indonesia. Pilihan tepat untuk videografi wedding, dokumenter, survei udara, dan konten perjalanan. Pembayaran otomatis & e-invoice resmi seketika.
            </p>

            <!-- Quick Specs HUD Bar (Inspirasi DJI Specs Strip) -->
            <div class="mt-12 grid grid-cols-2 md:grid-cols-4 gap-4 max-w-3xl mx-auto text-left border-y border-white/10 py-6">
                <div class="hud-spec">
                    <span class="block text-2xl font-bold text-white tracking-tight">4K / 5.1K</span>
                    <span class="text-[11px] uppercase tracking-wider text-gray-400">Sensor Hasselblad & HDR</span>
                </div>
                <div class="hud-spec">
                    <span class="block text-2xl font-bold text-white tracking-tight">Hingga 45m</span>
                    <span class="text-[11px] uppercase tracking-wider text-gray-400">Durasi Terbang per Baterai</span>
                </div>
                <div class="hud-spec">
                    <span class="block text-2xl font-bold text-white tracking-tight">20 KM</span>
                    <span class="text-[11px] uppercase tracking-wider text-gray-400">Transmisi Video O4 FHD</span>
                </div>
                <div class="hud-spec">
                    <span class="block text-2xl font-bold text-white tracking-tight">&lt; 249g</span>
                    <span class="text-[11px] uppercase tracking-wider text-gray-400">Tersedia Bebas Sertifikasi</span>
                </div>
            </div>

            <div class="mt-10 flex items-center justify-center gap-4">
                <a href="#fleet" class="rounded-lg bg-white text-black hover:bg-sky-400 hover:text-black font-semibold text-xs uppercase tracking-wider px-6 py-3 transition shadow-lg shadow-white/10">
                    Jelajahi Armada &rarr;
                </a>
                <a href="{{ route('pages.kebijakan') }}" class="rounded-lg border border-white/20 hover:border-white text-white text-xs uppercase tracking-wider px-6 py-3 transition">
                    Syarat & Tata Cara
                </a>
            </div>
        </div>
    </section>

    <!-- Product Showcase Grid (DJI Product Family Layout) -->
    <section id="fleet" class="mx-auto max-w-7xl px-4 sm:px-6 py-20">
        <div class="flex flex-col md:flex-row md:items-end justify-between mb-12 border-b border-white/10 pb-6">
            <div>
                <span class="text-xs uppercase tracking-[0.25em] text-sky-400 font-semibold block mb-1">Armada Pilihan</span>
                <h2 class="text-2xl sm:text-3xl font-bold text-white tracking-tight">PILIH DRONE SESUAI KEBUTUHAN ANDA</h2>
            </div>
            <p class="text-xs text-gray-400 mt-2 md:mt-0 max-w-md">
                Setiap unit lengkap dengan remote controller, baterai cadangan, hard case, filter ND, dan kabel data lengkap.
            </p>
        </div>

        <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-2">
            @forelse ($drones as $drone)
                <div class="dji-card rounded-xl overflow-hidden p-6 sm:p-8 flex flex-col justify-between">
                    <div>
                        <!-- Header Card -->
                        <div class="flex items-start justify-between">
                            <div>
                                <span class="text-[10px] tracking-widest text-sky-400 uppercase font-semibold block">
                                    @if ($drone->slug === 'dji-mini-4-pro')
                                        Ultra-Lightweight · Travel
                                    @elseif ($drone->slug === 'dji-air-3s')
                                        Dual-Camera 1" CMOS · All-Round
                                    @elseif ($drone->slug === 'dji-mavic-3-pro')
                                        Triple Hasselblad · Cinema Pro
                                    @elseif ($drone->slug === 'dji-avata-2')
                                        Immersive FPV · High Agility
                                    @else
                                        Professional Aircraft
                                    @endif
                                </span>
                                <h3 class="text-2xl font-bold text-white tracking-tight mt-1">{{ $drone->name }}</h3>
                            </div>
                            <div class="text-right">
                                <span class="text-xl font-bold text-white tracking-tight">Rp{{ number_format((float) $drone->daily_rate, 0, ',', '.') }}</span>
                                <span class="text-[11px] text-gray-400 block -mt-0.5">/ hari</span>
                            </div>
                        </div>

                        <!-- Drone Visual Silhouette Display -->
                        <div class="my-8 h-48 rounded-lg bg-gradient-to-b from-white/[0.03] to-transparent border border-white/5 flex items-center justify-center relative overflow-hidden group">
                            <div class="absolute inset-0 bg-sky-500/5 opacity-0 group-hover:opacity-100 transition duration-300"></div>
                            @if ($drone->image_path)
                                <img src="{{ str_starts_with($drone->image_path, 'http') ? $drone->image_path : asset('storage/'.$drone->image_path) }}" alt="{{ $drone->name }}" class="h-full w-full object-cover">
                            @else
                                <!-- Technical Wireframe Drone Emblem -->
                                <div class="text-center">
                                    <svg class="h-20 w-20 text-gray-600 group-hover:text-sky-400 transition stroke-[1.2] mx-auto" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                        <path d="M4 8h4V4M16 4v4h4M20 16h-4v4M8 20v-4H4" stroke-linecap="round"/>
                                        <circle cx="12" cy="12" r="3"/>
                                        <circle cx="6" cy="6" r="1.5"/>
                                        <circle cx="18" cy="6" r="1.5"/>
                                        <circle cx="6" cy="18" r="1.5"/>
                                        <circle cx="18" cy="18" r="1.5"/>
                                    </svg>
                                    <span class="text-[10px] text-gray-400 tracking-wider uppercase mt-2 block">DJI Flight Engineered</span>
                                </div>
                            @endif
                        </div>

                        <p class="text-xs text-gray-400 leading-relaxed min-h-[3rem]">
                            {{ $drone->description }}
                        </p>

                        <!-- HUD Metrics Grid (DJI Spec Matrix) -->
                        <div class="mt-6 grid grid-cols-4 gap-2 border-t border-white/10 pt-5 text-center">
                            <div>
                                <span class="block text-sm font-bold text-white">{{ $drone->flight_time_min }}m</span>
                                <span class="text-[9px] uppercase tracking-wider text-gray-400">Max Time</span>
                            </div>
                            <div>
                                <span class="block text-sm font-bold text-white">{{ $drone->range_km }}km</span>
                                <span class="text-[9px] uppercase tracking-wider text-gray-400">Range O4</span>
                            </div>
                            <div>
                                <span class="block text-sm font-bold text-white truncate px-1">{{ $drone->camera }}</span>
                                <span class="text-[9px] uppercase tracking-wider text-gray-400">Resolution</span>
                            </div>
                            <div>
                                <span class="block text-sm font-bold text-white">{{ $drone->weight_g }}g</span>
                                <span class="text-[9px] uppercase tracking-wider text-gray-400">Takeoff</span>
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="mt-8 pt-4 border-t border-white/5 flex items-center justify-between">
                        @if ($drone->weekly_rate)
                            <div class="text-[11px] text-gray-400">
                                Paket 7 Hari: <span class="text-white font-medium">Rp{{ number_format((float) $drone->weekly_rate, 0, ',', '.') }}</span>
                            </div>
                        @else
                            <div></div>
                        @endif

                        <a href="{{ route('drones.show', $drone) }}" class="inline-flex items-center gap-1.5 rounded bg-white/10 hover:bg-sky-400 hover:text-black text-white px-4 py-2 text-xs font-semibold uppercase tracking-wider transition">
                            <span>Detail & Sewa</span> &rarr;
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-2 text-center py-16 text-gray-500">
                    Belum ada armada drone terdaftar saat ini.
                </div>
            @endforelse
        </div>
    </section>

    <!-- DJI Pro Standards Banner -->
    <section class="border-t border-white/10 bg-[#0A0D14] py-16">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 grid md:grid-cols-3 gap-8 text-left">
            <div class="hud-spec">
                <span class="text-xs uppercase tracking-wider text-sky-400 font-bold block mb-1">Standard 01</span>
                <h4 class="text-lg font-bold text-white mb-2">Pemeriksaan Kalibrasi 100%</h4>
                <p class="text-xs text-gray-400 leading-relaxed">
                    Setiap drone menjalani kalibrasi IMU, kompas, dan gimbal sebelum diserahterimakan untuk menjamin kestabilan dan keamanan penerbangan Anda.
                </p>
            </div>
            <div class="hud-spec">
                <span class="text-xs uppercase tracking-wider text-sky-400 font-bold block mb-1">Standard 02</span>
                <h4 class="text-lg font-bold text-white mb-2">Baterai Sehat & Certified Cycle</h4>
                <p class="text-xs text-gray-400 leading-relaxed">
                    Baterai intelligent flight dicek rutin untuk menjamin kapasitas voltase stabil tanpa risiko drop mendadak saat sesi pengambilan gambar di udara.
                </p>
            </div>
            <div class="hud-spec">
                <span class="text-xs uppercase tracking-wider text-sky-400 font-bold block mb-1">Standard 03</span>
                <h4 class="text-lg font-bold text-white mb-2">Kepatuhan Regulasi & Asuransi</h4>
                <p class="text-xs text-gray-400 leading-relaxed">
                    Panduan terbang aman (Fly Safe) dan data registrasi drone lengkap untuk mempermudah perizinan proyek sinematik dan komersial Anda.
                </p>
            </div>
        </div>
    </section>
@endsection
