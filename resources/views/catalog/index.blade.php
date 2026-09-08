@extends('layouts.store')

@section('title', 'Sewa Drone DJI — Harian & Mingguan')

@section('content')
    <section class="relative overflow-hidden border-b border-[#24334F]">
        <div class="mx-auto max-w-6xl px-4 pt-16 pb-14">
            <div class="h-0.5 w-14 bg-[#38BDF8] mb-5"></div>
            <h1 class="text-3xl sm:text-5xl font-bold tracking-tight leading-tight max-w-2xl">
                Sewa drone DJI untuk
                <span class="text-[#38BDF8]">konten terbaik Anda</span>
            </h1>
            <p class="mt-4 text-[#94A3B8] max-w-xl leading-relaxed">
                Booking online, bayar via QRIS atau transfer bank, invoice otomatis.
                Mulai Rp350.000/hari — tanpa perlu punya drone sendiri.
            </p>
            <div class="mt-7 flex gap-4 text-sm text-[#94A3B8]">
                <span class="flex items-center gap-1.5"><span class="h-1.5 w-1.5 rounded-full bg-[#34D399]"></span>Unit terawat</span>
                <span class="flex items-center gap-1.5"><span class="h-1.5 w-1.5 rounded-full bg-[#34D399]"></span>Invoice resmi</span>
                <span class="flex items-center gap-1.5"><span class="h-1.5 w-1.5 rounded-full bg-[#34D399]"></span>Bisa dengan pilot</span>
            </div>
        </div>
    </section>

    <section class="mx-auto max-w-6xl px-4 py-12">
        <h2 class="text-lg font-semibold mb-6">Daftar drone</h2>
        <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
            @forelse ($drones as $drone)
                <x-card class="flex flex-col overflow-hidden">
                    <div class="h-36 bg-gradient-to-br from-[#1A2740] to-[#0B1220] flex items-center justify-center">
                        @if ($drone->image_path)
                            <img src="{{ asset('storage/'.$drone->image_path) }}" alt="{{ $drone->name }}" class="h-full w-full object-cover">
                        @else
                            <svg class="h-12 w-12 text-[#24334F]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.2">
                                <path d="M4 8h4V4M16 4v4h4M20 16h-4v4M8 20v-4H4" stroke-linecap="round"/>
                                <circle cx="12" cy="12" r="2.2"/>
                            </svg>
                        @endif
                    </div>
                    <div class="p-5 flex flex-col flex-1">
                        <h3 class="font-semibold">{{ $drone->name }}</h3>
                        <p class="mt-1 text-sm text-[#94A3B8] flex-1">
                            {{ $drone->camera }} · {{ $drone->flight_time_min }} menit terbang
                            @if ($drone->weight_g < 250)
                                · &lt;250g (bebas pilot)
                            @endif
                        </p>
                        <div class="mt-4 flex items-center justify-between">
                            <div>
                                <x-price :amount="$drone->daily_rate" class="text-lg" /><span class="text-xs text-[#94A3B8] font-normal">/hari</span>
                            </div>
                            <a href="{{ route('drones.show', $drone) }}" class="text-sm font-medium text-[#38BDF8] underline-offset-4 hover:underline">Booking &rarr;</a>
                        </div>
                    </div>
                </x-card>
            @empty
                <p class="text-[#94A3B8]">Belum ada drone tersedia.</p>
            @endforelse
        </div>
    </section>
@endsection
