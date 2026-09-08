@props(['amount'])

@php
    $formatted = 'Rp'.number_format((float) $amount, 0, ',', '.');
@endphp

<span {{ $attributes->merge(['class' => 'font-semibold text-[#38BDF8]']) }}>{{ $formatted }}</span>
