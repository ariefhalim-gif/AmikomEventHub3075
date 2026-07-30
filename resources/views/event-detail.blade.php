@extends('layouts.app')

@section('title', $event->title)

@section('content')
    <main class="max-w-7xl mx-auto px-6 py-12 grid grid-cols-1 lg:grid-cols-3 gap-12">

        <!-- Left Column: Poster & Category -->
        <div class="lg:col-span-1">
            <div class="sticky top-32 space-y-6">

                <!-- Poster -->
                <div class="overflow-hidden rounded-[2.5rem] shadow-2xl border-8 border-white bg-slate-100">
                    @if ($event->poster_path)
                        <img src="{{ asset('storage/' . $event->poster_path) }}" alt="{{ $event->title }}"
                             class="w-full h-auto object-cover">
                    @else
                        <img src="https://placehold.co/600x800?text=No+Poster" alt="No Poster"
                             class="w-full h-auto object-cover">
                    @endif
                </div>

                <!-- Category Info -->
                <div class="p-6 bg-white rounded-3xl border border-slate-100 shadow-sm">
                    <h4 class="font-bold mb-4 text-slate-800">Kategori Event</h4>
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-indigo-100 rounded-full flex items-center justify-center text-indigo-600 font-bold">
                            {{ strtoupper(substr($event->category?->name ?? 'EV', 0, 2)) }}
                        </div>
                        <div>
                            <p class="font-bold text-slate-800">
                                {{ $event->category?->name ?? 'Umum' }}
                            </p>
                            <p class="text-xs text-slate-500">
                                Event Category
                            </p>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!-- Right Column: Event Details -->
        <div class="lg:col-span-2 space-y-12">

            <!-- Title & Metadata -->
            <div class="space-y-4">
                <span class="inline-block px-4 py-1.5 bg-indigo-100 text-indigo-700 rounded-full text-sm font-bold uppercase tracking-wider">
                    {{ $event->category?->name ?? 'Umum' }}
                </span>

                <h1 class="text-4xl md:text-5xl font-black text-slate-900 leading-tight">
                    {{ $event->title }}
                </h1>

                <div class="flex flex-wrap gap-6 text-slate-500 font-medium pt-2">
                    <!-- Date -->
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                            </path>
                        </svg>
                        <span>
                            {{ \Carbon\Carbon::parse($event->date)->format('d F Y') }}
                        </span>
                    </div>

                    <!-- Location -->
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                            </path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M15 11a3 3 0 11-6 0 3 3 0 016 0z">
                            </path>
                        </svg>
                        <span>
                            {{ $event->location }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Description -->
            <div class="prose prose-slate max-w-none">
                <h3 class="text-2xl font-bold mb-4 text-slate-800">
                    Deskripsi Event
                </h3>
                <p class="text-lg text-slate-600 leading-relaxed whitespace-pre-line">
                    {{ $event->description }}
                </p>
            </div>

            <!-- Price & Ticket Purchase Card -->
            <div class="bg-indigo-600 rounded-[2.5rem] p-8 md:p-12 text-white shadow-2xl shadow-indigo-200 relative overflow-hidden">
                <div class="relative z-10 flex flex-col md:flex-row justify-between items-center gap-8">
                    <div>
                        <p class="text-indigo-200 font-bold uppercase tracking-widest text-sm mb-2">
                            Harga Tiket
                        </p>
                        <h2 class="text-4xl md:text-5xl font-black">
                            Rp {{ number_format($event->price, 0, ',', '.') }}
                            <span class="text-lg font-medium text-indigo-200">
                                / orang
                            </span>
                        </h2>

                        <p class="mt-4 text-indigo-100 flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                </path>
                            </svg>
                            Sisa stok:
                            <span class="font-bold underline">
                                @if($event->stock > 0)
                                    {{ $event->stock }} Tiket lagi!
                                @else
                                    Habis Terjual
                                @endif
                            </span>
                        </p>
                    </div>

                    <div>
                        @if($event->stock > 0)
                            <a href="{{ route('checkout', $event) }}"
                               class="inline-block px-10 py-5 bg-white text-indigo-600 rounded-2xl font-black text-xl hover:scale-105 transition-transform shadow-xl">
                                Pesan Sekarang
                            </a>
                        @else
                            <button disabled
                                    class="inline-block px-10 py-5 bg-slate-300 text-slate-500 rounded-2xl font-black text-xl cursor-not-allowed shadow-inner">
                                Tiket Habis
                            </button>
                        @endif
                    </div>
                </div>

                <!-- Decorative circles -->
                <div class="absolute -right-20 -bottom-20 w-64 h-64 bg-white opacity-10 rounded-full"></div>
                <div class="absolute -left-10 -top-10 w-32 h-32 bg-indigo-400 opacity-20 rounded-full"></div>
            </div>

            <!-- Policies -->
            <div class="space-y-4">
                <h3 class="text-xl font-bold text-slate-800">
                    Kebijakan Tiket
                </h3>
                <ul class="space-y-3 text-slate-500">
                    <li class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-green-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span>E-Ticket akan dikirim otomatis setelah pembayaran berhasil.</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-green-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span>Tiket dapat digunakan satu kali saat check-in.</span>
                    </li>
                    <li class="flex items-start gap-3 text-rose-500">
                        <svg class="w-5 h-5 text-rose-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                            </path>
                        </svg>
                        <span>Tiket yang sudah dibeli tidak dapat direfund.</span>
                    </li>
                </ul>
            </div>

            <!-- Rating & Reviews Section -->
            <div class="space-y-8 pt-6 border-t border-slate-100">

                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-3xl font-bold text-slate-800">
                            Rating & Review
                        </h2>
                        <p class="text-slate-500 mt-1">
                            Penilaian dari peserta event.
                        </p>
                    </div>

                    <div class="text-right">
                        <h3 class="text-4xl md:text-5xl font-black text-yellow-500">
                            @if ($event->totalReviews())
                                ⭐ {{ number_format($event->averageRating(), 1) }}
                            @else
                                -
                            @endif
                        </h3>
                        <p class="text-slate-500 text-sm mt-1">
                            {{ $event->totalReviews() }} Review
                        </p>
                    </div>
                </div>

                <!-- Review Form (Authenticated users who haven't reviewed yet) -->
                @auth
                    @if (!$event->reviews->where('user_id', auth()->id())->count())
                        <form action="{{ route('reviews.store', $event) }}" method="POST"
                              class="bg-white rounded-3xl p-8 shadow-sm border border-slate-200">
                            @csrf

                            <h3 class="text-xl font-bold mb-6 text-slate-800">
                                Berikan Review
                            </h3>

                            <div class="mb-6">
                                <label for="rating" class="block font-semibold text-slate-700 mb-2">
                                    Rating
                                </label>
                                <select id="rating" name="rating" class="w-full rounded-xl border-slate-300 focus:border-indigo-500 focus:ring-indigo-500">
                                    @for ($i = 5; $i >= 1; $i--)
                                        <option value="{{ $i }}">
                                            {{ $i }} ⭐
                                        </option>
                                    @endfor
                                </select>
                            </div>

                            <div class="mb-6">
                                <label for="review" class="block font-semibold text-slate-700 mb-2">
                                    Review
                                </label>
                                <textarea id="review" name="review" rows="4" required
                                          class="w-full rounded-xl border-slate-300 focus:border-indigo-500 focus:ring-indigo-500"
                                          placeholder="Bagaimana pengalaman mengikuti event ini?"></textarea>
                            </div>

                            <button type="submit" class="bg-indigo-600 text-white font-bold px-8 py-3 rounded-xl hover:bg-indigo-700 transition-colors">
                                Kirim Review
                            </button>
                        </form>
                    @endif
                @endauth

                <!-- Reviews List -->
                <div class="space-y-6">
                    @forelse($event->reviews as $review)
                        <div class="bg-white rounded-3xl p-6 border border-slate-100 shadow-sm">
                            <div class="flex justify-between items-center mb-4">
                                <div>
                                    <h4 class="font-bold text-slate-800">
                                        {{ $review->user->name }}
                                    </h4>
                                    <p class="text-xs text-slate-400">
                                        {{ $review->created_at->format('d M Y') }}
                                    </p>
                                </div>

                                <div class="text-yellow-500 text-lg">
                                    @for ($i = 1; $i <= 5; $i++)
                                        @if ($i <= $review->rating)
                                            ⭐
                                        @else
                                            ☆
                                        @endif
                                    @endfor
                                </div>
                            </div>

                            <p class="text-slate-600 leading-relaxed">
                                {{ $review->review }}
                            </p>
                        </div>
                    @empty
                        <div class="text-center py-16 bg-slate-50 rounded-3xl border border-dashed border-slate-200">
                            <div class="text-5xl mb-3">⭐</div>
                            <h3 class="text-xl font-bold text-slate-700">
                                Belum Ada Review
                            </h3>
                            <p class="text-slate-500 mt-1">
                                Jadilah peserta pertama yang memberikan ulasan.
                            </p>
                        </div>
                    @endforelse
                </div>

            </div>

        </div>

    </main>
@endsection