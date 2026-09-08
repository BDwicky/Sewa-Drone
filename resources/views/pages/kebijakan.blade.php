@extends('layouts.store')

@section('title', 'Kebijakan Sewa')
@section('meta_description', 'Kebijakan sewa drone: identitas & deposit, denda keterlambatan, kerusakan, regulasi DRONEID dan Permenhub PM 37/2020.')

@section('content')
    <div class="mx-auto max-w-3xl px-4 py-10">
        <h1 class="text-2xl font-bold">Kebijakan sewa</h1>
        <p class="mt-2 text-sm text-[#94A3B8]">Ringkasan ketentuan yang berlaku untuk semua penyewaan.</p>

        <div class="mt-8 space-y-8 text-sm leading-relaxed">
            <section>
                <h2 class="font-semibold text-base mb-2">1. Booking & pembayaran</h2>
                <p class="text-[#94A3B8]">Booking online memegang jadwal Anda selama <strong class="text-white">2 jam</strong>. Selesaikan pembayaran via Midtrans (QRIS, VA bank, e-wallet, kartu) sebelum jatuh tempo — setelah itu booking otomatis dilepas. Saat pembayaran berhasil, status berubah menjadi <em>dikonfirmasi</em> dan e-invoice terbit otomatis (ada QR verifikasi di pojok kanan atas).</p>
            </section>

            <section>
                <h2 class="font-semibold text-base mb-2">2. Identitas & jaminan saat pickup</h2>
                <p class="text-[#94A3B8]">Serahkan <strong class="text-white">KTP atau SIM asli</strong> <em>atau</em> deposit cash Rp500.000 – Rp2.000.000 (sesuai nilai unit). Dokumen/deposit kembali saat unit kembali lengkap dan normal.</p>
            </section>

            <section>
                <h2 class="font-semibold text-base mb-2">3. Durasi & denda keterlambatan</h2>
                <p class="text-[#94A3B8]">Perhitungan hari <em>inklusif</em> (hari ambil s/d hari kembali). Keterlambatan pengembalian dikenakan denda <strong class="text-white">50% tarif harian per jam</strong>, maksimal 100% tarif harian per hari.</p>
            </section>

            <section>
                <h2 class="font-semibold text-base mb-2">4. Kerusakan & kehilangan</h2>
                <p class="text-[#94A3B8]">Kerusakan akibat penyewa ditanggung biaya perbaikan penuh. Kehilangan unit dikenakan nilai penggantian sesuai harga unit baru (tercantum di detail drone).</p>
            </section>

            <section>
                <h2 class="font-semibold text-base mb-2">5. Regulasi penerbangan</h2>
                <p class="text-[#94A3B8]">Unit di bawah 250 g (DJI Mini 4 Pro) cukup registrasi <strong class="text-white">DRONEID</strong>. Unit ≥250 g (Air 3S, Mavic 3 Pro, Avata 2) wajib sertifikat pilot untuk penggunaan komersial sesuai <strong class="text-white">Permenhub PM 37/2020</strong>. Terbang di sekitar bandara, istana, atau area sensitif dilarang. Penyewa bertanggung jawab penuh atas pelanggaran regulasi saat masa sewa.</p>
            </section>

            <section>
                <h2 class="font-semibold text-base mb-2">6. Pembatalan & refund</h2>
                <p class="text-[#94A3B8]">Pembatalan sebelum pembayaran: tidak ada biaya. Pembatalan setelah dibayar: refund penuh via Midtrans bila ≥48 jam sebelum tanggal mulai; di bawah 48 jam diubah menjadi voucher sewa ulang.</p>
            </section>
        </div>
    </div>
@endsection
