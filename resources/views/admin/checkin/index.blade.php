@extends('layouts.admin')

@section('title', 'QR Check-in Scanner')

@section('content')
<main class="flex-1 p-6 md:p-10 overflow-y-auto">

    <!-- Header Page -->
    <div class="mb-8">
        <h1 class="text-3xl font-black text-slate-800">QR Check-in Scanner</h1>
        <p class="text-slate-500 font-medium mt-1">Arahkan kamera ke QR Code tiket peserta untuk melakukan validasi kehadiran otomatis.</p>
    </div>

    <!-- Scanner Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">

        <!-- Camera Scanner Card -->
        <div class="lg:col-span-6 bg-white rounded-[2.5rem] border border-slate-100 shadow-sm p-6 sm:p-8">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center font-bold">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h0.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                </div>
                <div>
                    <h2 class="text-lg font-extrabold text-slate-800">Kamera Scanner</h2>
                    <p class="text-xs text-slate-400 font-medium">Pastikan akses izin kamera sudah diizinkan</p>
                </div>
            </div>

            <!-- Scanner Box -->
            <div class="relative rounded-2xl overflow-hidden bg-slate-900 border border-slate-200">
                <div id="reader" class="w-full"></div>
            </div>
        </div>

        <!-- Result Card -->
        <div class="lg:col-span-6 bg-white rounded-[2.5rem] border border-slate-100 shadow-sm p-6 sm:p-8">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div>
                    <h2 class="text-lg font-extrabold text-slate-800">Hasil Pemindaian</h2>
                    <p class="text-xs text-slate-400 font-medium">Informasi tiket akan langsung muncul di sini</p>
                </div>
            </div>

            <!-- Result Placeholder / Content -->
            <div id="result" class="min-h-[280px] flex flex-col items-center justify-center text-center p-6 border-2 border-dashed border-slate-100 rounded-2xl bg-slate-50/50">
                <div class="w-16 h-16 rounded-full bg-slate-100 text-slate-400 flex items-center justify-center mb-3">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path>
                    </svg>
                </div>
                <h3 class="text-sm font-bold text-slate-700 mb-1">Siap Memindai</h3>
                <p class="text-xs text-slate-400 max-w-xs">Arahkan kamera ke QR Code pada tiket peserta untuk memproses *check-in*.</p>
            </div>
        </div>

    </div>

</main>

<!-- Html5Qrcode Library -->
<script src="https://unpkg.com/html5-qrcode"></script>

<script>
let isProcessing = false;

function onScanSuccess(decodedText) {
    // Mencegah request ganda beruntun saat QR terdeteksi berkali-kali
    if (isProcessing) return;
    isProcessing = true;

    const resultDiv = document.getElementById("result");
    
    // Tampilan Loading sementara
    resultDiv.innerHTML = `
        <div class="flex flex-col items-center justify-center py-8">
            <div class="w-10 h-10 border-4 border-indigo-600 border-t-transparent rounded-full animate-spin mb-3"></div>
            <p class="text-sm font-bold text-slate-700">Memproses Check-in...</p>
        </div>
    `;

    fetch("/admin/checkin/" + decodedText, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        }
    })
    .then(res => res.json())
    .then(data => {
        let html = "";

        if (data.status) {
            html = `
            <div class="w-full text-left space-y-4">
                <div class="flex items-center gap-3 p-4 bg-emerald-50 rounded-xl border border-emerald-100">
                    <div class="w-10 h-10 rounded-lg bg-emerald-500 text-white flex items-center justify-center shrink-0 font-bold text-xl">
                        ✓
                    </div>
                    <div>
                        <h3 class="text-base font-black text-emerald-800">Check-in Berhasil!</h3>
                        <p class="text-xs text-emerald-600 font-medium">Tiket terverifikasi valid.</p>
                    </div>
                </div>

                <div class="space-y-2.5 text-xs sm:text-sm pt-2">
                    <div class="flex justify-between py-2 border-b border-slate-100">
                        <span class="text-slate-400 font-medium">Order ID</span>
                        <span class="font-mono font-bold text-slate-800">${data.transaction.order_id}</span>
                    </div>
                    <div class="flex justify-between py-2 border-b border-slate-100">
                        <span class="text-slate-400 font-medium">Nama Peserta</span>
                        <span class="font-bold text-slate-800">${data.transaction.customer_name}</span>
                    </div>
                    <div class="flex justify-between py-2 border-b border-slate-100">
                        <span class="text-slate-400 font-medium">Email</span>
                        <span class="font-semibold text-slate-700">${data.transaction.customer_email}</span>
                    </div>
                    <div class="flex justify-between py-2 border-b border-slate-100">
                        <span class="text-slate-400 font-medium">Jumlah Tiket</span>
                        <span class="font-black text-indigo-600 bg-indigo-50 px-2.5 py-0.5 rounded-md">${data.transaction.quantity} Tiket</span>
                    </div>
                </div>
            </div>
            `;
        } else {
            html = `
            <div class="w-full text-left space-y-4">
                <div class="flex items-center gap-3 p-4 bg-rose-50 rounded-xl border border-rose-100">
                    <div class="w-10 h-10 rounded-lg bg-rose-500 text-white flex items-center justify-center shrink-0 font-bold text-xl">
                        ✕
                    </div>
                    <div>
                        <h3 class="text-base font-black text-rose-800">Check-in Gagal</h3>
                        <p class="text-xs text-rose-600 font-medium">${data.message || 'QR Code tidak valid atau sudah digunakan.'}</p>
                    </div>
                </div>
            </div>
            `;
        }

        resultDiv.innerHTML = html;

        // Buka kunci penanda pemindaian setelah 3 detik
        setTimeout(() => { isProcessing = false; }, 3000);
    })
    .catch(err => {
        resultDiv.innerHTML = `
            <div class="p-4 bg-rose-50 rounded-xl border border-rose-100 text-rose-700 text-xs font-bold w-full text-center">
                Terjadi kesalahan sistem saat menghubungi server.
            </div>
        `;
        setTimeout(() => { isProcessing = false; }, 3000);
    });
}

let html5QrcodeScanner = new Html5QrcodeScanner(
    "reader",
    {
        fps: 10,
        qrbox: { width: 220, height: 220 },
        aspectRatio: 1.0
    },
    /* verbose= */ false
);

html5QrcodeScanner.render(onScanSuccess);
</script>

<style>
/* Styling tambahan agar kontainer kamera HTML5QRcode menyatu secara mulus dengan Tailwind UI */
#reader {
    border: none !important;
}
#reader video {
    border-radius: 1rem;
    object-fit: cover;
}
#reader__dashboard_section {
    padding: 1rem;
    background: #f8fafc;
    border-bottom-left-radius: 1rem;
    border-bottom-right-radius: 1rem;
}
#reader__dashboard_section_button {
    background-color: #4f46e5 !important;
    color: #ffffff !important;
    border: none !important;
    padding: 0.5rem 1.25rem !important;
    border-radius: 0.75rem !important;
    font-weight: 700 !important;
    font-size: 0.875rem !important;
    cursor: pointer;
}
</style>
@endsection