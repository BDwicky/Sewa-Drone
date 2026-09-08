<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">{{ isset($drone) ? 'Edit' : 'Tambah' }} Drone</h2>
    </x-slot>

    <div class="py-8 max-w-3xl mx-auto px-4 sm:px-6">
        <form method="POST"
              action="{{ isset($drone) ? route('admin.drones.update', $drone) : route('admin.drones.store') }}"
              enctype="multipart/form-data" class="bg-white/5 border border-gray-700 rounded-lg p-6 space-y-4">
            @csrf
            @if (isset($drone)) @method('PUT') @endif

            <div>
                <label class="block text-xs text-gray-400 mb-1">Nama *</label>
                <input type="text" name="name" required value="{{ old('name', $drone->name ?? '') }}" class="w-full rounded-lg bg-gray-900 border border-gray-700 px-3 py-2 text-sm">
            </div>

            <div>
                <label class="block text-xs text-gray-400 mb-1">Deskripsi</label>
                <textarea name="description" rows="3" class="w-full rounded-lg bg-gray-900 border border-gray-700 px-3 py-2 text-sm">{{ old('description', $drone->description ?? '') }}</textarea>
            </div>

            <div class="grid sm:grid-cols-3 gap-4">
                <div><label class="block text-xs text-gray-400 mb-1">Kamera</label>
                    <input type="text" name="camera" value="{{ old('camera', $drone->camera ?? '') }}" class="w-full rounded-lg bg-gray-900 border border-gray-700 px-3 py-2 text-sm"></div>
                <div><label class="block text-xs text-gray-400 mb-1">Terbang (menit)</label>
                    <input type="number" name="flight_time_min" value="{{ old('flight_time_min', $drone->flight_time_min ?? '') }}" class="w-full rounded-lg bg-gray-900 border border-gray-700 px-3 py-2 text-sm"></div>
                <div><label class="block text-xs text-gray-400 mb-1">Berat (g)</label>
                    <input type="number" name="weight_g" value="{{ old('weight_g', $drone->weight_g ?? '') }}" class="w-full rounded-lg bg-gray-900 border border-gray-700 px-3 py-2 text-sm"></div>
            </div>

            <div class="grid sm:grid-cols-2 gap-4">
                <div><label class="block text-xs text-gray-400 mb-1">Tarif harian (Rp) *</label>
                    <input type="number" step="1000" name="daily_rate" required value="{{ old('daily_rate', $drone->daily_rate ?? '') }}" class="w-full rounded-lg bg-gray-900 border border-gray-700 px-3 py-2 text-sm"></div>
                <div><label class="block text-xs text-gray-400 mb-1">Tarif mingguan (Rp)</label>
                    <input type="number" step="1000" name="weekly_rate" value="{{ old('weekly_rate', $drone->weekly_rate ?? '') }}" class="w-full rounded-lg bg-gray-900 border border-gray-700 px-3 py-2 text-sm"></div>
                <div><label class="block text-xs text-gray-400 mb-1">Pilot/hari (Rp)</label>
                    <input type="number" step="1000" name="pilot_daily_rate" value="{{ old('pilot_daily_rate', $drone->pilot_daily_rate ?? '') }}" class="w-full rounded-lg bg-gray-900 border border-gray-700 px-3 py-2 text-sm"></div>
                <div><label class="block text-xs text-gray-400 mb-1">Biaya antar-jemput (Rp)</label>
                    <input type="number" step="1000" name="delivery_fee" value="{{ old('delivery_fee', $drone->delivery_fee ?? '') }}" class="w-full rounded-lg bg-gray-900 border border-gray-700 px-3 py-2 text-sm"></div>
                <div><label class="block text-xs text-gray-400 mb-1">Nilai ganti unit (Rp)</label>
                    <input type="number" step="1000" name="replacement_value" value="{{ old('replacement_value', $drone->replacement_value ?? '') }}" class="w-full rounded-lg bg-gray-900 border border-gray-700 px-3 py-2 text-sm"></div>
                <div><label class="block text-xs text-gray-400 mb-1">Jumlah unit</label>
                    <input type="number" name="stock" min="1" max="99" value="{{ old('stock', $drone->stock ?? 1) }}" class="w-full rounded-lg bg-gray-900 border border-gray-700 px-3 py-2 text-sm"></div>
            </div>

            <div>
                <label class="block text-xs text-gray-400 mb-1">Foto (jpg/png, maks 2MB)</label>
                <input type="file" name="image" accept="image/png,image/jpeg" class="w-full text-sm text-gray-400">
                @if (isset($drone) && $drone->image_path)
                    <img src="{{ asset('storage/'.$drone->image_path) }}" class="mt-2 h-16 rounded" alt="">
                @endif
            </div>

            <label class="flex items-center gap-2 text-sm">
                <input type="hidden" name="is_active" value="0">
                <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $drone->is_active ?? true)) class="accent-[#38BDF8]">
                Tampilkan di katalog
            </label>

            <div class="flex gap-3 pt-2">
                <x-small-button>{{ isset($drone) ? 'Simpan perubahan' : 'Tambah drone' }}</x-small-button>
                <a href="{{ route('admin.drones.index') }}" class="text-sm text-gray-400 hover:text-white px-3 py-2">Batal</a>
            </div>
        </form>
    </div>
</x-app-layout>
