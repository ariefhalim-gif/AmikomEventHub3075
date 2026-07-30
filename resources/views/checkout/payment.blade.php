@extends('layouts.app')

@section('title', 'Pembayaran - ' . $transaction->order_id)

@section('content')
<main class="max-w-xl mx-auto px-6 py-16 md:py-24">
    <div class="bg-white rounded-3xl border border-slate-100 p-8 md:p-12 shadow-xl shadow-slate-100/50">
        
        <!-- Header Minimalis -->
        <div class="text-center mb-8">
            <span class="inline-block px-3 py-1 bg-indigo-50 text-indigo-600 rounded-full text-xs font-semibold tracking-wide uppercase mb-3">
                Menunggu Pembayaran
            </span>
            <h1 class="text-2xl md:text-3xl font-bold text-slate-900 tracking-tight">
                Selesaikan Transaksi Anda
            </h1>
            <p class="text-sm text-slate-500 mt-1">
                Jendela pembayaran Midtrans akan terbuka secara otomatis.
            </p>
        </div>

        <!-- Detail Ringkas -->
        <div class="bg-slate-50/70 rounded-2xl p-5 mb-8 space-y-3.5 border border-slate-100/80">
            <div class="flex justify-between items-center text-sm">
                <span class="text-slate-400 font-medium">Order ID</span>
                <span class="font-mono font-semibold text-slate-700">{{ $transaction->order_id }}</span>
            </div>

            <div class="flex justify-between items-center text-sm">
                <span class="text-slate-400 font-medium">Event</span>
                <span class="font-semibold text-slate-800 text-right truncate max-w-[200px]" title="{{ $transaction->event->title ?? '-' }}">
                    {{ $transaction->event->title ?? '-' }}
                </span>
            </div>

            <div class="flex justify-between items-center text-sm pt-2 border-t border-slate-200/60">
                <span class="text-slate-500 font-medium">Total Tagihan</span>
                <span class="text-lg font-bold text-indigo-600">
                    Rp {{ number_format($transaction->total_price, 0, ',', '.') }}
                </span>
            </div>
        </div>

        <!-- Action Button -->
        <button id="pay-button"
                type="button"
                class="w-full py-4 bg-indigo-600 text-white rounded-2xl font-semibold text-base shadow-lg shadow-indigo-100 hover:bg-indigo-700 active:scale-[0.99] transition-all flex items-center justify-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
            </svg>
            <span id="button-text">Bayar Sekarang</span>
        </button>

        <!-- Bantuan Manual -->
        <p class="text-center text-xs text-slate-400 mt-6">
            Popup tidak muncul? 
            <a href="#" id="manual-trigger" class="text-indigo-600 font-medium hover:underline">Klik di sini untuk membuka ulang</a>
        </p>

    </div>
</main>

<!-- Dynamic Midtrans Script -->
<script src="{{ config('midtrans.is_production', false) ? 'https://app.midtrans.com/snap/snap.js' : 'https://app.sandbox.midtrans.com/snap/snap.js' }}"
        data-client-key="{{ config('midtrans.client_key') }}">
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const payButton = document.getElementById('pay-button');
        const manualTrigger = document.getElementById('manual-trigger');
        const buttonText = document.getElementById('button-text');
        const snapToken = '{{ $transaction->snap_token }}';

        function triggerPayment() {
            if (typeof snap === 'undefined') {
                alert('Sistem pembayaran sedang tidak siap. Silakan muat ulang halaman.');
                return;
            }

            buttonText.innerText = 'Menghubungkan...';
            payButton.disabled = true;
            payButton.classList.add('opacity-80', 'cursor-not-allowed');

            snap.pay(snapToken, {
                onSuccess: function (result) {
                    window.location.href = "{{ route('checkout.success', $transaction->order_id) }}";
                },
                onPending: function (result) {
                    resetButton('Lanjutkan Pembayaran');
                },
                onError: function (result) {
                    alert('Pembayaran gagal atau dibatalkan.');
                    resetButton('Coba Lagi');
                },
                onClose: function () {
                    resetButton('Bayar Sekarang');
                }
            });
        }

        function resetButton(text) {
            buttonText.innerText = text;
            payButton.disabled = false;
            payButton.classList.remove('opacity-80', 'cursor-not-allowed');
        }

        payButton.onclick = function (e) {
            e.preventDefault();
            triggerPayment();
        };

        manualTrigger.onclick = function (e) {
            e.preventDefault();
            triggerPayment();
        };

        // Auto trigger dengan jeda singkat agar halaman render sempurna
        setTimeout(function () {
            triggerPayment();
        }, 600);
    });
</script>
@endsection