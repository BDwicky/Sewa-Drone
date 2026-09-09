<x-app-layout>
    <x-slot name="header">
        <h1 class="font-extrabold text-2xl text-white tracking-tight">
            {{ __('Profil Pengguna & Keamanan') }}
        </h1>
        <p class="text-xs text-slate-400 mt-1">Kelola data login, email administrator, dan kata sandi akun.</p>
    </x-slot>

    <div class="py-8 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
        <div class="p-6 sm:p-8 bg-[#0F172A]/90 border border-slate-800/90 shadow-xl backdrop-blur rounded-2xl">
            <div class="max-w-xl">
                @include('profile.partials.update-profile-information-form')
            </div>
        </div>

        <div class="p-6 sm:p-8 bg-[#0F172A]/90 border border-slate-800/90 shadow-xl backdrop-blur rounded-2xl">
            <div class="max-w-xl">
                @include('profile.partials.update-password-form')
            </div>
        </div>

        <div class="p-6 sm:p-8 bg-[#0F172A]/90 border border-slate-800/90 shadow-xl backdrop-blur rounded-2xl">
            <div class="max-w-xl">
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>
</x-app-layout>
