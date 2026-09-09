@extends('layouts.store')

@section('title', 'FAQ — Sewa Drone')
@section('meta_description', 'Pertanyaan umum sewa drone: syarat, deposit, denda, zona terbang, DRONEID, pilot, pembayaran dan refund.')

@section('content')
    <div class="mx-auto max-w-3xl px-4 sm:px-6 py-12">
        <div class="border-b border-neutral-200 pb-6 mb-8">
            <span class="text-xs uppercase tracking-[0.2em] text-neutral-500 font-bold block mb-1">Pusat Bantuan &amp; Panduan</span>
            <h1 class="text-3xl font-extrabold text-neutral-950 tracking-tight uppercase">PERTANYAAN UMUM (FAQ)</h1>
            <p class="text-xs text-neutral-600 mt-2">
                Informasi seputar syarat sewa, regulasi zona terbang, integrasi pembayaran otomatis, dan SOP serah terima armada.
            </p>
        </div>

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
                <details class="group border border-neutral-200 rounded-xl bg-white hover:border-neutral-400 transition shadow-sm">
                    <summary class="cursor-pointer list-none px-5 py-4 font-semibold text-neutral-900 flex items-center justify-between">
                        <span>{{ $q }}</span>
                        <span class="text-neutral-600 group-open:rotate-45 transition text-lg leading-none font-bold">+</span>
                    </summary>
                    <p class="px-5 pb-4 text-sm text-neutral-600 leading-relaxed font-light border-t border-neutral-100 pt-3">{{ $a }}</p>
                </details>
            @endforeach
        </div>
    </div>
@endsection
