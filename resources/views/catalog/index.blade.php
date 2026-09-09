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
    <section class="relative min-h-[85vh] flex items-center justify-center overflow-hidden border-b border-white/10 bg-[#06080D]">
        <!-- Fullscreen Autoplay Video Background (Dolly / Aerial Tracking Shot) -->
        <div class="absolute inset-0 z-0 overflow-hidden">
            <video class="w-full h-full object-cover scale-105 filter brightness-[0.45] contrast-125 transition duration-1000" autoplay loop muted playsinline>
                <source src="{{ $heroVideo }}" type="video/mp4">
            </video>
            <!-- Vignette & Dark Overlay Gradients -->
            <div class="absolute inset-0 bg-gradient-to-t from-[#06080D] via-[#06080D]/40 to-[#06080D]/80"></div>
            <div class="absolute inset-0 bg-[radial-gradient(circle_at_center,rgba(56,189,248,0.12)_0%,rgba(6,8,13,0.7)_85%)]"></div>
        </div>

        <div class="relative z-10 mx-auto max-w-5xl px-4 sm:px-6 py-24 text-center">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full border border-sky-400/40 bg-black/60 backdrop-blur-md text-sky-400 text-xs tracking-wider uppercase mb-6 font-medium shadow-lg shadow-sky-500/10">
                <span class="h-1.5 w-1.5 rounded-full bg-sky-400 animate-ping"></span>
                <span>DJI Flagship Fleet Rental</span>
                <span class="text-gray-500 font-mono">/</span>
                <span class="text-gray-300">Live 4K Ready</span>
            </div>

            <h1 class="text-4xl sm:text-6xl md:text-7xl font-extrabold tracking-tight text-white uppercase leading-[1.05] drop-shadow-lg">
                TANGKAP SETIAP SUDUT<br>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-sky-400 via-white to-sky-200">SINEMATIK UDARA</span>
            </h1>

            <p class="mt-6 text-sm sm:text-base text-gray-300 max-w-2xl mx-auto font-light leading-relaxed drop-shadow">
                Penyewaan armada drone DJI resmi terlengkap di Indonesia. Dilengkapi kontroler DJI RC, multi-baterai, filter sinematik, serta sistem pemesanan full-otomatis dengan Midtrans &amp; e-invoice resmi.
            </p>

            <!-- Quick Specs HUD Bar -->
            <div class="mt-12 grid grid-cols-2 md:grid-cols-4 gap-4 max-w-3xl mx-auto text-left border-y border-white/15 bg-black/40 backdrop-blur-md rounded-xl p-6">
                <div class="hud-spec border-sky-400">
                    <span class="block text-2xl font-extrabold text-white tracking-tight">4K / 5.1K</span>
                    <span class="text-[10px] uppercase tracking-wider text-gray-400">Sensor Hasselblad &amp; HDR</span>
                </div>
                <div class="hud-spec border-sky-400">
                    <span class="block text-2xl font-extrabold text-white tracking-tight">Hingga 45m</span>
                    <span class="text-[10px] uppercase tracking-wider text-gray-400">Durasi Terbang Baterai</span>
                </div>
                <div class="hud-spec border-sky-400">
                    <span class="block text-2xl font-extrabold text-white tracking-tight">20 KM</span>
                    <span class="text-[10px] uppercase tracking-wider text-gray-400">Transmisi O4 FHD Video</span>
                </div>
                <div class="hud-spec border-sky-400">
                    <span class="block text-2xl font-extrabold text-white tracking-tight">&lt; 249g</span>
                    <span class="text-[10px] uppercase tracking-wider text-gray-400">Tersedia Bebas Izin</span>
                </div>
            </div>

            <div class="mt-10 flex items-center justify-center gap-4">
                <a href="#fleet" class="rounded-lg bg-sky-400 hover:bg-sky-300 text-black font-bold text-xs uppercase tracking-wider px-7 py-3.5 transition shadow-lg shadow-sky-400/30">
                    Jelajahi Armada &rarr;
                </a>
                <a href="{{ route('pages.kebijakan') }}" class="rounded-lg border border-white/20 hover:border-white text-white text-xs uppercase tracking-wider px-6 py-3.5 transition backdrop-blur-sm bg-black/30">
                    Syarat &amp; Kebijakan
                </a>
            </div>
        </div>
    </section>

    <!-- Product Showcase Grid (Multi-Angle Thumbnails + Device Previews) -->
    <section id="fleet" class="mx-auto max-w-7xl px-4 sm:px-6 py-20">
        <div class="flex flex-col md:flex-row md:items-end justify-between mb-12 border-b border-white/10 pb-6">
            <div>
                <span class="text-xs uppercase tracking-[0.25em] text-sky-400 font-semibold block mb-1">Armada Siap Terbang</span>
                <h2 class="text-2xl sm:text-3xl font-bold text-white tracking-tight">KATALOG DRONE &amp; KELENGKAPAN DEVICE</h2>
            </div>
            <p class="text-xs text-gray-400 mt-2 md:mt-0 max-w-md">
                Klik sudut pandang foto di bawah untuk melihat wujud fisik bodi, gimbal, propeller, serta kelengkapan perangkat tiap drone.
            </p>
        </div>

        <div class="grid gap-10 md:grid-cols-2 lg:grid-cols-2">
            @forelse ($drones as $drone)
                @php
                    $media = $allMedia[$drone->slug] ?? null;
                    $gallery = $media['gallery'] ?? [];
                    $firstImg = $gallery[0]['url'] ?? (str_starts_with($drone->image_path, 'http') ? $drone->image_path : asset('storage/'.$drone->image_path));
                @endphp
                <div class="dji-card rounded-2xl overflow-hidden p-6 sm:p-8 flex flex-col justify-between" id="card-{{ $drone->slug }}">
                    <div>
                        <!-- Header Card -->
                        <div class="flex items-start justify-between">
                            <div>
                                <span class="text-[10px] tracking-widest text-sky-400 uppercase font-semibold block">
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
                                <h3 class="text-2xl font-bold text-white tracking-tight mt-1">{{ $drone->name }}</h3>
                            </div>
                            <div class="text-right">
                                <span class="text-xl font-bold text-white tracking-tight">Rp{{ number_format((float) $drone->daily_rate, 0, ',', '.') }}</span>
                                <span class="text-[11px] text-gray-400 block -mt-0.5">/ hari</span>
                            </div>
                        </div>

                        <!-- Main Display Image for this Drone Card -->
                        <div class="my-6 h-56 rounded-xl bg-gradient-to-b from-white/[0.04] to-transparent border border-white/5 flex items-center justify-center relative overflow-hidden group p-4">
                            <div class="absolute inset-0 bg-sky-500/5 opacity-0 group-hover:opacity-100 transition duration-300"></div>
                            
                            <img id="card-img-{{ $drone->slug }}"
                                 src="{{ $firstImg }}"
                                 alt="{{ $drone->name }}"
                                 class="h-full w-full object-contain drop-shadow-[0_15px_25px_rgba(0,0,0,0.7)] transition-all duration-300">

                            <span id="card-label-{{ $drone->slug }}"
                                  class="absolute bottom-2.5 left-3 text-[9px] font-mono text-gray-400 uppercase bg-black/60 backdrop-blur-sm border border-white/10 px-2 py-0.5 rounded">
                                {{ $gallery[0]['title'] ?? 'Tampak Depan' }}
                            </span>
                        </div>

                        <!-- Multi-Angle & Device Thumbnails Row -->
                        @if (count($gallery) > 0)
                            <div class="mb-5">
                                <span class="text-[9px] uppercase tracking-wider text-gray-400 block mb-1.5 font-mono">Sudut Pandang Perangkat:</span>
                                <div class="grid grid-cols-4 gap-2">
                                    @foreach ($gallery as $idx => $g)
                                        <button type="button"
                                                onclick="updateCardPreview('{{ $drone->slug }}', '{{ $g['url'] }}', '{{ $g['title'] }}', this)"
                                                class="thumb-btn-{{ $drone->slug }} h-12 rounded-lg border {{ $idx === 0 ? 'border-sky-400 ring-1 ring-sky-400' : 'border-white/10 opacity-60' }} hover:opacity-100 hover:border-white/30 bg-black/40 p-1 flex flex-col items-center justify-center transition overflow-hidden">
                                            <img src="{{ $g['url'] }}" alt="{{ $g['title'] }}" class="h-8 w-auto object-contain">
                                            <span class="text-[8px] text-gray-300 truncate w-full text-center">{{ explode(' ', $g['title'])[0] }}</span>
                                        </button>
                                    @endforeach
                                </div>
                            </div>
                        @endif

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

                        <a href="{{ route('drones.show', $drone) }}" class="inline-flex items-center gap-1.5 rounded-lg bg-white/10 hover:bg-sky-400 hover:text-black text-white px-4 py-2.5 text-xs font-semibold uppercase tracking-wider transition">
                            <span>Detail &amp; Video Reel</span> &rarr;
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
                b.classList.remove('border-sky-400', 'ring-1', 'ring-sky-400');
                b.classList.add('border-white/10', 'opacity-60');
            });
            if (btn) {
                btn.classList.add('border-sky-400', 'ring-1', 'ring-sky-400');
                btn.classList.remove('border-white/10', 'opacity-60');
            }
        }
    </script>
@endsection
