@extends('layouts.app')

@section('title', 'Tiket Saya')

@section('content')
<main class="max-w-7xl mx-auto px-6 py-12 md:py-16">

    <!-- Page Header -->
    <div class="mb-10 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">
                Tiket Saya
            </h1>
            <p class="text-slate-500 mt-1 text-sm">
                Daftar semua tiket event yang telah Anda pesan.
            </p>
        </div>
    </div>

    <!-- Ticket Cards Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

        @forelse($tickets as $ticket)
            <div class="bg-white rounded-3xl border border-slate-100 p-6 shadow-xl shadow-slate-100/50 flex flex-col justify-between transition-all hover:border-slate-200">
                
                <div>
                    <!-- Status Badge -->
                    <div class="flex justify-between items-start mb-4">
                        @php
                            $status = strtolower($ticket->status ?? 'paid');
                        @endphp

                        @if(in_array($status, ['success', 'paid', 'lunas']))
                            <span class="px-3 py-1 bg-emerald-50 text-emerald-600 rounded-full text-xs font-semibold tracking-wide uppercase">
                                Lunas
                            </span>
                        @elseif(in_array($status, ['pending', 'menunggu']))
                            <span class="px-3 py-1 bg-amber-50 text-amber-600 rounded-full text-xs font-semibold tracking-wide uppercase">
                                Menunggu Pembayaran
                            </span>
                        @else
                            <span class="px-3 py-1 bg-rose-50 text-rose-600 rounded-full text-xs font-semibold tracking-wide uppercase">
                                Gagal / Batal
                            </span>
                        @endif

                        <span class="font-mono text-xs text-slate-400">
                            {{ $ticket->order_id }}
                        </span>
                    </div>

                    <!-- Event Title -->
                    <h2 class="text-lg font-bold text-slate-900 mb-4 line-clamp-2 leading-snug">
                        {{ $ticket->event->title ?? 'Event tidak ditemukan' }}
                    </h2>

                    <!-- Detail Info -->
                    <div class="space-y-2.5 text-sm border-t border-slate-100 pt-4 mb-6">
                        <div class="flex justify-between text-slate-500">
                            <span>Jumlah Tiket</span>
                            <span class="font-semibold text-slate-800">{{ $ticket->quantity }} Tiket</span>
                        </div>
                        <div class="flex justify-between text-slate-500">
                            <span>Total Pembayaran</span>
                            <span class="font-extrabold text-indigo-600">
                                Rp {{ number_format($ticket->total_price, 0, ',', '.') }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Action Button -->
                <div>
                    <a href="{{ route('tickets.show', $ticket) }}"
                       class="w-full py-3 bg-slate-50 text-slate-700 hover:bg-indigo-600 hover:text-white rounded-2xl font-semibold text-sm transition-all flex items-center justify-center gap-2 border border-slate-200/60 hover:border-transparent">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                        Lihat Detail Tiket
                    </a>
                </div>

            </div>
        @empty
            <!-- Empty State -->
            <div class="col-span-full text-center py-20 bg-white rounded-3xl border border-slate-100 shadow-xl shadow-slate-100/50 p-8">
                <div class="w-16 h-16 bg-indigo-50 text-indigo-600 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-slate-900 mb-1">
                    Belum Ada Tiket
                </h3>
                <p class="text-slate-500 text-sm max-w-sm mx-auto mb-6">
                    Anda belum memiliki riwayat pesanan tiket event yang aktif saat ini.
                </p>
                <a href="{{ route('home') }}"
                   class="inline-flex items-center gap-2 px-6 py-3 bg-indigo-600 text-white rounded-2xl font-semibold text-sm shadow-lg shadow-indigo-100 hover:bg-indigo-700 transition-all">
                    Jelajahi Event Sekarang
                </a>
            </div>
        @endforelse

    </div>

    <!-- Pagination Links -->
    @if($tickets->hasPages())
        <div class="mt-12 flex justify-center">
            {{ $tickets->links() }}
        </div>
    @endif

</main>
@endsection