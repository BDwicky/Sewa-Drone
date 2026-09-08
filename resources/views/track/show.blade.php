@extends('layouts.store')

@section('title', 'Lacak '.$booking->code)

@section('content')
    <div class="mx-auto max-w-2xl px-4 py-10">
        <h1 class="text-2xl font-bold">Status booking</h1>

        <x-card class="mt-6 p-6">
            <div class="flex items-center justify-between">
                <span class="font-mono text-2xl font-bold tracking-wider">{{ $booking->code }}</span>
                <x-status :status="$booking->status" />
            </div>

            <div class="mt-3">
                @php $paid = $booking->payments->firstWhere('status', 'settlement'); @endphp
                @if ($paid)
                    <x-status status="confirmed" /> <span class="text-xs text-[#94A3B8] ml-2">Lunas via {{ $paid->payment_type ?? 'midtrans' }}</span>
                @elseif ($booking->payments->isNotEmpty())
                    <x-status :status="$booking->payments->first()->status === 'expire' ? 'cancelled' : 'pending'" />
                    <span class="text-xs text-[#94A3B8] ml-2">Menunggu pembayaran</span>
                @else
                    <x-status :status="$booking->status" />
                @endif
            </div>

            <ol class="mt-7 space-y-0 border-l border-[#24334F] ml-2">
                @php
                    $steps = [
                        ['Booking dibuat', $booking->created_at, true],
                        ['Dibayar', $paid?->updated_at, $paid !== null],
                        ['Pickup / mulai sewa', $booking->start_date, $booking->status !== 'pending'],
                        ['Kembali / selesai', $booking->end_date, in_array($booking->status, ['completed'])],
                    ];
                    $states = ['done', 'done', $booking->status === 'active' ? 'now' : 'up', 'up'];
                @endphp
                @foreach ($steps as $i => [$label, $when, $done])
                    @php
                        $dot = $done ? 'bg-[#34D399]' : ($i === 2 && $booking->status === 'active' ? 'bg-[#38BDF8] animate-pulse' : 'bg-[#24334F]');
                        $txt = $done || $i === 2 && $booking->status === 'active' ? 'text-[#F1F5F9]' : 'text-[#94A3B8]';
                    @endphp
                    <li class="pl-5 pb-5 -ml-[5px] relative">
                        <span class="absolute left-0 top-1 h-2.5 w-2.5 rounded-full {{ $dot }}"></span>
                        <span class="text-sm font-medium {{ $txt }}">{{ $label }}</span>
                        <span class="block text-xs text-[#94A3B8]">
                            @if ($when instanceof \Carbon\CarbonInterface)
                                {{ $when->translatedFormat('d M Y') }}@if($label === 'Dibayar') , {{ $when->format('H:i') }}@endif
                            @else
                                —
                            @endif
                        </span>
                    </li>
                @endforeach
            </ol>

            <dl class="mt-4 space-y-2 text-sm border-t border-[#24334F] pt-5">
                <div class="flex justify-between"><dt class="text-[#94A3B8]">Drone</dt><dd class="font-medium">{{ $booking->drone->name }}</dd></div>
                <div class="flex justify-between"><dt class="text-[#94A3B8]">Periode</dt><dd class="font-medium">{{ $booking->days }} hari</dd></div>
                <div class="flex justify-between"><dt class="text-[#94A3B8]">Total</dt><dd><x-price :amount="$booking->total_price" /></dd></div>
            </dl>

            @if ($booking->invoice && $booking->status !== 'pending')
                <a href="{{ route('invoice.show', $booking->invoice->number) }}" target="_blank" class="mt-6 inline-block text-sm font-medium text-[#38BDF8] underline-offset-4 hover:underline">
                    Lihat invoice &rarr;
                </a>
            @endif
        </x-card>
    </div>
@endsection
