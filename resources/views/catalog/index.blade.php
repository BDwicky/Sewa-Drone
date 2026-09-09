@extends('layouts.store')

@section('title', 'Sewa Drone DJI Resmi — Armada Lengkap Harian & Mingguan')

@section('content')
    @php
        $mediaFile = base_path('database/dji_media.json');
        $allMedia = file_exists($mediaFile) ? json_decode(file_get_contents($mediaFile), true) : [];
        $heroDrone = $drones->firstWhere('slug', 'dji-air-3s') ?? $drones->first();
        $heroVideo = "https://terra-1-g.djicdn.com/851d20f7b9f64838a34cd02351370894/OQ102%20shot%20on/M83_OQ102_10S_CLEAN_M_2400x1440-08.14.mp4";
    @endphp

    <!-- DJI Hero Cinematic Section with Seamless Drone Dolly Video Background -->
    <section class="relative min-h-[88vh] flex items-center justify-center overflow-hidden border-b border-white/10 bg-[#06080D]">
        <!-- Fullscreen Autoplay Video Background (Dolly / Aerial Tracking Shot) -->
        <div class="absolute inset-0 z-0 overflow-hidden">
            <video class="w-full h-full object-cover scale-105 filter brightness-[0.45] contrast-125 transition duration-1000" autoplay loop muted playsinline>
                <source src="{{ $heroVideo }}" type="video/mp4">
            </video>
            <!-- Vignette & Dark Overlay Gradients -->
            <div class="absolute inset-0 bg-gradient-to-t from-[#06080D] via-[#06080D]/40 to-[#06080D]/80"></div>
            <div class="absolute inset-0 bg-[radial-gradient(circle_at_center,rgba(56,189,248,0.14)_0%,rgba(6,8,13,0.75)_85%)]"></div>
        </div>

        <div class="relative z-10 mx-auto max-w-5xl px-4 sm:px-6 py-20 sm:py-28 text-center flex flex-col items-center">
            <div class="inline-flex items-center gap-2.5 px-4 py-1.5 rounded-full border border-sky-400/40 bg-black/60 backdrop-blur-md text-sky-400 text-xs tracking-wider uppercase mb-8 font-medium shadow-xl shadow-sky-500/10">
                <span class="h-2 w-2 rounded-full bg-sky-400 animate-ping"></span>
                <span>DJI Flagship Fleet Rental</span>
                <span class="text-gray-500 font-mono">/</span>
                <span class="text-gray-300">Live 4K Cinema Ready</span>
            </div>

            <h1 class="text-4xl sm:text-6xl md:text-7xl font-extrabold tracking-tight text-white uppercase leading-[1.08] drop-shadow-2xl max-w-4xl">
                TANGKAP SETIAP SUDUT<br>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-sky-400 via-white to-sky-200">SINEMATIK UDARA</span>
            </h1>

            <p class="mt-6 text-sm sm:text-base md:text-lg text-gray-300 max-w-2xl mx-auto font-light leading-relaxed drop-shadow px-4">
                Penyewaan armada drone DJI resmi terlengkap di Indonesia. Dilengkapi kontroler DJI RC, multi-baterai, filter sinematik, serta sistem pemesanan full-otomatis dengan Midtrans &amp; e-invoice instan.
            </p>

            <!-- Quick Specs HUD Bar -->
            <div class="mt-12 grid grid-cols-2 sm:grid-cols-4 gap-6 w-full max-w-3xl text-left border-y border-white/15 bg-black/50 backdrop-blur-md rounded-2xl p-6 sm:p-8 shadow-2xl">
                <div class="hud-spec border-sky-400">
                    <span class="block text-2xl sm:text-3xl font-extrabold text-white tracking-tight">4K / 5.1K</span>
                    <span class="text-[10px] uppercase tracking-wider text-gray-400 font-medium mt-0.5 block">Hasselblad &amp; HDR</span>
                </div>
                <div class="hud-spec border-sky-400">
                    <span class="block text-2xl sm:text-3xl font-extrabold text-white tracking-tight">45 Menit</span>
                    <span class="text-[10px] uppercase tracking-wider text-gray-400 font-medium mt-0.5 block">Max Durasi Terbang</span>
                </div>
                <div class="hud-spec border-sky-400">
                    <span class="block text-2xl sm:text-3xl font-extrabold text-white tracking-tight">20 KM</span>
                    <span class="text-[10px] uppercase tracking-wider text-gray-400 font-medium mt-0.5 block">Transmisi O4 FHD</span>
                </div>
                <div class="hud-spec border-sky-400">
                    <span class="block text-2xl sm:text-3xl font-extrabold text-white tracking-tight">&lt; 249g</span>
                    <span class="text-[10px] uppercase tracking-wider text-gray-400 font-medium mt-0.5 block">Tersedia Bebas Izin</span>
                </div>
            </div>

            <!-- Hero Action Buttons with Perfect Padding -->
            <div class="mt-10 flex flex-wrap items-center justify-center gap-4">
                <a href="#fleet" class="inline-flex items-center justify-center gap-2 rounded-xl bg-sky-400 hover:bg-sky-300 text-black font-extrabold text-xs uppercase tracking-wider px-8 py-4 transition shadow-lg shadow-sky-400/25 hover:shadow-sky-400/40 transform hover:-translate-y-0.5">
                    <span>Jelajahi Armada</span>
                    <svg class="h-4 w-4 stroke-[2.5]" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M5 12h14M12 5l7 7-7 7" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </a>
                <a href="{{ route('pages.kebijakan') }}" class="inline-flex items-center justify-center rounded-xl border border-white/20 hover:border-white text-white text-xs uppercase tracking-wider px-8 py-4 transition backdrop-blur-md bg-black/40 hover:bg-white/10">
                    Syarat &amp; Tata Cara
                </a>
            </div>
        </div>
    </section>

    <!-- Product Showcase Grid (Refined Card Padding & Balanced Layout) -->
    <section id="fleet" class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-20 sm:py-28">
        <div class="flex flex-col md:flex-row md:items-end justify-between mb-14 border-b border-white/10 pb-8 gap-4">
            <div>
                <span class="text-xs uppercase tracking-[0.25em] text-sky-400 font-bold block mb-2">Armada Siap Terbang</span>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-white tracking-tight">PILIH DRONE &amp; KELENGKAPAN DEVICE</h2>
            </div>
            <p class="text-xs text-gray-400 max-w-md leading-relaxed">
                Setiap armada telah dikalibrasi 100%, lengkap dengan remote controller, cadangan intelligent flight battery, charger hub, dan tas pembawa waterproof.
            </p>
        </div>

        <div class="grid gap-8 sm:gap-10 lg:grid-cols-2">
            @forelse ($drones as $drone)
                @php
                    $media = $allMedia[$drone->slug] ?? null;
                    $gallery = $media['gallery'] ?? [];
                    $firstImg = $gallery[0]['url'] ?? (str_starts_with($drone->image_path, 'http') ? $drone->image_path : asset('storage/'.$drone->image_path));
                @endphp
                <div class="dji-card rounded-2xl overflow-hidden p-6 sm:p-9 flex flex-col justify-between" id="card-{{ $drone->slug }}">
                    <div class="space-y-6">
                        <!-- Header Card with Proper Badging -->
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

                        <!-- Main Display Image Showcase Canvas -->
                        <div class="h-60 sm:h-64 rounded-xl bg-gradient-to-b from-white/[0.04] to-black/40 border border-white/10 flex items-center justify-center relative overflow-hidden group p-6 shadow-inner">
                            <div class="absolute inset-0 bg-sky-500/[0.04] opacity-0 group-hover:opacity-100 transition duration-300 pointer-events-none"></div>
                            
                            <img id="card-img-{{ $drone->slug }}"
                                 src="{{ $firstImg }}"
                                 alt="{{ $drone->name }}"
                                 class="h-full w-full object-contain drop-shadow-[0_20px_30px_rgba(0,0,0,0.8)] transition-all duration-300">

                            <span id="card-label-{{ $drone->slug }}"
                                  class="absolute bottom-3 left-3 text-[10px] font-mono text-gray-300 uppercase bg-black/70 backdrop-blur-md border border-white/15 px-3 py-1 rounded-md shadow">
                                {{ $gallery[0]['title'] ?? 'Tampak Depan' }}
                            </span>
                        </div>

                        <!-- Multi-Angle & Device Thumbnails Row -->
                        @if (count($gallery) > 0)
                            <div>
                                <span class="text-[10px] uppercase tracking-wider text-gray-400 block mb-2 font-mono font-semibold">Tinjau Sudut Pandang Perangkat:</span>
                                <div class="grid grid-cols-4 gap-2.5">
                                    @foreach ($gallery as $idx => $g)
                                        <button type="button"
                                                onclick="updateCardPreview('{{ $drone->slug }}', '{{ $g['url'] }}', '{{ $g['title'] }}', this)"
                                                class="thumb-btn-{{ $drone->slug }} h-14 rounded-xl border {{ $idx === 0 ? 'border-sky-400 ring-2 ring-sky-400/40 bg-sky-400/10' : 'border-white/10 opacity-70 bg-black/50' }} hover:opacity-100 hover:border-white/40 p-1.5 flex flex-col items-center justify-center transition overflow-hidden">
                                            <img src="{{ $g['url'] }}" alt="{{ $g['title'] }}" class="h-8 w-auto object-contain">
                                            <span class="text-[8.5px] text-gray-300 truncate w-full text-center mt-0.5 font-medium">{{ explode(' ', $g['title'])[0] }}</span>
                                        </button>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <p class="text-xs sm:text-sm text-gray-400 leading-relaxed font-light min-h-[3.5rem]">
                            {{ $drone->description }}
                        </p>

                        <!-- HUD Metrics Grid (DJI Spec Matrix) -->
                        <div class="grid grid-cols-4 gap-2 border-t border-white/10 pt-5 text-center">
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

                    <!-- Card Actions with Refined Padding & Proportion -->
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
    <section class="border-t border-white/10 bg-[#080B11] py-20">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-14">
                <span class="text-xs uppercase tracking-[0.2em] text-sky-400 font-bold block mb-2">Standard &amp; Keamanan</span>
                <h3 class="text-2xl sm:text-3xl font-extrabold text-white tracking-tight">STANDAR SERAH TERIMA ARMADA RESMI</h3>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <div class="dji-card rounded-2xl p-7 text-left space-y-3">
                    <span class="text-xs uppercase font-mono tracking-widest text-sky-400 font-bold">Standard 01</span>
                    <h4 class="text-lg font-bold text-white tracking-tight">Kalibrasi Sensor 100%</h4>
                    <p class="text-xs text-gray-400 leading-relaxed font-light">
                        Seluruh unit melalui uji sistem IMU, kompas digital, dan penyeimbang 3-axis gimbal sebelum diserahkan demi memastikan kestabilan bidikan video udara.
                    </p>
                </div>
                <div class="dji-card rounded-2xl p-7 text-left space-y-3">
                    <span class="text-xs uppercase font-mono tracking-widest text-sky-400 font-bold">Standard 02</span>
                    <h4 class="text-lg font-bold text-white tracking-tight">Kesehatan Baterai Terjamin</h4>
                    <p class="text-xs text-gray-400 leading-relaxed font-light">
                        Baterai Intelligent Flight diperiksa secara berkala pada siklus pengisian sehat guna mencegah penurunan daya mendadak di tengah sesi produksi.
                    </p>
                </div>
                <div class="dji-card rounded-2xl p-7 text-left space-y-3">
                    <span class="text-xs uppercase font-mono tracking-widest text-sky-400 font-bold">Standard 03</span>
                    <h4 class="text-lg font-bold text-white tracking-tight">E-Invoice &amp; Legalitas</h4>
                    <p class="text-xs text-gray-400 leading-relaxed font-light">
                        Pemesanan instan dengan bukti e-invoice resmi bertanda QR pelacakan serta dukungan kepatuhan regulasi DRONEID DJPU dan Permenhub PM 37/2020.
                    </p>
                </div>
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
                label.textContent = title;
            }
            document.querySelectorAll('.thumb-btn-' + droneSlug).forEach(b => {
                b.classList.remove('border-sky-400', 'ring-2', 'ring-sky-400/40', 'bg-sky-400/10');
                b.classList.add('border-white/10', 'opacity-70', 'bg-black/50');
            });
            if (btn) {
                btn.classList.add('border-sky-400', 'ring-2', 'ring-sky-400/40', 'bg-sky-400/10');
                btn.classList.remove('border-white/10', 'opacity-70', 'bg-black/50');
            }
        }
    </script>
@endsection
