<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">Booking — Admin</h2>
    </x-slot>

    <div class="py-8 max-w-7xl mx-auto px-4 sm:px-6">
        @if (session('status'))
            <div class="mb-4 rounded-lg border border-emerald-500/30 bg-emerald-500/10 px-4 py-3 text-sm text-emerald-400">{{ session('status') }}</div>
        @endif

        <div class="mb-4 flex gap-2 text-sm">
            @foreach (['' => 'Semua', 'pending' => 'Pending', 'confirmed' => 'Confirmed', 'active' => 'Active', 'completed' => 'Completed', 'cancelled' => 'Cancelled'] as $s => $label)
                <a href="{{ route('admin.bookings.index', $s ? ['status' => $s] : []) }}"
                   class="px-3 py-1.5 rounded-lg border {{ request('status') === $s ? 'border-[#38BDF8] text-[#38BDF8]' : 'border-gray-700 text-gray-400' }} hover:border-[#38BDF8]">
                    {{ $label }}
                </a>
            @endforeach
        </div>

        <div class="bg-white/5 border border-gray-700 rounded-lg overflow-x-auto">
            <table class="w-full text-sm min-w-[720px]">
                <thead class="text-xs text-gray-400 border-b border-gray-700">
                    <tr>
                        <th class="text-left px-4 py-3">Kode</th>
                        <th class="text-left px-4 py-3">Drone</th>
                        <th class="text-left px-4 py-3">Penyewa</th>
                        <th class="text-left px-4 py-3">Periode</th>
                        <th class="text-right px-4 py-3">Total</th>
                        <th class="text-left px-4 py-3">Status</th>
                        <th class="text-left px-4 py-3">Bayar</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($bookings as $b)
                        <tr class="border-b border-gray-800 hover:bg-white/5">
                            <td class="px-4 py-3 font-mono">
                                <a href="{{ route('admin.bookings.show', $b) }}" class="text-[#38BDF8] hover:underline">{{ $b->code }}</a>
                            </td>
                            <td class="px-4 py-3">{{ $b->drone->name }}</td>
                            <td class="px-4 py-3">{{ $b->renter_name }}<br><span class="text-xs text-gray-500">{{ $b->phone }}</span></td>
                            <td class="px-4 py-3 text-xs">{{ $b->start_date->format('d M') }} – {{ $b->end_date->format('d M Y') }} <span class="text-gray-500">({{ $b->days }}h)</span></td>
                            <td class="px-4 py-3 text-right font-medium">Rp{{ number_format((float) $b->total_price, 0, ',', '.') }}</td>
                            <td class="px-4 py-3"><x-status :status="$b->status" /></td>
                            <td class="px-4 py-3 text-xs text-gray-400">
                                @php $settled = $b->payments->firstWhere('status', 'settlement'); @endphp
                                {{ $settled ? strtoupper($settled->payment_type ?? 'PAID') : '—' }}
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="px-4 py-8 text-center text-gray-500">Belum ada booking.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{ $bookings->links() }}
    </div>
</x-app-layout>
