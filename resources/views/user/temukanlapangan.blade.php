@extends('layouts.layout')

@section('title', 'Temukan Lapangan')

@section('content')

<div class="flex">
    <x-sidenavbar />

    <div class="flex-1 ml-64 p-8">

        <div class="mb-6">
            <h1 class="text-2xl font-bold text-zinc-900">Cari Lapangan</h1>
            <p class="text-zinc-500 text-sm mt-1">Pilih dan sewa lapangan favoritmu</p>
        </div>

        {{-- Search & Filter --}}
        <form method="GET" action="{{ route('user.cari-lapangan') }}" class="flex gap-3 mb-6">
            <div class="flex-1 relative">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-zinc-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <input type="text" name="search" value="{{ request('search') }}"
                       placeholder="Cari nama lapangan..."
                       class="w-full pl-10 pr-4 py-2.5 border border-zinc-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-zinc-900 bg-white">
            </div>

            <select name="jenis"
                    class="px-4 py-2.5 border border-zinc-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-zinc-900 bg-white text-zinc-700">
                <option value="">Semua Jenis</option>
                @foreach($jenis_lapangan as $jenis)
                    <option value="{{ $jenis->id }}" {{ request('jenis') == $jenis->id ? 'selected' : '' }}>
                        {{ $jenis->nama_jenis }}
                    </option>
                @endforeach
            </select>

            <button type="submit"
                    class="px-5 py-2.5 bg-zinc-900 text-white text-sm font-medium rounded-xl hover:bg-zinc-700 transition-colors">
                Cari
            </button>

            @if(request('search') || request('jenis'))
                <a href="{{ route('user.cari-lapangan') }}"
                   class="px-4 py-2.5 border border-zinc-200 text-zinc-600 text-sm rounded-xl hover:bg-zinc-50 transition-colors">
                    Reset
                </a>
            @endif
        </form>

        {{-- Hasil --}}
        @if(request('search') || request('jenis'))
            <p class="text-sm text-zinc-500 mb-4">
                Menampilkan <span class="font-semibold text-zinc-900">{{ $lapangan->total() }}</span> hasil
                @if(request('search')) untuk "<span class="font-semibold">{{ request('search') }}</span>"@endif
            </p>
        @endif

        {{-- Grid Lapangan --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($lapangan as $item)
                <div class="group bg-white rounded-2xl overflow-hidden border border-zinc-100 shadow-sm hover:shadow-lg hover:-translate-y-1 transition-all duration-300">

                    <div class="relative overflow-hidden">
                        @if($item->gambar_lapangan)
                            <img src="{{ asset('images/' . $item->gambar_lapangan) }}"
                                 class="w-full h-52 object-cover group-hover:scale-105 transition-transform duration-500"
                                 alt="{{ $item->nama_lapangan }}">
                        @else
                            <div class="w-full h-52 bg-zinc-100 flex items-center justify-center">
                                <span class="text-zinc-400 text-sm">Tidak ada gambar</span>
                            </div>
                        @endif
                        <div class="absolute top-3 left-3">
                            <span class="bg-white/90 backdrop-blur-sm text-zinc-700 text-xs font-semibold px-3 py-1 rounded-full shadow-sm">
                                {{ $item->jenisLapangan->nama_jenis ?? 'Umum' }}
                            </span>
                        </div>
                    </div>

                    <div class="p-5">
                        <h3 class="font-bold text-zinc-900 text-lg leading-tight">{{ $item->nama_lapangan }}</h3>
                        <div class="flex items-baseline gap-1 mt-1 mb-3">
                            <span class="text-xl font-black text-green-600">Rp{{ number_format($item->harga_sewa, 0, ',', '.') }}</span>
                            <span class="text-zinc-400 text-sm">/jam</span>
                        </div>
                        @if($item->deskripsi_lapangan)
                            <p class="text-zinc-500 text-sm leading-relaxed line-clamp-2 mb-4">{{ $item->deskripsi_lapangan }}</p>
                        @endif

                        <div class="flex gap-2 mt-auto">
                            <a href="{{ route('user.detail-lapangan', $item->id) }}"
                               class="flex-1 text-center py-2.5 rounded-xl border border-zinc-200 text-zinc-600 text-sm font-semibold hover:bg-zinc-50 transition-colors">
                                Detail
                            </a>
                            <a href="{{ route('booking.create', $item->id) }}"
                               class="flex-[2] text-center py-2.5 bg-green-500 text-white text-sm font-bold rounded-xl hover:bg-green-600 transition-colors">
                                Booking
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-3 py-20 text-center">
                    <p class="text-zinc-500 font-medium">Lapangan tidak ditemukan</p>
                    <p class="text-zinc-400 text-sm mt-1">Coba kata kunci atau filter yang berbeda</p>
                    <a href="{{ route('user.cari-lapangan') }}" class="inline-block mt-4 text-sm text-blue-500 hover:underline">Lihat semua lapangan</a>
                </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        @if($lapangan->hasPages())
            <div class="mt-6">{{ $lapangan->links() }}</div>
        @endif

    </div>
</div>

@endsection