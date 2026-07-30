@extends('layouts.app')

@section('title', 'Checkout - ' . $event->title)

@section('content')
<main class="max-w-3xl mx-auto px-6 py-12 md:py-20" x-data="{ 
    unitPrice: {{ $event->price }}, 
    adminFee: 5000, 
    quantity: {{ old('quantity', 1) }} 
}">

    <!-- Back Navigation & Title -->
    <div class="mb-10">
        <a href="{{ route('events.show', $event) }}" class="inline-flex items-center gap-2 text-indigo-600 font-bold hover:text-indigo-700 transition-colors mb-4">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
            Kembali ke Detail Event
        </a>

        <h1 class="text-3xl md:text-4xl font-extrabold text-slate-900">
            Checkout
        </h1>
        <p class="text-slate-500 mt-2">
            Lengkapi data Anda untuk memesan tiket event.
        </p>
    </div>

    <div class="grid gap-8">

        <!-- Order Summary Card -->
        <div class="bg-white rounded-3xl border border-slate-200 p-6 md:p-8 shadow-sm">
            <h3 class="text-xl font-bold mb-6 border-b border-slate-100 pb-4 text-slate-800">
                Ringkasan Pesanan
            </h3>

            <div class="flex flex-col sm:flex-row gap-6 items-start">
                <div class="w-24 h-24 shrink-0 rounded-2xl overflow-hidden bg-slate-100">
                    @if($event->poster_path)
                        <img src="{{ asset('storage/' . $event->poster_path) }}" 
                             alt="{{ $event->title }}"
                             class="w-full h-full object-cover">
                    @else
                        <img src="https://placehold.co/120x120?text=No+Poster" 
                             alt="No Poster"
                             class="w-full h-full object-cover">
                    @endif
                </div>

                <div class="space-y-1">
                    <h4 class="font-extrabold text-lg text-slate-900 leading-snug">
                        {{ $event->title }}
                    </h4>
                    <p class="text-sm text-slate-500 flex items-center gap-1.5 pt-1">
                        <svg class="w-4 h-4 text-indigo-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        {{ \Carbon\Carbon::parse($event->date)->format('d F Y') }}
                    </p>
                    <p class="text-sm text-slate-500 flex items-center gap-1.5">
                        <svg class="w-4 h-4 text-indigo-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        {{ $event->location }}
                    </p>
                    <p class="text-indigo-600 font-bold text-lg pt-1">
                        Rp {{ number_format($event->price, 0, ',', '.') }} <span class="text-xs text-slate-400 font-normal">/ tiket</span>
                    </p>
                    <p class="text-xs text-slate-500">
                        Stok tersedia: <strong class="text-slate-700">{{ $event->stock }}</strong> Tiket
                    </p>
                </div>
            </div>
        </div>

        <!-- Checkout Form Card -->
        <div class="bg-white rounded-3xl border border-slate-200 p-6 md:p-8 shadow-sm">
            <h3 class="text-xl font-bold mb-6 text-slate-800">
                Data Pemesan
            </h3>

            <form action="{{ route('checkout.store', $event) }}" method="POST">
                @csrf

                <div class="space-y-5">
                    <!-- Customer Name -->
                    <div>
                        <label for="customer_name" class="block font-semibold text-slate-700 mb-2">
                            Nama Lengkap
                        </label>
                        <input type="text"
                               id="customer_name"
                               name="customer_name"
                               value="{{ old('customer_name', auth()->user()->name ?? '') }}"
                               class="w-full border border-slate-300 rounded-xl p-3 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all @error('customer_name') border-red-500 @enderror"
                               placeholder="Masukkan nama lengkap"
                               required>
                        @error('customer_name')
                            <p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Customer Email -->
                    <div>
                        <label for="customer_email" class="block font-semibold text-slate-700 mb-2">
                            Email
                        </label>
                        <input type="email"
                               id="customer_email"
                               name="customer_email"
                               value="{{ old('customer_email', auth()->user()->email ?? '') }}"
                               class="w-full border border-slate-300 rounded-xl p-3 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all @error('customer_email') border-red-500 @enderror"
                               placeholder="contoh@email.com"
                               required>
                        @error('customer_email')
                            <p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Customer Phone -->
                    <div>
                        <label for="customer_phone" class="block font-semibold text-slate-700 mb-2">
                            Nomor HP / WhatsApp
                        </label>
                        <input type="tel"
                               id="customer_phone"
                               name="customer_phone"
                               value="{{ old('customer_phone') }}"
                               class="w-full border border-slate-300 rounded-xl p-3 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all @error('customer_phone') border-red-500 @enderror"
                               placeholder="081234567890"
                               required>
                        @error('customer_phone')
                            <p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Quantity Input -->
                    <div>
                        <label for="quantity" class="block font-semibold text-slate-700 mb-2">
                            Jumlah Tiket
                        </label>
                        <input type="number"
                               id="quantity"
                               name="quantity"
                               x-model.number="quantity"
                               min="1"
                               max="{{ $event->stock }}"
                               class="w-full border border-slate-300 rounded-xl p-3 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all @error('quantity') border-red-500 @enderror"
                               required>
                        @error('quantity')
                            <p class="text-xs text-red-500 mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Total Calculation Breakdown -->
                <div class="mt-8 border-t border-slate-100 pt-6 space-y-3">
                    <div class="flex justify-between text-slate-600">
                        <span>Harga Tiket (<span x-text="quantity || 1"></span>x)</span>
                        <strong class="text-slate-800">
                            Rp <span x-text="(unitPrice * (quantity || 1)).toLocaleString('id-ID')"></span>
                        </strong>
                    </div>

                    <div class="flex justify-between text-slate-600">
                        <span>Biaya Admin</span>
                        <strong class="text-slate-800">
                            Rp 5.000
                        </strong>
                    </div>

                    <div class="flex justify-between text-xl font-bold text-slate-900 border-t border-slate-100 pt-4">
                        <span>Total Pembayaran</span>
                        <span class="text-indigo-600">
                            Rp <span x-text="((unitPrice * (quantity || 1)) + adminFee).toLocaleString('id-ID')"></span>
                        </span>
                    </div>
                </div>

                <!-- Submit Button -->
                <button type="submit"
                        class="mt-8 w-full py-4 bg-indigo-600 text-white rounded-2xl font-bold text-lg hover:bg-indigo-700 focus:outline-none focus:ring-4 focus:ring-indigo-200 transition-all shadow-lg shadow-indigo-100">
                    Pesan Tiket Sekarang
                </button>
            </form>
        </div>

    </div>
</main>
@endsection