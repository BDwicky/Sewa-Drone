@extends('layouts.store')

@section('title', 'Kebijakan Sewa')
@section('meta_description', 'Kebijakan sewa drone: identitas & deposit, denda keterlambatan, kerusakan, regulasi DRONEID dan Permenhub PM 37/2020.')

@section('content')
    <div class="mx-auto max-w-3xl px-4 sm:px-6 py-12">
        <div class="border-b border-neutral-200 pb-6 mb-8">
            <span class="text-xs uppercase tracking-[0.2em] text-neutral-500 font-bold block mb-1">Ketentuan Operasional &amp; SOP</span>
            <h1 class="text-3xl font-extrabold text-neutral-950 tracking-tight uppercase">KEBIJAKAN SEWA ARMADA</h1>
            <p class="text-xs text-neutral-600 mt-2">
                Ringkasan ketentuan hukum, regulasi penerbangan, dan tanggung jawab operasional yang berlaku untuk semua penyewaan.
            </p>
        </div>

        <div class="space-y-4 text-sm leading-relaxed">
            <div class="rounded-xl bg-white border border-neutral-200 p-6 shadow-sm">
                <h2 class="font-bold text-neutral-950 text-base mb-2 flex items-center gap-2">
                    <span class="h-1.5 w-1.5 rounded-full bg-black"></span>
                    <span>1. Booking &amp; Pembayaran Otomatis</span>
                </h2>
                <p class="text-neutral-600 font-light">Booking online memegang jadwal Anda selama <strong class="text-neutral-900 font-semibold">2 jam</strong>. Selesaikan pembayaran via Midtrans (QRIS, VA bank, e-wallet, kartu) sebelum jatuh tempo — setelah itu booking otomatis dilepas. Saat pembayaran berhasil, status berubah menjadi <em>dikonfirmasi</em> dan e-invoice terbit otomatis dengan QR verifikasi resmi.</p>
            </div>

            <div class="rounded-xl bg-white border border-neutral-200 p-6 shadow-sm">
                <h2 class="font-bold text-neutral-950 text-base mb-2 flex items-center gap-2">
                    <span class="h-1.5 w-1.5 rounded-full bg-black"></span>
                    <span>2. Identitas &amp; Jaminan Saat Pickup</span>
                </h2>
                <p class="text-neutral-600 font-light">Serahkan <strong class="text-neutral-900 font-semibold">KTP atau SIM asli</strong> <em>atau</em> deposit tunai Rp500.000 – Rp2.000.000 (sesuai nilai unit). Dokumen atau deposit dikembalikan seketika saat unit kembali lengkap dan normal.</p>
            </div>

            <div class="rounded-xl bg-white border border-neutral-200 p-6 shadow-sm">
                <h2 class="font-bold text-neutral-950 text-base mb-2 flex items-center gap-2">
                    <span class="h-1.5 w-1.5 rounded-full bg-black"></span>
                    <span>3. Durasi &amp; Denda Keterlambatan</span>
                </h2>
                <p class="text-neutral-600 font-light">Perhitungan hari <em>inklusif</em> (hari ambil s/d hari kembali). Keterlambatan pengembalian dikenakan penyesuaian denda <strong class="text-neutral-900 font-semibold">50% tarif harian per jam</strong>, maksimal 100% tarif harian per hari.</p>
            </div>

            <div class="rounded-xl bg-white border border-neutral-200 p-6 shadow-sm">
                <h2 class="font-bold text-neutral-950 text-base mb-2 flex items-center gap-2">
                    <span class="h-1.5 w-1.5 rounded-full bg-black"></span>
                    <span>4. Tanggung Jawab Kerusakan &amp; Kehilangan</span>
                </h2>
                <p class="text-neutral-600 font-light">Kerusakan akibat operasional penyewa ditanggung biaya perbaikan suku cadang resmi DJI. Kehilangan unit dikenakan penggantian sesuai harga unit baru yang tercantum pada halaman katalog drone.</p>
            </div>

            <div class="rounded-xl bg-white border border-neutral-200 p-6 shadow-sm">
                <h2 class="font-bold text-neutral-950 text-base mb-2 flex items-center gap-2">
                    <span class="h-1.5 w-1.5 rounded-full bg-black"></span>
                    <span>5. Regulasi Penerbangan &amp; DRONEID</span>
                </h2>
                <p class="text-neutral-600 font-light">Unit di bawah 250 g (DJI Mini Series) terdaftar <strong class="text-neutral-900 font-semibold">DRONEID</strong> untuk rekreasi bebas izin. Unit &ge;250 g (Air 3S, Mavic 3 Pro, Avata 2, Inspire 3) wajib memiliki pilot berlisensi untuk pemakaian komersial sesuai <strong class="text-neutral-900 font-semibold">Permenhub PM 37/2020</strong>. Dilarang menerbangkan drone di zona terlarang (bandara, instalasi militer, atau ring-1 istana).</p>
            </div>

            <div class="rounded-xl bg-white border border-neutral-200 p-6 shadow-sm">
                <h2 class="font-bold text-neutral-950 text-base mb-2 flex items-center gap-2">
                    <span class="h-1.5 w-1.5 rounded-full bg-black"></span>
                    <span>6. Pembatalan Jadwal &amp; Refund</span>
                </h2>
                <p class="text-neutral-600 font-light">Pembatalan sebelum pembayaran: bebas biaya. Pembatalan setelah pembayaran terkonfirmasi &ge;48 jam sebelum jadwal: refund penuh via transfer Midtrans; di bawah 48 jam akan dialihkan menjadi voucher jadwal ulang.</p>
            </div>
        </div>
    </div>
@endsection
