@extends('layouts.admin')

@section('title','Categories')

@section('content')

<div class="container mx-auto p-6">

    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">
            Manajemen Kategori
        </h1>

        <button
            class="bg-indigo-600 text-white px-5 py-2 rounded-lg hover:bg-indigo-700">
            + Tambah Kategori
        </button>
    </div>

    <div class="bg-white rounded-xl shadow">

        <table class="min-w-full">

            <thead class="bg-gray-100">

                <tr>

                    <th class="px-5 py-3 text-left">No</th>

                    <th class="px-5 py-3 text-left">Nama</th>

                    <th class="px-5 py-3 text-left">Deskripsi</th>

                    <th class="px-5 py-3 text-center">
                        Aksi
                    </th>

                </tr>

            </thead>

            <tbody>

                @foreach($categories as $category)

                <tr class="border-b">

                    <td class="px-5 py-4">
                        {{ $category['id'] }}
                    </td>

                    <td class="px-5 py-4">
                        {{ $category['name'] }}
                    </td>

                    <td class="px-5 py-4">
                        {{ $category['description'] }}
                    </td>

                    <td class="px-5 py-4 text-center">

                        <button
                            class="bg-yellow-500 text-white px-3 py-1 rounded">
                            Edit
                        </button>

                        <button
                            class="bg-red-600 text-white px-3 py-1 rounded">
                            Hapus
                        </button>

                    </td>

                </tr>

                @endforeach

            </tbody>

        </table>

    </div>

</div>

@endsection