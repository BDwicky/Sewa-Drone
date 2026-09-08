<!DOCTYPE html>
<html lang="id" class="dark scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sewa Drone DJI — Rental Kamera Udara Profesional')</title>
    <meta name="description" content="@yield('meta_description', 'Rental drone DJI resmi Indonesia: Mini 4 Pro, Air 3S, Mavic 3 Pro, Avata 2. Sistem sewa harian & mingguan, verifikasi instan, e-invoice resmi.')">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    @stack('meta')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, sans-serif;
            background-color: #06080D;
            color: #F8FAFC;
        }
        .dji-glass {
            background: rgba(8, 11, 17, 0.75);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        }
        .dji-card {
            background: linear-gradient(180deg, rgba(18, 24, 38, 0.6) 0%, rgba(10, 14, 22, 0.9) 100%);
            border: 1px solid rgba(255, 255, 255, 0.07);
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .dji-card:hover {
            border-color: rgba(56, 189, 248, 0.35);
            transform: translateY(-2px);
            box-shadow: 0 20px 40px -15px rgba(0, 0, 0, 0.7);
        }
        .hud-spec {
            border-left: 2px solid rgba(56, 189, 248, 0.4);
            padding-left: 0.75rem;
        }
    </style>
</head>
<body class="antialiased min-h-screen flex flex-col selection:bg-sky-500 selection:text-black">
    <!-- DJI Style Sticky Navigation -->
    <header class="sticky top-0 z-50 dji-glass transition duration-200">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 h-16 flex items-center justify-between">
            <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                <div class="h-8 w-8 rounded bg-gradient-to-br from-sky-400 to-blue-600 flex items-center justify-center p-1.5 shadow-lg shadow-sky-500/20">
                    <svg class="h-full w-full text-black stroke-[2.2]" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <path d="M4 8h4V4M16 4v4h4M20 16h-4v4M8 20v-4H4" stroke-linecap="round"/>
                        <circle cx="12" cy="12" r="2.5" fill="currentColor"/>
                    </svg>
                </div>
                <div class="flex flex-col">
                    <span class="font-bold tracking-wider text-sm text-white group-hover:text-sky-400 transition">SEWA<span class="text-sky-400">DRONE</span></span>
                    <span class="text-[9px] tracking-[0.2em] text-gray-400 uppercase -mt-0.5">DJI Authorized Fleet</span>
                </div>
            </a>

            <nav class="hidden md:flex items-center gap-8 text-xs font-medium uppercase tracking-wider text-gray-300">
                <a href="{{ route('home') }}" class="hover:text-sky-400 transition {{ request()->routeIs('home') ? 'text-sky-400' : '' }}">Armada Drone</a>
                <a href="{{ route('pages.faq') }}" class="hover:text-sky-400 transition {{ request()->routeIs('pages.faq') ? 'text-sky-400' : '' }}">Spesifikasi & FAQ</a>
                <a href="{{ route('pages.kebijakan') }}" class="hover:text-sky-400 transition {{ request()->routeIs('pages.kebijakan') ? 'text-sky-400' : '' }}">Regulasi & Sewa</a>
            </nav>

            <div class="flex items-center gap-3">
                @auth
                    <a href="{{ route('admin.bookings.index') }}" class="text-xs font-medium text-gray-400 hover:text-white px-3 py-1.5 border border-white/10 rounded">Console</a>
                @endauth
                <a href="{{ route('home') }}#fleet" class="text-xs font-semibold bg-white text-black hover:bg-sky-400 hover:text-black transition px-4 py-2 rounded tracking-wide uppercase">
                    Pilih Unit &rarr;
                </a>
            </div>
        </div>
    </header>

    <main class="flex-1">
        @yield('content')
    </main>

    <!-- DJI Official Style Structured Footer -->
    <footer class="border-t border-white/10 bg-[#040609] text-gray-400 text-xs mt-24">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 py-14">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 pb-12 border-b border-white/5">
                <div>
                    <h4 class="text-white text-xs font-semibold uppercase tracking-wider mb-3">Armada Drone</h4>
                    <ul class="space-y-2">
                        <li><a href="{{ route('home') }}#fleet" class="hover:text-white transition">DJI Mini 4 Pro (<249g)</a></li>
                        <li><a href="{{ route('home') }}#fleet" class="hover:text-white transition">DJI Air 3S (Dual Cam)</a></li>
                        <li><a href="{{ route('home') }}#fleet" class="hover:text-white transition">DJI Mavic 3 Pro (Hasselblad)</a></li>
                        <li><a href="{{ route('home') }}#fleet" class="hover:text-white transition">DJI Avata 2 (Cinematic FPV)</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-white text-xs font-semibold uppercase tracking-wider mb-3">Layanan Sewa</h4>
                    <ul class="space-y-2">
                        <li><a href="{{ route('pages.kebijakan') }}" class="hover:text-white transition">Sewa Harian Lepas Kunci</a></li>
                        <li><a href="{{ route('pages.kebijakan') }}" class="hover:text-white transition">Paket Dengan Pilot Berlisensi</a></li>
                        <li><a href="{{ route('pages.kebijakan') }}" class="hover:text-white transition">Antar-Jemput Unit Wilayah</a></li>
                        <li><a href="{{ route('pages.kebijakan') }}" class="hover:text-white transition">Tarif Mingguan Spesial</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-white text-xs font-semibold uppercase tracking-wider mb-3">Regulasi & Legal</h4>
                    <ul class="space-y-2">
                        <li><a href="{{ route('pages.faq') }}" class="hover:text-white transition">Ketentuan DRONEID DJPU</a></li>
                        <li><a href="{{ route('pages.kebijakan') }}" class="hover:text-white transition">Sertifikasi Permenhub PM 37/2020</a></li>
                        <li><a href="{{ route('pages.kebijakan') }}" class="hover:text-white transition">Kebijakan Kerusakan & Deposit</a></li>
                        <li><a href="{{ route('pages.faq') }}" class="hover:text-white transition">Zona Terbang Aman (Fly Safe)</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-white text-xs font-semibold uppercase tracking-wider mb-3">Pusat Layanan</h4>
                    <p class="leading-relaxed text-gray-400 mb-3">
                        Pemesanan terverifikasi online dengan e-invoice instan dan integrasi pembayaran QRIS/VA Midtrans.
                    </p>
                    <a href="https://wa.me/{{ config('services.wa.admin_number') }}" target="_blank" class="inline-flex items-center gap-1.5 text-sky-400 hover:underline">
                        <span>WhatsApp Layanan Langsung</span> &rarr;
                    </a>
                </div>
            </div>

            <div class="pt-8 flex flex-col sm:flex-row justify-between items-center gap-4 text-gray-400">
                <p>&copy; {{ date('Y') }} SewaDrone Indonesia. Seluruh spesifikasi dan referensi produk merujuk standar DJI Innovations.</p>
                <div class="flex gap-6">
                    <a href="{{ route('pages.kebijakan') }}" class="hover:text-white">Syarat & Ketentuan</a>
                    <a href="{{ route('pages.faq') }}" class="hover:text-white">FAQ</a>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>
