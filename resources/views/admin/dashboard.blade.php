@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
    <main class="flex-1 p-10 overflow-y-auto">

        <!-- Header -->
        <header class="flex justify-between items-center mb-10">
            <div>
                <h1 class="text-3xl font-black">
                    {{ Auth::user()->role === 'admin' ? 'Dashboard Admin' : 'Dashboard Organizer' }}
                </h1>
                <p class="text-slate-500 font-medium mt-1">
                    Selamat datang,
                    <span class="font-semibold">{{ Auth::user()->name }}</span>
                    @if (Auth::user()->organization)
                        • {{ Auth::user()->organization->name }}
                    @endif
                </p>
            </div>

            <div class="flex items-center gap-4">
                <div class="text-right hidden md:block">
                    <p class="font-bold">{{ Auth::user()->name }}</p>
                    <p class="text-xs text-slate-400">{{ ucfirst(Auth::user()->role) }}</p>
                </div>
                <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=6366f1&color=ffffff"
                     class="w-12 h-12 rounded-2xl shadow border" alt="Avatar">
            </div>
        </header>

        <!-- Statistik Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6 mb-10">
            <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm">
                <p class="text-slate-400 text-sm font-bold uppercase mb-1">Total Pendapatan</p>
                <h3 class="text-2xl font-black">Rp {{ number_format($totalRevenue ?? 0, 0, ',', '.') }}</h3>
            </div>

            <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm">
                <p class="text-slate-400 text-sm font-bold uppercase mb-1">Tiket Terjual</p>
                <h3 class="text-2xl font-black">{{ number_format($ticketsSold ?? 0, 0, ',', '.') }}</h3>
            </div>

            <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm">
                <p class="text-slate-400 text-sm font-bold uppercase mb-1">Event Aktif</p>
                <h3 class="text-2xl font-black">{{ $activeEvents ?? 0 }} Event</h3>
            </div>

            <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm">
                <p class="text-slate-400 text-sm font-bold uppercase mb-1">Pesanan Pending</p>
                <h3 class="text-2xl font-black">{{ $pendingOrders ?? 0 }} Pesanan</h3>
            </div>

            <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm">
                <p class="text-slate-400 text-sm font-bold uppercase mb-1">Total User</p>
                <h3 class="text-2xl font-black">{{ number_format($totalUsers ?? 0) }}</h3>
            </div>
        </div>

        <!-- Grafik Visualisasi -->
        <div class="grid lg:grid-cols-2 gap-8 mb-10">
            <div class="bg-white rounded-3xl border p-8 shadow-sm">
                <h3 class="font-black text-xl mb-6">Pertumbuhan Event</h3>
                <div class="relative h-64">
                    <canvas id="eventChart"></canvas>
                </div>
            </div>

            <div class="bg-white rounded-3xl border p-8 shadow-sm">
                <h3 class="font-black text-xl mb-6">Pertumbuhan User</h3>
                <div class="relative h-64">
                    <canvas id="userChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Transaksi Terakhir -->
        <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
            <div class="p-8 border-b flex justify-between items-center">
                <h3 class="font-black text-xl">Transaksi Terakhir</h3>
                <a href="{{ route('admin.transactions.index') }}" class="text-indigo-600 font-bold hover:underline">
                    Lihat Semua
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-slate-50 text-slate-400 uppercase text-[10px] font-black tracking-widest">
                        <tr>
                            <th class="px-8 py-4">Tanggal</th>
                            <th class="px-8 py-4">Pembeli</th>
                            <th class="px-8 py-4">Event</th>
                            <th class="px-8 py-4">Status</th>
                            <th class="px-8 py-4 text-right">Total</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y border-t">
                        @forelse($recentTransactions as $transaction)
                            <tr class="hover:bg-slate-50 transition">
                                <td class="px-8 py-6">
                                    {{ $transaction->created_at->format('d M Y') }}
                                    <br>
                                    <span class="text-xs text-slate-400">{{ $transaction->order_id }}</span>
                                </td>
                                <td class="px-8 py-6">
                                    <p class="font-bold">{{ $transaction->customer_name }}</p>
                                    <p class="text-xs text-slate-400">{{ $transaction->customer_email }}</p>
                                </td>
                                <td class="px-8 py-6">
                                    {{ $transaction->event->title ?? '-' }}
                                </td>
                                <td class="px-8 py-6">
                                    @if (in_array($transaction->status, ['success', 'settlement']))
                                        <span class="px-3 py-1 bg-green-100 text-green-700 rounded-lg text-xs font-bold uppercase">
                                            Success
                                        </span>
                                    @elseif($transaction->status === 'pending')
                                        <span class="px-3 py-1 bg-orange-100 text-orange-700 rounded-lg text-xs font-bold uppercase">
                                            Pending
                                        </span>
                                    @elseif($transaction->status === 'failed')
                                        <span class="px-3 py-1 bg-red-100 text-red-700 rounded-lg text-xs font-bold uppercase">
                                            Failed
                                        </span>
                                    @else
                                        <span class="px-3 py-1 bg-slate-100 text-slate-700 rounded-lg text-xs font-bold uppercase">
                                            {{ ucfirst($transaction->status) }}
                                        </span>
                                    @endif
                                </td>
                                <td class="px-8 py-6 text-right font-black text-indigo-600">
                                    Rp {{ number_format($transaction->total_price, 0, ',', '.') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-10 text-slate-400">
                                    Belum ada transaksi.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </main>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Data Grafik Event dari PHP
            const eventData = @json($eventChart ?? []);
            const eventLabels = eventData.map(item => {
                const date = new Date(2026, item.month - 1, 1);
                return date.toLocaleString('id-ID', { month: 'short' });
            });
            const eventTotals = eventData.map(item => item.total);

            // Chart Event
            const eventCtx = document.getElementById('eventChart');
            if (eventCtx) {
                new Chart(eventCtx, {
                    type: 'bar',
                    data: {
                        labels: eventLabels,
                        datasets: [{
                            label: 'Jumlah Event',
                            data: eventTotals,
                            backgroundColor: '#6366f1',
                            borderRadius: 8,
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: { legend: { display: false } },
                        scales: { y: { beginAtZero: true } }
                    }
                });
            }

            // Data Grafik User dari PHP
            const userData = @json($userChart ?? []);
            const userLabels = userData.map(item => item.month);
            const userTotals = userData.map(item => item.total);

            // Chart User
            const userCtx = document.getElementById('userChart');
            if (userCtx) {
                new Chart(userCtx, {
                    type: 'line',
                    data: {
                        labels: userLabels,
                        datasets: [{
                            label: 'Jumlah User',
                            data: userTotals,
                            borderColor: '#4f46e5',
                            backgroundColor: 'rgba(79, 70, 229, 0.1)',
                            fill: true,
                            tension: 0.4,
                            pointRadius: 4,
                            pointBackgroundColor: '#4f46e5'
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: { legend: { display: false } },
                        scales: { y: { beginAtZero: true } }
                    }
                });
            }
        });
    </script>
@endpush