@extends('layouts.admin')

@section('title', 'Edit Event - Admin')

@section('content')
<main class="flex-1 p-6 md:p-10 overflow-y-auto">

    <!-- Header Page & Back Button -->
    <div class="mb-8">
        <a href="{{ route('admin.events.index') }}" 
           class="inline-flex items-center gap-2 text-sm font-bold text-slate-500 hover:text-indigo-600 transition mb-3">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Kembali ke Data Event
        </a>
        <h1 class="text-3xl font-black text-slate-800">Edit Event</h1>
        <p class="text-slate-500 font-medium mt-1">Perbarui rincian, jadwal, atau poster event yang sudah terdaftar.</p>
    </div>

    <!-- Form Card -->
    <div class="max-w-4xl bg-white rounded-[2.5rem] border border-slate-100 shadow-sm p-8" 
         x-data="{ imagePreview: '{{ $event->poster_path ? asset('storage/'.$event->poster_path) : '' }}' }">
        
        <form action="{{ route('admin.events.update', $event) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                
                <!-- Judul Event -->
                <div class="md:col-span-2">
                    <label for="title" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">
                        Judul Event <span class="text-rose-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        id="title"
                        name="title" 
                        value="{{ old('title', $event->title) }}" 
                        placeholder="Contoh: Konser Musik Amikom Soundfest 2026"
                        class="w-full px-5 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition text-sm text-slate-800 placeholder:text-slate-300 font-medium @error('title') border-rose-300 bg-rose-50/30 @enderror"
                        required>
                    @error('title')
                        <p class="text-xs text-rose-500 mt-1.5 font-semibold">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Kategori -->
                <div>
                    <label for="category_id" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">
                        Kategori <span class="text-rose-500">*</span>
                    </label>
                    <select 
                        id="category_id"
                        name="category_id" 
                        class="w-full px-5 py-3 rounded-xl border border-slate-200 bg-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition text-sm text-slate-700 font-medium cursor-pointer @error('category_id') border-rose-300 bg-rose-50/30 @enderror"
                        required>
                        <option value="" disabled>-- Pilih Kategori --</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id', $event->category_id) == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <p class="text-xs text-rose-500 mt-1.5 font-semibold">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tanggal & Waktu -->
                <div>
                    <label for="date" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">
                        Tanggal & Waktu <span class="text-rose-500">*</span>
                    </label>
                    <input 
                        type="datetime-local" 
                        id="date"
                        name="date" 
                        value="{{ old('date', date('Y-m-d\TH:i', strtotime($event->date))) }}"
                        class="w-full px-5 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition text-sm text-slate-700 font-medium @error('date') border-rose-300 bg-rose-50/30 @enderror"
                        required>
                    @error('date')
                        <p class="text-xs text-rose-500 mt-1.5 font-semibold">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Lokasi -->
                <div class="md:col-span-2">
                    <label for="location" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">
                        Lokasi / Tempat <span class="text-rose-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        id="location"
                        name="location" 
                        value="{{ old('location', $event->location) }}" 
                        placeholder="Contoh: Gedung Olahraga Amikom / Zoom Meeting"
                        class="w-full px-5 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition text-sm text-slate-800 placeholder:text-slate-300 font-medium @error('location') border-rose-300 bg-rose-50/30 @enderror"
                        required>
                    @error('location')
                        <p class="text-xs text-rose-500 mt-1.5 font-semibold">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Harga -->
                <div>
                    <label for="price" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">
                        Harga Tiket (Rp) <span class="text-rose-500">*</span>
                    </label>
                    <input 
                        type="number" 
                        id="price"
                        name="price" 
                        value="{{ old('price', $event->price) }}" 
                        placeholder="0 jika gratis"
                        min="0"
                        class="w-full px-5 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition text-sm text-slate-800 placeholder:text-slate-300 font-medium @error('price') border-rose-300 bg-rose-50/30 @enderror"
                        required>
                    @error('price')
                        <p class="text-xs text-rose-500 mt-1.5 font-semibold">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Stok -->
                <div>
                    <label for="stock" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">
                        Jumlah Stok Tiket <span class="text-rose-500">*</span>
                    </label>
                    <input 
                        type="number" 
                        id="stock"
                        name="stock" 
                        value="{{ old('stock', $event->stock) }}" 
                        placeholder="Contoh: 100"
                        min="0"
                        class="w-full px-5 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition text-sm text-slate-800 placeholder:text-slate-300 font-medium @error('stock') border-rose-300 bg-rose-50/30 @enderror"
                        required>
                    @error('stock')
                        <p class="text-xs text-rose-500 mt-1.5 font-semibold">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Deskripsi -->
                <div class="md:col-span-2">
                    <label for="description" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">
                        Deskripsi Event <span class="text-rose-500">*</span>
                    </label>
                    <textarea 
                        id="description"
                        name="description" 
                        rows="4" 
                        placeholder="Tuliskan rincian acara, pemateri, atau instruksi penting bagi peserta..."
                        class="w-full px-5 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition text-sm text-slate-800 placeholder:text-slate-300 font-medium @error('description') border-rose-300 bg-rose-50/30 @enderror"
                        required>{{ old('description', $event->description) }}</textarea>
                    @error('description')
                        <p class="text-xs text-rose-500 mt-1.5 font-semibold">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Upload / Update Poster Event -->
                <div class="md:col-span-2">
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">
                        Poster Event (Kosongkan jika tidak ingin mengubah)
                    </label>
                    
                    <div class="flex flex-col sm:flex-row items-start sm:items-center gap-5 p-4 rounded-2xl border border-dashed border-slate-200 bg-slate-50/50">
                        <!-- Box Preview Gambar -->
                        <div class="w-32 h-32 rounded-xl border border-slate-200 bg-white p-1 flex items-center justify-center shrink-0 overflow-hidden shadow-sm">
                            <template x-if="imagePreview">
                                <img :src="imagePreview" class="w-full h-full object-cover rounded-lg">
                            </template>
                            <template x-if="!imagePreview">
                                <div class="text-center p-2">
                                    <svg class="w-8 h-8 text-slate-300 mx-auto mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 002 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    <span class="text-[10px] font-semibold text-slate-400">Tidak ada gambar</span>
                                </div>
                            </template>
                        </div>

                        <!-- Input File -->
                        <div class="flex-1 w-full">
                            <input 
                                type="file" 
                                id="poster"
                                name="poster" 
                                accept="image/*"
                                @change="const file = $event.target.files[0]; if (file) { imagePreview = URL.createObjectURL(file) }"
                                class="block w-full text-sm text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-indigo-50 file:text-indigo-600 hover:file:bg-indigo-100 transition cursor-pointer">
                            <p class="text-xs text-slate-400 mt-2 font-medium">Format: JPG, PNG, WEBP. Maksimal ukuran file 2MB.</p>
                            @error('poster')
                                <p class="text-xs text-rose-500 mt-1.5 font-semibold">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

            </div>

            <!-- Form Actions -->
            <div class="flex items-center justify-end gap-3 pt-6 border-t border-slate-100">
                <a href="{{ route('admin.events.index') }}" 
                   class="px-6 py-3 bg-slate-100 text-slate-600 hover:bg-slate-200 font-bold rounded-xl text-sm transition">
                    Batal
                </a>
                <button type="submit" 
                        class="px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl text-sm shadow-md shadow-indigo-100 active:scale-95 transition flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Perbarui Event
                </button>
            </div>

        </form>
    </div>

</main>
@endsection