@extends('layouts.admin')

@section('title', 'Edit Event')

@section('content')

<div class="container mx-auto p-6">

    <div class="mb-6">
        <h1 class="text-3xl font-bold">Edit Event</h1>
        <p class="text-gray-500">Perbarui informasi event.</p>
    </div>

    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white shadow rounded-lg p-6">

        <form action="{{ route('admin.events.update', $event->id) }}" method="POST">

            @csrf
            @method('PUT')

            {{-- Kategori --}}
            <div class="mb-4">
                <label class="block font-semibold mb-2">
                    Kategori
                </label>

                <select
                    name="category_id"
                    class="w-full border rounded-lg p-2">

                    @foreach ($categories as $category)
                        <option
                            value="{{ $category->id }}"
                            {{ old('category_id', $event->category_id) == $category->id ? 'selected' : '' }}>

                            {{ $category->name }}

                        </option>
                    @endforeach

                </select>
            </div>

            {{-- Judul --}}
            <div class="mb-4">
                <label class="block font-semibold mb-2">
                    Judul Event
                </label>

                <input
                    type="text"
                    name="title"
                    value="{{ old('title', $event->title) }}"
                    class="w-full border rounded-lg p-2">
            </div>

            {{-- Deskripsi --}}
            <div class="mb-4">
                <label class="block font-semibold mb-2">
                    Deskripsi
                </label>

                <textarea
                    name="description"
                    rows="5"
                    class="w-full border rounded-lg p-2">{{ old('description', $event->description) }}</textarea>
            </div>

            {{-- Tanggal --}}
            <div class="mb-4">
                <label class="block font-semibold mb-2">
                    Tanggal Event
                </label>

                <input
                    type="datetime-local"
                    name="date"
                    value="{{ old('date', date('Y-m-d\TH:i', strtotime($event->date))) }}"
                    class="w-full border rounded-lg p-2">
            </div>

            {{-- Lokasi --}}
            <div class="mb-4">
                <label class="block font-semibold mb-2">
                    Lokasi
                </label>

                <input
                    type="text"
                    name="location"
                    value="{{ old('location', $event->location) }}"
                    class="w-full border rounded-lg p-2">
            </div>

            {{-- Harga --}}
            <div class="mb-4">
                <label class="block font-semibold mb-2">
                    Harga
                </label>

                <input
                    type="number"
                    name="price"
                    value="{{ old('price', $event->price) }}"
                    class="w-full border rounded-lg p-2">
            </div>

            {{-- Stok --}}
            <div class="mb-6">
                <label class="block font-semibold mb-2">
                    Stok Tiket
                </label>

                <input
                    type="number"
                    name="stock"
                    value="{{ old('stock', $event->stock) }}"
                    class="w-full border rounded-lg p-2">
            </div>

            <div class="flex gap-3">
                <button
                    type="submit"
                    class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-lg">

                    Update Event

                </button>

                <a
                    href="{{ route('admin.events.index') }}"
                    class="bg-gray-300 hover:bg-gray-400 px-6 py-2 rounded-lg">

                    Batal

                </a>
            </div>

        </form>

    </div>

</div>

@endsection