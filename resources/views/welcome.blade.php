@extends('layouts.app')

@section('title', 'Beranda - AmikomEventHub')

@section('content')

<!-- HERO SECTION -->
<section class="relative overflow-hidden pt-8 pb-16 lg:py-20">
    <!-- Glow Decorative Background Elements -->
    <div class="absolute top-1/4 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[500px] h-[500px] bg-amikom-600/10 rounded-full blur-3xl -z-10"></div>
    <div class="absolute top-1/3 right-10 w-[300px] h-[300px] bg-amber-500/10 rounded-full blur-3xl -z-10"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid lg:grid-cols-12 gap-12 lg:gap-8 items-center">
            
            <!-- Hero Text Content -->
            <div class="lg:col-span-7 space-y-6 text-center lg:text-left">
                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-amikom-50 border border-amikom-100 text-amikom-700 text-xs sm:text-sm font-bold shadow-xs">
                    <i data-lucide="sparkles" class="w-4 h-4 text-amber-500"></i>
                    <span>#1 Student Event Platform in Amikom</span>
                </div>

                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold text-slate-900 tracking-tight leading-[1.15]">
                    Temukan & Pesan <br class="hidden sm:inline" />
                    <span class="bg-gradient-to-r from-amikom-800 via-amikom-600 to-purple-600 bg-clip-text text-transparent">
                        Tiket Event Kampus
                    </span> Favoritmu.
                </h1>

                <p class="text-base sm:text-lg text-slate-600 max-w-2xl mx-auto lg:mx-0 leading-relaxed">
                    Jelajahi seminar, workshop, kompetisi, hingga konser kampus. Dapatkan tiket resmi secara cepat, aman, dan tanpa ribet.
                </p>

                <!-- Hero Action Buttons -->
                <div class="pt-2 flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-4">
                    <a href="#events"
                        class="w-full sm:w-auto px-8 py-4 bg-amikom-700 hover:bg-amikom-800 text-white rounded-2xl font-bold shadow-lg shadow-amikom-700/25 hover:shadow-xl hover:shadow-amikom-700/35 transition-all flex items-center justify-center gap-2 group">
                        <span>Eksplor Event</span>
                        <i data-lucide="arrow-right" class="w-5 h-5 group-hover:translate-x-1 transition-transform"></i>
                    </a>

                    <a href="#about"
                        class="w-full sm:w-auto px-8 py-4 bg-white hover:bg-slate-50 text-slate-700 border border-slate-200 rounded-2xl font-bold transition-all text-center">
                        Pelajari Selengkapnya
                    </a>
                </div>

                <!-- Metrics / Stats -->
                <div class="pt-8 border-t border-slate-200/80 grid grid-cols-3 gap-4 max-w-lg mx-auto lg:mx-0">
                    <div>
                        <h3 class="text-2xl sm:text-3xl font-extrabold text-amikom-800">100+</h3>
                        <p class="text-xs sm:text-sm text-slate-500 font-medium">Event Aktif</p>
                    </div>
                    <div>
                        <h3 class="text-2xl sm:text-3xl font-extrabold text-amikom-800">25K+</h3>
                        <p class="text-xs sm:text-sm text-slate-500 font-medium">Mahasiswa</p>
                    </div>
                    <div>
                        <h3 class="text-2xl sm:text-3xl font-extrabold text-amikom-800">99%</h3>
                        <p class="text-xs sm:text-sm text-slate-500 font-medium">Kepuasan</p>
                    </div>
                </div>
            </div>

            <!-- Hero Image Visual -->
            <div class="lg:col-span-5 relative flex justify-center">
                <div class="relative w-full max-w-md lg:max-w-none">
                    <!-- Background Accent Frame -->
                    <div class="absolute -inset-2 bg-gradient-to-r from-amikom-600 to-amber-500 rounded-[36px] blur-lg opacity-30"></div>
                    
                    <img src="{{ asset('assets/concert.png') }}"
                        alt="Amikom Event Concert"
                        class="relative w-full h-[420px] sm:h-[480px] object-cover rounded-[32px] shadow-2xl border border-white/20">

                    <!-- Floating Badge Element -->
                    <div class="absolute -bottom-6 -left-6 sm:bottom-6 sm:-left-6 bg-white/95 backdrop-blur-md p-4 rounded-2xl shadow-xl border border-slate-100 hidden sm:flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center">
                            <i data-lucide="shield-check" class="w-6 h-6"></i>
                        </div>
                        <div>
                            <p class="text-xs font-semibold text-slate-500">Sistem Pembayaran</p>
                            <p class="text-sm font-bold text-slate-800">Resmi & Terverifikasi</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- EVENT CATALOG SECTION -->
<section id="events" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 scroll-mt-20">

    <!-- Section Header & Search Bar -->
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-8">
        <div>
            <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">Eksplorasi Event Kampus</h2>
            <p class="text-slate-500 text-sm sm:text-base mt-1">Pilih kategori event yang ingin kamu ikuti minggu ini.</p>
        </div>

        <!-- Search Form -->
        <form method="GET" action="{{ route('home') }}#events" class="relative min-w-[280px] sm:min-w-[340px]">
            <i data-lucide="search" class="w-5 h-5 absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400"></i>
            <input type="text" 
                   name="search" 
                   value="{{ request('search') }}"
                   placeholder="Cari nama event..." 
                   class="w-full pl-11 pr-4 py-2.5 rounded-xl border border-slate-200 bg-white text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-amikom-600 focus:border-transparent shadow-xs transition">
            @if(request('category'))
                <input type="hidden" name="category" value="{{ request('category') }}">
            @endif
        </form>
    </div>

    <!-- Category Pills Filter -->
    <div class="flex items-center gap-2 overflow-x-auto pb-4 mb-8 scrollbar-none">
        <a href="{{ route('home') }}#events"
           class="{{ !request('category') ? 'bg-amikom-700 text-white shadow-md shadow-amikom-700/20' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200' }} px-5 py-2.5 rounded-xl font-semibold text-sm whitespace-nowrap transition">
            Semua Event
        </a>

        @foreach($categories as $cat)
            <a href="{{ route('home', ['category' => $cat->slug]) }}#events"
               class="{{ request('category') == $cat->slug ? 'bg-amikom-700 text-white shadow-md shadow-amikom-700/20' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200' }} px-5 py-2.5 rounded-xl font-semibold text-sm whitespace-nowrap transition">
                {{ $cat->name }}
            </a>
        @endforeach
    </div>

    <!-- Event Cards Grid -->
    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse($events as $event)

            <div class="group bg-white rounded-3xl overflow-hidden border border-slate-200/80 shadow-xs hover:shadow-xl hover:-translate-y-1.5 transition-all duration-300 flex flex-col">

                <!-- Image & Category Badge -->
                <div class="relative h-56 overflow-hidden bg-slate-100">
                    @if($event->poster_path)
                        @if(str_starts_with($event->poster_path, 'posters/'))
                            <img src="{{ asset('storage/'.$event->poster_path) }}" alt="{{ $event->title }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                        @else
                            <img src="{{ asset('assets/'.$event->poster_path) }}" alt="{{ $event->title }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                        @endif
                    @else
                        <img src="{{ asset('assets/no-image.png') }}" alt="No Poster" class="w-full h-full object-cover">
                    @endif

                    <div class="absolute inset-0 bg-gradient-to-t from-slate-900/60 via-transparent to-transparent"></div>

                    <!-- Category Pill -->
                    <span class="absolute top-4 left-4 bg-white/90 backdrop-blur-md text-amikom-900 text-xs font-bold px-3 py-1.5 rounded-full shadow-sm">
                        {{ $event->category->name }}
                    </span>

                    <!-- Price Badge Option -->
                    <div class="absolute bottom-3 right-4">
                        @if($event->price > 0)
                            <span class="bg-amikom-900/90 backdrop-blur-md text-amber-400 font-extrabold text-sm px-3 py-1 rounded-xl shadow-xs">
                                Rp {{ number_format($event->price, 0, ',', '.') }}
                            </span>
                        @else
                            <span class="bg-emerald-500 text-white font-extrabold text-xs px-3 py-1 rounded-xl shadow-xs uppercase tracking-wider">
                                Gratis
                            </span>
                        @endif
                    </div>
                </div>

                <!-- Event Details Body -->
                <div class="p-6 flex flex-col flex-grow justify-between">
                    <div>
                        <h3 class="text-xl font-bold text-slate-900 group-hover:text-amikom-700 transition line-clamp-2 leading-snug">
                            {{ $event->title }}
                        </h3>

                        <div class="mt-4 space-y-2.5 text-slate-500 text-sm">
                            <div class="flex items-center gap-2.5">
                                <i data-lucide="calendar" class="w-4 h-4 text-amikom-600 shrink-0"></i>
                                <span>{{ \Carbon\Carbon::parse($event->date)->format('d M Y • H:i') }} WIB</span>
                            </div>
                            <div class="flex items-center gap-2.5">
                                <i data-lucide="map-pin" class="w-4 h-4 text-amikom-600 shrink-0"></i>
                                <span class="line-clamp-1">{{ $event->location }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Card Footer Action -->
                    <div class="mt-6 pt-4 border-t border-slate-100 flex items-center justify-between">
                        <span class="text-xs text-slate-400 font-medium">Tiket Resmi</span>
                        
                        <a href="{{ route('events.show', $event) }}"
                           class="inline-flex items-center gap-1.5 text-sm font-bold text-amikom-700 hover:text-amikom-900 transition">
                            <span>Detail Event</span>
                            <i data-lucide="chevron-right" class="w-4 h-4"></i>
                        </a>
                    </div>
                </div>

            </div>

        @empty

            <!-- Empty State -->
            <div class="col-span-full bg-white border border-slate-200/80 rounded-3xl p-12 text-center my-6">
                <div class="w-16 h-16 bg-amikom-50 text-amikom-600 rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <i data-lucide="ticket-slash" class="w-8 h-8"></i>
                </div>
                <h3 class="text-xl font-bold text-slate-800">Event Tidak Ditemukan</h3>
                <p class="text-slate-500 text-sm mt-1 max-w-md mx-auto">
                    Belum ada event yang tersedia untuk kategori ini atau hasil pencarian kamu tidak cocok.
                </p>
                <a href="{{ route('home') }}" class="inline-block mt-6 px-6 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold rounded-xl text-sm transition">
                    Reset Filter
                </a>
            </div>

        @endforelse
    </div>

</section>

<!-- CALL TO ACTION BANNER -->
<section id="about" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-20">
    <div class="relative overflow-hidden rounded-[32px] bg-gradient-to-br from-amikom-900 via-amikom-800 to-purple-900 text-white p-8 sm:p-14 text-center shadow-2xl">
        <!-- Overlay Decorative Patterns -->
        <div class="absolute -right-10 -bottom-10 w-60 h-60 bg-amber-500/10 rounded-full blur-2xl"></div>
        
        <div class="relative z-10 max-w-2xl mx-auto space-y-4">
            <span class="text-amber-400 font-semibold text-xs sm:text-sm uppercase tracking-widest">Komunitas & Ormawa Amikom</span>
            <h2 class="text-3xl sm:text-4xl font-extrabold tracking-tight">Punya Event Mau Dipublikasikan?</h2>
            <p class="text-slate-300 text-sm sm:text-base leading-relaxed">
                Gunakan platform AmikomEventHub untuk mengelola pemesanan tiket seminar atau event organisasi kamu secara otomatis.
            </p>
            <div class="pt-4">
                <a href="mailto:support@amikomeventhub.com"
                   class="inline-flex items-center gap-2 bg-amber-400 hover:bg-amber-300 text-slate-900 px-8 py-3.5 rounded-2xl font-bold shadow-lg hover:scale-105 transition-all duration-200">
                    <i data-lucide="mail" class="w-5 h-5"></i>
                    <span>Hubungi Tim Admin</span>
                </a>
            </div>
        </div>
    </div>
</section>

@endsection