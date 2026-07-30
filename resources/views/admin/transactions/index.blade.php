@extends('layouts.admin')

@section('title', 'Laporan Transaksi - Admin')

@section('content')
<main class="flex-1 p-6 md:p-10 overflow-y-auto">

    <!-- Page Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
        <div>
            <h1 class="text-3xl font-black text-slate-800">Laporan Transaksi</h1>
            <p class="text-slate-500 font-medium mt-1">Pantau arus kas, performa penjualan tiket, dan riwayat pesanan.</p>
        </div>
        
        <!-- Action Buttons (Export Data) -->
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.transactions.export', request()->query()) }}" 
               class="px-5 py-2.5 bg-emerald-600 text-white rounded-xl font-bold shadow-md shadow-emerald-100 hover:bg-emerald-700 active:scale-95 transition flex items-center gap-2 text-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                Export Excel
            </a>
        </div>
    </div>

    <!-- Summary / Metric Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm flex items-center gap-5">
            <div class="w-14 h-14 bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center shrink-0">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <div>
                <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Total Pendapatan</p>
                <p class="text-2xl font-black text-slate-800 mt-1">
                    Rp {{ number_format($totalRevenue ?? 0, 0, ',', '.') }}
                </p>
            </div>
        </div>

        <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm flex items-center gap-5">
            <div class="w-14 h-14 bg-indigo-50 text-indigo-600 rounded-2xl flex items-center justify-center shrink-0">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <div>
                <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Transaksi Sukses</p>
                <p class="text-2xl font-black text-slate-800 mt-1">
                    {{ $successCount ?? 0 }} <span class="text-xs text-slate-400 font-normal">Pesanan</span>
                </p>
            </div>
        </div>

        <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm flex items-center gap-5">
            <div class="w-14 h-14 bg-amber-50 text-amber-600 rounded-2xl flex items-center justify-center shrink-0">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <div>
                <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Menunggu Pembayaran</p>
                <p class="text-2xl font-black text-slate-800 mt-1">
                    {{ $pendingCount ?? 0 }} <span class="text-xs text-slate-400 font-normal">Pending</span>
                </p>
            </div>
        </div>
    </div>

    <!-- Main Table Card -->
    <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden">

        <!-- Search & Filter Bar -->
        <form method="GET" action="{{ route('admin.transactions.index') }}" class="p-6 bg-slate-50/50 border-b flex flex-col md:flex-row gap-4">
            
            <!-- Search Keyword -->
            <div class="flex-1 relative">
                <input type="text" name="search" value="{{ request('search') }}" 
                    placeholder="Cari Order ID, Nama, atau Email Pembeli..."
                    class="w-full px-5 py-2.5 rounded-xl border-slate-200 border bg-white focus:ring-2 focus:ring-indigo-500 outline-none transition text-sm">
            </div>

            <!-- Status Filter -->
            <div class="w-full md:w-48">
                <select name="status" onchange="this.form.submit()" class="w-full px-4 py-2.5 rounded-xl border-slate-200 border bg-white outline-none text-sm cursor-pointer">
                    <option value="">Semua Status</option>
                    <option value="success" @selected(request('status') == 'success')>Success / Settlement</option>
                    <option value="pending" @selected(request('status') == 'pending')>Pending</option>
                    <option value="failed" @selected(request('status') == 'failed')>Gagal / Cancel / Expired</option>
                </select>
            </div>

            <!-- Filter Buttons -->
            <div class="flex gap-2">
                <button type="submit" class="px-5 py-2.5 bg-slate-800 text-white rounded-xl text-sm font-bold hover:bg-slate-900 transition">
                    Filter
                </button>
                @if(request()->hasAny(['search', 'status']))
                    <a href="{{ route('admin.transactions.index') }}" class="px-5 py-2.5 bg-slate-200 text-slate-600 rounded-xl text-sm font-bold hover:bg-slate-300 transition text-center">
                        Reset
                    </a>
                @endif
            </div>
        </form>

        <!-- Transactions Table -->
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-slate-50 text-slate-400 uppercase text-[10px] font-black tracking-widest border-b">
                    <tr>
                        <th class="px-8 py-4">Order ID</th>
                        <th class="px-8 py-4">Detail Pembeli</th>
                        <th class="px-8 py-4">Event</th>
                        <th class="px-8 py-4">Tgl Transaksi</th>
                        <th class="px-8 py-4">Status</th>
                        <th class="px-8 py-4 text-right">Total Tagihan</th>
                    </tr>
                </thead>
                <tbody class="divide-y border-t">
                    @forelse($transactions as $trx)
                        <tr class="hover:bg-slate-50/50 transition {{ $trx->status == 'pending' ? 'bg-amber-50/20' : '' }}">
                            
                            <!-- Order ID -->
                            <td class="px-8 py-6">
                                <span class="font-mono font-bold px-3 py-1.5 rounded-lg text-xs {{ in_array($trx->status, ['settlement', 'success']) ? 'text-indigo-600 bg-indigo-50 border border-indigo-100' : 'text-slate-600 bg-slate-100' }}">
                                    #{{ $trx->order_id }}
                                </span>
                            </td>

                            <!-- Detail Pembeli -->
                            <td class="px-8 py-6">
                                <p class="font-bold text-slate-800 text-sm">
                                    {{ $trx->customer_name }}
                                </p>
                                <p class="text-xs text-slate-400 mt-0.5">
                                    {{ $trx->customer_email }}
                                </p>
                                @if($trx->customer_phone)
                                    <p class="text-xs text-slate-400">
                                        {{ $trx->customer_phone }}
                                    </p>
                                @endif
                            </td>

                            <!-- Nama Event -->
                            <td class="px-8 py-6">
                                <p class="font-bold text-slate-700 text-sm line-clamp-1">
                                    {{ $trx->event->title ?? '-' }}
                                </p>
                            </td>

                            <!-- Tanggal Transaksi -->
                            <td class="px-8 py-6 text-sm text-slate-500 whitespace-nowrap">
                                {{ $trx->created_at->format('d M Y') }}
                                <span class="block text-xs text-slate-400">{{ $trx->created_at->format('H:i') }} WIB</span>
                            </td>

                            <!-- Status Badge -->
                            <td class="px-8 py-6 whitespace-nowrap">
                                @if(in_array($trx->status, ['settlement', 'success']))
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-emerald-100 text-emerald-700 rounded-full text-xs font-bold">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                        Success
                                    </span>
                                @elseif($trx->status == 'pending')
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-amber-100 text-amber-700 rounded-full text-xs font-bold">
                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                        Pending
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-rose-100 text-rose-700 rounded-full text-xs font-bold">
                                        <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                                        {{ ucfirst($trx->status) }}
                                    </span>
                                @endif
                            </td>

                            <!-- Total Tagihan -->
                            <td class="px-8 py-6 text-right font-black text-slate-800 text-base">
                                Rp {{ number_format($trx->total_price, 0, ',', '.') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-12 text-slate-400">
                                <svg class="w-12 h-12 mx-auto mb-3 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 14l2-2 4 4m6-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <p class="font-bold text-base text-slate-600">Belum ada transaksi ditemukan.</p>
                                <p class="text-xs text-slate-400 mt-1">Cobalah untuk mengubah filter pencarian Anda.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination Footer -->
        @if($transactions->hasPages())
            <div class="px-8 py-6 bg-slate-50/50 border-t">
                {{ $transactions->links() }}
            </div>
        @endif

    </div>
</main>
@endsection