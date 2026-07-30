@extends('layouts.admin')

@section('title', 'Data Partner - Admin')

@section('content')
<main class="flex-1 p-6 md:p-10 overflow-y-auto">

    <!-- Header Page -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
        <div>
            <h1 class="text-3xl font-black text-slate-800">Data Partner</h1>
            <p class="text-slate-500 font-medium mt-1">Kelola daftar partner dan sponsor acara.</p>
        </div>

        <a href="{{ route('admin.partners.create') }}" 
            class="px-5 py-2.5 bg-indigo-600 text-white rounded-xl font-bold shadow-md shadow-indigo-100 hover:bg-indigo-700 active:scale-95 transition flex items-center gap-2 text-sm">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Tambah Partner
        </a>
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

        <!-- Table Partner -->
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-slate-50 text-slate-400 uppercase text-[10px] font-black tracking-widest border-b">
                    <tr>
                        <th class="px-8 py-4 text-center w-16">No</th>
                        <th class="px-8 py-4 text-center w-28">Logo</th>
                        <th class="px-8 py-4">Nama Partner</th>
                        <th class="px-8 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y border-t text-sm text-slate-700">
                    @forelse($partners as $partner)
                        <tr class="hover:bg-slate-50/50 transition">
                            <td class="px-8 py-6 text-center font-bold text-slate-400">
                                {{ $loop->iteration }}
                            </td>
                            <td class="px-8 py-6 text-center">
                                <div class="w-12 h-12 rounded-xl bg-slate-50 border border-slate-100 p-1 flex items-center justify-center mx-auto overflow-hidden">
                                    <img src="{{ $partner->logo_url }}" 
                                         alt="{{ $partner->name }}" 
                                         class="max-w-full max-h-full object-contain">
                                </div>
                            </td>
                            <td class="px-8 py-6 font-bold text-slate-800">
                                {{ $partner->name }}
                            </td>
                            <td class="px-8 py-6 text-center whitespace-nowrap">
                                <div class="inline-flex items-center gap-2">
                                    <!-- Edit Button (Sesuaikan route jika ada) -->
                                    <a href="{{ route('admin.partners.edit', $partner->id) }}" 
                                       class="p-2 bg-amber-50 text-amber-600 hover:bg-amber-500 hover:text-white rounded-xl transition" title="Edit Partner">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 00-2 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                    </a>

                                    <!-- Delete Button -->
                                    <form action="{{ route('admin.partners.destroy', $partner->id) }}" method="POST" class="inline-block"
                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus partner ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 bg-rose-50 text-rose-600 hover:bg-rose-600 hover:text-white rounded-xl transition" title="Hapus Partner">
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
                            <td colspan="4" class="text-center py-12 text-slate-400">
                                <p class="font-bold text-slate-600">Belum ada partner ditemukan.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>

</main>
@endsection