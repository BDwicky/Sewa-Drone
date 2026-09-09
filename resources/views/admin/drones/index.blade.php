<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="font-extrabold text-2xl text-white tracking-tight flex items-center gap-2.5">
                    <span>Armada Drone</span>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-sky-500/10 text-[#38BDF8] border border-sky-500/20">
                        {{ $drones->count() }} Unit Terdaftar
                    </span>
                </h1>
                <p class="text-xs text-slate-400 mt-1">Kelola katalog drone sewa, spesifikasi, tarif harian/mingguan, dan ketersediaan unit.</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.drones.create') }}" class="inline-flex items-center gap-2 rounded-xl bg-[#38BDF8] px-4 py-2.5 text-xs font-bold text-[#0B1220] hover:bg-[#7DD3FC] transition shadow-lg shadow-sky-500/20">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    <span>+ Tambah Drone Baru</span>
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
        @if (session('status'))
            <div class="rounded-xl border border-emerald-500/30 bg-emerald-500/10 p-4 text-sm text-emerald-400 flex items-center gap-2.5 shadow-lg shadow-emerald-950/20">
                <svg class="w-5 h-5 text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>{{ session('status') }}</span>
            </div>
        @endif

        @if ($errors->any())
            <div class="rounded-xl border border-rose-500/30 bg-rose-500/10 p-4 text-sm text-rose-400 flex items-center gap-2.5 shadow-lg shadow-rose-950/20">
                <svg class="w-5 h-5 text-rose-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
                <span>{{ $errors->first() }}</span>
            </div>
        @endif

        <div class="bg-[#0F172A]/90 border border-slate-800/90 rounded-2xl shadow-xl backdrop-blur overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm min-w-[840px] text-left">
                    <thead class="text-xs uppercase font-bold tracking-wider text-slate-400 bg-slate-900/80 border-b border-slate-800">
                        <tr>
                            <th class="px-5 py-4">Drone</th>
                            <th class="px-5 py-4">Spesifikasi</th>
                            <th class="px-5 py-4 text-right">Tarif Sewa</th>
                            <th class="px-5 py-4 text-right">Biaya Tambahan</th>
                            <th class="px-5 py-4 text-center">Stok</th>
                            <th class="px-5 py-4 text-center">Pesanan</th>
                            <th class="px-5 py-4 text-center">Status</th>
                            <th class="px-5 py-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-800/60">
                        @forelse ($drones as $d)
                            <tr class="hover:bg-slate-800/40 transition group">
                                <!-- Drone Image & Name -->
                                <td class="px-5 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-12 h-12 rounded-xl bg-slate-800/80 border border-slate-700/80 flex items-center justify-center overflow-hidden shrink-0">
                                            @if ($d->image_path)
                                                <img src="{{ asset('storage/'.$d->image_path) }}" alt="{{ $d->name }}" class="w-full h-full object-cover">
                                            @else
                                                <svg class="w-6 h-6 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                                                </svg>
                                            @endif
                                        </div>
                                        <div>
                                            <a href="{{ route('drones.show', $d->slug) }}" target="_blank" class="font-bold text-white hover:text-[#38BDF8] transition inline-flex items-center gap-1">
                                                <span>{{ $d->name }}</span>
                                                <svg class="w-3 h-3 text-slate-500 group-hover:text-[#38BDF8]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                                </svg>
                                            </a>
                                            <div class="text-[11px] text-slate-500 font-mono mt-0.5">/drones/{{ $d->slug }}</div>
                                        </div>
                                    </div>
                                </td>

                                <!-- Specs -->
                                <td class="px-5 py-4 text-xs text-slate-300">
                                    <div class="space-y-0.5">
                                        @if ($d->camera)
                                            <div>📷 {{ $d->camera }}</div>
                                        @endif
                                        @if ($d->flight_time_min)
                                            <div>⏱️ {{ $d->flight_time_min }} Menit</div>
                                        @endif
                                        @if ($d->weight_g)
                                            <div>⚖️ {{ $d->weight_g }} gram</div>
                                        @endif
                                    </div>
                                </td>

                                <!-- Rates -->
                                <td class="px-5 py-4 text-right">
                                    <div class="font-bold text-white font-mono">Rp{{ number_format((float) $d->daily_rate, 0, ',', '.') }}<span class="text-[11px] font-normal text-slate-400">/hr</span></div>
                                    @if ($d->weekly_rate)
                                        <div class="text-[11px] text-slate-400 font-mono mt-0.5">Rp{{ number_format((float) $d->weekly_rate, 0, ',', '.') }}/mgg</div>
                                    @endif
                                </td>

                                <!-- Addon Rates -->
                                <td class="px-5 py-4 text-right text-xs">
                                    <div class="text-slate-300 font-mono">
                                        Pilot: {{ $d->pilot_daily_rate ? 'Rp'.number_format((float) $d->pilot_daily_rate, 0, ',', '.') : '—' }}
                                    </div>
                                    <div class="text-slate-500 font-mono mt-0.5">
                                        Antar: {{ $d->delivery_fee ? 'Rp'.number_format((float) $d->delivery_fee, 0, ',', '.') : '—' }}
                                    </div>
                                </td>

                                <!-- Stock -->
                                <td class="px-5 py-4 text-center">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-lg bg-slate-800 text-xs font-mono font-bold text-slate-200 border border-slate-700">
                                        {{ $d->stock }} Unit
                                    </span>
                                </td>

                                <!-- Bookings Count -->
                                <td class="px-5 py-4 text-center">
                                    <span class="text-xs font-bold text-slate-300">{{ $d->bookings_count }}</span>
                                </td>

                                <!-- Status -->
                                <td class="px-5 py-4 text-center">
                                    @if ($d->is_active)
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                                            AKTIF
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-slate-800 text-slate-400 border border-slate-700">
                                            <span class="w-1.5 h-1.5 rounded-full bg-slate-500"></span>
                                            NONAKTIF
                                        </span>
                                    @endif
                                </td>

                                <!-- Actions -->
                                <td class="px-5 py-4 text-right whitespace-nowrap">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('admin.drones.edit', $d) }}"
                                           class="px-2.5 py-1.5 rounded-lg text-xs font-semibold text-[#38BDF8] bg-sky-500/10 hover:bg-sky-500/20 border border-sky-500/20 transition">
                                            Edit
                                        </a>

                                        <form method="POST" action="{{ route('admin.drones.destroy', $d) }}" class="inline"
                                              onsubmit="return confirm('Apakah Anda yakin ingin menghapus drone {{ $d->name }}?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="px-2.5 py-1.5 rounded-lg text-xs font-semibold text-rose-400 bg-rose-500/10 hover:bg-rose-500/20 border border-rose-500/20 transition">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-6 py-12 text-center text-slate-400">
                                    Belum ada data drone yang terdaftar.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
