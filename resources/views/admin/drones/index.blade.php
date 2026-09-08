<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl">Drone — Admin</h2>
            <a href="{{ route('admin.drones.create') }}" class="rounded-lg bg-[#38BDF8] px-4 py-2 text-sm font-semibold text-[#0B1220] hover:bg-[#0EA5E9]">+ Drone</a>
        </div>
    </x-slot>

    <div class="py-8 max-w-6xl mx-auto px-4 sm:px-6">
        @if (session('status'))
            <div class="mb-4 rounded-lg border border-emerald-500/30 bg-emerald-500/10 px-4 py-3 text-sm text-emerald-400">{{ session('status') }}</div>
        @endif
        @if ($errors->any())
            <div class="mb-4 rounded-lg border border-red-500/30 bg-red-500/10 px-4 py-3 text-sm text-red-400">{{ $errors->first() }}</div>
        @endif

        <div class="bg-white/5 border border-gray-700 rounded-lg overflow-x-auto">
            <table class="w-full text-sm min-w-[680px]">
                <thead class="text-xs text-gray-400 border-b border-gray-700">
                    <tr>
                        <th class="text-left px-4 py-3">Nama</th>
                        <th class="text-right px-4 py-3">Tarif/hari</th>
                        <th class="text-right px-4 py-3">Mingguan</th>
                        <th class="text-right px-4 py-3">Pilot/hari</th>
                        <th class="text-center px-4 py-3">Bookings</th>
                        <th class="text-center px-4 py-3">Status</th>
                        <th class="text-right px-4 py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($drones as $d)
                        <tr class="border-b border-gray-800 hover:bg-white/5">
                            <td class="px-4 py-3 font-medium">{{ $d->name }}</td>
                            <td class="px-4 py-3 text-right">Rp{{ number_format((float) $d->daily_rate, 0, ',', '.') }}</td>
                            <td class="px-4 py-3 text-right text-gray-400">{{ $d->weekly_rate ? 'Rp'.number_format((float) $d->weekly_rate, 0, ',', '.') : '—' }}</td>
                            <td class="px-4 py-3 text-right text-gray-400">{{ $d->pilot_daily_rate ? 'Rp'.number_format((float) $d->pilot_daily_rate, 0, ',', '.') : '—' }}</td>
                            <td class="px-4 py-3 text-center">{{ $d->bookings_count }}</td>
                            <td class="px-4 py-3 text-center text-xs {{ $d->is_active ? 'text-emerald-400' : 'text-gray-500' }}">{{ $d->is_active ? 'AKTIF' : 'OFF' }}</td>
                            <td class="px-4 py-3 text-right">
                                <a href="{{ route('admin.drones.edit', $d) }}" class="text-[#38BDF8] hover:underline">Edit</a>
                                <form method="POST" action="{{ route('admin.drones.destroy', $d) }}" class="inline ml-3"
                                      onsubmit="return confirm('Hapus {{ $d->name }}?')">
                                    @csrf @method('DELETE')
                                    <button class="text-red-400 hover:underline">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
