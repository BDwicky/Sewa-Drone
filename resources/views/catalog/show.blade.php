@extends('layouts.store')

@section('title', $drone->name . ' — Sewa Drone DJI Resmi')

@section('content')
    @php
        $mediaFile = base_path('database/dji_media.json');
        $allMedia = file_exists($mediaFile) ? json_decode(file_get_contents($mediaFile), true) : [];
        $droneMedia = $allMedia[$drone->slug] ?? null;
        $gallery = $droneMedia['gallery'] ?? [];
        $videoUrl = $droneMedia['video'] ?? null;
    @endphp

    <!-- Top Sub-Nav (DJI Store Style) -->
    <div class="border-b border-white/10 bg-[#06080D] sticky top-16 z-40 backdrop-blur-md bg-opacity-90">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 py-3.5 flex items-center justify-between text-xs">
            <div class="flex items-center gap-3">
                <a href="{{ route('home') }}" class="text-gray-400 hover:text-white transition flex items-center gap-1">
                    <span>&larr;</span> <span>Armada</span>
                </a>
                <span class="text-gray-700">/</span>
                <span class="font-bold text-white tracking-wider uppercase">{{ $drone->name }}</span>
            </div>
            <div class="flex items-center gap-4">
                <div class="hidden sm:block text-right">
                    <span class="text-gray-400 text-[11px]">Tarif Sewa:</span>
                    <strong class="text-white text-sm ml-1 font-bold">Rp{{ number_format((float) $drone->daily_rate, 0, ',', '.') }}</strong>
                    <span class="text-gray-500 text-[10px]">/hari</span>
                </div>
                <a href="#booking-section" class="rounded bg-sky-400 hover:bg-sky-300 text-black px-4 py-2 font-bold uppercase tracking-wider text-[11px] transition shadow-lg shadow-sky-400/20">
                    Sewa Sekarang
                </a>
            </div>
        </div>
    </div>

    <div class="mx-auto max-w-7xl px-4 sm:px-6 py-12">
        <div class="grid gap-12 lg:grid-cols-[1.35fr_1fr] items-start">
            <!-- Left Column: Interactive Multi-Angle Gallery & Cinematic Video Reel -->
            <div class="space-y-8">
                <!-- Interactive Main Stage -->
                <div class="rounded-2xl bg-gradient-to-b from-[#121826] to-[#080B11] border border-white/10 p-6 sm:p-10 overflow-hidden relative">
                    <div class="flex items-center justify-between mb-4">
                        <span id="active-angle-title" class="text-xs uppercase tracking-widest text-sky-400 font-bold font-mono">
                            Tampilan Utama // Depan Gimbal
                        </span>
                        <span class="text-[10px] uppercase font-mono text-gray-400 border border-white/10 px-2 py-0.5 rounded">
                            Official DJI Media
                        </span>
                    </div>

                    <!-- Main Image Display -->
                    <div class="h-[300px] sm:h-[400px] w-full flex items-center justify-center relative my-2">
                        <img id="main-view-image"
                             src="{{ $gallery[0]['url'] ?? (str_starts_with($drone->image_path, 'http') ? $drone->image_path : asset('storage/'.$drone->image_path)) }}"
                             alt="{{ $drone->name }}"
                             class="h-full w-full object-contain drop-shadow-[0_20px_35px_rgba(0,0,0,0.8)] transition-all duration-300">
                    </div>

                    <!-- Multi-Angle Thumbnail Switcher -->
                    @if (count($gallery) > 0)
                        <div class="mt-6 pt-4 border-t border-white/10">
                            <span class="text-[10px] uppercase tracking-wider text-gray-400 block mb-2.5 font-medium">Pilih Sudut Pandang Drone:</span>
                            <div class="grid grid-cols-4 gap-3">
                                @foreach ($gallery as $index => $item)
                                    <button type="button"
                                            onclick="switchAngle('{{ $item['url'] }}', '{{ $item['title'] }}', this)"
                                            class="angle-btn rounded-lg border {{ $index === 0 ? 'border-sky-400 ring-1 ring-sky-400' : 'border-white/10 opacity-60' }} hover:opacity-100 hover:border-white/30 overflow-hidden bg-black/40 p-1.5 transition text-left group">
                                        <div class="h-14 w-full flex items-center justify-center overflow-hidden">
                                            <img src="{{ $item['url'] }}" alt="{{ $item['title'] }}" class="h-full w-full object-contain group-hover:scale-105 transition duration-200">
                                        </div>
                                        <span class="block text-[9px] text-gray-300 font-mono truncate mt-1 text-center">{{ $item['title'] }}</span>
                                    </button>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Official Cinematic Video Footage Reel -->
                @if ($videoUrl)
                    <div class="dji-card rounded-2xl p-6 sm:p-8 overflow-hidden">
                        <div class="flex items-center justify-between mb-4">
                            <div>
                                <span class="text-[10px] uppercase tracking-widest text-sky-400 font-bold block">Footage & Flight Reel</span>
                                <h3 class="text-lg font-bold text-white tracking-tight mt-0.5">HASIL REKAMAN & UJI TERBANG SINEMATIK</h3>
                            </div>
                            <span class="text-[10px] text-emerald-400 flex items-center gap-1 border border-emerald-500/30 px-2 py-0.5 rounded bg-emerald-500/10">
                                <span class="h-1.5 w-1.5 rounded-full bg-emerald-400 animate-pulse"></span> 4K Ultra HD
                            </span>
                        </div>

                        <div class="relative rounded-xl overflow-hidden bg-black aspect-video border border-white/10 group">
                            <video class="w-full h-full object-cover" autoplay loop muted playsinline controls>
                                <source src="{{ $videoUrl }}" type="video/mp4">
                                Browser Anda tidak mendukung pemutar video HTML5.
                            </video>
                        </div>
                        <p class="text-xs text-gray-400 mt-3 leading-relaxed">
                            Contoh video tangkapan kamera asli sensor DJI {{ $drone->name }} dengan profil warna 10-bit D-Log M dan stabilisasi gimbal 3-axis profesional.
                        </p>
                    </div>
                @endif

                <!-- Product Overview & Aerospace Specs -->
                <div>
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
                <div>
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

                <!-- Paket Kelengkapan Rental Box (In The Box) -->
                <div class="rounded-xl bg-white/[0.02] border border-white/5 p-6">
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
                <div class="hud-spec text-xs text-gray-400 space-y-2 border-sky-500/40">
                    <p class="text-white font-semibold uppercase tracking-wider">Ketentuan sewa & SOP keamanan</p>
                    <p>Wajib menitipkan KTP/SIM asli atau deposit uang saat serah terima unit di lokasi.</p>
                    <p>Keterlambatan pengembalian unit dikenakan penyesuaian denda 50%/jam, maksimal 1x tarif harian.</p>
                    <p>Kerusakan operasional ditanggung penyewa sesuai estimasi spare-part resmi DJI. Nilai unit baru: <x-price :amount="$drone->replacement_value ?? 0" class="text-white font-bold" />.</p>
                    @if ($drone->weight_g >= 250)
                        <p class="text-sky-400">Unit di atas 249g tunduk pada Permenhub PM 37/2020 untuk penerbangan komersial bersertifikasi.</p>
                    @endif
                </div>
            </div>

            <!-- Right Column: Sticky Booking & Availability Card -->
            <div id="booking-section" class="sticky top-28">
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

    <!-- Multi-Angle Switching Script -->
    <script>
        function switchAngle(imgUrl, title, btn) {
            const mainImg = document.getElementById('main-view-image');
            const titleEl = document.getElementById('active-angle-title');
            if (mainImg) {
                mainImg.style.opacity = '0';
                setTimeout(() => {
                    mainImg.src = imgUrl;
                    mainImg.style.opacity = '1';
                }, 150);
            }
            if (titleEl) {
                titleEl.textContent = 'Tampilan // ' + title;
            }
            document.querySelectorAll('.angle-btn').forEach(b => {
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
