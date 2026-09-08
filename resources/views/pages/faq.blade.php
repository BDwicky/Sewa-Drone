@extends('layouts.store')

@section('title', 'FAQ — Sewa Drone')
@section('meta_description', 'Pertanyaan umum sewa drone: syarat, deposit, denda, zona terbang, DRONEID, pilot, pembayaran dan refund.')

@section('content')
    <div class="mx-auto max-w-3xl px-4 py-10">
        <h1 class="text-2xl font-bold">Pertanyaan umum</h1>

        <div class="mt-8 space-y-4">
            @php
                $faqs = [
                    ['Apa saja syarat sewa?', 'Cukup data diri (nama, WhatsApp, email) saat booking, plus KTP/SIM asli atau deposit saat pickup. Tidak perlu kartu kredit.'],
                    ['Bagaimana cara bayar?', 'Via Midtrans: QRIS, transfer bank (VA), e-wallet (GoPay/OVO/Dana/ShopeePay), atau kartu kredit. Setelah lunas, invoice otomatis terbit.'],
                    ['Berapa lama waktu pembayaran?', 'Booking menahan jadwal 2 jam. Setelah itu otomatis dilepas agar orang lain bisa memesan.'],
                    ['Apakah bisa request dengan pilot?', 'Bisa. Di form booking centang "Dengan pilot/operator" (Rp500–750 ribu/hari tergantung unit). Cocok untuk wedding/event yang butuh footage profesional.'],
                    ['Apakah drone bisa diantar?', 'Bisa untuk area kota — centang "Antar-jemput unit" saat booking (Rp50–75 ribu).'],
                    ['Zona terbang mana yang dilarang?', 'Radius bandara, alun-alun istana, markas TNI/Polri, dan area tertutup. Registrasi DRONEID wajib untuk semua unit; sertifikat pilot wajib untuk unit ≥250 g yang dipakai komersial (Permenhub PM 37/2020).'],
                    ['Telat kembali bagaimana?', 'Denda 50% tarif harian per jam keterlambatan, maksimal 1x tarif harian per hari. Hubungi admin via WhatsApp bila terlambat.'],
                    ['Batal sewa, apakah refund?', 'Sebelum bayar: bebas. Setelah bayar dan ≥48 jam sebelum mulai: refund penuh via Midtrans. Kurang dari 48 jam: diubah voucher sewa ulang.'],
                    ['Unit rusak saat dipakai?', 'Lapor admin via WhatsApp. Kerusakan karena pemakaian ditanggung penyewa; nilai unit baru tercantum di halaman detail drone.'],
                    ['Bisa sewa FPV (Avata 2)?', 'Hanya untuk yang sudah berpengalaman, atau tambahkan pilot. Goggles & motion controller termasuk dalam paket.'],
                ];
            @endphp
            @foreach ($faqs as $i => [$q, $a])
                <details class="group border border-[#24334F] rounded-lg bg-[#111A2C]">
                    <summary class="cursor-pointer list-none px-5 py-4 font-medium flex items-center justify-between">
                        {{ $q }}
                        <span class="text-[#38BDF8] group-open:rotate-45 transition text-lg leading-none">+</span>
                    </summary>
                    <p class="px-5 pb-4 text-sm text-[#94A3B8] leading-relaxed">{{ $a }}</p>
                </details>
            @endforeach
        </div>
    </div>
@endsection
