<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.drones.index') }}" class="p-2 rounded-xl bg-slate-800/80 hover:bg-slate-700 text-slate-400 hover:text-white transition border border-slate-700/80" title="Kembali">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                </a>
                <div>
                    <h1 class="font-extrabold text-2xl text-white tracking-tight">Tambah Drone Baru</h1>
                    <p class="text-xs text-slate-400 mt-0.5">Daftarkan unit drone baru ke dalam armada sewa</p>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-8 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        @if ($errors->any())
            <div class="mb-6 rounded-xl border border-rose-500/30 bg-rose-500/10 p-4 text-sm text-rose-400">
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.drones.store') }}" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <!-- Section 1: Informasi Dasar -->
            <div class="p-6 rounded-2xl bg-[#0F172A]/90 border border-slate-800/90 shadow-xl backdrop-blur space-y-4">
                <h2 class="text-sm font-bold text-white uppercase tracking-wider flex items-center gap-2">
                    <svg class="w-4 h-4 text-[#38BDF8]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>Informasi Unit</span>
                </h2>

                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-1.5">Nama Drone <span class="text-rose-400">*</span></label>
                    <input type="text" name="name" required value="{{ old('name') }}" placeholder="Contoh: DJI Mavic 3 Pro"
                           class="w-full rounded-xl bg-[#0B1220] border border-slate-700 px-4 py-2.5 text-sm text-white placeholder-slate-500 focus:border-[#38BDF8] focus:ring-1 focus:ring-[#38BDF8]">
                </div>

                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-1.5">Deskripsi Ringkas</label>
                    <textarea name="description" rows="3" placeholder="Jelaskan keunggulan kamera, stabilisasi, dan peruntukan unit drone ini..."
                              class="w-full rounded-xl bg-[#0B1220] border border-slate-700 px-4 py-2.5 text-sm text-white placeholder-slate-500 focus:border-[#38BDF8] focus:ring-1 focus:ring-[#38BDF8]">{{ old('description') }}</textarea>
                </div>
            </div>

            <!-- Section 2: Spesifikasi Teknis -->
            <div class="p-6 rounded-2xl bg-[#0F172A]/90 border border-slate-800/90 shadow-xl backdrop-blur space-y-4">
                <h2 class="text-sm font-bold text-white uppercase tracking-wider flex items-center gap-2">
                    <svg class="w-4 h-4 text-[#38BDF8]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z" />
                    </svg>
                    <span>Spesifikasi Teknis</span>
                </h2>

                <div class="grid sm:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-1.5">Kamera / Sensor</label>
                        <input type="text" name="camera" value="{{ old('camera') }}" placeholder="4K/60fps Hasselblad"
                               class="w-full rounded-xl bg-[#0B1220] border border-slate-700 px-4 py-2.5 text-sm text-white placeholder-slate-500 focus:border-[#38BDF8] focus:ring-1 focus:ring-[#38BDF8]">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-1.5">Waktu Terbang (Menit)</label>
                        <input type="number" name="flight_time_min" value="{{ old('flight_time_min') }}" placeholder="43"
                               class="w-full rounded-xl bg-[#0B1220] border border-slate-700 px-4 py-2.5 text-sm text-white placeholder-slate-500 focus:border-[#38BDF8] focus:ring-1 focus:ring-[#38BDF8]">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-1.5">Bobot / Berat (Gram)</label>
                        <input type="number" name="weight_g" value="{{ old('weight_g') }}" placeholder="249"
                               class="w-full rounded-xl bg-[#0B1220] border border-slate-700 px-4 py-2.5 text-sm text-white placeholder-slate-500 focus:border-[#38BDF8] focus:ring-1 focus:ring-[#38BDF8]">
                    </div>
                </div>
            </div>

            <!-- Section 3: Tarif Sewa & Stok -->
            <div class="p-6 rounded-2xl bg-[#0F172A]/90 border border-slate-800/90 shadow-xl backdrop-blur space-y-4">
                <h2 class="text-sm font-bold text-white uppercase tracking-wider flex items-center gap-2">
                    <svg class="w-4 h-4 text-[#38BDF8]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>Tarif Sewa & Inventaris</span>
                </h2>

                <div class="grid sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-1.5">Tarif Harian (Rp) <span class="text-rose-400">*</span></label>
                        <input type="number" step="1000" name="daily_rate" required value="{{ old('daily_rate') }}" placeholder="350000"
                               class="w-full rounded-xl bg-[#0B1220] border border-slate-700 px-4 py-2.5 text-sm text-white placeholder-slate-500 focus:border-[#38BDF8] focus:ring-1 focus:ring-[#38BDF8]">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-1.5">Tarif Mingguan (Rp)</label>
                        <input type="number" step="1000" name="weekly_rate" value="{{ old('weekly_rate') }}" placeholder="1750000"
                               class="w-full rounded-xl bg-[#0B1220] border border-slate-700 px-4 py-2.5 text-sm text-white placeholder-slate-500 focus:border-[#38BDF8] focus:ring-1 focus:ring-[#38BDF8]">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-1.5">Tarif Jasa Pilot / Hari (Rp)</label>
                        <input type="number" step="1000" name="pilot_daily_rate" value="{{ old('pilot_daily_rate') }}" placeholder="500000"
                               class="w-full rounded-xl bg-[#0B1220] border border-slate-700 px-4 py-2.5 text-sm text-white placeholder-slate-500 focus:border-[#38BDF8] focus:ring-1 focus:ring-[#38BDF8]">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-1.5">Biaya Antar-Jemput (Rp)</label>
                        <input type="number" step="1000" name="delivery_fee" value="{{ old('delivery_fee') }}" placeholder="50000"
                               class="w-full rounded-xl bg-[#0B1220] border border-slate-700 px-4 py-2.5 text-sm text-white placeholder-slate-500 focus:border-[#38BDF8] focus:ring-1 focus:ring-[#38BDF8]">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-1.5">Nilai Penggantian Unit (Rp)</label>
                        <input type="number" step="1000" name="replacement_value" value="{{ old('replacement_value') }}" placeholder="15000000"
                               class="w-full rounded-xl bg-[#0B1220] border border-slate-700 px-4 py-2.5 text-sm text-white placeholder-slate-500 focus:border-[#38BDF8] focus:ring-1 focus:ring-[#38BDF8]">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-1.5">Jumlah Stok Unit Tersedia</label>
                        <input type="number" name="stock" min="1" max="99" value="{{ old('stock', 1) }}"
                               class="w-full rounded-xl bg-[#0B1220] border border-slate-700 px-4 py-2.5 text-sm text-white placeholder-slate-500 focus:border-[#38BDF8] focus:ring-1 focus:ring-[#38BDF8]">
                    </div>
                </div>
            </div>

            <!-- Section 4: Foto & Publikasi -->
            <div class="p-6 rounded-2xl bg-[#0F172A]/90 border border-slate-800/90 shadow-xl backdrop-blur space-y-4">
                <h2 class="text-sm font-bold text-white uppercase tracking-wider flex items-center gap-2">
                    <svg class="w-4 h-4 text-[#38BDF8]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <span>Foto & Status Publikasi</span>
                </h2>

                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider text-slate-300 mb-1.5">Foto Drone (JPG / PNG, Maksimal 2MB)</label>
                    <input type="file" name="image" accept="image/png,image/jpeg"
                           class="w-full text-xs text-slate-400 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-sky-500/10 file:text-[#38BDF8] hover:file:bg-sky-500/20 file:cursor-pointer">
                </div>

                <div class="pt-2">
                    <label class="inline-flex items-center gap-2.5 text-sm text-slate-200 cursor-pointer">
                        <input type="hidden" name="is_active" value="0">
                        <input type="checkbox" name="is_active" value="1" @checked(old('is_active', true)) class="rounded border-slate-700 bg-slate-900 text-[#38BDF8] focus:ring-[#38BDF8]">
                        <span class="font-medium">Tampilkan langsung di katalog publik (Aktif)</span>
                    </label>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center justify-end gap-3 pt-2">
                <a href="{{ route('admin.drones.index') }}" class="px-5 py-2.5 rounded-xl text-xs font-semibold text-slate-400 hover:text-white hover:bg-slate-800 transition">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2.5 rounded-xl text-xs font-bold bg-[#38BDF8] text-[#0B1220] hover:bg-[#7DD3FC] transition shadow-lg shadow-sky-500/20">
                    Simpan Drone
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
