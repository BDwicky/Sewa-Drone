<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="font-extrabold text-2xl text-white tracking-tight flex items-center gap-2.5">
                    <span>Manajemen Pesanan</span>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-sky-500/10 text-[#38BDF8] border border-sky-500/20">
                        {{ $bookings->total() }} Data
                    </span>
                </h1>
                <p class="text-xs text-slate-400 mt-1">Pantau status persewaan drone, verifikasi pembayaran Midtrans, dan kelola alur unit.</p>
            </div>
            <div class="flex items-center gap-2.5">
                <a href="{{ route('admin.drones.index') }}" class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl text-xs font-semibold text-slate-300 bg-slate-800/80 hover:bg-slate-700 hover:text-white border border-slate-700/80 transition shadow-sm">
                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                    </svg>
                    <span>Kelola Armada Drone</span>
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
        @if (session('status'))
            <div class="rounded-xl border border-emerald-500/30 bg-emerald-500/10 p-4 text-sm text-emerald-400 flex items-center justify-between shadow-lg shadow-emerald-950/20">
                <div class="flex items-center gap-2.5">
                    <svg class="w-5 h-5 text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>{{ session('status') }}</span>
                </div>
            </div>
        @endif

        <!-- Quick Stat Cards -->
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
            <!-- Total Pesanan -->
            <div class="p-5 rounded-2xl bg-[#0F172A]/90 border border-slate-800/90 shadow-xl backdrop-blur relative overflow-hidden group">
                <div class="absolute -right-3 -bottom-3 w-20 h-20 bg-sky-500/5 rounded-full blur-xl pointer-events-none group-hover:bg-sky-500/10 transition-all"></div>
                <div class="flex items-center justify-between">
                    <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Total Pesanan</span>
                    <span class="p-2 rounded-xl bg-sky-500/10 text-[#38BDF8] border border-sky-500/20">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </span>
                </div>
                <div class="mt-3">
                    <span class="text-2xl font-black text-white">{{ $stats['total'] }}</span>
                    <span class="text-xs text-slate-500 ms-1">transaksi</span>
                </div>
            </div>

            <!-- Menunggu Konfirmasi -->
            <div class="p-5 rounded-2xl bg-[#0F172A]/90 border border-slate-800/90 shadow-xl backdrop-blur relative overflow-hidden group">
                <div class="absolute -right-3 -bottom-3 w-20 h-20 bg-amber-500/5 rounded-full blur-xl pointer-events-none group-hover:bg-amber-500/10 transition-all"></div>
                <div class="flex items-center justify-between">
                    <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Perlu Konfirmasi</span>
                    <span class="p-2 rounded-xl bg-amber-500/10 text-amber-400 border border-amber-500/20">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </span>
                </div>
                <div class="mt-3 flex items-baseline gap-2">
                    <span class="text-2xl font-black {{ $stats['pending'] > 0 ? 'text-amber-400' : 'text-white' }}">{{ $stats['pending'] }}</span>
                    <span class="text-xs text-slate-500">pending / bayar</span>
                </div>
            </div>

            <!-- Sedang Disewa -->
            <div class="p-5 rounded-2xl bg-[#0F172A]/90 border border-slate-800/90 shadow-xl backdrop-blur relative overflow-hidden group">
                <div class="absolute -right-3 -bottom-3 w-20 h-20 bg-cyan-500/5 rounded-full blur-xl pointer-events-none group-hover:bg-cyan-500/10 transition-all"></div>
                <div class="flex items-center justify-between">
                    <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Sedang Disewa</span>
                    <span class="p-2 rounded-xl bg-cyan-500/10 text-[#38BDF8] border border-cyan-500/20">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </span>
                </div>
                <div class="mt-3 flex items-baseline gap-2">
                    <span class="text-2xl font-black text-[#38BDF8]">{{ $stats['active'] }}</span>
                    <span class="text-xs text-slate-500">unit di lapangan</span>
                </div>
            </div>

            <!-- Omset Terverifikasi -->
            <div class="p-5 rounded-2xl bg-[#0F172A]/90 border border-slate-800/90 shadow-xl backdrop-blur relative overflow-hidden group">
                <div class="absolute -right-3 -bottom-3 w-20 h-20 bg-emerald-500/5 rounded-full blur-xl pointer-events-none group-hover:bg-emerald-500/10 transition-all"></div>
                <div class="flex items-center justify-between">
                    <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Estimasi Omset</span>
                    <span class="p-2 rounded-xl bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </span>
                </div>
                <div class="mt-3">
                    <span class="text-xl font-black text-emerald-400">Rp{{ number_format($stats['revenue'], 0, ',', '.') }}</span>
                </div>
            </div>
        </div>

        <!-- Filter Status Bar -->
        <div class="flex items-center gap-2 overflow-x-auto pb-1 text-xs">
            @php
                $statusTabs = [
                    '' => ['label' => 'Semua Pesanan', 'count' => $stats['total']],
                    'pending' => ['label' => 'Pending Bayar', 'count' => $stats['pending']],
                    'confirmed' => ['label' => 'Dikonfirmasi', 'count' => $stats['confirmed']],
                    'active' => ['label' => 'Sedang Disewa', 'count' => $stats['active']],
                    'completed' => ['label' => 'Selesai', 'count' => $stats['completed']],
                    'cancelled' => ['label' => 'Dibatalkan', 'count' => $stats['cancelled']],
                ];
            @endphp
            @foreach ($statusTabs as $k => $tab)
                <a href="{{ route('admin.bookings.index', $k ? ['status' => $k] : []) }}"
                   class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl font-medium transition shadow-sm whitespace-nowrap {{ request('status') === $k ? 'bg-[#38BDF8] text-[#0B1220] font-bold shadow-sky-500/20 shadow-md' : 'bg-[#0F172A]/80 text-slate-400 hover:text-white hover:bg-slate-800 border border-slate-800' }}">
                    <span>{{ $tab['label'] }}</span>
                    <span class="px-1.5 py-0.2 rounded-full text-[11px] {{ request('status') === $k ? 'bg-[#0B1220]/20 text-[#0B1220] font-black' : 'bg-slate-800 text-slate-400' }}">
                        {{ $tab['count'] }}
                    </span>
                </a>
            @endforeach
        </div>

        <!-- Bookings Table Card -->
        <div class="bg-[#0F172A]/90 border border-slate-800/90 rounded-2xl shadow-xl backdrop-blur overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm min-w-[760px] text-left">
                    <thead class="text-xs uppercase font-bold tracking-wider text-slate-400 bg-slate-900/80 border-b border-slate-800">
                        <tr>
                            <th class="px-5 py-4">Kode</th>
                            <th class="px-5 py-4">Drone & Layanan</th>
                            <th class="px-5 py-4">Penyewa & Kontak</th>
                            <th class="px-5 py-4">Jadwal Sewa</th>
                            <th class="px-5 py-4 text-right">Total Biaya</th>
                            <th class="px-5 py-4 text-center">Status</th>
                            <th class="px-5 py-4">Pembayaran</th>
                            <th class="px-5 py-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-800/60">
                        @forelse ($bookings as $b)
                            <tr class="hover:bg-slate-800/40 transition group">
                                <!-- Kode -->
                                <td class="px-5 py-4 font-mono">
                                    <a href="{{ route('admin.bookings.show', $b) }}" class="inline-flex items-center gap-1 font-bold text-[#38BDF8] hover:text-[#7DD3FC] transition">
                                        <span>{{ $b->code }}</span>
                                    </a>
                                </td>

                                <!-- Drone & Layanan -->
                                <td class="px-5 py-4">
                                    <div class="font-semibold text-white">{{ $b->drone->name }}</div>
                                    <div class="flex flex-wrap gap-1 mt-1 text-[11px]">
                                        @if ($b->with_pilot)
                                            <span class="px-1.5 py-0.5 rounded bg-sky-500/10 text-[#38BDF8] border border-sky-500/20 font-medium">+ Pilot</span>
                                        @endif
                                        @if ($b->delivery)
                                            <span class="px-1.5 py-0.5 rounded bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 font-medium">Antar-Jemput</span>
                                        @endif
                                    </div>
                                </td>

                                <!-- Penyewa & Kontak -->
                                <td class="px-5 py-4">
                                    <div class="font-medium text-slate-200">{{ $b->renter_name }}</div>
                                    <div class="flex items-center gap-2 mt-0.5">
                                        <a href="https://wa.me/{{ preg_replace('/^0/', '62', $b->phone) }}?text={{ urlencode('Halo Kak '.$b->renter_name.', kami dari Sewa Drone mengonfirmasi pesanan Anda dengan kode '.$b->code) }}"
                                           target="_blank"
                                           class="text-xs text-emerald-400 hover:text-emerald-300 font-mono hover:underline flex items-center gap-1">
                                            <span>{{ $b->phone }}</span>
                                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 24 24"><path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766.001-3.187-2.575-5.771-5.764-5.771zm3.392 8.244c-.144.405-.837.774-1.17.824-.312.045-.694.062-1.927-.45-1.564-.648-2.587-2.227-2.664-2.332-.078-.105-.634-.847-.634-1.619 0-.771.399-1.15.542-1.309.144-.16.312-.2.417-.2.104 0 .209.001.299.006.095.005.223-.036.349.266.13.313.447 1.089.486 1.169.039.08.065.174.013.279-.052.104-.078.169-.156.26-.078.092-.164.205-.234.276-.078.079-.16.165-.069.321.091.156.406.669.87 1.082.597.532 1.101.697 1.258.775.156.079.248.069.34-.039.091-.107.391-.456.495-.612.104-.156.208-.13.348-.078.14.052.887.418 1.04.495.152.078.253.117.291.182.039.066.039.38-.105.785z"/></svg>
                                        </a>
                                    </div>
                                </td>

                                <!-- Jadwal Sewa -->
                                <td class="px-5 py-4 text-xs">
                                    <div class="text-slate-200 font-medium">{{ $b->start_date->format('d M') }} – {{ $b->end_date->format('d M Y') }}</div>
                                    <div class="text-slate-400 mt-0.5">{{ $b->days }} Hari Sewa</div>
                                </td>

                                <!-- Total Biaya -->
                                <td class="px-5 py-4 text-right">
                                    <div class="font-bold text-white font-mono">Rp{{ number_format((float) $b->total_price, 0, ',', '.') }}</div>
                                    @if ((float) $b->discount > 0)
                                        <div class="text-[11px] text-emerald-400">-Rp{{ number_format((float) $b->discount, 0, ',', '.') }}</div>
                                    @endif
                                </td>

                                <!-- Status -->
                                <td class="px-5 py-4 text-center">
                                    <x-status :status="$b->status" />
                                </td>

                                <!-- Status Pembayaran -->
                                <td class="px-5 py-4 text-xs">
                                    @php $settled = $b->payments->firstWhere('status', 'settlement'); @endphp
                                    @if ($settled)
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 font-semibold">
                                            <span class="h-1.5 w-1.5 rounded-full bg-emerald-400"></span>
                                            {{ strtoupper($settled->payment_type ?? 'LUNAS') }}
                                        </span>
                                    @elseif ($b->status === 'cancelled')
                                        <span class="text-slate-500">—</span>
                                    @else
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-amber-500/10 text-amber-400 border border-amber-500/20">
                                            <span class="h-1.5 w-1.5 rounded-full bg-amber-400"></span>
                                            BELUM LUNAS
                                        </span>
                                    @endif
                                </td>

                                <!-- Aksi -->
                                <td class="px-5 py-4 text-right">
                                    <a href="{{ route('admin.bookings.show', $b) }}"
                                       class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg text-xs font-semibold text-slate-200 bg-slate-800 hover:bg-[#38BDF8] hover:text-[#0B1220] transition border border-slate-700">
                                        <span>Detail</span>
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                        </svg>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-6 py-16 text-center text-slate-400">
                                    <div class="max-w-sm mx-auto flex flex-col items-center">
                                        <div class="h-12 w-12 rounded-full bg-slate-800/80 border border-slate-700 flex items-center justify-center text-slate-500 mb-3">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                            </svg>
                                        </div>
                                        <p class="font-semibold text-white">Tidak ada data pesanan</p>
                                        <p class="text-xs text-slate-500 mt-1">Belum ada pesanan dengan filter status yang dipilih saat ini.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($bookings->hasPages())
                <div class="p-4 border-t border-slate-800 bg-slate-900/60">
                    {{ $bookings->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
