@extends('layouts.store')

@section('title', 'Lacak Reservasi ' . $booking->code . ' — SewaDrone')

@section('content')
    <div class="mx-auto max-w-3xl px-4 sm:px-6 py-12">
        <div class="mb-8 border-b border-neutral-200 pb-6 flex items-end justify-between">
            <div>
                <span class="text-xs uppercase tracking-[0.2em] text-neutral-500 font-mono font-bold block mb-1">Status Pelacakan Pesanan</span>
                <h1 class="text-3xl font-extrabold text-neutral-950 tracking-tight uppercase">TIMELINE RESERVASI</h1>
            </div>
            <div class="font-mono text-xl font-bold text-neutral-900 bg-neutral-100 border border-neutral-300 px-3.5 py-1.5 rounded-lg shadow-sm">
                {{ $booking->code }}
            </div>
        </div>

        <div class="rounded-2xl bg-white border border-neutral-200 p-6 sm:p-10 shadow-sm">
            <!-- Header Summary -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-neutral-200 pb-6">
                <div>
                    <h3 class="text-xl font-bold text-neutral-900">{{ $booking->drone->name }}</h3>
                    <p class="text-xs text-neutral-500 mt-0.5">{{ $booking->days }} Hari Masa Sewa · {{ $booking->start_date->translatedFormat('d M Y') }} s/d {{ $booking->end_date->translatedFormat('d M Y') }}</p>
                </div>
                <div class="text-left sm:text-right">
                    <x-status :status="$booking->status" />
                    @php $paid = $booking->payments->firstWhere('status', 'settlement'); @endphp
                    @if ($paid)
                        <span class="text-[11px] text-neutral-500 block mt-1">Lunas: {{ strtoupper($paid->payment_type ?? 'QRIS') }}</span>
                    @endif
                </div>
            </div>

            <!-- Modern Technical Milestone Timeline -->
            <div class="my-8">
                <ol class="space-y-6 border-l-2 border-neutral-200 ml-3">
                    @php
                        $steps = [
                            ['Pemesanan Dibuat', $booking->created_at, true, 'Form reservasi berhasil dikirimkan oleh penyewa.'],
                            ['Pembayaran Terverifikasi', $paid?->updated_at, $paid !== null, 'Dana diverifikasi otomatis oleh sistem Midtrans.'],
                            ['Pengambilan & Inspeksi Unit', $booking->start_date, in_array($booking->status, ['active', 'completed']), 'Pengecekan fisik, deposit/KTP, dan serah terima unit di lokasi.'],
                            ['Pengembalian & Selesai', $booking->end_date, $booking->status === 'completed', 'Unit kembali dalam kondisi normal dan masa sewa ditutup.'],
                        ];
                    @endphp

                    @foreach ($steps as $i => [$label, $when, $done, $desc])
                        @php
                            $isActiveStep = ($i === 2 && $booking->status === 'active');
                            $bulletColor = $done ? 'bg-black ring-4 ring-neutral-200' : ($isActiveStep ? 'bg-neutral-600 ring-4 ring-neutral-200' : 'bg-neutral-300');
                        @endphp
                        <li class="pl-6 relative">
                            <span class="absolute -left-[9px] top-1 h-4 w-4 rounded-full {{ $bulletColor }} transition duration-300"></span>
                            <div class="flex flex-col sm:flex-row sm:items-baseline justify-between gap-1">
                                <h4 class="text-sm font-bold {{ $done || $isActiveStep ? 'text-neutral-950' : 'text-neutral-400' }} tracking-wide">{{ $label }}</h4>
                                <span class="text-[11px] font-mono {{ $done ? 'text-neutral-600' : 'text-neutral-400' }}">
                                    @if ($when instanceof \Carbon\CarbonInterface)
                                        {{ $when->translatedFormat('d M Y, H:i') }} WIB
                                    @else
                                        —
                                    @endif
                                </span>
                            </div>
                            <p class="text-xs text-neutral-600 mt-1 leading-relaxed">{{ $desc }}</p>
                        </li>
                    @endforeach
                </ol>
            </div>

            <!-- Booking Highlights & Actions -->
            <div class="pt-6 border-t border-neutral-200 flex flex-col sm:flex-row items-center justify-between gap-4">
                <div class="text-xs text-neutral-500">
                    Total Nilai: <span class="text-base font-bold text-neutral-950 ml-1">Rp{{ number_format((float) $booking->total_price, 0, ',', '.') }}</span>
                </div>

                <div class="flex gap-3 w-full sm:w-auto">
                    @if ($booking->invoice)
                        <a href="{{ route('invoice.show', $booking->invoice->number) }}" target="_blank"
                           class="flex-1 sm:flex-none text-center rounded-lg bg-black text-white hover:bg-neutral-800 border border-black font-semibold px-4 py-2 text-xs uppercase tracking-wider transition shadow-sm">
                            Buka E-Invoice Resmi ↗
                        </a>
                    @endif
                    <a href="https://wa.me/{{ config('services.wa.admin_number') }}" target="_blank"
                       class="flex-1 sm:flex-none text-center rounded-lg bg-white border border-neutral-300 hover:bg-neutral-50 hover:border-neutral-400 text-neutral-800 px-4 py-2 text-xs uppercase tracking-wider transition shadow-sm">
                        Hubungi Admin
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
