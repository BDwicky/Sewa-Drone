<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Drone Rental')</title>
    <meta name="description" content="@yield('meta_description', 'Sewa drone DJI harian dan mingguan dengan harga terbaik. Booking online, bayar via QRIS/VA, invoice otomatis.')">
    @stack('meta')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#0B1220] text-[#F1F5F9] antialiased font-sans min-h-screen flex flex-col">
    <header class="sticky top-0 z-40 border-b border-[#24334F] bg-[#0B1220]/90 backdrop-blur">
        <div class="mx-auto max-w-6xl px-4 h-14 flex items-center justify-between">
            <a href="{{ route('home') }}" class="flex items-center gap-2 font-semibold tracking-tight">
                <svg class="h-5 w-5 text-[#38BDF8]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                    <path d="M4 8h4V4M16 4v4h4M20 16h-4v4M8 20v-4H4" stroke-linecap="round"/>
                    <circle cx="12" cy="12" r="2.2"/>
                </svg>
                <span>Sewa<span class="text-[#38BDF8]">Drone</span></span>
            </a>
            <nav class="flex items-center gap-5 text-sm text-[#94A3B8]">
                <a href="{{ route('pages.faq') }}" class="hover:text-white">FAQ</a>
                <a href="{{ route('pages.kebijakan') }}" class="hover:text-white">Kebijakan</a>
                @auth
                    <a href="{{ route('admin.bookings.index') }}" class="hover:text-white">Admin</a>
                @endauth
            </nav>
        </div>
    </header>

    <main class="flex-1">
        @yield('content')
    </main>

    <footer class="border-t border-[#24334F] mt-16">
        <div class="mx-auto max-w-6xl px-4 py-8 text-sm text-[#94A3B8] flex flex-col sm:flex-row gap-3 justify-between">
            <span>&copy; {{ date('Y') }} SewaDrone — Rental drone untuk kreator Indonesia.</span>
            <span class="flex gap-4">
                <a href="{{ route('pages.kebijakan') }}" class="hover:text-white">Kebijakan Sewa</a>
                <a href="{{ route('pages.faq') }}" class="hover:text-white">FAQ</a>
            </span>
        </div>
    </footer>
</body>
</html>
