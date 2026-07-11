@extends('layouts.app')

@section('content')

<!-- Hero Section -->
<section class="max-w-7xl mx-auto px-6 py-20 flex flex-col md:flex-row items-center gap-12">
    <div class="flex-1 space-y-8">
        <span
            class="inline-block px-4 py-1.5 bg-indigo-100 text-indigo-700 rounded-full text-sm font-bold uppercase tracking-wider">
            #1 Event Platform
        </span>

        <h1 class="text-5xl md:text-7xl font-extrabold leading-tight">
            Temukan & Pesan <span class="text-indigo-600">Tiket Event</span> Impianmu.
        </h1>

        <p class="text-lg text-slate-500 max-w-lg leading-relaxed">
            Dari konser musik hingga workshop teknologi, semua ada di genggamanmu.
            Pesan aman & cepat dengan Midtrans.
        </p>

        <div class="flex gap-4">
            <a href="#events"
                class="px-8 py-4 bg-indigo-600 text-white rounded-2xl font-bold text-lg shadow-xl shadow-indigo-200 hover:scale-105 transition-transform">
                Mulai Jelajah
            </a>

            <a href="#"
                class="px-8 py-4 border-2 border-slate-200 rounded-2xl font-bold text-lg hover:border-indigo-600 hover:text-indigo-600 transition">
                Cara Pesan
            </a>
        </div>
    </div>

    <div class="flex-1 relative">

        <div
            class="absolute -top-10 -left-10 w-64 h-64 bg-indigo-400 rounded-full mix-blend-multiply blur-3xl opacity-20">
        </div>

        <div
            class="absolute -bottom-10 -right-10 w-64 h-64 bg-purple-400 rounded-full mix-blend-multiply blur-3xl opacity-20">
        </div>

        <img src="{{ asset('assets/concert.png') }}"
            alt="Concert"
            class="rounded-[2rem] shadow-2xl relative z-10 w-full object-cover aspect-[4/5]">

        <div class="absolute -bottom-6 -left-6 glass p-6 rounded-2xl shadow-xl z-20 border border-white">

            <div class="flex items-center gap-4">

                <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center text-green-600">

                    ✓

                </div>

                <div>

                    <p class="text-xs text-slate-500 font-bold uppercase">
                        Terverifikasi
                    </p>

                    <p class="font-bold">
                        Pembayaran Aman via Midtrans
                    </p>

                </div>

            </div>

        </div>

    </div>
</section>

<!-- Events -->
<section id="events" class="max-w-7xl mx-auto px-6 py-20">

    <div class="mb-10">

        <h2 class="text-3xl font-extrabold mb-2">
            Event Terdekat
        </h2>

        <p class="text-slate-500">
            Jangan sampai ketinggalan acara seru minggu ini!
        </p>

    </div>

    <!-- Filter -->
    <div class="flex flex-wrap gap-3 mb-10">

        <a href="{{ route('home') }}"
            class="{{ request('category') ? 'bg-gray-200 text-gray-700' : 'bg-indigo-600 text-white' }} px-4 py-2 rounded-xl font-semibold transition">

            Semua

        </a>

        @foreach($categories as $cat)

            <a href="{{ route('home',['category'=>$cat->slug]) }}"
                class="{{ request('category') == $cat->slug ? 'bg-indigo-600 text-white' : 'bg-indigo-100 text-indigo-700' }} px-4 py-2 rounded-xl font-semibold transition">

                {{ $cat->name }}

            </a>

        @endforeach

    </div>

    <!-- Grid Event -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">

        @forelse($events as $event)

        <div
            class="group bg-white rounded-3xl border border-slate-100 shadow-sm hover:shadow-2xl transition-all overflow-hidden">

            <div class="relative aspect-[3/4] overflow-hidden">

                <img src="{{ asset('assets/' . $event->poster_path) }}"
                    alt="{{ $event->title }}"
                    class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">

                <div
                    class="absolute top-4 left-4 bg-white/90 px-3 py-1 rounded-lg text-xs font-bold text-indigo-600">

                    {{ $event->category->name }}

                </div>

            </div>

            <div class="p-6">

                <h3 class="text-xl font-bold mb-3">

                    {{ $event->title }}

                </h3>

                <p class="text-gray-500 text-sm mb-2">

                     {{ $event->location }}

                </p>

                <p class="text-gray-500 text-sm mb-5">

                    🗓
                    {{ \Carbon\Carbon::parse($event->date)->format('d M Y H:i') }}

                </p>

                <div class="flex justify-between items-center border-t pt-4">

                    <span class="text-2xl font-black text-indigo-600">

                        Rp {{ number_format($event->price,0,',','.') }}

                    </span>

                    <a href="{{ route('event.detail') }}"
                        class="px-4 py-2 bg-indigo-600 text-white rounded-xl hover:bg-indigo-700">

                        Detail

                    </a>

                </div>

            </div>

        </div>

        @empty

        <div class="col-span-3 text-center py-20">

            <h3 class="text-2xl font-bold text-gray-500">

                Belum ada event tersedia.

            </h3>

            <p class="text-gray-400 mt-3">

                Silakan tambahkan data event melalui halaman admin.

            </p>

        </div>

        @endforelse

    </div>

</section>

@endsection