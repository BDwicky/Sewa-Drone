@props(['status'])

@php
    $map = [
        'pending' => ['Menunggu pembayaran', 'text-[#FBBF24]', 'bg-[#FBBF24]'],
        'confirmed' => ['Dikonfirmasi', 'text-[#34D399]', 'bg-[#34D399]'],
        'active' => ['Sedang disewa', 'text-[#38BDF8]', 'bg-[#38BDF8]'],
        'completed' => ['Selesai', 'text-[#34D399]', 'bg-[#34D399]'],
        'cancelled' => ['Dibatalkan', 'text-[#F87171]', 'bg-[#F87171]'],
    ];
    [$label, $text, $dot] = $map[$status] ?? [$status, 'text-[#94A3B8]', 'bg-[#94A3B8]'];
@endphp

<span {{ $attributes->merge(['class' => 'inline-flex items-center gap-1.5 text-xs font-medium '.$text]) }}>
    <span class="h-1.5 w-1.5 rounded-full {{ $dot }}"></span>
    {{ $label }}
</span>
