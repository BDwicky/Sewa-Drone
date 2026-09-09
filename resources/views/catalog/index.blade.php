@extends('layouts.store')

@section('title', 'Sewa Drone DJI Resmi — Armada Lengkap Harian & Mingguan')

@section('content')
    @php
        $mediaFile = base_path('database/dji_media.json');
        $allMedia = file_exists($mediaFile) ? json_decode(file_get_contents($mediaFile), true) : [];
        $heroDrone = $drones->firstWhere('slug', 'dji-air-3s') ?? $drones->first();
        $heroVideo = "https://terra-1-g.djicdn.com/851d20f7b9f64838a34cd02351370894/OQ102%20shot%20on/M83_OQ102_10S_CLEAN_M_2400x1440-08.14.mp4";
    @endphp

    <!-- DJI Official Style Full-Screen Hero Banner Section (Persis seperti dji.com/id) -->
    <section class="relative min-h-screen sm:min-h-[110vh] py-32 sm:py-48 w-full flex items-center justify-center overflow-hidden border-b border-white/10 bg-black">
        <!-- Background 4K Drone Footage (Autoplay, Loop, Muted, Seamless Dolly Shot) -->
        <div class="absolute inset-0 z-0">
            <video class="w-full h-full object-cover scale-105 filter brightness-[0.55] contrast-110 transition duration-1000" autoplay loop muted playsinline>
                <source src="{{ $heroVideo }}" type="video/mp4">
            </video>
            <!-- Cinematic Vignette & Gradient Overlays (Authentic DJI Lighting) -->
            <div class="absolute inset-0 bg-gradient-to-t from-[#06080D] via-transparent to-black/60"></div>
            <div class="absolute inset-0 bg-gradient-to-b from-black/40 via-transparent to-[#06080D]"></div>
        </div>

        <!-- Hero Content (Structured exactly like DJI's banner-text & banner-btn-box) -->
        <div class="relative z-10 mx-auto max-w-4xl px-4 sm:px-6 text-center flex flex-col items-center justify-center pt-8">
            <!-- Eyebrow text -->
            <div class="text-xs sm:text-sm uppercase tracking-[0.25em] text-gray-200 font-medium mb-3 drop-shadow-md">
                Armada Rental Drone Kamera Flagship
            </div>

            <!-- Main Product Branding / Headline -->
            <h1 class="text-4xl sm:text-7xl md:text-8xl font-extrabold tracking-tight text-white uppercase leading-none drop-shadow-2xl">
                SEWA DRONE DJI
            </h1>

            <!-- DJI Signature Slogan -->
            <h2 class="text-lg sm:text-2xl md:text-3xl font-light tracking-wide text-gray-200 mt-4 sm:mt-5 drop-shadow-md">
                Chase the View. Tangkap Sudut Sinematik.
            </h2>

            <p class="mt-4 text-xs sm:text-sm text-gray-300 max-w-xl mx-auto font-light leading-relaxed drop-shadow">
                Penyewaan resmi unit DJI Mini 4 Pro, Air 3S, Mavic 3 Pro &amp; Avata 2. Sistem booking anti-bentrok, pembayaran online otomatis, dan e-invoice resmi seketika.
            </p>

            <!-- DJI Official Style Action Button Box -->
            <div class="mt-8 sm:mt-10 flex items-center justify-center gap-8 sm:gap-10">
                <a href="#fleet" class="group inline-flex items-center gap-1.5 text-sm sm:text-base font-semibold text-white hover:text-sky-400 transition drop-shadow">
                    <span>Lihat Armada</span>
                    <span class="inline-block transform group-hover:translate-x-1 transition text-sky-400 font-bold">&gt;</span>
                </a>
                <a href="{{ route('pages.kebijakan') }}" class="group inline-flex items-center gap-1.5 text-sm sm:text-base font-semibold text-white hover:text-sky-400 transition drop-shadow">
                    <span>Syarat &amp; Kebijakan</span>
                    <span class="inline-block transform group-hover:translate-x-1 transition text-sky-400 font-bold">&gt;</span>
                </a>
            </div>

            <!-- Key Quick Spec Badges (Clean Monochromatic HUD) -->
            <div class="mt-12 sm:mt-16 flex flex-wrap items-center justify-center gap-6 sm:gap-10 text-[11px] sm:text-xs text-gray-300 font-medium">
                <div class="flex items-center gap-2">
                    <span class="h-1.5 w-1.5 rounded-full bg-sky-400"></span>
                    <span>Sensor 4K / 5.1K Hasselblad</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="h-1.5 w-1.5 rounded-full bg-sky-400"></span>
                    <span>Durasi Terbang s/d 45 Menit</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="h-1.5 w-1.5 rounded-full bg-sky-400"></span>
                    <span>Transmisi Video O4 20 KM</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="h-1.5 w-1.5 rounded-full bg-sky-400"></span>
                    <span>Tersedia Unit Bebas Izin &lt;249g</span>
                </div>
            </div>
        </div>

        <!-- Down Arrow Indicator -->
        <a href="#fleet" class="absolute bottom-6 left-1/2 -translate-x-1/2 text-gray-400 hover:text-white transition z-10 animate-bounce">
            <svg class="h-5 w-5 stroke-[2]" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                <path d="M19 9l-7 7-7-7" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </a>
    </section>

    <!-- Product Showcase Grid (Pilih Drone dan Kelengkapan Device - Pure Physical Hardware Photos) -->
    <section id="fleet" class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-20 sm:py-28">
        <!-- Section Header -->
        <div class="flex flex-col md:flex-row md:items-end justify-between mb-14 border-b border-white/10 pb-8 gap-4">
            <div>
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full border border-sky-400/30 bg-sky-500/10 text-sky-400 text-[11px] font-mono tracking-wider uppercase mb-3">
                    <span class="h-1.5 w-1.5 rounded-full bg-sky-400"></span>
                    Armada Siap Terbang
                </div>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-white tracking-tight">PILIH DRONE &amp; KELENGKAPAN DEVICE</h2>
            </div>
            <p class="text-xs text-gray-400 max-w-md leading-relaxed">
                Menampilkan wujud fisik asli unit pesawat drone DJI, propeller, gimbal, dan kelengkapan remote controller siap terbang.
            </p>
        </div>

        <div class="grid gap-10 lg:grid-cols-2">
            @forelse ($drones as $drone)
                @php
                    $media = $allMedia[$drone->slug] ?? null;
                    $gallery = $media['gallery'] ?? [];
                    // Ensure the initial image uses the actual local hardware photograph
                    $firstImg = isset($gallery[0]['url']) 
                        ? (str_starts_with($gallery[0]['url'], 'http') ? $gallery[0]['url'] : asset($gallery[0]['url']))
                        : (str_starts_with($drone->image_path, 'http') ? $drone->image_path : asset('storage/'.$drone->image_path));
                @endphp
                <div class="dji-card rounded-2xl overflow-hidden p-6 sm:p-8 flex flex-col justify-between" id="card-{{ $drone->slug }}">
                    <div class="flex flex-col gap-6">
                        <!-- Top Header: Title, Category Badge & Price Box -->
                        <div class="flex items-start justify-between gap-4">
                            <div>
                                <span class="text-[10px] tracking-widest text-sky-400 uppercase font-bold block">
                                    @if ($drone->slug === 'dji-mini-4-pro')
                                        Ultra-Lightweight · Travel Ready
                                    @elseif ($drone->slug === 'dji-air-3s')
                                        Dual-Camera 1" CMOS · All-Round
                                    @elseif ($drone->slug === 'dji-mavic-3-pro')
                                        Triple Hasselblad · Cinema Master
                                    @elseif ($drone->slug === 'dji-avata-2')
                                        Immersive FPV · High Agility
                                    @else
                                        Professional Aircraft
                                    @endif
                                </span>
                                <h3 class="text-2xl sm:text-3xl font-extrabold text-white tracking-tight mt-1.5">{{ $drone->name }}</h3>
                            </div>
                            <div class="text-right shrink-0 bg-white/[0.03] border border-white/10 rounded-xl px-4 py-2.5">
                                <span class="text-lg sm:text-xl font-extrabold text-white tracking-tight">Rp{{ number_format((float) $drone->daily_rate, 0, ',', '.') }}</span>
                                <span class="text-[10px] text-gray-400 block -mt-0.5 uppercase tracking-wider font-medium">/ hari</span>
                            </div>
                        </div>

                        <!-- Main Image Stage with Floating Hardware Device Showcase -->
                        <div class="h-64 sm:h-72 rounded-xl bg-gradient-to-b from-white/[0.04] to-black/50 border border-white/10 flex items-center justify-center relative overflow-hidden group p-4 shadow-inner">
                            <div class="absolute inset-0 bg-sky-500/[0.04] opacity-0 group-hover:opacity-100 transition duration-300 pointer-events-none"></div>
                            
                            <img id="card-img-{{ $drone->slug }}"
                                 src="{{ $firstImg }}"
                                 alt="{{ $drone->name }}"
                                 class="h-full w-full object-contain drop-shadow-[0_20px_35px_rgba(0,0,0,0.85)] transition-all duration-300">

                            <span id="card-label-{{ $drone->slug }}"
                                  class="absolute bottom-3 left-3 text-[10px] font-mono text-gray-200 uppercase bg-black/75 backdrop-blur-md border border-white/20 px-3 py-1 rounded shadow-lg flex items-center gap-1.5">
                                <span class="h-1.5 w-1.5 rounded-full bg-sky-400"></span>
                                <span>{{ $gallery[0]['title'] ?? 'Wujud Fisik Depan' }}</span>
                            </span>
                        </div>

                        <!-- Multi-Angle Device Hardware Thumbnails Selector -->
                        @if (count($gallery) > 0)
                            <div>
                                <span class="text-[10px] uppercase tracking-wider text-gray-400 block mb-2 font-mono font-semibold">Tinjau Wujud Fisik &amp; Sudut Drone:</span>
                                <div class="grid grid-cols-4 gap-2.5">
                                    @foreach ($gallery as $idx => $g)
                                        @php
                                            $gUrl = str_starts_with($g['url'], 'http') ? $g['url'] : asset($g['url']);
                                        @endphp
                                        <button type="button"
                                                onclick="updateCardPreview('{{ $drone->slug }}', '{{ $gUrl }}', '{{ $g['title'] }}', this)"
                                                class="thumb-btn-{{ $drone->slug }} h-16 rounded-lg border {{ $idx === 0 ? 'border-sky-400 ring-1 ring-sky-400/40 bg-sky-400/10' : 'border-white/10 opacity-70 bg-black/50' }} hover:opacity-100 hover:border-white/40 p-1.5 flex flex-col items-center justify-center transition overflow-hidden group">
                                            <img src="{{ $gUrl }}" alt="{{ $g['title'] }}" class="h-9 w-auto object-contain group-hover:scale-105 transition duration-200">
                                            <span class="text-[8px] text-gray-300 truncate w-full text-center mt-1 font-medium">{{ explode(' ', $g['title'])[0] }}</span>
                                        </button>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <p class="text-xs sm:text-sm text-gray-400 leading-relaxed font-light min-h-[3rem]">
                            {{ $drone->description }}
                        </p>

                        <!-- HUD Metrics Grid (DJI Spec Matrix) -->
                        <div class="grid grid-cols-4 gap-2 border-t border-white/10 pt-4 text-center">
                            <div class="bg-white/[0.02] rounded-lg py-2.5 px-1 border border-white/5">
                                <span class="block text-sm sm:text-base font-bold text-white">{{ $drone->flight_time_min }}m</span>
                                <span class="text-[9px] uppercase tracking-wider text-gray-400">Max Time</span>
                            </div>
                            <div class="bg-white/[0.02] rounded-lg py-2.5 px-1 border border-white/5">
                                <span class="block text-sm sm:text-base font-bold text-white">{{ $drone->range_km }}km</span>
                                <span class="text-[9px] uppercase tracking-wider text-gray-400">Range O4</span>
                            </div>
                            <div class="bg-white/[0.02] rounded-lg py-2.5 px-1 border border-white/5">
                                <span class="block text-sm sm:text-base font-bold text-white truncate px-1">{{ $drone->camera }}</span>
                                <span class="text-[9px] uppercase tracking-wider text-gray-400">Sensor</span>
                            </div>
                            <div class="bg-white/[0.02] rounded-lg py-2.5 px-1 border border-white/5">
                                <span class="block text-sm sm:text-base font-bold text-white">{{ $drone->weight_g }}g</span>
                                <span class="text-[9px] uppercase tracking-wider text-gray-400">Takeoff</span>
                            </div>
                        </div>
                    </div>

                    <!-- Card Actions with Refined Alignment -->
                    <div class="mt-8 pt-5 border-t border-white/10 flex items-center justify-between gap-4">
                        <div>
                            @if ($drone->weekly_rate)
                                <span class="text-[10px] text-gray-400 block uppercase tracking-wider">Tarif 7 Hari:</span>
                                <span class="text-xs sm:text-sm text-white font-semibold">Rp{{ number_format((float) $drone->weekly_rate, 0, ',', '.') }}</span>
                            @else
                                <span class="text-xs text-gray-500">Unit Siap Sewa</span>
                            @endif
                        </div>

                        <a href="{{ route('drones.show', $drone) }}" class="inline-flex items-center gap-2 rounded-xl bg-white text-black hover:bg-sky-400 hover:text-black px-6 py-3 text-xs font-bold uppercase tracking-wider transition shadow-md shadow-white/5 hover:shadow-sky-400/20">
                            <span>Detail &amp; Sewa</span>
                            <svg class="h-3.5 w-3.5 stroke-[2.5]" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M5 12h14M12 5l7 7-7 7" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-2 text-center py-20 text-gray-500">
                    Belum ada armada drone terdaftar saat ini.
                </div>
            @endforelse
        </div>
    </section>

    <!-- DJI Professional Standards Showcase -->
    <section class="border-t border-white/10 bg-gradient-to-b from-[#06080D] via-[#090D15] to-[#040609] py-24 relative overflow-hidden">
        <!-- Subtle Grid & Radial Glow Background -->
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_bottom_left,rgba(56,189,248,0.06)_0%,transparent_60%)] pointer-events-none"></div>

        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 relative z-10">
            <!-- Section Header -->
            <div class="flex flex-col md:flex-row md:items-end justify-between mb-16 border-b border-white/10 pb-8 gap-6">
                <div>
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full border border-sky-400/30 bg-sky-500/10 text-sky-400 text-[11px] font-mono tracking-wider uppercase mb-3">
                        <span class="h-1.5 w-1.5 rounded-full bg-sky-400"></span>
                        Jaminan Kualitas Operasional
                    </div>
                    <h3 class="text-3xl sm:text-4xl font-extrabold text-white tracking-tight">STANDAR LAYANAN ARMADA RESMI</h3>
                </div>
                <p class="text-xs sm:text-sm text-gray-400 max-w-md font-light leading-relaxed">
                    Setiap unit melalui protokol inspeksi keselamatan dan integrasi sistem digital untuk kelancaran proyek penerbangan Anda.
                </p>
            </div>

            <!-- Redesigned High-Impact Feature Cards -->
            <div class="grid lg:grid-cols-3 gap-8">
                <!-- Card 01: Pre-Flight Calibration -->
                <div class="group relative rounded-2xl bg-gradient-to-b from-white/[0.05] to-black/60 border border-white/10 p-8 hover:border-sky-400/50 transition-all duration-300 flex flex-col justify-between overflow-hidden shadow-2xl">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-sky-500/10 rounded-full blur-3xl pointer-events-none group-hover:bg-sky-500/20 transition duration-500"></div>

                    <div>
                        <div class="flex items-center justify-between mb-8">
                            <div class="h-12 w-12 rounded-xl bg-sky-400/10 border border-sky-400/30 flex items-center justify-center text-sky-400 group-hover:bg-sky-400 group-hover:text-black transition duration-300">
                                <svg class="h-6 w-6 stroke-[1.8]" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                    <circle cx="12" cy="12" r="9"/>
                                    <path d="M12 3v18M3 12h18"/>
                                    <circle cx="12" cy="12" r="3"/>
                                </svg>
                            </div>
                            <span class="font-mono text-xs text-gray-500 uppercase tracking-widest">Protocol // 01</span>
                        </div>

                        <h4 class="text-xl font-bold text-white tracking-tight group-hover:text-sky-300 transition duration-200">
                            Kalibrasi Sensor &amp; Gimbal 100%
                        </h4>
                        <p class="text-xs sm:text-sm text-gray-400 mt-3 leading-relaxed font-light">
                            Uji akurasi kompas digital, IMU dual-redundancy, dan balancing 3-axis gimbal dilakukan sebelum diserahkan demi rekaman video stabil tanpa micro-jitter.
                        </p>
                    </div>

                    <div class="mt-8 pt-6 border-t border-white/10 flex items-center justify-between text-[11px] font-mono text-gray-400">
                        <span class="flex items-center gap-1.5 text-emerald-400">
                            <span class="h-1.5 w-1.5 rounded-full bg-emerald-400"></span> Pre-Flight Passed
                        </span>
                        <span>Zero Drift Testing</span>
                    </div>
                </div>

                <!-- Card 02: Intelligent Battery Management -->
                <div class="group relative rounded-2xl bg-gradient-to-b from-white/[0.05] to-black/60 border border-white/10 p-8 hover:border-sky-400/50 transition-all duration-300 flex flex-col justify-between overflow-hidden shadow-2xl">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-emerald-500/10 rounded-full blur-3xl pointer-events-none group-hover:bg-emerald-500/20 transition duration-500"></div>

                    <div>
                        <div class="flex items-center justify-between mb-8">
                            <div class="h-12 w-12 rounded-xl bg-emerald-400/10 border border-emerald-400/30 flex items-center justify-center text-emerald-400 group-hover:bg-emerald-400 group-hover:text-black transition duration-300">
                                <svg class="h-6 w-6 stroke-[1.8]" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                    <rect x="2" y="7" width="16" height="10" rx="2"/>
                                    <line x1="22" y1="11" x2="22" y2="13"/>
                                    <line x1="6" y1="11" x2="6" y2="13"/>
                                    <line x1="10" y1="11" x2="10" y2="13"/>
                                </svg>
                            </div>
                            <span class="font-mono text-xs text-gray-500 uppercase tracking-widest">Protocol // 02</span>
                        </div>

                        <h4 class="text-xl font-bold text-white tracking-tight group-hover:text-emerald-300 transition duration-200">
                            Baterai Sehat Siklus Terverifikasi
                        </h4>
                        <p class="text-xs sm:text-sm text-gray-400 mt-3 leading-relaxed font-light">
                            Setiap unit dilengkapi baterai Intelligent Flight dengan internal resistance rendah dan siklus sehat untuk daya tahan maksimum tanpa drop voltase tiba-tiba.
                        </p>
                    </div>

                    <div class="mt-8 pt-6 border-t border-white/10 flex items-center justify-between text-[11px] font-mono text-gray-400">
                        <span class="flex items-center gap-1.5 text-emerald-400">
                            <span class="h-1.5 w-1.5 rounded-full bg-emerald-400"></span> Multi-Battery Pack
                        </span>
                        <span>Charging Hub Ready</span>
                    </div>
                </div>

                <!-- Card 03: E-Invoice & Regulatory Compliance -->
                <div class="group relative rounded-2xl bg-gradient-to-b from-white/[0.05] to-black/60 border border-white/10 p-8 hover:border-sky-400/50 transition-all duration-300 flex flex-col justify-between overflow-hidden shadow-2xl">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-blue-500/10 rounded-full blur-3xl pointer-events-none group-hover:bg-blue-500/20 transition duration-500"></div>

                    <div>
                        <div class="flex items-center justify-between mb-8">
                            <div class="h-12 w-12 rounded-xl bg-blue-400/10 border border-blue-400/30 flex items-center justify-center text-blue-400 group-hover:bg-blue-400 group-hover:text-black transition duration-300">
                                <svg class="h-6 w-6 stroke-[1.8]" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                                    <polyline points="14 2 14 8 20 8"/>
                                    <line x1="16" y1="13" x2="8" y2="13"/>
                                    <line x1="16" y1="17" x2="8" y2="17"/>
                                    <polyline points="10 9 9 9 8 9"/>
                                </svg>
                            </div>
                            <span class="font-mono text-xs text-gray-500 uppercase tracking-widest">Protocol // 03</span>
                        </div>

                        <h4 class="text-xl font-bold text-white tracking-tight group-hover:text-blue-300 transition duration-200">
                            E-Invoice Resmi &amp; QR Tracking
                        </h4>
                        <p class="text-xs sm:text-sm text-gray-400 mt-3 leading-relaxed font-light">
                            Setelah pembayaran online Midtrans selesai, e-invoice resmi PDF terbit seketika dengan QR verifikasi untuk pelacakan status sewa dan validitas serah terima.
                        </p>
                    </div>

                    <div class="mt-8 pt-6 border-t border-white/10 flex items-center justify-between text-[11px] font-mono text-gray-400">
                        <span class="flex items-center gap-1.5 text-sky-400">
                            <span class="h-1.5 w-1.5 rounded-full bg-sky-400"></span> Instan PDF + QR
                        </span>
                        <span>DRONEID DJPU</span>
                    </div>
                </div>
            </div>

            <!-- Bottom Quality Statement Strip -->
            <div class="mt-12 rounded-2xl border border-white/10 bg-white/[0.02] p-6 sm:p-8 flex flex-col md:flex-row items-center justify-between gap-6">
                <div class="flex items-center gap-4">
                    <div class="h-10 w-10 rounded-full bg-sky-400/10 border border-sky-400/30 flex items-center justify-center text-sky-400 shrink-0">
                        <svg class="h-5 w-5 stroke-[2]" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                        </svg>
                    </div>
                    <div>
                        <h5 class="text-sm font-bold text-white">Butuh Dukungan Teknis atau Operator Drone Khusus?</h5>
                        <p class="text-xs text-gray-400 mt-0.5">Konsultasikan kebutuhan produksi sinematik atau survei Anda langsung dengan tim kami.</p>
                    </div>
                </div>
                <a href="https://wa.me/{{ config('services.wa.admin_number') }}" target="_blank"
                   class="inline-flex items-center gap-2 rounded-xl bg-white/10 hover:bg-sky-400 hover:text-black text-white px-6 py-3 text-xs font-bold uppercase tracking-wider transition shrink-0">
                    <span>Hubungi Tim Teknis</span>
                    <svg class="h-3.5 w-3.5 stroke-[2.5]" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M5 12h14M12 5l7 7-7 7" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </a>
            </div>
        </div>
    </section>

    <!-- Interactive Card Image Switcher Script -->
    <script>
        function updateCardPreview(droneSlug, imgUrl, title, btn) {
            const img = document.getElementById('card-img-' + droneSlug);
            const label = document.getElementById('card-label-' + droneSlug);
            if (img) {
                img.style.opacity = '0';
                setTimeout(() => {
                    img.src = imgUrl;
                    img.style.opacity = '1';
                }, 120);
            }
            if (label) {
                label.innerHTML = '<span class="h-1.5 w-1.5 rounded-full bg-sky-400 inline-block mr-1.5"></span>' + title;
            }
            document.querySelectorAll('.thumb-btn-' + droneSlug).forEach(b => {
                b.classList.remove('border-sky-400', 'ring-1', 'ring-sky-400/40', 'bg-sky-400/10');
                b.classList.add('border-white/10', 'opacity-70', 'bg-black/50');
            });
            if (btn) {
                btn.classList.add('border-sky-400', 'ring-1', 'ring-sky-400/40', 'bg-sky-400/10');
                btn.classList.remove('border-white/10', 'opacity-70', 'bg-black/50');
            }
        }
    </script>
@endsection
