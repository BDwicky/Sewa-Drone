<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sewa Drone DJI — Rental Kamera Udara Profesional')</title>
    <meta name="description" content="@yield('meta_description', 'Rental drone DJI resmi Indonesia: Mini 4 Pro, Air 3S, Mavic 3 Pro, Avata 2. Sistem sewa harian & mingguan, verifikasi instan, e-invoice resmi.')">
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}?v=3">
    <link rel="apple-touch-icon" href="{{ asset('favicon.svg') }}?v=3">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    @stack('meta')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, sans-serif;
            background-color: #FFFFFF;
            color: #111111;
        }
        .dji-glass {
            background: rgba(0, 0, 0, 0.95);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        .dji-card {
            background: #FFFFFF;
            border: 1px solid rgba(0, 0, 0, 0.08);
            box-shadow: 0 4px 20px -2px rgba(0, 0, 0, 0.05);
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .dji-card:hover {
            border-color: rgba(0, 0, 0, 0.25);
            transform: translateY(-3px);
            box-shadow: 0 16px 36px -10px rgba(0, 0, 0, 0.09);
        }
        .hud-spec {
            border-left: 2px solid #000000;
            padding-left: 0.75rem;
        }
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }
        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
</head>
<body class="antialiased min-h-screen flex flex-col selection:bg-black selection:text-white bg-white text-neutral-900">
    <!-- DJI Official Style Sticky Navigation (Minimalist Jet Black) -->
    <header class="sticky top-0 z-50 dji-glass transition duration-200">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 h-16 flex items-center justify-between">
            <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                <x-application-logo class="h-9 w-9 rounded-xl shadow-sm transition-transform duration-300 group-hover:scale-105 shrink-0" />
                <div class="flex flex-col">
                    <span class="font-extrabold tracking-wider text-sm sm:text-base text-white group-hover:text-neutral-300 transition leading-tight">SEWA<span class="text-neutral-400">DRONE</span></span>
                    <span class="text-[9px] tracking-[0.2em] text-neutral-400 uppercase -mt-0.5 font-semibold">DJI Authorized Fleet</span>
                </div>
            </a>

            <nav class="hidden md:flex items-center gap-8 text-xs font-semibold uppercase tracking-wider text-neutral-400">
                <a href="{{ route('home') }}" class="hover:text-white transition {{ request()->routeIs('home') ? 'text-white font-bold' : '' }}">Armada Drone</a>
                <a href="{{ route('pages.faq') }}" class="hover:text-white transition {{ request()->routeIs('pages.faq') ? 'text-white font-bold' : '' }}">Spesifikasi & FAQ</a>
                <a href="{{ route('pages.kebijakan') }}" class="hover:text-white transition {{ request()->routeIs('pages.kebijakan') ? 'text-white font-bold' : '' }}">Regulasi & Sewa</a>
            </nav>

            <div class="flex items-center gap-3">
                @auth
                    <a href="{{ route('admin.bookings.index') }}" class="text-xs font-medium text-neutral-300 hover:text-white px-3.5 py-1.5 border border-neutral-700 bg-neutral-900 rounded-full hover:border-neutral-500 transition">Console</a>
                @endauth
                <a href="{{ route('home') }}#fleet" class="text-xs font-semibold bg-white text-black hover:bg-neutral-200 transition px-5 py-2 rounded-full tracking-wide uppercase shadow-sm border border-white">
                    Pilih Unit &rarr;
                </a>
            </div>
        </div>
    </header>

    <main class="flex-1 bg-white">
        @yield('content')
    </main>

    <!-- DJI Official Style Structured Footer (High-Contrast Minimalist Black) -->
    <footer class="border-t border-neutral-800 bg-black text-neutral-400 text-xs">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 py-14">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 pb-12 border-b border-neutral-800/80">
                <div>
                    <h4 class="text-white text-xs font-bold uppercase tracking-wider mb-3">Armada Drone</h4>
                    <ul class="space-y-2">
                        <li><a href="{{ route('home') }}#fleet" class="hover:text-white transition">DJI Neo &amp; Mini Series (&lt;249g)</a></li>
                        <li><a href="{{ route('home') }}#fleet" class="hover:text-white transition">DJI Air 3S (Dual-Camera)</a></li>
                        <li><a href="{{ route('home') }}#fleet" class="hover:text-white transition">DJI Mavic 3 Pro &amp; Classic</a></li>
                        <li><a href="{{ route('home') }}#fleet" class="hover:text-white transition">DJI Avata 2 (FPV) &amp; Inspire 3 (8K)</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-white text-xs font-bold uppercase tracking-wider mb-3">Layanan Sewa</h4>
                    <ul class="space-y-2">
                        <li><a href="{{ route('pages.kebijakan') }}" class="hover:text-white transition">Sewa Harian Lepas Kunci</a></li>
                        <li><a href="{{ route('pages.kebijakan') }}" class="hover:text-white transition">Paket Dengan Pilot Berlisensi</a></li>
                        <li><a href="{{ route('pages.kebijakan') }}" class="hover:text-white transition">Antar-Jemput Unit Wilayah</a></li>
                        <li><a href="{{ route('pages.kebijakan') }}" class="hover:text-white transition">Tarif Mingguan Spesial</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-white text-xs font-bold uppercase tracking-wider mb-3">Regulasi & Legal</h4>
                    <ul class="space-y-2">
                        <li><a href="{{ route('pages.faq') }}" class="hover:text-white transition">Ketentuan DRONEID DJPU</a></li>
                        <li><a href="{{ route('pages.kebijakan') }}" class="hover:text-white transition">Sertifikasi Permenhub PM 37/2020</a></li>
                        <li><a href="{{ route('pages.kebijakan') }}" class="hover:text-white transition">Kebijakan Kerusakan & Deposit</a></li>
                        <li><a href="{{ route('pages.faq') }}" class="hover:text-white transition">Zona Terbang Aman (Fly Safe)</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-white text-xs font-bold uppercase tracking-wider mb-3">Pusat Layanan</h4>
                    <p class="leading-relaxed text-neutral-400 mb-3">
                        Pemesanan terverifikasi online dengan e-invoice instan dan integrasi pembayaran QRIS/VA Midtrans.
                    </p>
                    <a href="https://wa.me/{{ config('services.wa.admin_number') }}" target="_blank" class="inline-flex items-center gap-1.5 text-white hover:text-neutral-300 font-semibold transition">
                        <span>WhatsApp Layanan Langsung</span> &rarr;
                    </a>
                </div>
            </div>

            <div class="pt-8 flex flex-col sm:flex-row justify-between items-center gap-4 text-neutral-400">
                <div class="flex items-center gap-3">
                    <x-application-logo class="h-6 w-6 rounded-lg shrink-0 opacity-90" />
                    <p>&copy; {{ date('Y') }} SewaDrone Indonesia. Seluruh spesifikasi dan referensi produk merujuk standar DJI Innovations.</p>
                </div>
                <div class="flex flex-wrap gap-6 font-medium text-xs">
                    <a href="{{ route('pages.kebijakan') }}" class="hover:text-white transition">Syarat & Ketentuan</a>
                    <a href="{{ route('pages.faq') }}" class="hover:text-white transition">FAQ</a>
                    <button type="button" onclick="window.openCookieSettings()" class="hover:text-white transition cursor-pointer">Pengaturan Cookie</button>
                </div>
            </div>
        </div>
    </footer>

    <!-- DJI Official Style Cookie Consent Banner & Preferences Modal -->
    <x-cookie-banner />
</body>
</html>
