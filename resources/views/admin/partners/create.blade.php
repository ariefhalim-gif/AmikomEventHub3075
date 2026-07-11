@extends('layouts.admin')

@section('content')

<div class="p-6">

    <h2 class="text-2xl font-bold mb-6">
        Tambah Partner
    </h2>

    @if ($errors->any())
        <div class="bg-red-100 text-red-700 p-4 rounded mb-4">
            <ul class="list-disc ml-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.partners.store') }}" method="POST">

        @csrf

        <div class="mb-4">

            <label class="block mb-2 font-semibold">
                Nama Partner
            </label>

            <input
                type="text"
                name="name"
                value="{{ old('name') }}"
                class="w-full border rounded-lg p-3">

        </div>

        <div class="mb-4">

            <label class="block mb-2 font-semibold">
                Logo URL
            </label>

            <select
                name="logo_url"
                class="w-full border rounded-lg p-3">

                <option value="https://placehold.co/200x200">
                    Placeholder 1
                </option>

                <option value="https://placehold.co/200x200/4F46E5/FFFFFF">
                    Placeholder 2
                </option>

                <option value="https://placehold.co/200x200/059669/FFFFFF">
                    Placeholder 3
                </option>

            </select>

        </div>

        <button
            class="bg-indigo-600 text-white px-5 py-2 rounded-lg">

            Simpan

        </button>

        <a
            href="{{ route('admin.partners.index') }}"
            class="ml-3 text-gray-600">

            Kembali

        </a>

    </form>

</div>

@endsection