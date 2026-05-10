@extends('layouts.layout')

@section('content')

<div class="flex">

    <x-sidenavbar />

    <div class="flex-1 p-8 ml-60">

        <h1 class="text-2xl font-bold mb-6">
            Cari Lapangan
        </h1>

        <div class="grid grid-cols-3 gap-4">

            @foreach($lapangan as $item)

            <div class="border rounded-lg p-4 shadow">

                <img
                    src="{{ asset('images/' . $item->gambar_lapangan) }}"
                    class="w-full h-40 object-cover rounded">

                <h2 class="text-xl font-bold mt-2">
                    {{ $item->nama_lapangan }}
                </h2>

                <p>
                    {{ $item->jenisLapangan->nama_jenis }}
                </p>

                <p class="text-green-600 font-bold">
                    Rp{{ number_format($item->harga_sewa, 0, ',', '.') }}
                </p>

                <a
                    href="{{ route('booking.create', $item->id) }}"
                    class="bg-blue-500 text-white px-4 py-2 rounded inline-block mt-3">

                    Booking

                </a>

            </div>

            @endforeach

        </div>

    </div>

</div>

@endsection