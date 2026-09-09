<!-- Commercial DJI-Style Cookie Consent Banner & Preferences Modal -->
<div id="cookie-banner" class="fixed bottom-4 sm:bottom-6 left-4 sm:left-6 right-4 sm:right-auto sm:max-w-xl md:max-w-2xl z-50 transform translate-y-16 opacity-0 pointer-events-none transition-all duration-500 ease-out" role="dialog" aria-live="polite" aria-label="Pemberitahuan Cookie">
    <div class="rounded-2xl bg-neutral-950/95 backdrop-blur-xl border border-neutral-800 text-white shadow-2xl p-5 sm:p-6 relative overflow-hidden">
        <!-- Subtle Grid Pattern Accent -->
        <div class="absolute inset-0 pointer-events-none opacity-10">
            <div class="absolute inset-0 bg-[linear-gradient(to_right,rgba(255,255,255,0.1)_1px,transparent_1px),linear-gradient(to_bottom,rgba(255,255,255,0.1)_1px,transparent_1px)] bg-[size:32px_32px]"></div>
        </div>

        <div class="relative z-10">
            <!-- Header Row -->
            <div class="flex items-start justify-between gap-3 mb-2.5">
                <div class="flex items-center gap-2.5">
                    <div class="h-8 w-8 rounded-lg bg-white/10 border border-white/20 flex items-center justify-center text-white shrink-0 shadow-sm">
                        <svg class="h-4 w-4 stroke-[2]" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <path d="M12 2a10 10 0 1 0 10 10 4 4 0 0 1-5-5 4 4 0 0 1-5-5"></path>
                            <path d="M8.5 8.5v.01"></path>
                            <path d="M16 15.5v.01"></path>
                            <path d="M12 12v.01"></path>
                            <path d="M11 17v.01"></path>
                            <path d="M7 13v.01"></path>
                        </svg>
                    </div>
                    <div>
                        <h4 class="text-sm font-bold text-white tracking-tight">Preferensi Cookies &amp; Privasi</h4>
                        <span class="text-[10px] font-mono uppercase tracking-widest text-neutral-400">DJI Commercial Standards</span>
                    </div>
                </div>
                <button type="button" onclick="window.acceptEssentialOnly()" aria-label="Tutup dan tolak non-esensial" class="text-neutral-400 hover:text-white p-1 rounded-lg hover:bg-white/10 transition">
                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M18 6L6 18M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <!-- Body Description -->
            <p class="text-xs text-neutral-300 leading-relaxed font-normal mb-4">
                Kami menggunakan cookies esensial untuk memproses autentikasi, reservasi armada, dan transaksi pembayaran Midtrans yang aman. Kami juga menggunakan cookies analitis opsional untuk mengoptimalkan kinerja tampilan interaktif 360° dan katalog drone.
                <a href="{{ route('pages.kebijakan') }}" class="text-white underline underline-offset-2 hover:text-neutral-300 ml-1 font-medium">Pelajari Kebijakan Privasi</a>.
            </p>

            <!-- Actions Row -->
            <div class="flex flex-wrap items-center gap-2.5 pt-2 border-t border-neutral-800/80">
                <button type="button" onclick="window.acceptAllCookies()" class="rounded-full bg-white text-black hover:bg-neutral-200 px-5 py-2 text-xs font-bold uppercase tracking-wider transition shadow-sm border border-white">
                    Terima Semua
                </button>
                <button type="button" onclick="window.acceptEssentialOnly()" class="rounded-full bg-neutral-900 text-neutral-300 hover:text-white hover:bg-neutral-800 px-4 py-2 text-xs font-semibold tracking-wider transition border border-neutral-700">
                    Hanya Esensial
                </button>
                <button type="button" onclick="window.openCookieSettings()" class="text-xs text-neutral-400 hover:text-white underline underline-offset-4 transition py-1.5 px-2 font-medium">
                    Atur Preferensi
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Pengaturan Preferensi Cookies -->
<div id="cookie-modal" class="fixed inset-0 bg-black/80 backdrop-blur-sm z-[60] hidden items-center justify-center p-4 transition-opacity duration-300 opacity-0" role="dialog" aria-modal="true" aria-labelledby="modal-title">
    <div class="bg-neutral-950 border border-neutral-800 text-white rounded-2xl max-w-lg w-full p-6 sm:p-7 shadow-2xl relative transform transition-all duration-300 scale-95 max-h-[90vh] overflow-y-auto">
        <!-- Modal Header -->
        <div class="flex items-start justify-between gap-4 pb-4 border-b border-neutral-800">
            <div>
                <h3 id="modal-title" class="text-lg font-bold text-white tracking-tight">Pengaturan Preferensi Cookie</h3>
                <p class="text-xs text-neutral-400 mt-1">Kelola perizinan penggunaan data dan cookies sesuai kebutuhan Anda.</p>
            </div>
            <button type="button" onclick="window.closeCookieSettings()" class="text-neutral-400 hover:text-white p-1 rounded-lg hover:bg-white/10 transition">
                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M18 6L6 18M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <!-- Cookie Categories Accordion / Cards -->
        <div class="space-y-4 my-6">
            <!-- 1. Cookies Esensial (Wajib) -->
            <div class="p-4 rounded-xl bg-neutral-900/70 border border-neutral-800">
                <div class="flex items-center justify-between gap-3 mb-2">
                    <div class="flex items-center gap-2">
                        <span class="h-2 w-2 rounded-full bg-emerald-400"></span>
                        <h4 class="text-xs font-bold uppercase tracking-wider text-white">Cookies Esensial (Wajib)</h4>
                    </div>
                    <span class="text-[10px] font-mono font-bold uppercase tracking-wider px-2 py-0.5 rounded bg-white/10 text-neutral-300 border border-white/20">
                        Selalu Aktif
                    </span>
                </div>
                <p class="text-xs text-neutral-400 leading-relaxed font-light">
                    Diperlukan untuk fungsi dasar situs: autentikasi sesi pengguna, keamanan formulir CSRF, keranjang reservasi sewa drone, dan otorisasi pembayaran Midtrans.
                </p>
            </div>

            <!-- 2. Cookies Kinerja & Analisis -->
            <div class="p-4 rounded-xl bg-neutral-900/70 border border-neutral-800">
                <div class="flex items-center justify-between gap-3 mb-2">
                    <div class="flex items-center gap-2">
                        <span class="h-2 w-2 rounded-full bg-sky-400"></span>
                        <h4 class="text-xs font-bold uppercase tracking-wider text-white">Kinerja &amp; Analisis</h4>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" id="cookie-opt-analytics" class="sr-only peer" checked>
                        <div class="w-9 h-5 bg-neutral-700 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-neutral-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-white peer-checked:after:bg-black"></div>
                    </label>
                </div>
                <p class="text-xs text-neutral-400 leading-relaxed font-light">
                    Mengumpulkan data anonim interaksi situs untuk mempercepat waktu muat galeri 360°, rendering model CAD 3D, dan efisiensi alur pemesanan.
                </p>
            </div>

            <!-- 3. Cookies Personalisasi & Pemasaran -->
            <div class="p-4 rounded-xl bg-neutral-900/70 border border-neutral-800">
                <div class="flex items-center justify-between gap-3 mb-2">
                    <div class="flex items-center gap-2">
                        <span class="h-2 w-2 rounded-full bg-purple-400"></span>
                        <h4 class="text-xs font-bold uppercase tracking-wider text-white">Personalisasi Fitur</h4>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" id="cookie-opt-marketing" class="sr-only peer">
                        <div class="w-9 h-5 bg-neutral-700 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-neutral-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-white peer-checked:after:bg-black"></div>
                    </label>
                </div>
                <p class="text-xs text-neutral-400 leading-relaxed font-light">
                    Menyimpan riwayat unit drone yang baru dilihat dan preferensi durasi sewa favorit Anda untuk rekomendasi paket peralatan berikutnya.
                </p>
            </div>
        </div>

        <!-- Modal Footer -->
        <div class="flex flex-col sm:flex-row items-center justify-between gap-3 pt-4 border-t border-neutral-800">
            <button type="button" onclick="window.rejectAllFromModal()" class="text-xs text-neutral-400 hover:text-white transition order-2 sm:order-1 font-medium">
                Tolak Semua Non-Esensial
            </button>
            <div class="flex items-center gap-2 w-full sm:w-auto order-1 sm:order-2">
                <button type="button" onclick="window.saveCustomPreferences()" class="w-full sm:w-auto rounded-full bg-white text-black hover:bg-neutral-200 px-6 py-2.5 text-xs font-bold uppercase tracking-wider transition border border-white">
                    Simpan Pengaturan
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Floating Confirmation Toast -->
<div id="cookie-toast" class="fixed bottom-6 right-6 z-[70] transform translate-y-8 opacity-0 pointer-events-none transition-all duration-300 ease-out">
    <div class="flex items-center gap-2.5 px-4 py-2.5 rounded-xl bg-black border border-neutral-700 text-white text-xs font-medium shadow-2xl">
        <svg class="h-4 w-4 text-emerald-400 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
            <polyline points="20 6 9 17 4 12"></polyline>
        </svg>
        <span id="cookie-toast-msg">Preferensi cookie berhasil disimpan.</span>
    </div>
</div>

<script>
    (function () {
        const STORAGE_KEY = 'sewa_drone_cookie_preferences';
        const banner = document.getElementById('cookie-banner');
        const modal = document.getElementById('cookie-modal');
        const toast = document.getElementById('cookie-toast');
        const toastMsg = document.getElementById('cookie-toast-msg');

        function getStoredPreferences() {
            try {
                const item = localStorage.getItem(STORAGE_KEY);
                return item ? JSON.parse(item) : null;
            } catch (e) {
                return null;
            }
        }

        function savePreferences(prefs) {
            try {
                localStorage.setItem(STORAGE_KEY, JSON.stringify({
                    ...prefs,
                    timestamp: new Date().toISOString()
                }));
            } catch (e) {}
        }

        function showBanner() {
            if (!banner) return;
            banner.classList.remove('translate-y-16', 'opacity-0', 'pointer-events-none');
            banner.classList.add('translate-y-0', 'opacity-100', 'pointer-events-auto');
        }

        function hideBanner() {
            if (!banner) return;
            banner.classList.add('translate-y-16', 'opacity-0', 'pointer-events-none');
            banner.classList.remove('translate-y-0', 'opacity-100', 'pointer-events-auto');
        }

        function showToast(msg) {
            if (!toast) return;
            if (toastMsg && msg) toastMsg.textContent = msg;
            toast.classList.remove('translate-y-8', 'opacity-0', 'pointer-events-none');
            toast.classList.add('translate-y-0', 'opacity-100', 'pointer-events-auto');
            setTimeout(() => {
                toast.classList.add('translate-y-8', 'opacity-0', 'pointer-events-none');
                toast.classList.remove('translate-y-0', 'opacity-100', 'pointer-events-auto');
            }, 2500);
        }

        window.acceptAllCookies = function () {
            savePreferences({ essential: true, analytics: true, marketing: true });
            hideBanner();
            showToast('Semua cookies telah disetujui.');
        };

        window.acceptEssentialOnly = function () {
            savePreferences({ essential: true, analytics: false, marketing: false });
            hideBanner();
            showToast('Hanya cookies esensial yang diaktifkan.');
        };

        window.openCookieSettings = function () {
            if (!modal) return;
            const current = getStoredPreferences() || { essential: true, analytics: true, marketing: false };
            const chkAnalytics = document.getElementById('cookie-opt-analytics');
            const chkMarketing = document.getElementById('cookie-opt-marketing');
            if (chkAnalytics) chkAnalytics.checked = !!current.analytics;
            if (chkMarketing) chkMarketing.checked = !!current.marketing;

            modal.classList.remove('hidden');
            modal.classList.add('flex');
            setTimeout(() => {
                modal.classList.remove('opacity-0');
                const modalBox = modal.querySelector('div');
                if (modalBox) {
                    modalBox.classList.remove('scale-95');
                    modalBox.classList.add('scale-100');
                }
            }, 10);
            document.body.style.overflow = 'hidden';
        };

        window.closeCookieSettings = function () {
            if (!modal) return;
            modal.classList.add('opacity-0');
            const modalBox = modal.querySelector('div');
            if (modalBox) {
                modalBox.classList.remove('scale-100');
                modalBox.classList.add('scale-95');
            }
            setTimeout(() => {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
                document.body.style.overflow = '';
            }, 250);
        };

        window.saveCustomPreferences = function () {
            const chkAnalytics = document.getElementById('cookie-opt-analytics');
            const chkMarketing = document.getElementById('cookie-opt-marketing');
            savePreferences({
                essential: true,
                analytics: chkAnalytics ? chkAnalytics.checked : false,
                marketing: chkMarketing ? chkMarketing.checked : false
            });
            window.closeCookieSettings();
            hideBanner();
            showToast('Preferensi cookie Anda berhasil diperbarui.');
        };

        window.rejectAllFromModal = function () {
            const chkAnalytics = document.getElementById('cookie-opt-analytics');
            const chkMarketing = document.getElementById('cookie-opt-marketing');
            if (chkAnalytics) chkAnalytics.checked = false;
            if (chkMarketing) chkMarketing.checked = false;
            window.saveCustomPreferences();
        };

        // Check on load
        document.addEventListener('DOMContentLoaded', () => {
            const stored = getStoredPreferences();
            if (!stored) {
                setTimeout(showBanner, 800);
            }
        });

        // Close on ESC or clicking backdrop
        if (modal) {
            modal.addEventListener('click', (e) => {
                if (e.target === modal) {
                    window.closeCookieSettings();
                }
            });
        }
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && modal && !modal.classList.contains('hidden')) {
                window.closeCookieSettings();
            }
        });
    })();
</script>
