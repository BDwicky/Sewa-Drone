<nav x-data="{ open: false }" class="bg-black/95 backdrop-blur border-b border-white/10 sticky top-0 z-40">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center gap-8">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('admin.bookings.index') }}" class="flex items-center gap-2.5 group">
                        <x-application-logo class="h-9 w-9 rounded-lg shadow-sm group-hover:scale-105 transition-transform shrink-0" />
                        <div class="flex flex-col">
                            <span class="font-black text-sm tracking-wider text-white">SEWA<span class="text-neutral-400">DRONE</span></span>
                            <span class="text-[9px] font-bold tracking-widest text-neutral-400 uppercase">COMMAND PORTAL</span>
                        </div>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden sm:-my-px sm:flex sm:items-center sm:gap-2">
                    <x-nav-link :href="route('admin.bookings.index')" :active="request()->routeIs('admin.bookings.*')">
                        <svg class="w-4 h-4 me-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                        </svg>
                        {{ __('Pesanan & Booking') }}
                    </x-nav-link>

                    <x-nav-link :href="route('admin.drones.index')" :active="request()->routeIs('admin.drones.*')">
                        <svg class="w-4 h-4 me-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                        </svg>
                        {{ __('Armada Drone') }}
                    </x-nav-link>
                </div>
            </div>

            <!-- Right Controls: View Storefront & User Profile Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:gap-3">
                <a href="{{ route('home') }}" target="_blank"
                   class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg border border-white/15 bg-white/5 text-xs font-medium text-neutral-300 hover:text-white hover:border-white hover:bg-white/10 transition shadow-sm">
                    <span>Lihat Toko</span>
                    <svg class="w-3.5 h-3.5 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                    </svg>
                </a>

                <x-dropdown align="right" width="48" contentClasses="py-1 bg-neutral-950 border border-white/15 shadow-2xl rounded-xl">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center gap-2 px-3 py-1.5 border border-white/15 rounded-lg text-sm font-medium text-neutral-300 bg-black hover:bg-white/5 hover:text-white focus:outline-none transition">
                            <div class="h-6 w-6 rounded-full bg-white/10 border border-white/20 flex items-center justify-center text-xs font-bold text-white">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>
                            <div class="text-xs font-semibold text-neutral-200">{{ Auth::user()->name }}</div>
                            <svg class="fill-current h-3.5 w-3.5 text-neutral-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <div class="px-4 py-2.5 border-b border-white/10">
                            <div class="font-semibold text-xs text-white">{{ Auth::user()->name }}</div>
                            <div class="text-[11px] text-neutral-400 truncate">{{ Auth::user()->email }}</div>
                        </div>

                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profil Pengguna') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault(); this.closest('form').submit();"
                                    class="text-red-400 hover:text-red-300 hover:bg-red-500/10">
                                {{ __('Keluar (Log Out)') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger (Mobile) -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-neutral-400 hover:text-white hover:bg-white/10 focus:outline-none transition">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu (Mobile) -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden border-b border-white/10 bg-black">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('admin.bookings.index')" :active="request()->routeIs('admin.bookings.*')">
                {{ __('Pesanan & Booking') }}
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('admin.drones.index')" :active="request()->routeIs('admin.drones.*')">
                {{ __('Armada Drone') }}
            </x-responsive-nav-link>

            <a href="{{ route('home') }}" target="_blank" class="block w-full ps-3 pe-4 py-2 border-l-4 border-transparent text-start text-base font-medium text-slate-400 hover:text-slate-100 hover:bg-slate-800/60">
                {{ __('Lihat Toko (Website) ↗') }}
            </a>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-3 border-t border-slate-800/80">
            <div class="px-4">
                <div class="font-semibold text-sm text-white">{{ Auth::user()->name }}</div>
                <div class="font-medium text-xs text-slate-400">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profil Pengguna') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault(); this.closest('form').submit();"
                            class="text-red-400">
                        {{ __('Keluar (Log Out)') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
