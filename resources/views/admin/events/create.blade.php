@extends('layouts.admin')

@section('content')

<div class="p-6">

    <h2 class="text-2xl font-bold mb-6">
        Tambah Event
    </h2>

    <form action="{{ route('admin.events.store') }}" method="POST">

        @csrf
<div class="mb-4">
    <label>Kategori</label>

    <select
        name="category_id"
        class="w-full border rounded p-2">

        @foreach($categories as $category)

            <option value="{{ $category->id }}">
                {{ $category->name }}
            </option>

        @endforeach

    </select>
</div>

<div class="mb-4">
    <label>Judul Event</label>

    <input
        type="text"
        name="title"
        class="w-full border rounded p-2">
</div>

<div class="mb-4">
    <label>Deskripsi</label>

    <textarea
        name="description"
        rows="4"
        class="w-full border rounded p-2"></textarea>
</div>

<div class="mb-4">
    <label>Tanggal</label>

    <input
        type="datetime-local"
        name="date"
        class="w-full border rounded p-2">
</div>

<div class="mb-4">
    <label>Lokasi</label>

    <input
        type="text"
        name="location"
        class="w-full border rounded p-2">
</div>


<div class="mb-4">
    <label>Harga</label>

    <input
        type="number"
        name="price"
        class="w-full border rounded p-2">
</div>

<div class="mb-4">
    <label>Stok</label>

    <input
        type="number"
        name="stock"
        class="w-full border rounded p-2">
</div>

<div class="mt-6">

    <button
        class="bg-indigo-600 text-white px-5 py-2 rounded">
        Simpan
    </button>

    <a
        href="{{ route('admin.events.index') }}"
        class="ml-3 text-gray-600">
        Batal
    </a>

</div>

</form>

</div>

@endsection