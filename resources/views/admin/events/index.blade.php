@extends('layouts.admin')

@section('content')
    <div class="p-6">

        <!-- Header Page -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">Manajemen Event</h2>
                <p class="text-sm text-gray-500">Kelola semua daftar acara, tiket, dan ketersediaan stok.</p>
            </div>

            <a href="{{ route('admin.events.create') }}"
                class="inline-flex items-center gap-2 bg-indigo-600 text-white px-4 py-2.5 rounded-lg font-semibold shadow hover:bg-indigo-700 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Tambah Event
            </a>
        </div>

        <!-- Alert Notification -->
        @if (session('success'))
            <div class="bg-green-50 text-green-700 border border-green-200 p-4 rounded-lg mb-6 flex items-center justify-between">
                <span>{{ session('success') }}</span>
                <button onclick="this.parentElement.remove()" class="text-green-500 hover:text-green-700">&times;</button>
            </div>
        @endif

        <!-- Filter & Search Bar -->
        <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 mb-6">
            <form method="GET" action="{{ route('admin.events.index') }}" class="flex flex-col md:flex-row gap-3">
                
                <!-- Input Search -->
                <div class="flex-1">
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Cari berdasarkan judul event..."
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition text-sm">
                </div>

                <!-- Select Category Filter -->
                <div class="w-full md:w-56">
                    <select name="category_id" onchange="this.form.submit()"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none transition text-sm">
                        <option value="">Semua Kategori</option>
                        @isset($categories)
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" @selected(request('category_id') == $category->id)>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        @endisset
                    </select>
                </div>

                <!-- Submit / Reset Buttons -->
                <div class="flex gap-2">
                    <button type="submit" class="bg-gray-800 text-white px-4 py-2 rounded-lg text-sm hover:bg-gray-900 transition">
                        Cari
                    </button>
                    @if(request('search') || request('category_id'))
                        <a href="{{ route('admin.events.index') }}" class="bg-gray-200 text-gray-700 px-4 py-2 rounded-lg text-sm hover:bg-gray-300 transition">
                            Reset
                        </a>
                    @endif
                </div>

            </form>
        </div>

        <!-- Data Table -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">

                    <thead class="bg-gray-50 text-gray-500 uppercase text-xs font-semibold tracking-wider border-b">
                        <tr>
                            <th class="p-4 text-center w-12">No</th>
                            <th class="p-4 text-center">Poster</th>
                            <th class="p-4">Judul Event</th>
                            <th class="p-4">Kategori</th>
                            <th class="p-4">Tanggal</th>
                            <th class="p-4">Lokasi</th>
                            <th class="p-4 text-right">Harga</th>
                            <th class="p-4 text-center">Stok</th>
                            <th class="p-4 text-center">Aksi</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-100 text-sm text-gray-700">

                        @forelse($events as $event)
                            <tr class="hover:bg-gray-50/80 transition">

                                <td class="p-4 text-center font-medium text-gray-400">
                                    {{ $loop->iteration + ($events->currentPage() - 1) * $events->perPage() }}
                                </td>

                                <td class="p-4 text-center">
                                    @if ($event->poster_path)
                                        <img src="{{ asset('storage/' . $event->poster_path) }}" alt="{{ $event->title }}"
                                            class="w-16 h-20 object-cover rounded-md shadow-sm mx-auto">
                                    @else
                                        <div class="w-16 h-20 bg-gray-100 rounded-md border border-gray-200 flex items-center justify-center text-xs text-gray-400 mx-auto">
                                            No Poster
                                        </div>
                                    @endif
                                </td>

                                <td class="p-4 font-semibold text-gray-900">
                                    {{ $event->title }}
                                </td>

                                <td class="p-4">
                                    <span class="inline-block bg-indigo-50 text-indigo-700 px-2.5 py-1 rounded-full text-xs font-medium">
                                        {{ $event->category->name ?? 'Uncategorized' }}
                                    </span>
                                </td>

                                <td class="p-4 whitespace-nowrap">
                                    {{ \Carbon\Carbon::parse($event->date)->format('d M Y') }}
                                    <span class="block text-xs text-gray-400">{{ \Carbon\Carbon::parse($event->date)->format('H:i') }} WIB</span>
                                </td>

                                <td class="p-4">
                                    {{ $event->location }}
                                </td>

                                <td class="p-4 text-right font-medium">
                                    @if($event->price > 0)
                                        Rp {{ number_format($event->price, 0, ',', '.') }}
                                    @else
                                        <span class="text-green-600 font-bold">Gratis</span>
                                    @endif
                                </td>

                                <td class="p-4 text-center">
                                    @if($event->stock > 10)
                                        <span class="bg-gray-100 text-gray-800 px-2.5 py-0.5 rounded text-xs font-medium">{{ $event->stock }}</span>
                                    @elseif($event->stock > 0)
                                        <span class="bg-amber-100 text-amber-800 px-2.5 py-0.5 rounded text-xs font-medium">{{ $event->stock }}</span>
                                    @else
                                        <span class="bg-red-100 text-red-800 px-2.5 py-0.5 rounded text-xs font-medium">Habis</span>
                                    @endif
                                </td>

                                <td class="p-4 text-center whitespace-nowrap">
                                    <div class="inline-flex items-center gap-1">
                                        <a href="{{ route('admin.events.edit', $event->id) }}"
                                            class="p-2 bg-amber-50 text-amber-600 hover:bg-amber-500 hover:text-white rounded-lg transition"
                                            title="Edit Event">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 00-2 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                        </a>

                                        <form action="{{ route('admin.events.destroy', $event->id) }}" method="POST"
                                            class="inline-block"
                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus event ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="p-2 bg-red-50 text-red-600 hover:bg-red-600 hover:text-white rounded-lg transition"
                                                title="Hapus Event">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="p-12 text-center text-gray-400">
                                    <svg class="w-12 h-12 mx-auto mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    <p class="font-medium text-gray-600">Belum ada data event.</p>
                                    <p class="text-xs text-gray-400 mt-1">Gunakan tombol "Tambah Event" di atas untuk membuat acara baru.</p>
                                </td>
                            </tr>
                        @endforelse

                    </tbody>

                </table>
            </div>

            <!-- Pagination Footer -->
            @if($events->hasPages())
                <div class="px-6 py-4 border-t bg-gray-50/50">
                    {{ $events->links() }}
                </div>
            @endif
        </div>

    </div>
@endsection