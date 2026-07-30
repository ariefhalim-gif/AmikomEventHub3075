@php
    use SimpleSoftwareIO\QrCode\Facades\QrCode;
    
    // Fallback poster logic
    $posterUrl = asset('assets/no-image.png');
    if ($transaction->event->poster_path) {
        $posterUrl = str_starts_with($transaction->event->poster_path, 'posters/')
            ? asset('storage/' . $transaction->event->poster_path)
            : asset('assets/' . $transaction->event->poster_path);
    }
@endphp

@extends('layouts.app')

@section('title', 'E-Ticket - ' . $transaction->order_id)

@section('content')
<main class="max-w-4xl mx-auto px-6 py-12 md:py-16">

    <!-- Header Page (Disembunyikan saat di-print) -->
    <div class="text-center mb-8 print:hidden">
        <a href="{{ route('tickets.mine') }}" class="inline-flex items-center gap-2 text-sm text-indigo-600 font-semibold mb-4 hover:underline">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            Kembali ke Tiket Saya
        </a>
        <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">
            E-Ticket Event
        </h1>
        <p class="text-sm text-slate-500 mt-1">
            Tunjukkan QR Code ini kepada petugas lokasi untuk verifikasi check-in.
        </p>
    </div>

    <!-- MAIN TICKET BOARDING PASS CARD -->
    <div class="bg-white rounded-3xl border border-slate-100 shadow-xl shadow-slate-100/50 overflow-hidden relative print:border-none print:shadow-none">
        
        <div class="grid lg:grid-cols-12 items-stretch">

            <!-- LEFT SIDE: Event Info (8 cols) -->
            <div class="lg:col-span-8 p-6 md:p-8 flex flex-col justify-between">
                <div>
                    <!-- Status Header -->
                    <div class="flex items-center justify-between mb-6">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-emerald-50 text-emerald-600 rounded-full text-xs font-semibold tracking-wide uppercase">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                            E-Ticket Sah
                        </span>
                        <span class="font-mono text-xs text-slate-400">
                            #{{ $transaction->order_id }}
                        </span>
                    </div>

                    <!-- Event Poster & Title -->
                    <div class="flex flex-col sm:flex-row gap-5 items-start mb-6">
                        <img src="{{ $posterUrl }}" 
                             alt="{{ $transaction->event->title }}" 
                             class="w-24 h-32 rounded-2xl object-cover shadow-sm shrink-0 mx-auto sm:mx-0">

                        <div class="space-y-1.5 text-center sm:text-left">
                            <h2 class="text-xl md:text-2xl font-bold text-slate-900 leading-snug">
                                {{ $transaction->event->title ?? '-' }}
                            </h2>

                            @if(isset($transaction->event->date))
                                <p class="text-xs text-indigo-600 font-semibold flex items-center justify-center sm:justify-start gap-1.5">
                                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    {{ \Carbon\Carbon::parse($transaction->event->date)->format('d F Y, H:i') }} WIB
                                </p>
                            @endif

                            @if(isset($transaction->event->location))
                                <p class="text-xs text-slate-500 flex items-center justify-center sm:justify-start gap-1.5">
                                    <svg class="w-4 h-4 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                    {{ $transaction->event->location }}
                                </p>
                            @endif
                        </div>
                    </div>

                    <!-- Attendee Grid Details -->
                    <div class="grid grid-cols-2 gap-4 pt-4 border-t border-slate-100 text-xs">
                        <div>
                            <span class="text-slate-400 block font-medium">Pemegang Tiket</span>
                            <span class="font-bold text-slate-800 text-sm">{{ $transaction->customer_name }}</span>
                        </div>
                        <div>
                            <span class="text-slate-400 block font-medium">Email</span>
                            <span class="font-semibold text-slate-700 truncate block">{{ $transaction->customer_email }}</span>
                        </div>
                        <div>
                            <span class="text-slate-400 block font-medium">Jumlah Tiket</span>
                            <span class="font-bold text-slate-800">{{ $transaction->quantity }} Tiket</span>
                        </div>
                        <div>
                            <span class="text-slate-400 block font-medium">Total Harga</span>
                            <span class="font-extrabold text-indigo-600">Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>

                <!-- Footer Status Check-in -->
                <div class="mt-6 pt-4 border-t border-slate-100 flex items-center justify-between text-xs">
                    <span class="text-slate-400">Status Verification:</span>
                    @if ($transaction->is_used)
                        <span class="font-semibold text-emerald-600 flex items-center gap-1">
                            ✅ Check-in pada {{ \Carbon\Carbon::parse($transaction->used_at)->format('d M H:i') }}
                        </span>
                    @else
                        <span class="font-semibold text-amber-600 flex items-center gap-1">
                            ⏳ Belum Check-in
                        </span>
                    @endif
                </div>
            </div>

            <!-- RIGHT SIDE: Stub QR Code (4 cols) -->
            <div class="lg:col-span-4 bg-slate-50 p-6 md:p-8 flex flex-col items-center justify-center text-center border-t lg:border-t-0 lg:border-l border-dashed border-slate-200 relative">
                
                <!-- Ticket Notch Decors (Desktop Only) -->
                <div class="hidden lg:block absolute -top-3 -left-3 w-6 h-6 bg-white rounded-full border border-slate-100"></div>
                <div class="hidden lg:block absolute -bottom-3 -left-3 w-6 h-6 bg-white rounded-full border border-slate-100"></div>

                <p class="text-xs text-slate-400 font-semibold tracking-wider uppercase mb-1">
                    Scan for Entry
                </p>

                <p class="font-mono text-xs font-bold text-slate-600 mb-4 bg-white px-3 py-1 rounded-lg border border-slate-200/60">
                    TKT-{{ strtoupper(substr(md5($transaction->order_id), 0, 10)) }}
                </p>

                <!-- QR Container -->
                <div class="bg-white p-3 rounded-2xl border border-slate-200 shadow-xs mb-3 inline-block">
                    {!! QrCode::size(150)->generate($transaction->order_id) !!}
                </div>

                <p class="text-[11px] text-slate-400 leading-tight">
                    Perlihatkan kode ini kepada panitia di pintu masuk event.
                </p>
            </div>

        </div>

    </div>

    <!-- ACTION BUTTONS (Hidden on Print) -->
    <div class="flex flex-col sm:flex-row justify-center gap-3 mt-8 print:hidden">
        <button onclick="window.print()"
                class="px-6 py-3 bg-indigo-600 text-white rounded-2xl font-semibold text-sm shadow-lg shadow-indigo-100 hover:bg-indigo-700 active:scale-[0.99] transition-all flex items-center justify-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
            Cetak / Simpan PDF
        </button>

        <a href="{{ route('tickets.mine') }}"
           class="px-6 py-3 bg-white text-slate-700 border border-slate-200 rounded-2xl font-semibold text-sm hover:bg-slate-50 transition-all text-center">
            Kembali ke Daftar Tiket
        </a>
    </div>

</main>

<style>
    @media print {
        body {
            background-color: white !important;
        }
        nav, footer, .print\:hidden {
            display: none !important;
        }
    }
</style>
@endsection