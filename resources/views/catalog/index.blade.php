@extends('layouts.store')

@section('title', 'Sewa Drone DJI Resmi — Armada Lengkap Harian & Mingguan')

@section('content')
    @php
        $mediaFile = base_path('database/dji_media.json');
        $allMedia = file_exists($mediaFile) ? json_decode(file_get_contents($mediaFile), true) : [];
        $heroDrone = $drones->firstWhere('slug', 'dji-air-3s') ?? $drones->first();
        $heroLocalVideo = asset('storage/drones/videos/air3s_reel.mp4');
        $heroVideo = "https://terra-1-g.djicdn.com/851d20f7b9f64838a34cd02351370894/OQ102%20shot%20on/M83_OQ102_10S_CLEAN_M_2400x1440-08.14.mp4";
    @endphp

    <!-- DJI Official Style Full-Screen Hero Banner Section (Persis seperti dji.com/id) -->
    <section class="relative min-h-[66vh] sm:min-h-[70vh] py-16 sm:py-20 w-full flex items-center justify-center overflow-hidden border-b border-white/10 bg-black">
        <!-- Background 4K Drone Footage (Autoplay, Loop, Muted, Seamless Dolly Shot) -->
        <div class="absolute inset-0 z-0">
            <video class="w-full h-full object-cover scale-105 filter brightness-[0.55] contrast-110 transition duration-1000" autoplay loop muted playsinline>
                <source src="{{ $heroLocalVideo }}" type="video/mp4">
                <source src="{{ $heroVideo }}" type="video/mp4">
            </video>
            <!-- Cinematic Vignette & Gradient Overlays (Authentic DJI Lighting) -->
            <div class="absolute inset-0 bg-gradient-to-t from-black via-transparent to-black/70"></div>
            <div class="absolute inset-0 bg-gradient-to-b from-black/50 via-transparent to-black"></div>
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
                <a href="#fleet" class="group inline-flex items-center gap-1.5 text-sm sm:text-base font-semibold text-white hover:text-neutral-300 transition drop-shadow">
                    <span>Lihat Armada</span>
                    <span class="inline-block transform group-hover:translate-x-1 transition text-white font-bold">&gt;</span>
                </a>
                <a href="{{ route('pages.kebijakan') }}" class="group inline-flex items-center gap-1.5 text-sm sm:text-base font-semibold text-white hover:text-neutral-300 transition drop-shadow">
                    <span>Syarat &amp; Kebijakan</span>
                    <span class="inline-block transform group-hover:translate-x-1 transition text-white font-bold">&gt;</span>
                </a>
            </div>

            <!-- Key Quick Spec Badges (Clean Monochromatic HUD) -->
            <div class="mt-12 sm:mt-16 flex flex-wrap items-center justify-center gap-6 sm:gap-10 text-[11px] sm:text-xs text-neutral-300 font-medium">
                <div class="flex items-center gap-2">
                    <span class="h-1.5 w-1.5 rounded-full bg-white"></span>
                    <span>Sensor 4K / 5.1K Hasselblad</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="h-1.5 w-1.5 rounded-full bg-white"></span>
                    <span>Durasi Terbang s/d 45 Menit</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="h-1.5 w-1.5 rounded-full bg-white"></span>
                    <span>Transmisi Video O4 20 KM</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="h-1.5 w-1.5 rounded-full bg-white"></span>
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

        <!-- Luminous White Beam Horizon Line -->
        <div class="absolute bottom-0 inset-x-0 h-px bg-gradient-to-r from-transparent via-white/50 to-transparent shadow-[0_0_16px_rgba(255,255,255,0.35)] z-20"></div>
    </section>

    <!-- Product Showcase Grid Section with DJI Official White Studio Style -->
    <section id="fleet" class="relative py-20 sm:py-28 overflow-hidden bg-white">
        <!-- Subtle Architectural Tech Grid Overlay -->
        <div class="absolute inset-0 pointer-events-none">
            <div class="absolute inset-0 bg-[linear-gradient(to_right,rgba(0,0,0,0.02)_1px,transparent_1px),linear-gradient(to_bottom,rgba(0,0,0,0.02)_1px,transparent_1px)] bg-[size:48px_48px]"></div>
        </div>

        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 relative z-10">
            <!-- Section Header -->
            <div class="flex flex-col md:flex-row md:items-end justify-between mb-12 border-b border-neutral-200 pb-6 gap-4">
                <div>
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full border border-neutral-300 bg-neutral-100 text-neutral-800 text-[11px] font-mono tracking-wider uppercase mb-2 shadow-sm">
                        <span class="h-1.5 w-1.5 rounded-full bg-black animate-pulse"></span>
                        Armada Siap Terbang
                    </div>
                    <h2 class="text-2xl sm:text-3xl font-extrabold text-neutral-950 tracking-tight">PILIH DRONE &amp; KELENGKAPAN DEVICE</h2>
                </div>
                <p class="text-xs sm:text-sm text-neutral-600 max-w-md font-normal leading-relaxed">
                    Unit fisik pesawat, remote DJI RC, baterai cadangan, dan filter sinematik lengkap terawat.
                </p>
            </div>

            <!-- 4-Column Strict Structured Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6 items-stretch">
                @forelse ($drones as $drone)
                    @php
                        $media = $allMedia[$drone->slug] ?? null;
                        $gallery = $media['gallery'] ?? [];
                        $firstImg = isset($gallery[0]['url']) 
                            ? (str_starts_with($gallery[0]['url'], 'http') ? $gallery[0]['url'] : asset($gallery[0]['url']))
                            : (str_starts_with($drone->image_path, 'http') ? $drone->image_path : asset('storage/'.$drone->image_path));
                    @endphp
                    <!-- Card Container with Locked Internal Grid Rows -->
                    <div class="dji-card rounded-2xl overflow-hidden p-5 flex flex-col justify-between h-full group bg-white border border-neutral-200 hover:border-neutral-400 hover:shadow-xl transition-all duration-300" id="card-{{ $drone->slug }}">
                        <div class="flex flex-col">
                            <!-- ROW 1: Header (Category, Title, Price Box) — Fixed 58px -->
                            <div class="h-[58px] flex items-start justify-between gap-2 border-b border-neutral-100 pb-3">
                                <div class="flex-1 min-w-0">
                                    <span class="text-[9px] font-mono tracking-widest text-neutral-500 uppercase font-bold block truncate">
                                        @if ($drone->slug === 'dji-neo')
                                            &lt;135g · Palm AI Vlog
                                        @elseif ($drone->slug === 'dji-mini-3-pro')
                                            &lt;249g · True Vertical
                                        @elseif ($drone->slug === 'dji-mini-4-pro')
                                            &lt;249g · Travel Ready
                                        @elseif ($drone->slug === 'dji-air-3s')
                                            Dual-Camera 1" CMOS
                                        @elseif ($drone->slug === 'dji-mavic-3-classic')
                                            Hasselblad 4/3 CMOS
                                        @elseif ($drone->slug === 'dji-avata-2')
                                            Immersive FPV Agility
                                        @elseif ($drone->slug === 'dji-mavic-3-pro')
                                            Triple Hasselblad Pro
                                        @elseif ($drone->slug === 'dji-inspire-3')
                                            Full-Frame 8K Cinema
                                        @else
                                            Aircraft System
                                        @endif
                                    </span>
                                    <h3 class="text-base font-bold text-neutral-900 tracking-tight mt-0.5 truncate">{{ $drone->name }}</h3>
                                </div>
                                <div class="text-right shrink-0 bg-black text-white border border-black rounded-lg px-2.5 py-1 shadow-sm">
                                    <span class="text-sm font-extrabold text-white block leading-tight">Rp{{ number_format((float) $drone->daily_rate, 0, ',', '.') }}</span>
                                    <span class="text-[8.5px] text-neutral-400 block font-mono uppercase leading-tight">/ hari</span>
                                </div>
                            </div>

                            <!-- ROW 2: Main Image Canvas — Fixed 180px Exact Height with White Studio Pedestal Glow -->
                            <div class="h-[180px] w-full my-3.5 rounded-xl bg-[#F7F7F8] border border-neutral-200/80 flex items-center justify-center relative overflow-hidden p-3 shadow-inner group-hover:border-neutral-300 transition duration-300">
                                <!-- Studio Pedestal Accent -->
                                <div class="absolute inset-0 flex items-center justify-center pointer-events-none opacity-40">
                                    <div class="w-36 h-36 rounded-full border border-neutral-300"></div>
                                    <div class="w-52 h-52 rounded-full border border-neutral-200 absolute"></div>
                                </div>

                                <img id="card-img-{{ $drone->slug }}"
                                     src="{{ $firstImg }}"
                                     alt="{{ $drone->name }}"
                                     class="h-full w-full object-contain drop-shadow-[0_10px_20px_rgba(0,0,0,0.12)] transition-all duration-300 group-hover:scale-105 relative z-10">

                                <span id="card-label-{{ $drone->slug }}"
                                      class="absolute bottom-2 left-2 text-[8px] font-mono text-neutral-800 uppercase bg-white/95 backdrop-blur-md border border-neutral-200 px-2 py-0.5 rounded truncate max-w-[170px] flex items-center gap-1.5 z-10 shadow-sm">
                                    <span class="h-1.5 w-1.5 rounded-full bg-black animate-pulse"></span>
                                    <span>{{ $gallery[0]['title'] ?? 'Wujud Fisik Depan' }}</span>
                                </span>
                            </div>

                            <!-- ROW 3: 4-Angle Thumbnails Selector — Fixed 48px Exact Height -->
                            <div class="h-[48px] mb-3">
                                @if (count($gallery) > 0)
                                    <div class="grid grid-cols-4 gap-1.5 h-full">
                                        @foreach ($gallery as $idx => $g)
                                            @php
                                                $gUrl = str_starts_with($g['url'], 'http') ? $g['url'] : asset($g['url']);
                                            @endphp
                                            <button type="button"
                                                    onclick="updateCardPreview('{{ $drone->slug }}', '{{ $gUrl }}', '{{ $g['title'] }}', this)"
                                                    class="thumb-btn-{{ $drone->slug }} h-full rounded-lg border {{ $idx === 0 ? 'border-black ring-1 ring-black/30 bg-neutral-100' : 'border-neutral-200 opacity-70 bg-white' }} hover:opacity-100 hover:border-neutral-400 p-1 flex items-center justify-center transition overflow-hidden">
                                                <img src="{{ $gUrl }}" alt="{{ $g['title'] }}" class="h-6 w-auto object-contain">
                                            </button>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="h-full"></div>
                                @endif
                            </div>

                            <!-- ROW 4: Description Snippet — Fixed 36px Exact Height (2 lines clamp) -->
                            <div class="h-[36px] mb-3 flex items-center overflow-hidden">
                                <p class="text-[11px] text-neutral-600 leading-snug font-normal line-clamp-2">
                                    {{ $drone->description }}
                                </p>
                            </div>

                            <!-- ROW 5: 3-Column HUD Specs Feature Grid — Fixed 52px Exact Height -->
                            <div class="h-[52px] grid grid-cols-3 gap-1.5 border-t border-neutral-100 pt-2.5 text-center">
                                <div class="bg-neutral-50 rounded py-1 border border-neutral-200 flex flex-col justify-center">
                                    <span class="block text-xs font-bold text-neutral-900 leading-tight">{{ $drone->flight_time_min }}m</span>
                                    <span class="text-[8px] uppercase tracking-wider text-neutral-500 leading-tight">Terbang</span>
                                </div>
                                <div class="bg-neutral-50 rounded py-1 border border-neutral-200 flex flex-col justify-center">
                                    <span class="block text-xs font-bold text-neutral-900 leading-tight">{{ $drone->range_km }}km</span>
                                    <span class="text-[8px] uppercase tracking-wider text-neutral-500 leading-tight">Jarak O4</span>
                                </div>
                                <div class="bg-neutral-50 rounded py-1 border border-neutral-200 flex flex-col justify-center">
                                    <span class="block text-xs font-bold text-neutral-900 leading-tight">{{ $drone->weight_g }}g</span>
                                    <span class="text-[8px] uppercase tracking-wider text-neutral-500 leading-tight">Bobot</span>
                                </div>
                            </div>
                        </div>

                        <!-- ROW 6: Action Button — Fixed 42px Baseline Aligned -->
                        <div class="h-[42px] mt-4 pt-2 border-t border-neutral-100 flex items-center">
                            <a href="{{ route('drones.show', $drone) }}" class="w-full h-full flex items-center justify-center gap-1.5 rounded-lg bg-black text-white hover:bg-neutral-800 text-xs font-bold uppercase tracking-wider transition shadow-sm border border-black">
                                <span>Detail &amp; Sewa</span>
                                <svg class="h-3 w-3 stroke-[2.5]" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M5 12h14M12 5l7 7-7 7" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="col-span-4 text-center py-16 text-neutral-500">
                        Belum ada armada drone terdaftar saat ini.
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- DJI Professional Standards Showcase with High-Contrast Minimalist Jet Black Aesthetic -->
    <section class="border-t border-neutral-900 bg-black text-white py-24 relative overflow-hidden">
        <!-- Subtle Grid Pattern Overlay -->
        <div class="absolute inset-0 pointer-events-none opacity-20">
            <div class="absolute inset-0 bg-[linear-gradient(to_right,rgba(255,255,255,0.08)_1px,transparent_1px),linear-gradient(to_bottom,rgba(255,255,255,0.08)_1px,transparent_1px)] bg-[size:48px_48px]"></div>
        </div>

        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 relative z-10">
            <!-- Section Header -->
            <div class="flex flex-col md:flex-row md:items-end justify-between mb-16 border-b border-neutral-800 pb-8 gap-6">
                <div>
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full border border-white/20 bg-white/10 text-white text-[11px] font-mono tracking-wider uppercase mb-3 shadow-sm">
                        <span class="h-1.5 w-1.5 rounded-full bg-white animate-pulse"></span>
                        Jaminan Kualitas Operasional
                    </div>
                    <h3 class="text-3xl sm:text-4xl font-extrabold text-white tracking-tight">STANDAR LAYANAN ARMADA RESMI</h3>
                </div>
                <p class="text-xs sm:text-sm text-neutral-400 max-w-md font-normal leading-relaxed">
                    Setiap unit melalui protokol inspeksi keselamatan dan integrasi sistem digital untuk kelancaran proyek penerbangan Anda.
                </p>
            </div>

            <!-- Feature Cards (DJI Minimalist Black & White Cards) -->
            <div class="grid lg:grid-cols-3 gap-8">
                <!-- Card 01: Pre-Flight Calibration -->
                <div class="group relative rounded-2xl bg-neutral-950 border border-neutral-800 p-8 hover:border-white/40 hover:bg-neutral-900/60 transition-all duration-300 flex flex-col justify-between overflow-hidden shadow-2xl">
                    <div>
                        <div class="flex items-center justify-between mb-8">
                            <div class="h-12 w-12 rounded-xl bg-white/10 border border-white/20 flex items-center justify-center text-white group-hover:bg-white group-hover:text-black transition duration-300 shadow-sm">
                                <svg class="h-6 w-6 stroke-[1.8]" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                    <circle cx="12" cy="12" r="9"/>
                                    <path d="M12 3v18M3 12h18"/>
                                    <circle cx="12" cy="12" r="3"/>
                                </svg>
                            </div>
                            <span class="font-mono text-xs text-neutral-400 uppercase tracking-widest font-semibold">Protocol // 01</span>
                        </div>

                        <h4 class="text-xl font-bold text-white tracking-tight group-hover:text-neutral-100 transition duration-200">
                            Kalibrasi Sensor &amp; Gimbal 100%
                        </h4>
                        <p class="text-xs sm:text-sm text-neutral-400 mt-3 leading-relaxed font-light">
                            Uji akurasi kompas digital, IMU dual-redundancy, dan balancing 3-axis gimbal dilakukan sebelum diserahkan demi rekaman video stabil tanpa micro-jitter.
                        </p>
                    </div>

                    <div class="mt-8 pt-6 border-t border-neutral-800/80 flex items-center justify-between text-[11px] font-mono text-neutral-400">
                        <span class="flex items-center gap-1.5 text-white font-medium">
                            <span class="h-1.5 w-1.5 rounded-full bg-white"></span> Pre-Flight Passed
                        </span>
                        <span>Zero Drift Testing</span>
                    </div>
                </div>

                <!-- Card 02: Intelligent Battery Management -->
                <div class="group relative rounded-2xl bg-neutral-950 border border-neutral-800 p-8 hover:border-white/40 hover:bg-neutral-900/60 transition-all duration-300 flex flex-col justify-between overflow-hidden shadow-2xl">
                    <div>
                        <div class="flex items-center justify-between mb-8">
                            <div class="h-12 w-12 rounded-xl bg-white/10 border border-white/20 flex items-center justify-center text-white group-hover:bg-white group-hover:text-black transition duration-300 shadow-sm">
                                <svg class="h-6 w-6 stroke-[1.8]" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                    <rect x="2" y="7" width="16" height="10" rx="2"/>
                                    <line x1="22" y1="11" x2="22" y2="13"/>
                                    <line x1="6" y1="11" x2="6" y2="13"/>
                                    <line x1="10" y1="11" x2="10" y2="13"/>
                                </svg>
                            </div>
                            <span class="font-mono text-xs text-neutral-400 uppercase tracking-widest font-semibold">Protocol // 02</span>
                        </div>

                        <h4 class="text-xl font-bold text-white tracking-tight group-hover:text-neutral-100 transition duration-200">
                            Baterai Sehat Siklus Terverifikasi
                        </h4>
                        <p class="text-xs sm:text-sm text-neutral-400 mt-3 leading-relaxed font-light">
                            Setiap unit dilengkapi baterai Intelligent Flight dengan internal resistance rendah dan siklus sehat untuk daya tahan maksimum tanpa drop voltase tiba-tiba.
                        </p>
                    </div>

                    <div class="mt-8 pt-6 border-t border-neutral-800/80 flex items-center justify-between text-[11px] font-mono text-neutral-400">
                        <span class="flex items-center gap-1.5 text-white font-medium">
                            <span class="h-1.5 w-1.5 rounded-full bg-white"></span> Multi-Battery Pack
                        </span>
                        <span>Charging Hub Ready</span>
                    </div>
                </div>

                <!-- Card 03: E-Invoice & Regulatory Compliance -->
                <div class="group relative rounded-2xl bg-neutral-950 border border-neutral-800 p-8 hover:border-white/40 hover:bg-neutral-900/60 transition-all duration-300 flex flex-col justify-between overflow-hidden shadow-2xl">
                    <div>
                        <div class="flex items-center justify-between mb-8">
                            <div class="h-12 w-12 rounded-xl bg-white/10 border border-white/20 flex items-center justify-center text-white group-hover:bg-white group-hover:text-black transition duration-300 shadow-sm">
                                <svg class="h-6 w-6 stroke-[1.8]" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                                    <polyline points="14 2 14 8 20 8"/>
                                    <line x1="16" y1="13" x2="8" y2="13"/>
                                    <line x1="16" y1="17" x2="8" y2="17"/>
                                    <polyline points="10 9 9 9 8 9"/>
                                </svg>
                            </div>
                            <span class="font-mono text-xs text-neutral-400 uppercase tracking-widest font-semibold">Protocol // 03</span>
                        </div>

                        <h4 class="text-xl font-bold text-white tracking-tight group-hover:text-neutral-100 transition duration-200">
                            E-Invoice Resmi &amp; QR Tracking
                        </h4>
                        <p class="text-xs sm:text-sm text-neutral-400 mt-3 leading-relaxed font-light">
                            Setelah pembayaran online Midtrans selesai, e-invoice resmi PDF terbit seketika dengan QR verifikasi untuk pelacakan status sewa dan validitas serah terima.
                        </p>
                    </div>

                    <div class="mt-8 pt-6 border-t border-neutral-800/80 flex items-center justify-between text-[11px] font-mono text-neutral-400">
                        <span class="flex items-center gap-1.5 text-white font-medium">
                            <span class="h-1.5 w-1.5 rounded-full bg-white"></span> Instan PDF + QR
                        </span>
                        <span>DRONEID DJPU</span>
                    </div>
                </div>
            </div>

            <!-- Bottom Quality Statement Strip with Minimalist B&W Styling -->
            <div class="mt-12 rounded-2xl border border-neutral-800 bg-neutral-950 p-6 sm:p-8 flex flex-col md:flex-row items-center justify-between gap-6 shadow-2xl">
                <div class="flex items-center gap-4">
                    <div class="h-10 w-10 rounded-full bg-white/10 border border-white/20 flex items-center justify-center text-white shrink-0 shadow-sm">
                        <svg class="h-5 w-5 stroke-[2]" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                        </svg>
                    </div>
                    <div>
                        <h5 class="text-sm font-bold text-white">Butuh Dukungan Teknis atau Operator Drone Khusus?</h5>
                        <p class="text-xs text-neutral-400 mt-0.5">Konsultasikan kebutuhan produksi sinematik atau survei Anda langsung dengan tim kami.</p>
                    </div>
                </div>
                <a href="https://wa.me/{{ config('services.wa.admin_number') }}" target="_blank"
                   class="inline-flex items-center gap-2 rounded-xl bg-white text-black hover:bg-neutral-200 px-6 py-3 text-xs font-bold uppercase tracking-wider transition shrink-0 shadow-lg border border-white">
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
                label.innerHTML = '<span class="h-1.5 w-1.5 rounded-full bg-black animate-pulse inline-block mr-1.5"></span>' + title;
            }
            document.querySelectorAll('.thumb-btn-' + droneSlug).forEach(b => {
                b.classList.remove('border-black', 'ring-1', 'ring-black/30', 'bg-neutral-100');
                b.classList.add('border-neutral-200', 'opacity-70', 'bg-white');
            });
            if (btn) {
                btn.classList.add('border-black', 'ring-1', 'ring-black/30', 'bg-neutral-100');
                btn.classList.remove('border-neutral-200', 'opacity-70', 'bg-white');
            }
        }
    </script>
@endsection
