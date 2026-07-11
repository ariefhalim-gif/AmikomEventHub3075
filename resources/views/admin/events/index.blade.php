@extends('layouts.admin')

@section('content')

<div class="p-6">

    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold">
            Manajemen Event
        </h2>

        <a href="{{ route('admin.events.create') }}"
            class="bg-indigo-600 text-white px-4 py-2 rounded font-semibold hover:bg-indigo-700">
            Tambah Event
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 border border-green-200 p-4 rounded mb-5">
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white rounded-lg shadow border">

            <thead class="bg-gray-100">
                <tr>
                    <th class="p-4 text-left">No</th>
                    <th class="p-4 text-left">Judul Event</th>
                    <th class="p-4 text-left">Kategori</th>
                    <th class="p-4 text-left">Tanggal</th>
                    <th class="p-4 text-left">Lokasi</th>
                    <th class="p-4 text-right">Harga</th>
                    <th class="p-4 text-center">Stok</th>
                    <th class="p-4 text-center">Aksi</th>
                </tr>
            </thead>

            <tbody>

                @forelse($events as $event)

                    <tr class="border-b hover:bg-gray-50">

                        <td class="p-4">
                            {{ $loop->iteration + ($events->currentPage() - 1) * $events->perPage() }}
                        </td>

                        <td class="p-4 font-medium">
                            {{ $event->title }}
                        </td>

                        <td class="p-4">
                            {{ $event->category->name ?? '-' }}
                        </td>

                        <td class="p-4">
                            {{ \Carbon\Carbon::parse($event->date)->format('d M Y H:i') }}
                        </td>

                        <td class="p-4">
                            {{ $event->location }}
                        </td>

                        <td class="p-4 text-right">
                            Rp {{ number_format($event->price, 0, ',', '.') }}
                        </td>

                        <td class="p-4 text-center">
                            {{ $event->stock }}
                        </td>

                        <td class="p-4 text-center">

                            <a href="{{ route('admin.events.edit', $event->id) }}"
                                class="inline-block bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded text-sm">
                                Edit
                            </a>

                            <form action="{{ route('admin.events.destroy', $event->id) }}"
                                method="POST"
                                class="inline">

                                @csrf
                                @method('DELETE')

                                <button type="submit"
                                    onclick="return confirm('Yakin ingin menghapus event ini?')"
                                    class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-sm">
                                    Hapus
                                </button>

                            </form>

                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="8" class="p-6 text-center text-gray-500">
                            Belum ada data event.
                        </td>
                    </tr>

                @endforelse

            </tbody>

        </table>
    </div>

    <div class="mt-6">
        {{ $events->links() }}
    </div>

</div>

@endsection