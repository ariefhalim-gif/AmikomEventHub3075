@extends('layouts.admin')

@section('title', 'Kelola Event')

@section('content')
    <main class="flex-1 p-10 overflow-y-auto">

        <!-- Header -->
        <header class="flex justify-between items-center mb-10">
            <div>
                <h1 class="text-3xl font-black">Kelola Event</h1>
                <p class="text-slate-500 font-medium">Buat dan atur acara seru Anda di sini.</p>
            </div>
            <a href="{{ route('admin.events.create') }}"
                class="px-6 py-3 bg-indigo-600 text-white rounded-2xl font-bold shadow-lg shadow-indigo-100 hover:bg-indigo-700 active:scale-95 transition flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Tambah Event Baru
            </a>
        </header>

        <!-- Notification Alert -->
        @if (session('success'))
            <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-2xl font-medium text-sm flex items-center justify-between">
                <span>{{ session('success') }}</span>
                <button onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700">&times;</button>
            </div>
        @endif

        <!-- Filter & Main Content Card -->
        <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden">
            
            <!-- Filter Bar -->
            <form method="GET" action="{{ route('admin.events.index') }}" class="px-8 py-6 bg-slate-50/50 border-b flex flex-col md:flex-row gap-4">
                <div class="flex-1 relative">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama event..."
                        class="w-full px-5 py-3 rounded-xl border-slate-200 border bg-white focus:ring-2 focus:ring-indigo-500 outline-none transition">
                </div>
                
                <select name="category_id" onchange="this.form.submit()" class="px-5 py-3 rounded-xl border-slate-200 border bg-white outline-none cursor-pointer">
                    <option value="">Semua Kategori</option>
                    <select name="category_id" onchange="this.form.submit()" class="px-5 py-3 rounded-xl border-slate-200 border bg-white outline-none cursor-pointer">
    <option value="">Semua Kategori</option>
    
    @isset($categories)
        @foreach ($categories as $category)
            <option value="{{ $category->id }}" @selected(request('category_id') == $category->id)>
                {{ $category->name }}
            </option>
        @endforeach
    @endisset
</select>
                </select>

                @if(request('search') || request('category_id'))
                    <a href="{{ route('admin.events.index') }}" class="px-5 py-3 bg-slate-200 text-slate-600 rounded-xl font-bold hover:bg-slate-300 transition text-center">
                        Reset
                    </a>
                @endif
            </form>

            <!-- Table Data -->
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-slate-50 text-slate-400 uppercase text-[10px] font-black tracking-widest">
                        <tr>
                            <th class="px-8 py-4 w-16">No</th>
                            <th class="px-8 py-4">Poster</th>
                            <th class="px-8 py-4">Event</th>
                            <th class="px-8 py-4">Harga / Stok</th>
                            <th class="px-8 py-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y border-t">
                        @forelse($events as $index => $event)
                            <tr class="hover:bg-slate-50/50 transition">
                                <td class="px-8 py-6 font-bold text-slate-400">
                                    {{ $events->firstItem() + $index }}
                                </td>
                                <td class="px-8 py-6">
                                    @if ($event->poster)
                                        <img src="{{ Storage::url($event->poster) }}" alt="{{ $event->title }}"
                                            class="w-16 h-20 rounded-xl object-cover shadow-sm border border-slate-100">
                                    @else
                                        <div class="w-16 h-20 bg-slate-100 rounded-xl flex items-center justify-center text-slate-400 text-xs font-bold">
                                            No Poster
                                        </div>
                                    @endif
                                </td>
                                <td class="px-8 py-6">
                                    <p class="font-black text-slate-800 text-base">{{ $event->title }}</p>
                                    <p class="text-xs text-slate-400 mt-1">
                                        {{ $event->category->name ?? 'Uncategorized' }} • {{ \Carbon\Carbon::parse($event->date)->format('d M Y') }}
                                    </p>
                                </td>
                                <td class="px-8 py-6">
                                    <p class="font-bold text-indigo-600">
                                        {{ $event->price > 0 ? 'Rp ' . number_format($event->price, 0, ',', '.') : 'Gratis' }}
                                    </p>
                                    <p class="text-xs text-slate-400 mt-1">
                                        Stok: <span class="font-bold {{ $event->stock < 10 ? 'text-rose-500' : 'text-slate-600' }}">{{ $event->stock }}</span>
                                    </p>
                                </td>
                                <td class="px-8 py-6">
                                    <div class="flex justify-center gap-2">
                                        <a href="{{ route('admin.events.edit', $event->id) }}"
                                            class="p-2.5 bg-indigo-50 text-indigo-600 rounded-xl hover:bg-indigo-600 hover:text-white transition"
                                            title="Edit Event">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 00-2 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                                </path>
                                            </svg>
                                        </a>

                                        <form action="{{ route('admin.events.destroy', $event->id) }}" method="POST"
                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus event ini? Data yang dihapus tidak dapat dikembalikan.')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="p-2.5 bg-rose-50 text-rose-600 rounded-xl hover:bg-rose-600 hover:text-white transition"
                                                title="Hapus Event">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                    </path>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-12 text-slate-400">
                                    <svg class="w-12 h-12 mx-auto mb-3 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    <p class="font-semibold text-base">Belum ada data event.</p>
                                    <p class="text-xs text-slate-400 mt-1">Silakan klik "+ Tambah Event Baru" untuk membuat acara baru.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Footer / Pagination -->
            @if($events->hasPages())
                <div class="px-8 py-6 border-t bg-slate-50/50">
                    {{ $events->links() }}
                </div>
            @endif

        </div>
    </main>
@endsection