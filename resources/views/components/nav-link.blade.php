@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center px-3 pt-1 border-b-2 border-white text-sm font-semibold leading-5 text-white bg-white/10 rounded-t-lg focus:outline-none transition duration-150 ease-in-out'
            : 'inline-flex items-center px-3 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-neutral-400 hover:text-white hover:border-neutral-700 hover:bg-white/5 rounded-t-lg focus:outline-none transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
