@extends('layouts.layout')

@section('title', 'Temukan Lapangan Terbaik')

@section('content')

<div class="bg-gray-50 min-h-screen py-10">
    <div class="container mx-auto px-4">

        <x-sidenavbar />

        <div class="mb-8">
            <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900">
                Katalog Lapangan
            </h1>

            <p class="text-gray-500 mt-2">
                Pilih lapangan terbaik untuk olahraga kamu
            </p>

            @if(request('search'))
                <p class="mt-3 text-sm text-gray-600">
                    Hasil pencarian: 
                    <span class="font-semibold text-green-600">
                        "{{ request('search') }}"
                    </span>
                </p>
            @endif
        </div>

        @if($lapangan->count() > 0)

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

            @foreach ($lapangan as $item)
                <div class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition group">

                    <div class="relative">
                        @if($item->gambar_lapangan)
                            <img src="{{ asset('images/' . $item->gambar_lapangan) }}"
                                 class="w-full h-56 object-cover group-hover:scale-105 transition duration-300"
                                 alt="{{ $item->nama_lapangan }}">
                        @else
                            <div class="w-full h-56 bg-gray-200 flex items-center justify-center">
                                <span class="text-gray-400 text-sm">Tidak ada gambar</span>
                            </div>
                        @endif

                        <div class="absolute top-3 left-3">
                            <span class="bg-black/70 text-white text-[10px] px-3 py-1 rounded-full">
                                {{ $item->jenisLapangan->nama_jenis ?? 'Umum' }}
                            </span>
                        </div>
                    </div>

                    <div class="p-5">

                        <h3 class="font-bold text-lg text-gray-800">
                            {{ $item->nama_lapangan }}
                        </h3>

                        <p class="text-green-600 font-extrabold mt-2">
                            Rp{{ number_format($item->harga_sewa, 0, ',', '.') }}
                            <span class="text-gray-400 font-normal text-sm">/jam</span>
                        </p>

                        <p class="text-gray-500 text-sm mt-3 line-clamp-2">
                            {{ $item->deskripsi_lapangan }}
                        </p>

                        <div class="mt-5 flex gap-2">
                            <button class="flex-1 bg-green-500 hover:bg-green-600 text-white font-semibold py-2.5 rounded-xl transition">
                                Booking
                            </button>

                            <button class="px-4 border border-gray-200 rounded-xl text-gray-600 hover:bg-gray-50">
                                Detail
                            </button>
                        </div>

                    </div>

                </div>
            @endforeach

        </div>

        @else
            <div class="text-center py-20">
                <p class="text-gray-400 text-lg">
                    Lapangan tidak ditemukan 😢
                </p>
                <p class="text-sm text-gray-500 mt-2">
                    Coba gunakan kata kunci lain
                </p>
            </div>
        @endif

    </div>
</div>

@endsection