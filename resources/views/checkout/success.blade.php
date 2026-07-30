@extends('layouts.app')

@section('title', 'Pembayaran Berhasil - ' . $transaction->order_id)

@section('content')
<main class="max-w-xl mx-auto px-6 py-16 md:py-24">
    <div class="bg-white rounded-3xl border border-slate-100 p-8 md:p-12 shadow-xl shadow-slate-100/50 text-center">
        
        <!-- Animated Icon Success -->
        <div class="w-20 h-20 bg-emerald-50 text-emerald-600 rounded-full flex items-center justify-center mx-auto mb-6 shadow-inner">
            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path>
            </svg>
        </div>

        <!-- Header Status -->
        <span class="inline-block px-3 py-1 bg-emerald-50 text-emerald-600 rounded-full text-xs font-semibold tracking-wide uppercase mb-3">
            Pembayaran Berhasil
        </span>
        
        <h1 class="text-2xl md:text-3xl font-bold text-slate-900 tracking-tight mb-2">
            Terima Kasih atas Pesanan Anda!
        </h1>
        
        <p class="text-sm text-slate-500 leading-relaxed max-w-sm mx-auto mb-8">
            E-Ticket telah dikirim ke email <strong class="text-slate-700 font-semibold">{{ $transaction->customer_email }}</strong>
        </p>

        <!-- E-Ticket Card Summary -->
        <div class="bg-slate-50/70 rounded-2xl p-6 mb-8 text-left border border-slate-100 relative overflow-hidden">
            <!-- Decorative Accent Circle -->
            <div class="absolute -right-6 -bottom-6 w-24 h-24 bg-indigo-50 rounded-full blur-xl opacity-60"></div>

            <div class="flex justify-between items-start mb-4 border-b border-slate-200/60 pb-3">
                <div>
                    <p class="text-xs text-slate-400 font-medium uppercase tracking-wider">Order ID</p>
                    <p class="font-mono font-bold text-slate-800 text-sm mt-0.5">{{ $transaction->order_id }}</p>
                </div>
                <span class="px-2.5 py-1 bg-white border border-slate-200 rounded-lg text-xs font-semibold text-slate-600 shadow-2xs">
                    {{ $transaction->quantity }} Tiket
                </span>
            </div>

            <div class="space-y-2">
                <div>
                    <p class="text-xs text-slate-400 font-medium">Event</p>
                    <p class="font-bold text-slate-900 text-base leading-snug">
                        {{ $transaction->event->title ?? '-' }}
                    </p>
                </div>

                @if(isset($transaction->event->date))
                    <div class="pt-1 flex items-center gap-1.5 text-xs text-slate-500">
                        <svg class="w-4 h-4 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <span>{{ \Carbon\Carbon::parse($transaction->event->date)->format('d M Y, H:i') }} WIB</span>
                    </div>
                @endif
            </div>

            <div class="mt-4 pt-3 border-t border-slate-200/60 flex justify-between items-center text-xs">
                <span class="text-slate-500">Total Dibayar</span>
                <span class="font-extrabold text-slate-900 text-sm">
                    Rp {{ number_format($transaction->total_price, 0, ',', '.') }}
                </span>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="space-y-3">
            <a href="{{ route('home') }}"
               class="w-full py-4 bg-indigo-600 text-white rounded-2xl font-semibold text-sm shadow-lg shadow-indigo-100 hover:bg-indigo-700 active:scale-[0.99] transition-all inline-flex items-center justify-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                </svg>
                Kembali ke Beranda
            </a>
        </div>

    </div>
</main>
@endsection