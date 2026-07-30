@extends('layouts.admin')

@section('title', 'Tambah Partner - Admin')

@section('content')
<main class="flex-1 p-6 md:p-10 overflow-y-auto">

    <!-- Header Page & Back Button -->
    <div class="mb-8">
        <a href="{{ route('admin.partners.index') }}" 
           class="inline-flex items-center gap-2 text-sm font-bold text-slate-500 hover:text-indigo-600 transition mb-3">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Kembali ke Data Partner
        </a>
        <h1 class="text-3xl font-black text-slate-800">Tambah Partner Baru</h1>
        <p class="text-slate-500 font-medium mt-1">Tambahkan partner atau sponsor baru ke sistem.</p>
    </div>

    <!-- Form Card -->
    <div class="max-w-2xl bg-white rounded-[2.5rem] border border-slate-100 shadow-sm p-8" x-data="{ selectedLogo: '{{ old('logo_url', 'https://placehold.co/200x200') }}' }">
        
        <form action="{{ route('admin.partners.store') }}" method="POST">
            @csrf

            <!-- Nama Partner -->
            <div class="mb-6">
                <label for="name" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">
                    Nama Partner <span class="text-rose-500">*</span>
                </label>
                <input 
                    type="text" 
                    id="name"
                    name="name" 
                    value="{{ old('name') }}" 
                    placeholder="Contoh: PT Tokopedia, Amikom Center"
                    class="w-full px-5 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition text-sm text-slate-800 placeholder:text-slate-300 font-medium @error('name') border-rose-300 bg-rose-50/30 @enderror"
                    required>
                @error('name')
                    <p class="text-xs text-rose-500 mt-1.5 font-semibold">{{ $message }}</p>
                @enderror
            </div>

            <!-- Logo Selection & Preview -->
            <div class="mb-8">
                <label for="logo_url" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">
                    Pilih Logo Partner <span class="text-rose-500">*</span>
                </label>
                
                <div class="flex flex-col sm:flex-row items-start sm:items-center gap-5">
                    <!-- Preview Image Box -->
                    <div class="w-24 h-24 rounded-2xl border-2 border-dashed border-slate-200 bg-slate-50/50 p-2 flex items-center justify-center shrink-0 overflow-hidden shadow-inner">
                        <img :src="selectedLogo" alt="Preview Logo" class="max-w-full max-h-full object-contain rounded-lg">
                    </div>

                    <!-- Select Input -->
                    <div class="flex-1 w-full">
                        <select 
                            id="logo_url"
                            name="logo_url" 
                            x-model="selectedLogo"
                            class="w-full px-5 py-3 rounded-xl border border-slate-200 bg-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition text-sm text-slate-700 font-medium cursor-pointer @error('logo_url') border-rose-300 bg-rose-50/30 @enderror">
                            <option value="https://placehold.co/200x200">Placeholder Standard (Abu-abu)</option>
                            <option value="https://placehold.co/200x200/4F46E5/FFFFFF">Placeholder Indigo</option>
                            <option value="https://placehold.co/200x200/059669/FFFFFF">Placeholder Emerald (Hijau)</option>
                            <option value="https://placehold.co/200x200/D97706/FFFFFF">Placeholder Amber (Oranye)</option>
                        </select>
                        <p class="text-xs text-slate-400 mt-2 font-medium">Pilih warna aset default untuk digunakan sebagai logo.</p>
                        @error('logo_url')
                            <p class="text-xs text-rose-500 mt-1.5 font-semibold">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                <a href="{{ route('admin.partners.index') }}" 
                   class="px-6 py-3 bg-slate-100 text-slate-600 hover:bg-slate-200 font-bold rounded-xl text-sm transition">
                    Batal
                </a>
                <button type="submit" 
                        class="px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl text-sm shadow-md shadow-indigo-100 active:scale-95 transition flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Simpan Partner
                </button>
            </div>

        </form>
    </div>

</main>
@endsection