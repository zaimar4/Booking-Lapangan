@extends('layouts.layout')

@section('content')

<div class="p-4 sm:p-8">

    <h1 class="text-xl sm:text-2xl font-bold mb-5 sm:mb-6">
        Cari Lapangan
    </h1>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">

        @foreach($lapangan as $item)

        <div class="border rounded-lg p-4 shadow bg-white">

            <img
                src="{{  $item->gambar_lapangan) }}"
                class="w-full h-40 object-cover rounded">

            <h2 class="text-lg sm:text-xl font-bold mt-2">
                {{ $item->nama_lapangan }}
            </h2>

            <p class="text-sm text-gray-600">
                {{ $item->jenisLapangan->nama_jenis }}
            </p>

            <p class="text-green-600 font-bold">
                Rp{{ number_format($item->harga_sewa, 0, ',', '.') }}
            </p>

            <a
                href="{{ route('booking.create', $item->id) }}"
                class="bg-blue-500 text-white px-4 py-2 rounded inline-block mt-3 text-sm hover:bg-blue-600 transition-colors">
                Booking
            </a>

        </div>

        @endforeach

    </div>

</div>

@endsection
