@extends('layouts.layout')

@section('title', 'Temukan Lapangan Terbaik')

@section('content')

<div class="bg-gray-50 min-h-screen py-12">
    <div class="container mx-auto px-4">
        
        <div class="mb-12">
            <h1 class="text-4xl font-black text-gray-900 tracking-tight">
                Katalog Lapangan
            </h1>
            <p class="text-gray-500 mt-2 text-lg">Pilih dan sewa lapangan favoritmu dengan mudah.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach ($lapangan as $item)
                <div class="group bg-white rounded-3xl overflow-hidden border border-gray-100 shadow-sm hover:shadow-2xl hover:-translate-y-2 transition-all duration-300">
                    
                    <div class="relative overflow-hidden">
                        @if($item->gambar_lapangan)
                            <img src="{{ asset('images/' . $item->gambar_lapangan) }}"
                                 class="w-full h-64 object-cover transform group-hover:scale-110 transition-transform duration-500"
                                 alt="{{ $item->nama_lapangan }}">
                        @else
                            <div class="w-full h-64 bg-gray-200 flex items-center justify-center">
                                <span class="text-gray-400 font-medium text-sm italic">Foto tidak tersedia</span>
                            </div>
                        @endif
                        
                        <div class="absolute top-4 left-4">
                            <span class="bg-white/90 backdrop-blur-sm text-green-700 text-[10px] font-bold px-3 py-1.5 rounded-full uppercase tracking-widest shadow-sm">
                                {{ $item->jenisLapangan->nama_jenis ?? 'General' }}
                            </span>
                        </div>
                    </div>

                    <div class="p-6">
                        <div class="flex justify-between items-start mb-3">
                            <h3 class="text-xl font-bold text-gray-800 leading-tight">
                                {{ $item->nama_lapangan }}
                            </h3>
                        </div>

                        <div class="flex items-baseline gap-1 mb-4">
                            <span class="text-2xl font-black text-green-600">
                                Rp{{ number_format($item->harga_sewa, 0, ',', '.') }}
                            </span>
                            <span class="text-gray-400 text-sm">/jam</span>
                        </div>

                        <p class="text-gray-500 text-sm leading-relaxed line-clamp-2 mb-6">
                            {{ $item->deskripsi_lapangan }}
                        </p>

                        <div class="flex items-center gap-3 mt-auto">
                            <a href="{{ route('user.detail-lapangan', $item->id) }}"
                               class="flex-1 text-center py-3 rounded-2xl border-2 border-gray-100 text-gray-600 font-bold hover:bg-gray-50 transition-colors">
                                Detail
                            </a>

                            <button class="flex-[2] bg-green-500 text-white font-bold py-3 rounded-2xl hover:bg-green-600 hover:shadow-lg hover:shadow-green-200 transition-all">
                                Booking Sekarang
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

    </div>
</div>

@endsection