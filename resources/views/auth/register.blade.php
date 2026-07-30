<x-guest-layout>
    <div class="mb-6 text-center">
        <h2 class="text-2xl font-black text-slate-800">Buat Akun Baru</h2>
        <p class="text-sm font-medium text-slate-500 mt-1">Daftar sekarang untuk mulai memesan tiket event.</p>
    </div>

    <!-- Google Register Button -->
    <a href="{{ route('google.redirect') }}"
       class="w-full flex items-center justify-center gap-3 border border-slate-200 bg-white hover:bg-slate-50 text-slate-700 font-semibold py-3 px-4 rounded-xl shadow-sm transition active:scale-[0.98]">
        <img src="https://www.svgrepo.com/show/475656/google-color.svg" class="w-5 h-5" alt="Google Logo">
        <span class="text-sm">Register dengan Google</span>
    </a>

    <!-- Divider -->
    <div class="my-6 flex items-center">
        <div class="flex-1 border-t border-slate-200"></div>
        <span class="px-4 text-xs font-bold text-slate-400 uppercase tracking-wider">atau daftar email</span>
        <div class="flex-1 border-t border-slate-200"></div>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Nama Lengkap')" class="text-xs font-bold text-slate-600 uppercase tracking-wider mb-1" />
            <x-text-input 
                id="name" 
                class="block w-full px-4 py-2.5 rounded-xl border-slate-200 focus:border-indigo-500 focus:ring-indigo-500 text-sm font-medium text-slate-800 placeholder:text-slate-300"
                type="text"
                name="name"
                :value="old('name')"
                placeholder="Masukkan nama lengkap"
                required
                autofocus />
            <x-input-error :messages="$errors->get('name')" class="mt-1.5 text-xs font-semibold text-rose-500" />
        </div>

        <!-- Email -->
        <div>
            <x-input-label for="email" :value="__('Email')" class="text-xs font-bold text-slate-600 uppercase tracking-wider mb-1" />
            <x-text-input 
                id="email"
                class="block w-full px-4 py-2.5 rounded-xl border-slate-200 focus:border-indigo-500 focus:ring-indigo-500 text-sm font-medium text-slate-800 placeholder:text-slate-300"
                type="email"
                name="email"
                :value="old('email')"
                placeholder="nama@email.com"
                required />
            <x-input-error :messages="$errors->get('email')" class="mt-1.5 text-xs font-semibold text-rose-500" />
        </div>

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Password')" class="text-xs font-bold text-slate-600 uppercase tracking-wider mb-1" />
            <x-text-input
                id="password"
                class="block w-full px-4 py-2.5 rounded-xl border-slate-200 focus:border-indigo-500 focus:ring-indigo-500 text-sm font-medium text-slate-800 placeholder:text-slate-300"
                type="password"
                name="password"
                placeholder="••••••••"
                required />
            <x-input-error :messages="$errors->get('password')" class="mt-1.5 text-xs font-semibold text-rose-500" />
        </div>

        <!-- Confirm Password -->
        <div>
            <x-input-label for="password_confirmation" :value="__('Konfirmasi Password')" class="text-xs font-bold text-slate-600 uppercase tracking-wider mb-1" />
            <x-text-input
                id="password_confirmation"
                class="block w-full px-4 py-2.5 rounded-xl border-slate-200 focus:border-indigo-500 focus:ring-indigo-500 text-sm font-medium text-slate-800 placeholder:text-slate-300"
                type="password"
                name="password_confirmation"
                placeholder="••••••••"
                required />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1.5 text-xs font-semibold text-rose-500" />
        </div>

        <!-- Submit Button & Login Link -->
        <div class="pt-2">
            <x-primary-button class="w-full justify-center py-3 bg-indigo-600 hover:bg-indigo-700 active:bg-indigo-800 font-bold rounded-xl text-sm transition shadow-sm">
                {{ __('Daftar Sekarang') }}
            </x-primary-button>
        </div>

        <div class="text-center pt-3">
            <p class="text-xs text-slate-500 font-medium">
                Sudah punya akun?
                <a href="{{ route('login') }}" class="font-bold text-indigo-600 hover:text-indigo-700 hover:underline">
                    Masuk di sini
                </a>
            </p>
        </div>
    </form>
</x-guest-layout>