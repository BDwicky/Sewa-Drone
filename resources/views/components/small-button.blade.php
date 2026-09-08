@props(['type' => 'submit'])

<button {{ $attributes->merge(['type' => $type, 'class' => 'inline-flex items-center justify-center rounded-lg bg-[#38BDF8] px-4 py-2 text-sm font-semibold text-[#0B1220] hover:bg-[#0EA5E9] transition']) }}>
    {{ $slot }}
</button>
