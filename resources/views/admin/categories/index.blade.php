@extends('layouts.admin')

@section('title', 'Manajemen Kategori - Admin')

@section('content')
<!-- Mencegah 'Flicker' Modal saat Reload -->
<style>
    [x-cloak] { display: none !important; }
</style>

<main class="flex-1 p-6 md:p-10 overflow-y-auto" 
      x-data="{ 
          createModal: {{ $errors->has('name') && !old('id') ? 'true' : 'false' }}, 
          editModal: {{ $errors->has('name') && old('id') ? 'true' : 'false' }}, 
          activeCategory: { 
              id: '{{ old('id') }}', 
              name: '{{ old('name') }}', 
              description: '{{ old('description') }}' 
          } 
      }">

    <!-- Header Page -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
        <div>
            <h1 class="text-3xl font-black text-slate-800">Manajemen Kategori</h1>
            <p class="text-slate-500 font-medium mt-1">Kelola kategori acara untuk mempermudah pencarian event pembeli.</p>
        </div>

        <button @click="createModal = true" 
            class="px-5 py-2.5 bg-indigo-600 text-white rounded-xl font-bold shadow-md shadow-indigo-100 hover:bg-indigo-700 active:scale-95 transition flex items-center gap-2 text-sm">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Tambah Kategori
        </button>
    </div>

    <!-- Alert Status -->
    @if (session('success'))
        <div class="bg-emerald-50 text-emerald-700 border border-emerald-200 p-4 rounded-2xl mb-6 flex items-center justify-between text-sm font-semibold">
            <span>{{ session('success') }}</span>
            <button onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700">&times;</button>
        </div>
    @endif

    @if (session('error'))
        <div class="bg-rose-50 text-rose-700 border border-rose-200 p-4 rounded-2xl mb-6 flex items-center justify-between text-sm font-semibold">
            <span>{{ session('error') }}</span>
            <button onclick="this.parentElement.remove()" class="text-rose-500 hover:text-rose-700">&times;</button>
        </div>
    @endif

    <!-- Card Principal -->
    <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden">

        <!-- Search Bar -->
        <form method="GET" action="{{ route('admin.categories') }}" class="p-6 bg-slate-50/50 border-b flex flex-col md:flex-row gap-4">
            <div class="flex-1 relative">
                <input type="text" name="search" value="{{ request('search') }}" 
                    placeholder="Cari nama atau deskripsi kategori..."
                    class="w-full px-5 py-2.5 rounded-xl border-slate-200 border bg-white focus:ring-2 focus:ring-indigo-500 outline-none transition text-sm">
            </div>
            <div class="flex gap-2">
                <button type="submit" class="px-5 py-2.5 bg-slate-800 text-white rounded-xl text-sm font-bold hover:bg-slate-900 transition">
                    Cari
                </button>
                @if(request('search'))
                    <a href="{{ route('admin.categories') }}" class="px-5 py-2.5 bg-slate-200 text-slate-600 rounded-xl text-sm font-bold hover:bg-slate-300 transition text-center">
                        Reset
                    </a>
                @endif
            </div>
        </form>

        <!-- Table Kategori -->
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-slate-50 text-slate-400 uppercase text-[10px] font-black tracking-widest border-b">
                    <tr>
                        <th class="px-8 py-4 text-center w-16">No</th>
                        <th class="px-8 py-4">Nama Kategori</th>
                        <th class="px-8 py-4">Deskripsi</th>
                        <th class="px-8 py-4 text-center">Jumlah Event</th>
                        <th class="px-8 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y border-t text-sm text-slate-700">
                    @forelse($categories as $category)
                        <tr class="hover:bg-slate-50/50 transition">
                            <td class="px-8 py-6 text-center font-bold text-slate-400">
                                {{ $loop->iteration + ($categories->currentPage() - 1) * $categories->perPage() }}
                            </td>
                            <td class="px-8 py-6 font-bold text-slate-800">
                                {{ $category->name }}
                                <span class="block text-xs text-slate-400 font-normal">/{{ $category->slug }}</span>
                            </td>
                            <td class="px-8 py-6 text-slate-500 max-w-md">
                                {{ $category->description ?? '-' }}
                            </td>
                            <td class="px-8 py-6 text-center">
                                <span class="px-3 py-1 bg-indigo-50 text-indigo-600 rounded-full text-xs font-bold">
                                    {{ $category->events_count ?? $category->events()->count() }} Event
                                </span>
                            </td>
                            <td class="px-8 py-6 text-center whitespace-nowrap">
                                <div class="inline-flex items-center gap-2">
                                    <!-- Edit Button -->
                                    <button @click="editModal = true; activeCategory = { id: {{ $category->id }}, name: '{{ addslashes($category->name) }}', description: '{{ addslashes($category->description ?? '') }}' }"
                                        class="p-2 bg-amber-50 text-amber-600 hover:bg-amber-500 hover:text-white rounded-xl transition" title="Edit Kategori">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 00-2 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                    </button>

                                    <!-- Delete Button -->
                                    <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" class="inline-block"
                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 bg-rose-50 text-rose-600 hover:bg-rose-600 hover:text-white rounded-xl transition" title="Hapus Kategori">
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
                            <td colspan="5" class="text-center py-12 text-slate-400">
                                <p class="font-bold text-slate-600">Belum ada kategori ditemukan.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($categories->hasPages())
            <div class="px-8 py-6 bg-slate-50/50 border-t">
                {{ $categories->links() }}
            </div>
        @endif
    </div>

    <!-- Modal Tambah Kategori -->
    <div x-show="createModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/40 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="bg-white rounded-3xl max-w-md w-full p-6 shadow-xl border border-slate-100" @click.away="createModal = false">
            <h3 class="text-xl font-bold text-slate-800 mb-4">Tambah Kategori Baru</h3>
            <form action="{{ route('admin.categories.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Nama Kategori</label>
                    <input type="text" name="name" value="{{ old('name') }}" required placeholder="Contoh: Concerts, Seminar"
                        class="w-full px-4 py-2.5 rounded-xl border-slate-200 border outline-none focus:ring-2 focus:ring-indigo-500 text-sm">
                    @error('name')
                        <span class="text-xs text-rose-500 mt-1 block font-medium">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-6">
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Deskripsi</label>
                    <textarea name="description" rows="3" placeholder="Keterangan singkat kategori..."
                        class="w-full px-4 py-2.5 rounded-xl border-slate-200 border outline-none focus:ring-2 focus:ring-indigo-500 text-sm">{{ old('description') }}</textarea>
                </div>
                <div class="flex justify-end gap-3">
                    <button type="button" @click="createModal = false" class="px-5 py-2.5 bg-slate-100 text-slate-600 font-bold rounded-xl text-sm hover:bg-slate-200 transition">Batal</button>
                    <button type="submit" class="px-5 py-2.5 bg-indigo-600 text-white font-bold rounded-xl text-sm hover:bg-indigo-700 transition">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Edit Kategori -->
    <div x-show="editModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/40 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="bg-white rounded-3xl max-w-md w-full p-6 shadow-xl border border-slate-100" @click.away="editModal = false">
            <h3 class="text-xl font-bold text-slate-800 mb-4">Edit Kategori</h3>
            <form :action="'{{ url('admin/categories') }}/' + activeCategory.id" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="id" :value="activeCategory.id">
                
                <div class="mb-4">
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Nama Kategori</label>
                    <input type="text" name="name" x-model="activeCategory.name" required
                        class="w-full px-4 py-2.5 rounded-xl border-slate-200 border outline-none focus:ring-2 focus:ring-indigo-500 text-sm">
                    @error('name')
                        <span class="text-xs text-rose-500 mt-1 block font-medium">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-6">
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Deskripsi</label>
                    <textarea name="description" rows="3" x-model="activeCategory.description"
                        class="w-full px-4 py-2.5 rounded-xl border-slate-200 border outline-none focus:ring-2 focus:ring-indigo-500 text-sm"></textarea>
                </div>
                <div class="flex justify-end gap-3">
                    <button type="button" @click="editModal = false" class="px-5 py-2.5 bg-slate-100 text-slate-600 font-bold rounded-xl text-sm hover:bg-slate-200 transition">Batal</button>
                    <button type="submit" class="px-5 py-2.5 bg-indigo-600 text-white font-bold rounded-xl text-sm hover:bg-indigo-700 transition">Perbarui</button>
                </div>
            </form>
        </div>
    </div>

</main>
@endsection