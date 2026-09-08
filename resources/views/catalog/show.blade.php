@extends('layouts.store')

@section('title', $drone->name.' — Sewa Harian')

@section('content')
    <div class="mx-auto max-w-6xl px-4 py-10">
        <a href="{{ route('home') }}" class="text-sm text-[#94A3B8] hover:text-white">&larr; Kembali ke katalog</a>

        <div class="mt-6 grid gap-8 lg:grid-cols-[1.2fr_1fr]">
            <div>
                <div class="h-56 sm:h-72 rounded-lg bg-gradient-to-br from-[#1A2740] to-[#0B1220] border border-[#24334F] flex items-center justify-center overflow-hidden">
                    @if ($drone->image_path)
                        <img src="{{ asset('storage/'.$drone->image_path) }}" alt="{{ $drone->name }}" class="h-full w-full object-cover">
                    @else
                        <svg class="h-20 w-20 text-[#24334F]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.2">
                            <path d="M4 8h4V4M16 4v4h4M20 16h-4v4M8 20v-4H4" stroke-linecap="round"/>
                            <circle cx="12" cy="12" r="2.2"/>
                        </svg>
                    @endif
                </div>

                <h1 class="mt-6 text-2xl font-bold">{{ $drone->name }}</h1>
                <p class="mt-3 text-[#94A3B8] leading-relaxed">{{ $drone->description }}</p>

                <dl class="mt-6 grid grid-cols-2 sm:grid-cols-4 gap-4 text-sm">
                    <div><dt class="text-[#94A3B8]">Kamera</dt><dd class="mt-0.5 font-medium">{{ $drone->camera }}</dd></div>
                    <div><dt class="text-[#94A3B8]">Terbang</dt><dd class="mt-0.5 font-medium">{{ $drone->flight_time_min }} menit</dd></div>
                    <div><dt class="text-[#94A3B8]">Jangkauan</dt><dd class="mt-0.5 font-medium">{{ $drone->range_km }} km</dd></div>
                    <div><dt class="text-[#94A3B8]">Berat</dt><dd class="mt-0.5 font-medium">{{ $drone->weight_g }} g</dd></div>
                </dl>

                <div class="mt-8 border-l-2 border-[#38BDF8] pl-4 text-sm text-[#94A3B8] space-y-1.5">
                    <p class="font-medium text-[#F1F5F9]">Ketentuan sewa</p>
                    <p>Identitas (KTP/SIM) atau deposit saat pickup.</p>
                    <p>Telat kembali: denda 50%/jam, maks. 1x tarif harian.</p>
                    <p>Kerusakan ditanggung penyewa — nilai ganti: <x-price :amount="$drone->replacement_value ?? 0" class="text-sm" />.</p>
                    @if ($drone->weight_g >= 250)
                        <p>Unit ≥250 g: butuh sertifikat pilot untuk penggunaan komersial (Permenhub PM 37/2020).</p>
                    @endif
                </div>
            </div>

            <div>
                <x-card class="p-6 sticky top-20">
                    <div class="flex items-baseline justify-between">
                        <div>
                            <x-price :amount="$drone->daily_rate" class="text-2xl" /><span class="text-sm text-[#94A3B8] font-normal">/hari</span>
                        </div>
                        @if ($drone->weekly_rate)
                            <span class="text-xs text-[#94A3B8]">Mingguan <x-price :amount="$drone->weekly_rate" class="text-sm" /></span>
                        @endif
                    </div>

                    <form action="{{ route('bookings.create', $drone) }}" method="GET" class="mt-5 space-y-3">
                        <div>
                            <label class="block text-xs font-medium text-[#94A3B8] mb-1.5">Tanggal mulai</label>
                            <input type="date" name="start_date" required min="{{ now()->toDateString() }}"
                                   class="w-full rounded-lg bg-[#0B1220] border border-[#24334F] px-3 py-2.5 text-sm focus:border-[#38BDF8] focus:outline-none">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-[#94A3B8] mb-1.5">Tanggal selesai</label>
                            <input type="date" name="end_date" required min="{{ now()->toDateString() }}"
                                   class="w-full rounded-lg bg-[#0B1220] border border-[#24334F] px-3 py-2.5 text-sm focus:border-[#38BDF8] focus:outline-none">
                        </div>
                        <x-btn type="submit" class="w-full">Cek ketersediaan</x-btn>
                    </form>
                </x-card>
            </div>
        </div>
    </div>
@endsection
