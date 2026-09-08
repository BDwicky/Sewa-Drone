@props(['variant' => 'primary', 'type' => 'button'])

@php
    $classes = $variant === 'primary'
        ? 'inline-flex items-center justify-center gap-2 rounded-lg bg-[#38BDF8] px-4 py-2.5 text-sm font-semibold text-[#0B1220] hover:bg-[#0EA5E9] transition'
        : 'inline-flex items-center justify-center gap-1 text-sm font-medium text-[#38BDF8] underline-offset-4 hover:underline';
@endphp

<button {{ $attributes->merge(['type' => $type, 'class' => $classes]) }}>
    {{ $slot }}
</button>
