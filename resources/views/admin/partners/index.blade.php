@extends('layouts.admin')

@section('content')

<div class="p-6">

    <div class="flex justify-between items-center mb-6">

        <h2 class="text-2xl font-bold">
            Data Partner
        </h2>

        <a href="{{ route('admin.partners.create') }}"
            class="bg-indigo-600 text-white px-4 py-2 rounded">
            Tambah Partner
        </a>

    </div>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <table class="w-full bg-white rounded shadow">

        <thead class="bg-gray-100">

            <tr>

                <th class="p-3">No</th>

                <th class="p-3">Logo</th>

                <th class="p-3">Nama Partner</th>

            </tr>

        </thead>

        <tbody>

        @foreach($partners as $partner)

            <tr class="border-b">

                <td class="p-3">
                    {{ $loop->iteration }}
                </td>

                <td class="p-3">

                    <img
                        src="{{ $partner->logo_url }}"
                        width="70">

                </td>

                <td class="p-3">

                    {{ $partner->name }}

                </td>

            </tr>

        @endforeach

        </tbody>

    </table>

</div>

@endsection