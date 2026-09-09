@extends('layouts.store')

@section('title', $drone->name . ' — Sewa Drone DJI Resmi')

@section('content')
    @php
        $mediaFile = base_path('database/dji_media.json');
        $allMedia = file_exists($mediaFile) ? json_decode(file_get_contents($mediaFile), true) : [];
        $droneMedia = $allMedia[$drone->slug] ?? null;
        $gallery = $droneMedia['gallery'] ?? [];
        $turntable = $droneMedia['turntable_360'] ?? $gallery;
        $videoUrl = $droneMedia['video'] ?? null;
        $videoCdn = $droneMedia['video_cdn'] ?? null;
        $videoBadge = $droneMedia['video_badge'] ?? '4K Ultra HD';
        $videoTitle = $droneMedia['video_title'] ?? ('DJI ' . $drone->name . ' — Footage & Flight Reel');
        $videoDescription = $droneMedia['video_description'] ?? ('Contoh rekaman video asli sensor DJI ' . $drone->name . ' dengan profil warna 10-bit D-Log M dan stabilisasi gimbal 3-axis profesional.');
        $model3d = $droneMedia['model_3d'] ?? '/storage/drones/models/drone_model.glb';
        $specs = $droneMedia['specs'] ?? null;

        $resolveImg = function($img) {
            if (empty($img)) return null;
            if (str_starts_with($img, 'http')) return $img;
            $clean = ltrim($img, '/');
            return str_starts_with($clean, 'storage/') ? asset($clean) : asset('storage/' . $clean);
        };

        $primaryImgUrl = $resolveImg($droneMedia['primary_image'] ?? $drone->image_path);

        $turntableItems = [];
        if (!empty($turntable)) {
            foreach ($turntable as $idx => $t) {
                $turntableItems[] = [
                    'title' => $t['title'] ?? ('Sudut ' . ($idx + 1)),
                    'url' => $resolveImg($t['url'] ?? $primaryImgUrl),
                    'deg' => isset($t['deg']) ? (int)$t['deg'] : (int)round(($idx / max(1, count($turntable))) * 360),
                ];
            }
        } else {
            $turntableItems[] = [
                'title' => 'Wujud Fisik Depan (0°)',
                'url' => $primaryImgUrl,
                'deg' => 0
            ];
        }

        $galleryItems = [];
        foreach ($gallery as $g) {
            $galleryItems[] = [
                'title' => $g['title'] ?? 'Sudut Fisik',
                'url' => $resolveImg($g['url']),
                'deg' => isset($g['deg']) ? (int)$g['deg'] : 0,
            ];
        }
        if (empty($galleryItems)) {
            $galleryItems = $turntableItems;
        }
    @endphp

    <!-- Top Sub-Nav (DJI Store Style) -->
    <div class="border-b border-neutral-200 bg-white/95 sticky top-16 z-40 backdrop-blur-md">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 py-3.5 flex items-center justify-between text-xs">
            <div class="flex items-center gap-3">
                <a href="{{ route('home') }}" class="text-neutral-500 hover:text-black transition flex items-center gap-1">
                    <span>&larr;</span> <span>Armada</span>
                </a>
                <span class="text-neutral-400">/</span>
                <span class="font-bold text-neutral-950 tracking-wider uppercase">{{ $drone->name }}</span>
            </div>
            <div class="flex items-center gap-4">
                <div class="hidden sm:block text-right">
                    <span class="text-neutral-500 text-[11px]">Tarif Sewa:</span>
                    <strong class="text-neutral-950 text-sm ml-1 font-extrabold">Rp{{ number_format((float) $drone->daily_rate, 0, ',', '.') }}</strong>
                    <span class="text-neutral-500 text-[10px]">/hari</span>
                </div>
                <a href="#booking-section" class="rounded-full bg-black hover:bg-neutral-800 text-white px-5 py-2 font-bold uppercase tracking-wider text-[11px] transition shadow-sm border border-black">
                    Sewa Sekarang
                </a>
            </div>
        </div>
    </div>

    <!-- Core Global Viewer Logic (Declared Early so all buttons are immediately interactive) -->
    <script>
        window.turntableData = @json($turntableItems);
        window.galleryData = @json($galleryItems);
        window.activeViewerMode = 'physical';
        window.currentTurntableIndex = 0;
        window.turntableAutoPlayTimer = null;
        window.isPhysicalZoomed = false;

        function getCardinalLabel(deg) {
            const norm = (deg % 360 + 360) % 360;
            if (norm >= 337.5 || norm < 22.5) return 'DEPAN (0°)';
            if (norm >= 22.5 && norm < 67.5) return 'SERONG DEPAN-KANAN (45°)';
            if (norm >= 67.5 && norm < 112.5) return 'SAMPING KANAN (90°)';
            if (norm >= 112.5 && norm < 157.5) return 'SERONG BELAKANG-KANAN';
            if (norm >= 157.5 && norm < 202.5) return 'BELAKANG (180°)';
            if (norm >= 202.5 && norm < 247.5) return 'SERONG BELAKANG-KIRI';
            if (norm >= 247.5 && norm < 292.5) return 'SAMPING KIRI (270°)';
            return 'SERONG DEPAN-KIRI';
        }

        window.switchViewerMode = function(mode) {
            window.activeViewerMode = mode;
            const btnPhysical = document.getElementById('tab-btn-physical');
            const btn3d = document.getElementById('tab-btn-3d');
            const modePhysical = document.getElementById('viewer-mode-physical');
            const mode3d = document.getElementById('viewer-mode-3d');
            const hudBadge = document.getElementById('hud-badge-mode');

            if (mode === 'physical') {
                if (modePhysical) modePhysical.classList.remove('hidden');
                if (mode3d) mode3d.classList.add('hidden');

                if (btnPhysical) {
                    btnPhysical.className = 'px-3.5 py-1.5 rounded-lg text-xs font-mono font-bold flex items-center gap-2 transition bg-black text-white shadow-sm border border-black';
                }
                if (btn3d) {
                    btn3d.className = 'px-3.5 py-1.5 rounded-lg text-xs font-mono font-medium flex items-center gap-2 transition text-neutral-600 hover:text-black hover:bg-neutral-100';
                }
                if (hudBadge) {
                    hudBadge.innerHTML = '<span class="h-1.5 w-1.5 rounded-full bg-black animate-pulse"></span><span>STUDIO 360° TURNTABLE</span>';
                    hudBadge.className = 'inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md bg-neutral-100 border border-neutral-200 text-neutral-800 text-[10.5px] font-mono font-bold tracking-wider uppercase';
                }
                window.updatePhysicalHUD();
            } else {
                if (modePhysical) modePhysical.classList.add('hidden');
                if (mode3d) mode3d.classList.remove('hidden');

                if (btnPhysical) {
                    btnPhysical.className = 'px-3.5 py-1.5 rounded-lg text-xs font-mono font-medium flex items-center gap-2 transition text-neutral-600 hover:text-black hover:bg-neutral-100';
                }
                if (btn3d) {
                    btn3d.className = 'px-3.5 py-1.5 rounded-lg text-xs font-mono font-bold flex items-center gap-2 transition bg-black text-white shadow-sm border border-black';
                }
                if (hudBadge) {
                    hudBadge.innerHTML = '<span class="h-1.5 w-1.5 rounded-full bg-black animate-ping"></span><span>3D WEBGL CAD</span>';
                    hudBadge.className = 'inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md bg-neutral-100 border border-neutral-200 text-neutral-800 text-[10.5px] font-mono font-bold tracking-wider uppercase';
                }

                // Initialize or resize 3D engine
                if (window.initThreeEngine) {
                    window.initThreeEngine();
                }
                if (window.drone3DResize) {
                    setTimeout(window.drone3DResize, 60);
                }
            }
        };

        window.updatePhysicalHUD = function() {
            if (!window.turntableData || window.turntableData.length === 0) return;
            const current = window.turntableData[window.currentTurntableIndex];
            if (!current) return;

            const hudAz = document.getElementById('hud-azimuth');
            const hudCard = document.getElementById('hud-cardinal');
            const frameTitle = document.getElementById('turntable-frame-title');
            const frameCount = document.getElementById('turntable-frame-count');

            if (hudAz) hudAz.textContent = String(current.deg ?? 0).padStart(3, '0') + '°';
            if (hudCard) hudCard.textContent = getCardinalLabel(current.deg ?? 0);
            if (frameTitle) frameTitle.textContent = current.title ?? 'Wujud Fisik Drone';
            if (frameCount) frameCount.textContent = (window.currentTurntableIndex + 1) + '/' + window.turntableData.length;

            // Highlight thumbnail
            document.querySelectorAll('.gallery-thumb-btn').forEach((btn, idx) => {
                const btnImg = btn.querySelector('img');
                if (btnImg && btnImg.src.includes(current.url.split('/').pop())) {
                    btn.classList.add('border-black', 'ring-1', 'ring-black/40', 'opacity-100', 'bg-neutral-100');
                    btn.classList.remove('border-neutral-200', 'opacity-70', 'bg-white');
                } else {
                    btn.classList.remove('border-black', 'ring-1', 'ring-black/40', 'opacity-100', 'bg-neutral-100');
                    btn.classList.add('border-neutral-200', 'opacity-70', 'bg-white');
                }
            });
        };

        window.setTurntableIndex = function(newIdx) {
            if (!window.turntableData || window.turntableData.length === 0) return;
            const total = window.turntableData.length;
            window.currentTurntableIndex = (newIdx % total + total) % total;
            const item = window.turntableData[window.currentTurntableIndex];
            const imgEl = document.getElementById('turntable-image');
            if (imgEl && item) {
                imgEl.src = item.url;
            }
            if (window.photoZoom) {
                window.photoZoom.reset();
            }
            window.updatePhysicalHUD();
        };

        window.setTurntableAngle = function(targetDeg, clickedBtn) {
            if (!window.turntableData || window.turntableData.length === 0) return;
            let closestIdx = 0;
            let minDiff = 999;
            window.turntableData.forEach((item, idx) => {
                const diff = Math.abs((item.deg ?? 0) - targetDeg);
                if (diff < minDiff) {
                    minDiff = diff;
                    closestIdx = idx;
                }
            });
            window.setTurntableIndex(closestIdx);

            // Update preset button styles
            document.querySelectorAll('.angle-preset-btn').forEach(btn => {
                btn.classList.remove('bg-black', 'text-white', 'font-bold', 'border-black');
                btn.classList.add('bg-neutral-100', 'border-neutral-200', 'text-neutral-700');
            });
            if (clickedBtn) {
                clickedBtn.classList.add('bg-black', 'text-white', 'font-bold', 'border-black');
                clickedBtn.classList.remove('bg-neutral-100', 'border-neutral-200', 'text-neutral-700');
            }
        };

        window.toggleTurntableAutoPlay = function() {
            const btn = document.getElementById('btn-physical-autoplay');
            const icon = document.getElementById('physical-play-icon');
            const text = document.getElementById('physical-play-text');

            if (window.turntableAutoPlayTimer) {
                clearInterval(window.turntableAutoPlayTimer);
                window.turntableAutoPlayTimer = null;
                if (icon) icon.textContent = '▶';
                if (text) text.textContent = 'Auto 360°';
                if (btn) {
                    btn.classList.remove('bg-black', 'text-white', 'border-black');
                    btn.classList.add('bg-neutral-100', 'text-neutral-800', 'border-neutral-300');
                }
            } else {
                if (icon) icon.textContent = '⏸';
                if (text) text.textContent = 'Jeda';
                if (btn) {
                    btn.classList.add('bg-black', 'text-white', 'border-black');
                    btn.classList.remove('bg-neutral-100', 'text-neutral-800', 'border-neutral-300');
                }
                window.turntableAutoPlayTimer = setInterval(() => {
                    window.setTurntableIndex(window.currentTurntableIndex + 1);
                }, 1400);
            }
        };

        window.photoZoom = {
            scale: 1,
            panX: 0,
            panY: 0,
            isPanning: false,

            apply: function(animate = true) {
                const img = document.getElementById('turntable-image');
                const btn = document.getElementById('btn-zoom-toggle');
                const text = document.getElementById('zoom-text');
                const viewport = document.getElementById('turntable-viewport');

                if (!img) return;

                if (animate) {
                    img.style.transition = 'transform 0.22s cubic-bezier(0.16, 1, 0.3, 1)';
                } else {
                    img.style.transition = 'none';
                }

                img.style.transform = `translate(${this.panX}px, ${this.panY}px) scale(${this.scale})`;

                if (this.scale > 1) {
                    if (viewport) {
                        viewport.style.cursor = this.isPanning ? 'grabbing' : 'grab';
                    }
                    if (btn) {
                        btn.classList.add('bg-black', 'border-black', 'text-white');
                        btn.classList.remove('bg-neutral-100', 'border-neutral-300', 'text-neutral-800');
                    }
                    if (text) {
                        text.textContent = `Reset (${Math.round(this.scale * 100)}%)`;
                    }
                } else {
                    if (viewport) {
                        viewport.style.cursor = 'zoom-in';
                    }
                    if (btn) {
                        btn.classList.remove('bg-black', 'border-black', 'text-white');
                        btn.classList.add('bg-neutral-100', 'border-neutral-300', 'text-neutral-800');
                    }
                    if (text) {
                        text.textContent = 'Zoom 2x';
                    }
                }
            },

            zoomTo: function(newScale, animate = true) {
                this.scale = Math.min(Math.max(Number(newScale.toFixed(2)), 1), 3.5);
                if (this.scale === 1) {
                    this.panX = 0;
                    this.panY = 0;
                } else {
                    this.clampPan();
                }
                this.apply(animate);
            },

            toggle: function() {
                if (this.scale > 1) {
                    this.reset();
                } else {
                    this.zoomTo(2, true);
                }
            },

            reset: function() {
                this.scale = 1;
                this.panX = 0;
                this.panY = 0;
                this.apply(true);
            },

            clampPan: function() {
                const viewport = document.getElementById('turntable-viewport');
                if (!viewport) return;
                const maxPanX = Math.max(0, (viewport.offsetWidth * (this.scale - 1)) / 2);
                const maxPanY = Math.max(0, (viewport.offsetHeight * (this.scale - 1)) / 2);
                this.panX = Math.min(Math.max(this.panX, -maxPanX), maxPanX);
                this.panY = Math.min(Math.max(this.panY, -maxPanY), maxPanY);
            }
        };

        window.togglePhysicalZoom = function() {
            window.photoZoom.toggle();
        };

        window.selectGalleryImage = function(url, title, deg, btn) {
            const imgEl = document.getElementById('turntable-image');
            if (imgEl) imgEl.src = url;

            // Find matching index in turntableData if exists
            let foundIdx = window.turntableData.findIndex(item => item.url === url);
            if (foundIdx !== -1) {
                window.currentTurntableIndex = foundIdx;
            }

            if (window.photoZoom) {
                window.photoZoom.reset();
            }

            const frameTitle = document.getElementById('turntable-frame-title');
            if (frameTitle) frameTitle.textContent = title;
            const hudAz = document.getElementById('hud-azimuth');
            const hudCard = document.getElementById('hud-cardinal');
            if (hudAz) hudAz.textContent = String(deg).padStart(3, '0') + '°';
            if (hudCard) hudCard.textContent = getCardinalLabel(deg);

            document.querySelectorAll('.gallery-thumb-btn').forEach(b => {
                b.classList.remove('border-black', 'ring-1', 'ring-black/40', 'opacity-100', 'bg-neutral-100');
                b.classList.add('border-neutral-200', 'opacity-70', 'bg-white');
            });
            if (btn) {
                btn.classList.add('border-black', 'ring-1', 'ring-black/40', 'opacity-100', 'bg-neutral-100');
                btn.classList.remove('border-neutral-200', 'opacity-70', 'bg-white');
            }
        };
    </script>

    <!-- Main Detail Studio Canvas (Soft Studio Palette to avoid harsh white glare) -->
    <div class="bg-[#F8F9FB] border-t border-neutral-200/70 min-h-screen py-8 sm:py-12">
        <div class="mx-auto max-w-7xl px-4 sm:px-6">
            <div class="grid gap-8 lg:gap-10 lg:grid-cols-[minmax(0,1.05fr)_minmax(0,1fr)] items-start">
                <!-- Left Column: Interactive Multi-Angle Gallery & Cinematic Video Reel -->
                <div class="space-y-8 min-w-0">
                    <!-- Interactive 360° Physical Turntable & 3D WebGL Model Showcase -->
                    <div class="rounded-2xl bg-white border border-neutral-200/80 p-5 sm:p-6 overflow-hidden relative shadow-[0_4px_24px_-6px_rgba(0,0,0,0.05)] transition">
                        
                        <!-- Top Switcher & Telemetry HUD -->
                        <div class="flex items-center justify-between border-b border-neutral-200/80 pb-3.5 mb-4 gap-2 flex-wrap">
                            <div class="flex items-center gap-1.5 p-1 bg-neutral-100 border border-neutral-200/80 rounded-xl">
                                <button type="button" id="tab-btn-physical" onclick="window.switchViewerMode('physical')"
                                        class="px-3.5 py-1.5 rounded-lg text-xs font-mono font-bold flex items-center gap-2 transition bg-black text-white shadow-sm border border-black">
                                    <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                        <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                                        <circle cx="8.5" cy="8.5" r="1.5"></circle>
                                        <polyline points="21 15 16 10 5 21"></polyline>
                                    </svg>
                                    <span>Foto Fisik Asli (360°)</span>
                                </button>
                                <button type="button" id="tab-btn-3d" onclick="window.switchViewerMode('3d')"
                                        class="px-3.5 py-1.5 rounded-lg text-xs font-mono font-medium flex items-center gap-2 transition text-neutral-600 hover:text-black hover:bg-neutral-200/60">
                                    <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path>
                                        <polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline>
                                        <line x1="12" y1="22.08" x2="12" y2="12"></line>
                                    </svg>
                                    <span>Simulasi 3D</span>
                                </button>
                            </div>

                            <!-- Live Heading / Orbit Azimuth HUD -->
                            <div id="telemetry-hud" class="flex items-center gap-2">
                                <span id="hud-badge-mode" class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md bg-neutral-100 border border-neutral-200/80 text-neutral-800 text-[10.5px] font-mono font-bold tracking-wider uppercase">
                                    <span class="h-1.5 w-1.5 rounded-full bg-black animate-pulse"></span>
                                    <span>STUDIO 360° TURNTABLE</span>
                                </span>
                                <span class="text-[10px] font-mono text-neutral-600 bg-neutral-100 border border-neutral-200/80 px-2 py-1 rounded">
                                    <span id="hud-azimuth" class="text-black font-bold">000°</span> [<span id="hud-cardinal" class="text-neutral-900 font-semibold">DEPAN (0°)</span>]
                                </span>
                            </div>
                        </div>

                        <!-- 1. PRIMARY VIEW: REAL PHYSICAL DRONE 360° PHOTO TURNTABLE -->
                        <div id="viewer-mode-physical" class="relative">
                            <!-- Action Bar for Turntable -->
                            <div class="flex items-center justify-between gap-2 mb-3 text-xs">
                                <div class="flex items-center gap-1 sm:gap-1.5 overflow-x-auto no-scrollbar py-0.5">
                                    <button type="button" id="btn-physical-autoplay" onclick="window.toggleTurntableAutoPlay()"
                                            class="px-2.5 py-1.5 rounded-lg text-[11px] font-mono bg-neutral-100 hover:bg-neutral-200 border border-neutral-300 text-neutral-800 transition flex items-center gap-1.5 shadow-sm active:scale-95 shrink-0">
                                        <span id="physical-play-icon">▶</span>
                                        <span id="physical-play-text">Auto 360°</span>
                                    </button>
                                    <div class="h-4 w-px bg-neutral-200 hidden sm:block mx-0.5 shrink-0"></div>
                                    <span class="text-[10px] font-mono text-neutral-500 uppercase hidden md:inline shrink-0">Sudut:</span>
                                    <button type="button" onclick="window.setTurntableAngle(0, this)"
                                            class="angle-preset-btn px-2.5 py-1 rounded-md text-[10.5px] font-mono bg-black text-white font-bold border border-black transition shrink-0">
                                        0° Depan
                                    </button>
                                    <button type="button" onclick="window.setTurntableAngle(45, this)"
                                            class="angle-preset-btn px-2.5 py-1 rounded-md text-[10.5px] font-mono bg-neutral-100 hover:bg-black hover:text-white border border-neutral-200 text-neutral-700 transition shrink-0">
                                        45°
                                    </button>
                                    <button type="button" onclick="window.setTurntableAngle(90, this)"
                                            class="angle-preset-btn px-2.5 py-1 rounded-md text-[10.5px] font-mono bg-neutral-100 hover:bg-black hover:text-white border border-neutral-200 text-neutral-700 transition shrink-0">
                                        90°
                                    </button>
                                    <button type="button" onclick="window.setTurntableAngle(180, this)"
                                            class="angle-preset-btn px-2.5 py-1 rounded-md text-[10.5px] font-mono bg-neutral-100 hover:bg-black hover:text-white border border-neutral-200 text-neutral-700 transition shrink-0">
                                        180°
                                    </button>
                                </div>

                                <button type="button" id="btn-zoom-toggle" onclick="window.togglePhysicalZoom()"
                                        class="px-2.5 py-1.5 rounded-lg text-[11px] font-mono bg-neutral-100 hover:bg-neutral-200 border border-neutral-300 text-neutral-800 transition flex items-center gap-1.5 shadow-sm shrink-0">
                                    <span>🔍</span> <span id="zoom-text">Zoom 2x</span>
                                </button>
                            </div>

                            <!-- Turntable Stage Viewport with Interactive Zoom & Pan (100% Unobstructed) -->
                            <div id="turntable-viewport"
                                 style="height: 420px; min-height: 360px;"
                                 class="relative w-full h-[320px] sm:h-[420px] rounded-xl overflow-hidden border border-neutral-200 bg-[#F4F5F7] shadow-inner flex items-center justify-center select-none">
                                
                                <!-- Studio Ambient Concentric Pedestal Graphic (Monochrome Minimalist) -->
                                <div class="absolute inset-0 pointer-events-none flex items-center justify-center opacity-40">
                                    <div class="w-72 h-72 rounded-full border border-neutral-300"></div>
                                    <div class="w-[420px] h-[420px] rounded-full border border-neutral-200 absolute"></div>
                                    <div class="w-[560px] h-[560px] rounded-full border border-neutral-200/60 absolute"></div>
                                </div>

                                <!-- Real Physical Drone Image -->
                                <div class="absolute inset-4 sm:inset-6 flex items-center justify-center overflow-hidden pointer-events-none">
                                    <img id="turntable-image"
                                         src="{{ $turntableItems[0]['url'] ?? $primaryImgUrl }}"
                                         alt="{{ $drone->name }}"
                                         draggable="false"
                                         class="w-full h-full object-contain drop-shadow-[0_15px_30px_rgba(0,0,0,0.12)] select-none">
                                </div>
                            </div>

                            <!-- Gallery Thumbnails (4+ Physical Angles) -->
                            @if (count($galleryItems) > 0)
                                <div class="mt-4 pt-3 border-t border-neutral-200/80">
                                    <div class="grid grid-cols-2 sm:grid-cols-4 md:grid-cols-6 gap-2">
                                        @foreach ($galleryItems as $index => $item)
                                            <button type="button"
                                                    onclick="window.selectGalleryImage('{{ $item['url'] }}', '{{ $item['title'] }}', {{ $item['deg'] ?? 0 }}, this)"
                                                    class="gallery-thumb-btn rounded-lg border {{ $index === 0 ? 'border-black ring-1 ring-black/40 opacity-100 bg-neutral-100' : 'border-neutral-200 opacity-70 bg-white' }} hover:opacity-100 hover:border-neutral-400 overflow-hidden p-1.5 transition text-left group">
                                                <div class="h-14 w-full flex items-center justify-center overflow-hidden">
                                                    <img src="{{ $item['url'] }}" alt="{{ $item['title'] }}" draggable="false" class="h-full w-full object-contain group-hover:scale-105 transition duration-200">
                                                </div>
                                                <span class="block text-[9.5px] text-neutral-700 font-mono truncate mt-1 text-center font-medium">{{ $item['title'] }}</span>
                                            </button>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>

                        <!-- 2. SECONDARY VIEW: 3D WEBGL CAD SIMULATION -->
                        <div id="viewer-mode-3d" class="hidden relative">
                            <!-- 3D Actions Bar -->
                            <div class="flex items-center justify-between gap-2 mb-3 text-xs">
                                <div class="flex items-center gap-1 sm:gap-1.5 overflow-x-auto no-scrollbar py-0.5">
                                    <button type="button" id="btn-auto-rotate" onclick="window.toggleAutoRotate()"
                                            class="px-2.5 py-1.5 rounded-lg text-[11px] font-mono bg-neutral-100 hover:bg-neutral-200 border border-neutral-300 text-neutral-800 transition flex items-center gap-1.5 shadow-sm shrink-0">
                                        <span id="rotate-icon">▶</span>
                                        <span id="rotate-text">Putar 360°</span>
                                    </button>
                                    <button type="button" id="btn-rotor-spin" onclick="window.toggleRotorSpin()"
                                            class="px-2.5 py-1.5 rounded-lg text-[11px] font-mono bg-black text-white border border-black transition flex items-center gap-1.5 shadow-sm shrink-0">
                                        <span id="rotor-icon" class="inline-block animate-spin" style="animation-duration: 2s;">⚙</span>
                                        <span id="rotor-text">Baling-Baling</span>
                                    </button>
                                    <button type="button" id="btn-wireframe" onclick="window.toggleWireframe()"
                                            class="px-2.5 py-1.5 rounded-lg text-[11px] font-mono bg-neutral-100 hover:bg-neutral-200 border border-neutral-300 text-neutral-800 transition flex items-center gap-1.5 shadow-sm shrink-0">
                                        <span>🌐</span>
                                        <span id="wireframe-text">Wireframe</span>
                                    </button>
                                </div>

                                <button type="button" onclick="window.reset3DCamera()"
                                        class="px-2.5 py-1.5 rounded-lg text-[11px] font-mono bg-neutral-100 hover:bg-neutral-200 border border-neutral-300 text-neutral-700 transition flex items-center gap-1 shadow-sm shrink-0">
                                    <span>↺</span> Reset
                                </button>
                            </div>

                            <!-- 3D Viewport Box -->
                            <div id="canvas-wrapper"
                                 style="height: 420px; min-height: 360px;"
                                 class="relative w-full h-[320px] sm:h-[420px] rounded-xl overflow-hidden border border-neutral-200 bg-[#F4F5F7] shadow-inner flex items-center justify-center">

                                <!-- Real Three.js Canvas -->
                                <canvas id="drone-webgl-canvas" class="w-full h-full block cursor-grab active:cursor-grabbing outline-none"></canvas>

                                <!-- WebGL Model Loader Overlay -->
                                <div id="webgl-loader" class="absolute inset-0 bg-white/95 backdrop-blur-md flex flex-col items-center justify-center gap-3 transition-opacity duration-500 z-20 pointer-events-none">
                                    <div class="relative w-12 h-12">
                                        <div class="absolute inset-0 border-2 border-neutral-300 rounded-full"></div>
                                        <div class="absolute inset-0 border-2 border-black border-t-transparent rounded-full animate-spin"></div>
                                    </div>
                                    <div class="text-center">
                                        <p class="text-xs font-mono font-bold text-neutral-900 tracking-widest uppercase">Memuat Model 3D {{ $drone->name }}</p>
                                        <p class="text-[10px] font-mono text-neutral-500 mt-1">Menginisialisasi WebGL Mesh 3D &amp; Lighting...</p>
                                    </div>
                                </div>

                                <!-- Touch / Drag Hint Overlay -->
                                <div id="webgl-drag-hint"
                                     class="absolute top-3 inset-x-0 mx-auto w-max pointer-events-none flex items-center gap-2 bg-black/80 backdrop-blur-md border border-black/10 px-3.5 py-1.5 rounded-full text-[10.5px] font-mono text-white transition-opacity duration-300 shadow-xl z-10">
                                    <span class="h-2 w-2 rounded-full bg-white animate-ping"></span>
                                    <span>Tahan &amp; Geser untuk Memutar 360° Bebas &bull; Scroll untuk Zoom</span>
                                </div>

                                <!-- Live Pitch & Zoom Badge -->
                                <div class="absolute bottom-3 right-3 pointer-events-none bg-white/90 backdrop-blur-md border border-neutral-200 px-2.5 py-1 rounded text-[9.5px] font-mono text-neutral-700 shadow-sm z-10">
                                    PITCH: <span id="hud-pitch" class="text-neutral-950 font-bold">+18°</span> | DIST: <span id="hud-zoom" class="text-neutral-500">4.2m</span>
                                </div>
                            </div>

                            <!-- Quick Camera Angle Presets for 3D -->
                            <div class="mt-3.5 pt-3 border-t border-neutral-200/80 flex flex-wrap items-center justify-between gap-2.5">
                                <span class="text-[10.5px] font-mono uppercase text-neutral-500">Preset Kamera 3D:</span>
                                <div class="flex items-center gap-1.5 flex-wrap">
                                    <button type="button" onclick="window.setCameraPreset('perspective')"
                                            class="preset-btn text-[10px] font-mono px-2.5 py-1 rounded-md bg-neutral-100 hover:bg-black hover:text-white border border-neutral-200 text-neutral-700 transition">
                                        Perspektif 45°
                                    </button>
                                    <button type="button" onclick="window.setCameraPreset('front')"
                                            class="preset-btn text-[10px] font-mono px-2.5 py-1 rounded-md bg-neutral-100 hover:bg-black hover:text-white border border-neutral-200 text-neutral-700 transition">
                                        Depan (0°)
                                    </button>
                                    <button type="button" onclick="window.setCameraPreset('top')"
                                            class="preset-btn text-[10px] font-mono px-2.5 py-1 rounded-md bg-neutral-100 hover:bg-black hover:text-white border border-neutral-200 text-neutral-700 transition">
                                        Atas (Top 90°)
                                    </button>
                                    <button type="button" onclick="window.setCameraPreset('side')"
                                            class="preset-btn text-[10px] font-mono px-2.5 py-1 rounded-md bg-neutral-100 hover:bg-black hover:text-white border border-neutral-200 text-neutral-700 transition">
                                        Samping (90°)
                                    </button>
                                    <button type="button" onclick="window.setCameraPreset('gimbal')"
                                            class="preset-btn text-[10px] font-mono px-2.5 py-1 rounded-md bg-neutral-100 hover:bg-black hover:text-white border border-neutral-200 text-neutral-700 transition">
                                        Kamera Gimbal
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Official Cinematic Video Footage Reel (Minimalist Black Cinema Card) -->
                    @if ($videoUrl || $videoCdn)
                        <div class="rounded-2xl bg-black border border-neutral-800 p-6 sm:p-8 overflow-hidden shadow-2xl text-white">
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-4 gap-2">
                                <div>
                                    <span class="text-[10px] uppercase tracking-widest text-neutral-400 font-bold block font-mono">Footage &amp; Flight Reel</span>
                                    <h3 class="text-lg font-bold text-white tracking-tight mt-0.5">{{ $videoTitle }}</h3>
                                </div>
                                <span class="text-[10px] text-white flex items-center gap-1.5 border border-white/20 px-2.5 py-1 rounded-full bg-white/10 self-start sm:self-auto font-mono">
                                    <span class="h-1.5 w-1.5 rounded-full bg-white animate-pulse"></span> {{ $videoBadge }}
                                </span>
                            </div>

                            <div class="relative rounded-xl overflow-hidden bg-neutral-950 aspect-video border border-neutral-800 group shadow-2xl">
                                <video class="w-full h-full object-cover" autoplay loop muted playsinline controls preload="metadata">
                                    @if ($videoUrl)
                                        <source src="{{ str_starts_with($videoUrl, 'http') ? $videoUrl : asset(ltrim($videoUrl, '/')) }}" type="video/mp4">
                                    @endif
                                    @if ($videoCdn)
                                        <source src="{{ $videoCdn }}" type="video/mp4">
                                    @endif
                                    Browser Anda tidak mendukung pemutar video HTML5.
                                </video>
                            </div>
                            <p class="text-xs text-neutral-300 mt-3.5 leading-relaxed font-light">
                                {{ $videoDescription }}
                            </p>
                        </div>
                    @endif

                    <!-- Product Overview Card -->
                    <div class="rounded-2xl bg-white border border-neutral-200/80 p-6 sm:p-8 shadow-sm space-y-3">
                        <div class="flex items-center gap-2">
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10.5px] font-mono font-bold tracking-wider uppercase {{ $drone->weight_g < 250 ? 'bg-emerald-50 text-emerald-800 border border-emerald-200' : 'bg-neutral-100 text-neutral-800 border border-neutral-200' }}">
                                <span class="h-1.5 w-1.5 rounded-full {{ $drone->weight_g < 250 ? 'bg-emerald-500' : 'bg-neutral-900' }}"></span>
                                {{ $drone->weight_g < 250 ? 'Sub-249g Bebas Izin Rekreasi' : 'Komersial Standar PM 37/2020' }}
                            </span>
                            <span class="text-[10.5px] font-mono text-neutral-400">DJI Authorized Fleet</span>
                        </div>

                        <h1 class="text-3xl sm:text-4xl font-extrabold text-neutral-900 tracking-tight uppercase">
                            {{ $drone->name }}
                        </h1>

                        <p class="text-sm text-neutral-600 leading-relaxed font-light pt-1">
                            {{ $drone->description }}
                        </p>
                    </div>

                    <!-- Comprehensive Technical Specifications (DJI Pro Structured Matrix) -->
                    <div class="rounded-2xl bg-white border border-neutral-200/80 p-6 sm:p-8 space-y-6 shadow-sm" x-data="{ activeSpecTab: 'camera' }">
                        <!-- Section Header -->
                        <div class="flex flex-col sm:flex-row sm:items-end justify-between border-b border-neutral-200/80 pb-5 gap-3">
                            <div>
                                <span class="text-[10px] uppercase font-mono tracking-widest text-neutral-500 font-bold block">Telemetry &amp; Optical Matrix</span>
                                <h2 class="text-2xl sm:text-3xl font-extrabold text-neutral-900 tracking-tight mt-0.5">
                                    Spesifikasi Teknis &amp; Kualitas
                                </h2>
                            </div>
                            <span class="text-xs font-mono font-semibold px-3 py-1 rounded-full bg-neutral-100 text-neutral-800 border border-neutral-300 self-start sm:self-auto shadow-sm">
                                {{ str_starts_with($drone->name, 'DJI') ? $drone->name : ('DJI ' . $drone->name) }}
                            </span>
                        </div>

                        <!-- 1. Hero Telemetry HUD (4 Big Visual Metric Cards - Scannable & High Visual Quality) -->
                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                            <!-- Metric 1: Optik & Resolusi -->
                            <div class="rounded-xl bg-neutral-50 border border-neutral-200/80 p-4 flex flex-col justify-between hover:border-black/30 transition">
                                <span class="text-[10px] uppercase font-mono tracking-wider text-neutral-500 font-bold flex items-center gap-1.5">
                                    <span>📷</span> Sensor Kamera
                                </span>
                                <div class="my-2">
                                    <span class="text-lg sm:text-xl font-black text-neutral-950 tracking-tight block">
                                        {{ Str::contains($specs['camera']['video_res'] ?? '', '4K') ? '4K Ultra HD' : (Str::contains($specs['camera']['video_res'] ?? '', '8K') ? '8K Cinema' : 'FHD 1080p') }}
                                    </span>
                                    <span class="text-[11px] text-neutral-600 font-medium block truncate mt-0.5">
                                        {{ $specs['camera']['sensor'] ?? $drone->camera }}
                                    </span>
                                </div>
                                <span class="text-[10px] font-mono text-neutral-500 block truncate">
                                    {{ $specs['camera']['stabilization'] ?? 'Gimbal 3-Axis' }}
                                </span>
                            </div>

                            <!-- Metric 2: Waktu Terbang -->
                            <div class="rounded-xl bg-neutral-50 border border-neutral-200/80 p-4 flex flex-col justify-between hover:border-black/30 transition">
                                <span class="text-[10px] uppercase font-mono tracking-wider text-neutral-500 font-bold flex items-center gap-1.5">
                                    <span>⏱️</span> Durasi Terbang
                                </span>
                                <div class="my-2">
                                    <span class="text-lg sm:text-xl font-black text-neutral-950 tracking-tight">
                                        {{ $drone->flight_time_min }} <span class="text-xs font-semibold text-neutral-500">Menit</span>
                                    </span>
                                    <span class="text-[11px] text-neutral-600 font-medium block truncate mt-0.5">
                                        Baterai Cerdas
                                    </span>
                                </div>
                                <span class="text-[10px] font-mono text-neutral-500 block truncate">
                                    {{ $specs['flight']['wind_resistance'] ?? 'Wind Resist Level 5' }}
                                </span>
                            </div>

                            <!-- Metric 3: Jarak Transmisi -->
                            <div class="rounded-xl bg-neutral-50 border border-neutral-200/80 p-4 flex flex-col justify-between hover:border-black/30 transition">
                                <span class="text-[10px] uppercase font-mono tracking-wider text-neutral-500 font-bold flex items-center gap-1.5">
                                    <span>📡</span> Jangkauan Sinyal
                                </span>
                                <div class="my-2">
                                    <span class="text-lg sm:text-xl font-black text-neutral-950 tracking-tight">
                                        {{ $drone->range_km }} <span class="text-xs font-semibold text-neutral-500">KM</span>
                                    </span>
                                    <span class="text-[11px] text-neutral-600 font-medium block truncate mt-0.5">
                                        DJI Transmission
                                    </span>
                                </div>
                                <span class="text-[10px] font-mono text-neutral-500 block truncate">
                                    Live View Rendah Latensi
                                </span>
                            </div>

                            <!-- Metric 4: Bobot & Regulasi -->
                            <div class="rounded-xl bg-neutral-50 border border-neutral-200/80 p-4 flex flex-col justify-between hover:border-black/30 transition">
                                <span class="text-[10px] uppercase font-mono tracking-wider text-neutral-500 font-bold flex items-center gap-1.5">
                                    <span>⚖️</span> Bobot Pesawat
                                </span>
                                <div class="my-2">
                                    <span class="text-lg sm:text-xl font-black text-neutral-950 tracking-tight">
                                        {{ $drone->weight_g }} <span class="text-xs font-semibold text-neutral-500">Gram</span>
                                    </span>
                                    <span class="text-[11px] text-neutral-600 font-medium block truncate mt-0.5">
                                        Takeoff Weight
                                    </span>
                                </div>
                                <span class="text-[10px] font-mono {{ $drone->weight_g < 250 ? 'text-emerald-700' : 'text-neutral-600' }} block truncate font-medium">
                                    {{ $drone->weight_g < 250 ? 'Bebas Izin Rekreasi' : 'Standar PM 37/2020' }}
                                </span>
                            </div>
                        </div>

                        <!-- Category Tab Switcher Pills -->
                        <div class="flex items-center gap-2 overflow-x-auto no-scrollbar pb-1 border-b border-neutral-200/80">
                            <button type="button" @click="activeSpecTab = 'camera'"
                                    :class="activeSpecTab === 'camera' ? 'bg-black text-white font-bold border-black shadow-sm' : 'bg-neutral-100 text-neutral-700 hover:text-black hover:bg-neutral-200 border-neutral-200'"
                                    class="px-3.5 py-2 rounded-lg text-xs font-mono transition border flex items-center gap-1.5 shrink-0">
                                <span>📷</span> Kamera &amp; Optik
                            </button>
                            <button type="button" @click="activeSpecTab = 'flight'"
                                    :class="activeSpecTab === 'flight' ? 'bg-black text-white font-bold border-black shadow-sm' : 'bg-neutral-100 text-neutral-700 hover:text-black hover:bg-neutral-200 border-neutral-200'"
                                    class="px-3.5 py-2 rounded-lg text-xs font-mono transition border flex items-center gap-1.5 shrink-0">
                                <span>✈️</span> Performa Terbang
                            </button>
                            <button type="button" @click="activeSpecTab = 'safety'"
                                    :class="activeSpecTab === 'safety' ? 'bg-black text-white font-bold border-black shadow-sm' : 'bg-neutral-100 text-neutral-700 hover:text-black hover:bg-neutral-200 border-neutral-200'"
                                    class="px-3.5 py-2 rounded-lg text-xs font-mono transition border flex items-center gap-1.5 shrink-0">
                                <span>🛡️</span> Sensor &amp; Keamanan
                            </button>
                            <button type="button" @click="activeSpecTab = 'hardware'"
                                    :class="activeSpecTab === 'hardware' ? 'bg-black text-white font-bold border-black shadow-sm' : 'bg-neutral-100 text-neutral-700 hover:text-black hover:bg-neutral-200 border-neutral-200'"
                                    class="px-3.5 py-2 rounded-lg text-xs font-mono transition border flex items-center gap-1.5 shrink-0">
                                <span>📦</span> Kelengkapan Sewa
                            </button>
                        </div>

                        <!-- Tab 1: Kamera & Optik (Clean Spacious Table) -->
                        <div x-show="activeSpecTab === 'camera'" class="rounded-xl border border-neutral-200/80 overflow-hidden bg-white shadow-xs">
                            <div class="divide-y divide-neutral-100">
                                <div class="py-3.5 px-5 sm:grid sm:grid-cols-3 sm:gap-4 hover:bg-neutral-50/70 transition items-center">
                                    <dt class="text-xs font-mono font-bold uppercase tracking-wider text-neutral-500">Sensor Gambar</dt>
                                    <dd class="mt-1 text-sm text-neutral-900 font-semibold sm:col-span-2 sm:mt-0">{{ $specs['camera']['sensor'] ?? $drone->camera }}</dd>
                                </div>
                                <div class="py-3.5 px-5 sm:grid sm:grid-cols-3 sm:gap-4 hover:bg-neutral-50/70 transition items-center">
                                    <dt class="text-xs font-mono font-bold uppercase tracking-wider text-neutral-500">Resolusi Video</dt>
                                    <dd class="mt-1 text-sm text-neutral-900 font-semibold sm:col-span-2 sm:mt-0">{{ $specs['camera']['video_res'] ?? '4K Ultra HD @ 60fps' }}</dd>
                                </div>
                                <div class="py-3.5 px-5 sm:grid sm:grid-cols-3 sm:gap-4 hover:bg-neutral-50/70 transition items-center">
                                    <dt class="text-xs font-mono font-bold uppercase tracking-wider text-neutral-500">Resolusi Foto</dt>
                                    <dd class="mt-1 text-sm text-neutral-900 font-semibold sm:col-span-2 sm:mt-0">{{ $specs['camera']['photo_res'] ?? 'Foto Resolusi Tinggi' }}</dd>
                                </div>
                                <div class="py-3.5 px-5 sm:grid sm:grid-cols-3 sm:gap-4 hover:bg-neutral-50/70 transition items-center">
                                    <dt class="text-xs font-mono font-bold uppercase tracking-wider text-neutral-500">Profil Warna &amp; HDR</dt>
                                    <dd class="mt-1 text-sm text-neutral-900 font-semibold sm:col-span-2 sm:mt-0">{{ $specs['camera']['color_profile'] ?? '10-bit D-Log M / HLG' }}</dd>
                                </div>
                                <div class="py-3.5 px-5 sm:grid sm:grid-cols-3 sm:gap-4 hover:bg-neutral-50/70 transition items-center">
                                    <dt class="text-xs font-mono font-bold uppercase tracking-wider text-neutral-500">Lensa &amp; Bukaan</dt>
                                    <dd class="mt-1 text-sm text-neutral-900 font-semibold sm:col-span-2 sm:mt-0">{{ $specs['camera']['lens_aperture'] ?? 'Lensa Kualitas Tinggi' }}</dd>
                                </div>
                                <div class="py-3.5 px-5 sm:grid sm:grid-cols-3 sm:gap-4 hover:bg-neutral-50/70 transition items-center">
                                    <dt class="text-xs font-mono font-bold uppercase tracking-wider text-neutral-500">Sistem Stabilisasi</dt>
                                    <dd class="mt-1 text-sm text-neutral-900 font-semibold sm:col-span-2 sm:mt-0">{{ $specs['camera']['stabilization'] ?? 'Gimbal Mekanikal 3-Axis' }}</dd>
                                </div>
                                <div class="py-3.5 px-5 sm:grid sm:grid-cols-3 sm:gap-4 hover:bg-neutral-50/70 transition items-center">
                                    <dt class="text-xs font-mono font-bold uppercase tracking-wider text-neutral-500">Rentang ISO</dt>
                                    <dd class="mt-1 text-sm font-mono text-neutral-900 sm:col-span-2 sm:mt-0">{{ $specs['camera']['iso_range'] ?? 'ISO 100 - 6400' }}</dd>
                                </div>
                            </div>
                        </div>

                        <!-- Tab 2: Performa Terbang (Clean Spacious Table) -->
                        <div x-show="activeSpecTab === 'flight'" class="rounded-xl border border-neutral-200/80 overflow-hidden bg-white shadow-xs">
                            <div class="divide-y divide-neutral-100">
                                <div class="py-3.5 px-5 sm:grid sm:grid-cols-3 sm:gap-4 hover:bg-neutral-50/70 transition items-center">
                                    <dt class="text-xs font-mono font-bold uppercase tracking-wider text-neutral-500">Durasi Terbang Maksimal</dt>
                                    <dd class="mt-1 text-sm text-neutral-900 font-semibold sm:col-span-2 sm:mt-0">{{ $specs['flight']['max_time'] ?? ($drone->flight_time_min . ' Menit') }}</dd>
                                </div>
                                <div class="py-3.5 px-5 sm:grid sm:grid-cols-3 sm:gap-4 hover:bg-neutral-50/70 transition items-center">
                                    <dt class="text-xs font-mono font-bold uppercase tracking-wider text-neutral-500">Jangkauan Transmisi Video</dt>
                                    <dd class="mt-1 text-sm text-neutral-900 font-semibold sm:col-span-2 sm:mt-0">{{ $specs['flight']['max_range'] ?? ($drone->range_km . ' KM') }}</dd>
                                </div>
                                <div class="py-3.5 px-5 sm:grid sm:grid-cols-3 sm:gap-4 hover:bg-neutral-50/70 transition items-center">
                                    <dt class="text-xs font-mono font-bold uppercase tracking-wider text-neutral-500">Ketahanan Terpaan Angin</dt>
                                    <dd class="mt-1 text-sm text-neutral-900 font-semibold sm:col-span-2 sm:mt-0">{{ $specs['flight']['wind_resistance'] ?? 'Level 5 (10.7 m/s)' }}</dd>
                                </div>
                                <div class="py-3.5 px-5 sm:grid sm:grid-cols-3 sm:gap-4 hover:bg-neutral-50/70 transition items-center">
                                    <dt class="text-xs font-mono font-bold uppercase tracking-wider text-neutral-500">Kecepatan Maksimal</dt>
                                    <dd class="mt-1 text-sm text-neutral-900 font-semibold sm:col-span-2 sm:mt-0">{{ $specs['flight']['max_speed'] ?? '16 m/s' }}</dd>
                                </div>
                                <div class="py-3.5 px-5 sm:grid sm:grid-cols-3 sm:gap-4 hover:bg-neutral-50/70 transition items-center">
                                    <dt class="text-xs font-mono font-bold uppercase tracking-wider text-neutral-500">Ketinggian Terbang Maksimal</dt>
                                    <dd class="mt-1 text-sm text-neutral-900 font-semibold sm:col-span-2 sm:mt-0">{{ $specs['flight']['max_altitude'] ?? '4.000 m dpl' }}</dd>
                                </div>
                                <div class="py-3.5 px-5 sm:grid sm:grid-cols-3 sm:gap-4 hover:bg-neutral-50/70 transition items-center">
                                    <dt class="text-xs font-mono font-bold uppercase tracking-wider text-neutral-500">Bobot Lepas Landas (MTOW)</dt>
                                    <dd class="mt-1 text-sm text-neutral-900 font-semibold sm:col-span-2 sm:mt-0">{{ $specs['flight']['weight'] ?? ($drone->weight_g . ' Gram') }}</dd>
                                </div>
                            </div>
                        </div>

                        <!-- Tab 3: Sensor & Keamanan (Clean Spacious Table) -->
                        <div x-show="activeSpecTab === 'safety'" class="rounded-xl border border-neutral-200/80 overflow-hidden bg-white shadow-xs">
                            <div class="divide-y divide-neutral-100">
                                <div class="py-3.5 px-5 sm:grid sm:grid-cols-3 sm:gap-4 hover:bg-neutral-50/70 transition items-center">
                                    <dt class="text-xs font-mono font-bold uppercase tracking-wider text-neutral-500">Penghindaran Rintangan</dt>
                                    <dd class="mt-1 text-sm text-neutral-900 font-semibold sm:col-span-2 sm:mt-0">{{ $specs['safety']['obstacle_sensing'] ?? 'Vision System & Deteksi Halangan' }}</dd>
                                </div>
                                <div class="py-3.5 px-5 sm:grid sm:grid-cols-3 sm:gap-4 hover:bg-neutral-50/70 transition items-center">
                                    <dt class="text-xs font-mono font-bold uppercase tracking-wider text-neutral-500">Pelacakan Cerdas (Tracking)</dt>
                                    <dd class="mt-1 text-sm text-neutral-900 font-semibold sm:col-span-2 sm:mt-0">{{ $specs['safety']['tracking'] ?? 'ActiveTrack & Subject Tracking' }}</dd>
                                </div>
                                <div class="py-3.5 px-5 sm:grid sm:grid-cols-3 sm:gap-4 hover:bg-neutral-50/70 transition items-center">
                                    <dt class="text-xs font-mono font-bold uppercase tracking-wider text-neutral-500">Satelit &amp; Akurasi Posisi</dt>
                                    <dd class="mt-1 text-sm text-neutral-900 font-semibold sm:col-span-2 sm:mt-0">{{ $specs['safety']['satellite'] ?? 'GPS + Galileo + BeiDou' }}</dd>
                                </div>
                                <div class="py-3.5 px-5 sm:grid sm:grid-cols-3 sm:gap-4 hover:bg-neutral-50/70 transition items-center">
                                    <dt class="text-xs font-mono font-bold uppercase tracking-wider text-neutral-500">Sistem Return to Home</dt>
                                    <dd class="mt-1 text-sm text-neutral-900 font-semibold sm:col-span-2 sm:mt-0">{{ $specs['safety']['rth'] ?? 'Advanced Smart RTH Otomatis' }}</dd>
                                </div>
                            </div>
                        </div>

                        <!-- Tab 4: Kelengkapan Sewa (In The Box Cards Grid) -->
                        <div x-show="activeSpecTab === 'hardware'" class="space-y-4">
                            <div class="rounded-xl border border-neutral-200/80 overflow-hidden bg-white shadow-xs">
                                <div class="divide-y divide-neutral-100">
                                    <div class="py-3.5 px-5 sm:grid sm:grid-cols-3 sm:gap-4 hover:bg-neutral-50/70 transition items-center">
                                        <dt class="text-xs font-mono font-bold uppercase tracking-wider text-neutral-500">Media Penyimpanan</dt>
                                        <dd class="mt-1 text-sm text-neutral-900 font-semibold sm:col-span-2 sm:mt-0">{{ $specs['hardware']['storage'] ?? 'Slot MicroSD UHS-I V30' }}</dd>
                                    </div>
                                    <div class="py-3.5 px-5 sm:grid sm:grid-cols-3 sm:gap-4 hover:bg-neutral-50/70 transition items-center">
                                        <dt class="text-xs font-mono font-bold uppercase tracking-wider text-neutral-500">Tipe &amp; Kapasitas Baterai</dt>
                                        <dd class="mt-1 text-sm text-neutral-900 font-semibold sm:col-span-2 sm:mt-0">{{ $specs['hardware']['battery'] ?? 'Intelligent Flight Battery' }}</dd>
                                    </div>
                                    <div class="py-3.5 px-5 sm:grid sm:grid-cols-3 sm:gap-4 hover:bg-neutral-50/70 transition items-center">
                                        <dt class="text-xs font-mono font-bold uppercase tracking-wider text-neutral-500">Remote Controller</dt>
                                        <dd class="mt-1 text-sm text-neutral-900 font-semibold sm:col-span-2 sm:mt-0">{{ $specs['hardware']['controller'] ?? 'DJI Remote Controller Resmi' }}</dd>
                                    </div>
                                </div>
                            </div>

                            <!-- Visual In The Box Checklist -->
                            <div class="p-5 rounded-xl bg-neutral-50/90 border border-neutral-200/80 mt-4">
                                <div class="flex items-center justify-between mb-4">
                                    <h4 class="text-xs uppercase font-bold text-neutral-900 tracking-wider flex items-center gap-2">
                                        <span class="h-2 w-2 rounded-full bg-black"></span>
                                        <span>Isi Paket Sewa Standar (In The Box Lengkap)</span>
                                    </h4>
                                    <span class="text-[10px] font-mono text-neutral-500 uppercase bg-white border border-neutral-200 px-2 py-0.5 rounded">Siap Terbang</span>
                                </div>
                                
                                @php
                                    $inTheBoxItems = $specs['in_the_box'] ?? [
                                        '1x Unit Drone ' . $drone->name,
                                        '1x DJI Remote Controller (RC)',
                                        '2x Intelligent Flight Battery',
                                        '1x Two-Way Charging Hub',
                                        '1x Set ND Filter Profesional',
                                        '1x Waterproof Hard Case'
                                    ];
                                @endphp
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                    @foreach ($inTheBoxItems as $boxItem)
                                        <div class="flex items-center gap-3 p-3 rounded-lg bg-white border border-neutral-200/70 text-xs shadow-2xs">
                                            <div class="h-6 w-6 rounded-md bg-black text-white flex items-center justify-center shrink-0 text-[10px] font-bold">
                                                ✓
                                            </div>
                                            <span class="text-neutral-800 font-medium">{{ $boxItem }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Aturan Sewa & Tanggung Jawab Card -->
                    <div class="rounded-2xl bg-white border border-neutral-200/80 p-6 shadow-sm space-y-3">
                        <h3 class="text-xs uppercase font-mono font-bold tracking-wider text-neutral-900 flex items-center gap-2">
                            <span>🛡️</span>
                            <span>Ketentuan Sewa &amp; SOP Keamanan Operasional</span>
                        </h3>
                        <ul class="text-xs text-neutral-600 space-y-2 leading-relaxed font-light list-disc list-inside">
                            <li>Wajib menitipkan KTP/SIM asli atau deposit uang saat serah terima unit di lokasi.</li>
                            <li>Keterlambatan pengembalian unit dikenakan penyesuaian denda 50%/jam, maksimal 1x tarif harian.</li>
                            <li>Kerusakan operasional ditanggung penyewa sesuai estimasi spare-part resmi DJI. Nilai unit baru: <x-price :amount="$drone->replacement_value ?? 0" class="text-neutral-900 font-bold" />.</li>
                            @if ($drone->weight_g >= 250)
                                <li class="text-neutral-800 font-medium">Unit berbobot di atas 249g tunduk pada Permenhub PM 37/2020 untuk penerbangan komersial berlisensi.</li>
                            @endif
                        </ul>
                    </div>
                </div>

                <!-- Right Column: Sticky Booking & Availability Card -->
                <div id="booking-section" class="sticky top-28 min-w-0">
                    <div class="rounded-2xl bg-white border border-neutral-200/80 p-6 sm:p-8 shadow-[0_4px_24px_-6px_rgba(0,0,0,0.05)]">
                        <div class="flex items-baseline justify-between border-b border-neutral-200 pb-5">
                            <div>
                                <span class="text-[10px] tracking-widest text-neutral-500 uppercase block font-medium">Tarif Sewa Harian</span>
                                <div class="text-3xl font-extrabold text-neutral-950 tracking-tight mt-1">
                                    Rp{{ number_format((float) $drone->daily_rate, 0, ',', '.') }}
                                    <span class="text-xs text-neutral-500 font-normal">/ hari</span>
                                </div>
                            </div>
                            @if ($drone->weekly_rate)
                                <div class="text-right">
                                    <span class="text-[10px] tracking-widest text-neutral-500 uppercase block font-semibold">Paket Mingguan</span>
                                    <span class="text-sm font-bold text-neutral-900">Rp{{ number_format((float) $drone->weekly_rate, 0, ',', '.') }}</span>
                                </div>
                            @endif
                        </div>

                        <form action="{{ route('bookings.create', $drone) }}" method="GET" class="mt-6 space-y-4">
                            <div>
                                <label class="block text-xs font-semibold text-neutral-700 uppercase tracking-wider mb-2">Tanggal Mulai Sewa</label>
                                <input type="date" name="start_date" required min="{{ now()->toDateString() }}"
                                       class="w-full rounded-lg bg-white border border-neutral-300 px-3.5 py-3 text-sm text-neutral-900 focus:border-black focus:outline-none focus:ring-1 focus:ring-black transition shadow-sm">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-neutral-700 uppercase tracking-wider mb-2">Tanggal Selesai Sewa</label>
                                <input type="date" name="end_date" required min="{{ now()->toDateString() }}"
                                       class="w-full rounded-lg bg-white border border-neutral-300 px-3.5 py-3 text-sm text-neutral-900 focus:border-black focus:outline-none focus:ring-1 focus:ring-black transition shadow-sm">
                            </div>

                            <div class="pt-2">
                                <button type="submit" class="w-full rounded-lg bg-black hover:bg-neutral-800 text-white font-extrabold py-3.5 px-4 text-xs uppercase tracking-wider transition shadow-lg border border-black flex items-center justify-center gap-2">
                                    <span>Cek ketersediaan &amp; Pesan</span> &rarr;
                                </button>
                            </div>
                        </form>

                        <div class="mt-6 pt-5 border-t border-neutral-200 text-[11px] text-neutral-600 space-y-2">
                            <div class="flex items-center gap-2">
                                <svg class="h-4 w-4 text-black shrink-0" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                                <span>Pembayaran instan otomatis via Midtrans (QRIS/VA)</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <svg class="h-4 w-4 text-black shrink-0" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                                <span>E-Invoice sah diterbitkan seketika dengan QR verifikasi</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Three.js + DRACOLoader + GLTFLoader Engine Scripts -->
    <script src="{{ asset('js/three/three.min.js') }}" onerror="this.onerror=null;this.src='https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js'"></script>
    <script src="{{ asset('js/three/OrbitControls.js') }}" onerror="this.onerror=null;this.src='https://cdn.jsdelivr.net/npm/three@0.128.0/examples/js/controls/OrbitControls.js'"></script>
    <script src="{{ asset('js/three/DRACOLoader.js') }}" onerror="this.onerror=null;this.src='https://cdn.jsdelivr.net/npm/three@0.128.0/examples/js/loaders/DRACOLoader.js'"></script>
    <script src="{{ asset('js/three/GLTFLoader.js') }}" onerror="this.onerror=null;this.src='https://cdn.jsdelivr.net/npm/three@0.128.0/examples/js/loaders/GLTFLoader.js'"></script>

    <script>
        // Setup Photo Viewport Zoom & Pan Interaction (Smooth inspect & pan, zero unwanted slide switching)
        (function() {
            function initPhotoViewerInteractions() {
                const stage = document.getElementById('turntable-viewport');
                const img = document.getElementById('turntable-image');
                if (!stage || !img) return;

                // Initial cursor
                stage.style.cursor = 'zoom-in';

                // 1. Mouse wheel zoom in / out
                stage.addEventListener('wheel', (e) => {
                    e.preventDefault();
                    const delta = e.deltaY < 0 ? 0.25 : -0.25;
                    const newScale = window.photoZoom.scale + delta;
                    window.photoZoom.zoomTo(newScale, true);
                }, { passive: false });

                // 2. Double click to toggle zoom
                stage.addEventListener('dblclick', (e) => {
                    e.preventDefault();
                    window.photoZoom.toggle();
                });

                // 3. Pointer drag to pan when zoomed
                let isDown = false;
                let startX = 0;
                let startY = 0;
                let initialPanX = 0;
                let initialPanY = 0;
                let hasMoved = false;

                stage.addEventListener('pointerdown', (e) => {
                    // Stop autoplay if running
                    if (window.turntableAutoPlayTimer) {
                        window.toggleTurntableAutoPlay();
                    }

                    isDown = true;
                    hasMoved = false;
                    startX = e.clientX;
                    startY = e.clientY;
                    initialPanX = window.photoZoom.panX;
                    initialPanY = window.photoZoom.panY;

                    if (window.photoZoom.scale > 1) {
                        window.photoZoom.isPanning = true;
                        stage.style.cursor = 'grabbing';
                        try { stage.setPointerCapture(e.pointerId); } catch(err) {}
                    }
                });

                stage.addEventListener('pointermove', (e) => {
                    if (!isDown) return;
                    const dx = e.clientX - startX;
                    const dy = e.clientY - startY;

                    if (Math.abs(dx) > 3 || Math.abs(dy) > 3) {
                        hasMoved = true;
                    }

                    if (window.photoZoom.scale > 1) {
                        window.photoZoom.panX = initialPanX + dx;
                        window.photoZoom.panY = initialPanY + dy;
                        window.photoZoom.clampPan();
                        window.photoZoom.apply(false); // Smooth direct panning
                    }
                });

                const endDrag = (e) => {
                    if (!isDown) return;
                    isDown = false;
                    window.photoZoom.isPanning = false;
                    try { stage.releasePointerCapture(e.pointerId); } catch(err) {}

                    if (window.photoZoom.scale > 1) {
                        stage.style.cursor = 'grab';
                    } else {
                        stage.style.cursor = 'zoom-in';
                        // If it was a simple click on 1x without dragging, zoom in to 2x!
                        if (!hasMoved && (e.type === 'pointerup' || e.type === 'mouseup')) {
                            window.photoZoom.zoomTo(2, true);
                        }
                    }
                };

                stage.addEventListener('pointerup', endDrag);
                stage.addEventListener('pointercancel', endDrag);
            }

            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', initPhotoViewerInteractions);
            } else {
                initPhotoViewerInteractions();
            }
        })();

        // Three.js 3D WebGL Engine with DRACOLoader Support
        (function() {
            const model3dUrl = @json($model3d ? asset(ltrim($model3d, '/')) : null);
            let scene, camera, renderer, controls;
            let spinningRotors = [];
            let allDroneMeshes = [];
            let isWireframeActive = false;
            let isRotorSpinning = true;
            let rotorSpeed = 0.38;
            let isInitialized = false;

            window.initThreeEngine = function() {
                if (isInitialized) return;
                if (typeof THREE === 'undefined' || typeof THREE.OrbitControls === 'undefined') {
                    setTimeout(window.initThreeEngine, 60);
                    return;
                }

                const canvas = document.getElementById('drone-webgl-canvas');
                const container = document.getElementById('canvas-wrapper');
                if (!canvas || !container) return;
                isInitialized = true;

                // 1. Scene
                scene = new THREE.Scene();

                // 2. Camera
                camera = new THREE.PerspectiveCamera(40, container.clientWidth / container.clientHeight, 0.1, 100);
                camera.position.set(0, 1.4, 3.8);

                // 3. Renderer
                renderer = new THREE.WebGLRenderer({
                    canvas: canvas,
                    antialias: true,
                    alpha: true,
                    powerPreference: 'high-performance'
                });
                renderer.setSize(container.clientWidth, container.clientHeight);
                renderer.setPixelRatio(Math.min(window.devicePixelRatio, 2));
                renderer.shadowMap.enabled = true;
                renderer.shadowMap.type = THREE.PCFSoftShadowMap;
                renderer.toneMapping = THREE.ACESFilmicToneMapping;
                renderer.toneMappingExposure = 1.15;

                // 4. OrbitControls
                controls = new THREE.OrbitControls(camera, renderer.domElement);
                controls.enableDamping = true;
                controls.dampingFactor = 0.05;
                controls.minDistance = 1.6;
                controls.maxDistance = 8.0;
                controls.maxPolarAngle = Math.PI / 2 + 0.16;
                controls.minPolarAngle = 0.06;
                controls.autoRotate = false;
                controls.autoRotateSpeed = 2.0;
                controls.target.set(0, 0, 0);

                const dragHint = document.getElementById('webgl-drag-hint');
                controls.addEventListener('start', () => {
                    if (dragHint) {
                        dragHint.style.opacity = '0';
                        setTimeout(() => dragHint.style.display = 'none', 300);
                    }
                });

                // 5. Lighting
                const ambientLight = new THREE.AmbientLight(0xffffff, 0.9);
                scene.add(ambientLight);

                const keyLight = new THREE.DirectionalLight(0xffffff, 1.4);
                keyLight.position.set(5, 7, 5);
                keyLight.castShadow = true;
                keyLight.shadow.mapSize.width = 1024;
                keyLight.shadow.mapSize.height = 1024;
                keyLight.shadow.bias = -0.0005;
                scene.add(keyLight);

                const fillLight = new THREE.DirectionalLight(0x94a3b8, 0.6);
                fillLight.position.set(-5, 4, -3);
                scene.add(fillLight);

                const rimLight = new THREE.PointLight(0xffffff, 1.2, 12);
                rimLight.position.set(0, 0.2, -3.2);
                scene.add(rimLight);

                // 6. Pedestal & Compass Rings
                const pedestalGroup = new THREE.Group();
                pedestalGroup.position.y = -0.85;

                const shadowPlaneGeo = new THREE.PlaneGeometry(8, 8);
                const shadowPlaneMat = new THREE.ShadowMaterial({ opacity: 0.18 });
                const shadowPlane = new THREE.Mesh(shadowPlaneGeo, shadowPlaneMat);
                shadowPlane.rotation.x = -Math.PI / 2;
                shadowPlane.receiveShadow = true;
                pedestalGroup.add(shadowPlane);

                function makeRing(inner, outer, color, opacity) {
                    const geo = new THREE.RingGeometry(inner, outer, 64);
                    const mat = new THREE.MeshBasicMaterial({ color: color, transparent: true, opacity: opacity, side: THREE.DoubleSide });
                    const ring = new THREE.Mesh(geo, mat);
                    ring.rotation.x = -Math.PI / 2;
                    ring.position.y = 0.002;
                    return ring;
                }
                pedestalGroup.add(makeRing(2.18, 2.22, 0x111111, 0.22));
                pedestalGroup.add(makeRing(1.58, 1.60, 0x111111, 0.14));
                pedestalGroup.add(makeRing(0.78, 0.80, 0x111111, 0.10));

                const gridMat = new THREE.LineBasicMaterial({ color: 0x111111, transparent: true, opacity: 0.12 });
                const gridPoints = [
                    new THREE.Vector3(0, 0.003, -2.25), new THREE.Vector3(0, 0.003, 2.25),
                    new THREE.Vector3(-2.25, 0.003, 0), new THREE.Vector3(2.25, 0.003, 0)
                ];
                const gridGeo = new THREE.BufferGeometry().setFromPoints(gridPoints);
                pedestalGroup.add(new THREE.LineSegments(gridGeo, gridMat));
                scene.add(pedestalGroup);

                // 7. Drone Container & GLB Loading
                const droneRoot = new THREE.Group();
                scene.add(droneRoot);

                // Build Sleek Procedural DJI Drone Fallback
                function buildProceduralDJIDrone() {
                    const group = new THREE.Group();
                    const bodyMat = new THREE.MeshStandardMaterial({ color: 0xd1d5db, metalness: 0.4, roughness: 0.3 });
                    const darkMat = new THREE.MeshStandardMaterial({ color: 0x1f2937, metalness: 0.7, roughness: 0.35 });
                    const motorMat = new THREE.MeshStandardMaterial({ color: 0x9ca3af, metalness: 0.9, roughness: 0.2 });
                    const bladeMat = new THREE.MeshStandardMaterial({ color: 0x111827, metalness: 0.5, roughness: 0.4 });
                    const tipMat = new THREE.MeshStandardMaterial({ color: 0xf97316, metalness: 0.3, roughness: 0.4 });
                    const lensMat = new THREE.MeshPhysicalMaterial({ color: 0x051a30, metalness: 0.9, roughness: 0.05, reflectivity: 0.9, clearcoat: 1.0 });

                    // Aerodynamic DJI-Style Fuselage
                    const bodyGeo = new THREE.CylinderGeometry(0.35, 0.32, 1.1, 24);
                    bodyGeo.rotateX(Math.PI / 2);
                    const body = new THREE.Mesh(bodyGeo, bodyMat);
                    body.scale.set(0.9, 0.45, 1.0);
                    body.castShadow = true;
                    group.add(body);
                    allDroneMeshes.push(body);

                    // Obstacle Sensors (Front Eyes)
                    const eyeGeo = new THREE.SphereGeometry(0.045, 16, 16);
                    const eyeL = new THREE.Mesh(eyeGeo, lensMat);
                    eyeL.position.set(-0.16, 0.06, -0.55);
                    const eyeR = new THREE.Mesh(eyeGeo, lensMat);
                    eyeR.position.set(0.16, 0.06, -0.55);
                    group.add(eyeL, eyeR);

                    // 3-Axis Gimbal & Camera Lens
                    const gimbalGeo = new THREE.BoxGeometry(0.24, 0.22, 0.25);
                    const gimbal = new THREE.Mesh(gimbalGeo, darkMat);
                    gimbal.position.set(0, -0.16, -0.42);
                    gimbal.castShadow = true;
                    group.add(gimbal);
                    allDroneMeshes.push(gimbal);

                    const lensGeo = new THREE.CylinderGeometry(0.08, 0.08, 0.08, 20);
                    lensGeo.rotateX(Math.PI / 2);
                    const lens = new THREE.Mesh(lensGeo, motorMat);
                    lens.position.set(0, -0.16, -0.55);
                    group.add(lens);

                    // 4 Foldable Aerodynamic Arms
                    const armConfigs = [
                        { x: 0.92, z: -0.75, isFront: true },
                        { x: -0.92, z: -0.75, isFront: true },
                        { x: 0.98, z: 0.75, isFront: false },
                        { x: -0.98, z: 0.75, isFront: false }
                    ];

                    armConfigs.forEach((cfg, idx) => {
                        const len = Math.hypot(cfg.x, cfg.z) * 0.85;
                        const armGeo = new THREE.CylinderGeometry(0.04, 0.035, len, 12);
                        armGeo.rotateZ(Math.PI / 2);
                        const arm = new THREE.Mesh(armGeo, bodyMat);
                        arm.position.set(cfg.x * 0.5, 0.02, cfg.z * 0.5);
                        arm.rotation.y = -Math.atan2(cfg.z, cfg.x);
                        arm.castShadow = true;
                        group.add(arm);
                        allDroneMeshes.push(arm);

                        // Brushless Motor
                        const mGeo = new THREE.CylinderGeometry(0.1, 0.1, 0.1, 16);
                        const motor = new THREE.Mesh(mGeo, motorMat);
                        motor.position.set(cfg.x, 0.08, cfg.z);
                        motor.castShadow = true;
                        group.add(motor);

                        // Propeller Hub & Blades
                        const pivot = new THREE.Group();
                        pivot.position.set(cfg.x, 0.15, cfg.z);

                        const bGeo = new THREE.BoxGeometry(0.66, 0.012, 0.07);
                        const blade = new THREE.Mesh(bGeo, bladeMat);
                        blade.castShadow = true;
                        pivot.add(blade);

                        const tipL = new THREE.Mesh(new THREE.BoxGeometry(0.09, 0.014, 0.072), tipMat);
                        tipL.position.set(-0.28, 0, 0);
                        pivot.add(tipL);
                        const tipR = new THREE.Mesh(new THREE.BoxGeometry(0.09, 0.014, 0.072), tipMat);
                        tipR.position.set(0.28, 0, 0);
                        pivot.add(tipR);

                        group.add(pivot);
                        spinningRotors.push({ pivot: pivot, dir: (idx % 2 === 0 ? 1 : -1) });
                    });

                    return group;
                }

                const proceduralDrone = buildProceduralDJIDrone();
                droneRoot.add(proceduralDrone);

                // Load GLB with DRACOLoader
                const loaderOverlay = document.getElementById('webgl-loader');
                if (model3dUrl && typeof THREE.GLTFLoader !== 'undefined') {
                    const loader = new THREE.GLTFLoader();
                    if (typeof THREE.DRACOLoader !== 'undefined') {
                        const dracoLoader = new THREE.DRACOLoader();
                        dracoLoader.setDecoderPath('{{ asset('js/three/draco') }}/');
                        loader.setDRACOLoader(dracoLoader);
                    }

                    loader.load(model3dUrl, (gltf) => {
                        const glbModel = gltf.scene;
                        const box = new THREE.Box3().setFromObject(glbModel);
                        const center = box.getCenter(new THREE.Vector3());
                        const size = box.getSize(new THREE.Vector3());
                        const maxDim = Math.max(size.x, size.y, size.z) || 1;
                        const scale = 2.8 / maxDim;

                        glbModel.scale.set(scale, scale, scale);
                        glbModel.position.set(-center.x * scale, -center.y * scale, -center.z * scale);

                        const glbRotors = [];
                        glbModel.traverse((child) => {
                            if (child.isMesh) {
                                child.castShadow = true;
                                child.receiveShadow = true;
                                allDroneMeshes.push(child);
                                const n = (child.name || '').toLowerCase();
                                if (n.includes('circle') || n.includes('prop') || n.includes('rotor') || n.includes('blade')) {
                                    glbRotors.push({ pivot: child, dir: (glbRotors.length % 2 === 0 ? 1 : -1) });
                                }
                            }
                        });

                        droneRoot.remove(proceduralDrone);
                        droneRoot.add(glbModel);
                        if (glbRotors.length > 0) {
                            spinningRotors = glbRotors;
                        }

                        if (loaderOverlay) {
                            loaderOverlay.style.opacity = '0';
                            setTimeout(() => loaderOverlay.style.display = 'none', 400);
                        }
                    }, undefined, (err) => {
                        console.info('Using optimized procedural DJI model for 3D simulation.');
                        if (loaderOverlay) {
                            loaderOverlay.style.opacity = '0';
                            setTimeout(() => loaderOverlay.style.display = 'none', 400);
                        }
                    });
                } else {
                    if (loaderOverlay) {
                        loaderOverlay.style.opacity = '0';
                        setTimeout(() => loaderOverlay.style.display = 'none', 400);
                    }
                }

                // Animation Loop
                function animate() {
                    requestAnimationFrame(animate);

                    if (isRotorSpinning && spinningRotors.length > 0) {
                        spinningRotors.forEach(r => {
                            r.pivot.rotation.y += r.dir * rotorSpeed;
                        });
                    }

                    controls.update();

                    if (window.activeViewerMode === '3d') {
                        const azRad = controls.getAzimuthalAngle();
                        const azDeg = Math.round((azRad * (180 / Math.PI) + 360) % 360);
                        const polarRad = controls.getPolarAngle();
                        const polarDeg = Math.round(polarRad * (180 / Math.PI));
                        const pitchDeg = 90 - polarDeg;
                        const dist = camera.position.distanceTo(controls.target).toFixed(1);

                        const hudAz = document.getElementById('hud-azimuth');
                        const hudCard = document.getElementById('hud-cardinal');
                        const hudPitch = document.getElementById('hud-pitch');
                        const hudZoom = document.getElementById('hud-zoom');

                        if (hudAz) hudAz.textContent = String(azDeg).padStart(3, '0') + '°';
                        if (hudCard) hudCard.textContent = getCardinalLabel(azDeg);
                        if (hudPitch) hudPitch.textContent = (pitchDeg >= 0 ? '+' : '') + pitchDeg + '°';
                        if (hudZoom) hudZoom.textContent = dist + 'm';
                    }

                    renderer.render(scene, camera);
                }
                animate();

                // 3D Controls
                window.toggleAutoRotate = function() {
                    controls.autoRotate = !controls.autoRotate;
                    const btn = document.getElementById('btn-auto-rotate');
                    const icon = document.getElementById('rotate-icon');
                    const text = document.getElementById('rotate-text');
                    if (controls.autoRotate) {
                        if (icon) icon.textContent = '⏸';
                        if (text) text.textContent = 'Jeda Orbit';
                        if (btn) btn.classList.add('bg-white', 'text-black', 'border-white');
                    } else {
                        if (icon) icon.textContent = '▶';
                        if (text) text.textContent = 'Putar 360°';
                        if (btn) btn.classList.remove('bg-white', 'text-black', 'border-white');
                    }
                };

                window.toggleRotorSpin = function() {
                    isRotorSpinning = !isRotorSpinning;
                    const btn = document.getElementById('btn-rotor-spin');
                    const icon = document.getElementById('rotor-icon');
                    const text = document.getElementById('rotor-text');
                    if (isRotorSpinning) {
                        if (text) text.textContent = 'Baling-Baling: Aktif';
                        if (icon) icon.classList.add('animate-spin');
                        if (btn) btn.className = 'px-2.5 py-1 rounded-lg text-[11px] font-mono bg-white border border-white text-black transition flex items-center gap-1.5 shadow-sm';
                    } else {
                        if (text) text.textContent = 'Baling-Baling: Mati';
                        if (icon) icon.classList.remove('animate-spin');
                        if (btn) btn.className = 'px-2.5 py-1 rounded-lg text-[11px] font-mono bg-white/5 hover:bg-white/10 border border-white/15 text-neutral-300 transition flex items-center gap-1.5 shadow-sm';
                    }
                };

                window.toggleWireframe = function() {
                    isWireframeActive = !isWireframeActive;
                    allDroneMeshes.forEach(m => {
                        if (m && m.material) {
                            if (Array.isArray(m.material)) {
                                m.material.forEach(mat => mat.wireframe = isWireframeActive);
                            } else {
                                m.material.wireframe = isWireframeActive;
                            }
                        }
                    });
                    const btn = document.getElementById('btn-wireframe');
                    const text = document.getElementById('wireframe-text');
                    if (isWireframeActive) {
                        if (text) text.textContent = 'Wireframe: ON';
                        if (btn) btn.classList.add('bg-white', 'text-black', 'border-white');
                    } else {
                        if (text) text.textContent = 'Wireframe: Off';
                        if (btn) btn.classList.remove('bg-white', 'text-black', 'border-white');
                    }
                };

                let cameraLerpRaf = null;
                window.setCameraPreset = function(name) {
                    if (cameraLerpRaf) cancelAnimationFrame(cameraLerpRaf);
                    let targetPos = new THREE.Vector3(0, 1.4, 3.8);
                    let targetLook = new THREE.Vector3(0, 0, 0);

                    switch(name) {
                        case 'perspective': targetPos.set(2.4, 1.5, 2.8); break;
                        case 'front': targetPos.set(0, 0.25, 3.6); break;
                        case 'top': targetPos.set(0, 4.0, 0.05); break;
                        case 'side': targetPos.set(3.6, 0.25, 0); break;
                        case 'gimbal': targetPos.set(0, -0.4, 1.5); targetLook.set(0, -0.2, 0.4); break;
                    }

                    const startPos = camera.position.clone();
                    const startTarget = controls.target.clone();
                    const startTime = performance.now();
                    const duration = 500;

                    function step(now) {
                        const elapsed = now - startTime;
                        const progress = Math.min(1, elapsed / duration);
                        const ease = 1 - Math.pow(1 - progress, 3);
                        camera.position.lerpVectors(startPos, targetPos, ease);
                        controls.target.lerpVectors(startTarget, targetLook, ease);
                        if (progress < 1) cameraLerpRaf = requestAnimationFrame(step);
                    }
                    cameraLerpRaf = requestAnimationFrame(step);
                };

                window.reset3DCamera = function() {
                    if (controls.autoRotate) window.toggleAutoRotate();
                    window.setCameraPreset('perspective');
                };

                window.drone3DResize = function() {
                    if (!container || !renderer || !camera) return;
                    const w = container.clientWidth;
                    const h = container.clientHeight;
                    if (w === 0 || h === 0) return;
                    camera.aspect = w / h;
                    camera.updateProjectionMatrix();
                    renderer.setSize(w, h);
                };

                window.addEventListener('resize', window.drone3DResize);
            };
        })();
    </script>
@endsection
