@extends('layouts.layout')

@section('title', 'Temukan Lapangan')

@section('content')

<div class="p-4 sm:p-8">

    <div class="mb-5 sm:mb-6">
        <h1 class="text-xl sm:text-2xl font-bold text-zinc-900">Cari Lapangan</h1>
        <p class="text-zinc-500 text-sm mt-1">Pilih dan sewa lapangan favoritmu</p>
    </div>

    {{-- Search & Filter --}}
    <form method="GET" action="{{ route('user.cari-lapangan') }}" class="flex flex-col sm:flex-row gap-2 sm:gap-3 mb-5 sm:mb-6">
        <div class="flex-1 relative">
            <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-zinc-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
            <input type="text" name="search" value="{{ request('search') }}"
                   placeholder="Cari nama lapangan..."
                   class="w-full pl-10 pr-4 py-2.5 border border-zinc-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-zinc-900 bg-white">
        </div>

        <div class="flex gap-2">
            <select name="jenis"
                    class="flex-1 sm:flex-none pl-4 pr-10 py-2.5 border border-zinc-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-zinc-900 bg-white text-zinc-700">
                <option value="">Semua Jenis</option>
                @foreach($jenis_lapangan as $jenis)
                    <option value="{{ $jenis->id }}" {{ request('jenis') == $jenis->id ? 'selected' : '' }}>
                        {{ $jenis->nama_jenis }}
                    </option>
                @endforeach
            </select>

            <button type="submit"
                    class="px-4 sm:px-5 py-2.5 bg-zinc-900 text-white text-sm font-medium rounded-xl hover:bg-zinc-700 transition-colors">
                Cari
            </button>

            @if(request('search') || request('jenis'))
                <a href="{{ route('user.cari-lapangan') }}"
                   class="px-3 sm:px-4 py-2.5 border border-zinc-200 text-zinc-600 text-sm rounded-xl hover:bg-zinc-50 transition-colors">
                    Reset
                </a>
            @endif
        </div>
    </form>

    {{-- Hasil --}}
    @if(request('search') || request('jenis'))
        <p class="text-sm text-zinc-500 mb-4">
            Menampilkan <span class="font-semibold text-zinc-900">{{ $lapangan->total() }}</span> hasil
            @if(request('search')) untuk "<span class="font-semibold">{{ request('search') }}</span>"@endif
        </p>
    @endif

    {{-- Grid Lapangan --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-4 sm:gap-6">
        @forelse($lapangan as $item)
            @php
                $jamBukaInt  = (int) explode(':', $item->jam_buka)[0];
                $jamTutupInt = (int) explode(':', $item->jam_tutup)[0];
                $jamSekarang = (int) now()->format('H');
                $isBuka      = $jamSekarang >= $jamBukaInt && $jamSekarang < $jamTutupInt;
            @endphp

            <div class="group bg-white rounded-2xl overflow-hidden border border-zinc-100 shadow-sm hover:shadow-lg hover:-translate-y-1 transition-all duration-300">

                <div class="relative overflow-hidden">
                    @if($item->gambar_lapangan)
                        <img src="{{ $item->gambar_lapangan }}"
                             class="w-full h-48 sm:h-52 object-cover group-hover:scale-105 transition-transform duration-500 {{ !$isBuka ? 'brightness-75' : '' }}"
                             alt="{{ $item->nama_lapangan }}">
                    @else
                        <div class="w-full h-48 sm:h-52 bg-zinc-100 flex items-center justify-center">
                            <span class="text-zinc-400 text-sm">Tidak ada gambar</span>
                        </div>
                    @endif

                    {{-- Badge Jenis --}}
                    <div class="absolute top-3 left-3">
                        <span class="bg-white/90 backdrop-blur-sm text-zinc-700 text-xs font-semibold px-3 py-1 rounded-full shadow-sm">
                            {{ $item->jenisLapangan->nama_jenis ?? 'Umum' }}
                        </span>
                    </div>

                    {{-- Badge Buka / Tutup --}}
                    <div class="absolute top-3 right-3">
                        @if($isBuka)
                            <span class="flex items-center gap-1 bg-green-500 text-white text-xs font-bold px-2.5 py-1 rounded-full shadow">
                                <span class="w-1.5 h-1.5 bg-white rounded-full animate-pulse inline-block"></span>
                                Buka
                            </span>
                        @else
                            <span class="flex items-center gap-1 bg-zinc-700 text-white text-xs font-bold px-2.5 py-1 rounded-full shadow">
                                <span class="w-1.5 h-1.5 bg-zinc-400 rounded-full inline-block"></span>
                                Tutup
                            </span>
                        @endif
                    </div>
                </div>

                <div class="p-4 sm:p-5">
                    <h3 class="font-bold text-zinc-900 text-base sm:text-lg leading-tight">{{ $item->nama_lapangan }}</h3>

                    <div class="flex items-baseline gap-1 mt-1">
                        <span class="text-lg sm:text-xl font-black text-green-600">Rp{{ number_format($item->harga_sewa, 0, ',', '.') }}</span>
                        <span class="text-zinc-400 text-sm">/jam</span>
                    </div>

                    {{-- Jam Operasional --}}
                    <div class="flex items-center gap-1.5 mt-1.5 mb-3">
                        <svg class="w-3.5 h-3.5 text-zinc-400 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span class="text-xs text-zinc-500">
                            {{ \Illuminate\Support\Str::substr($item->jam_buka, 0, 5) }} – {{ \Illuminate\Support\Str::substr($item->jam_tutup, 0, 5) }}
                            @if(!$isBuka)
                                &bull; <span class="text-red-500 font-medium">Tutup sekarang</span>
                            @else
                                &bull; <span class="text-green-600 font-medium">Buka sekarang</span>
                            @endif
                        </span>
                    </div>

                    @if($item->deskripsi_lapangan)
                        <p class="text-zinc-500 text-sm leading-relaxed line-clamp-2 mb-4">{{ $item->deskripsi_lapangan }}</p>
                    @endif

                    <div class="flex gap-2 mt-auto">
                        <a href="{{ route('user.detail-lapangan', $item->id) }}"
                           class="flex-1 text-center py-2.5 rounded-xl border border-zinc-200 text-zinc-600 text-sm font-semibold hover:bg-zinc-50 transition-colors">
                            Detail
                        </a>

                        {{-- Tombol booking tetap bisa diklik meski tutup (user bisa booking hari lain),
                             tapi beri visual berbeda kalau sedang tutup hari ini --}}
                        <a href="{{ route('booking.create', $item->id) }}"
                           class="flex-[2] text-center py-2.5 text-sm font-bold rounded-xl transition-colors
                                  {{ $isBuka
                                      ? 'bg-green-500 text-white hover:bg-green-600'
                                      : 'bg-zinc-200 text-zinc-500 hover:bg-zinc-300' }}">
                            {{ $isBuka ? 'Booking' : 'Booking (Tutup)' }}
                        </a>
                    </div>

                    {{-- Keterangan tambahan jika tutup --}}
                    @if(!$isBuka)
                        <p class="text-xs text-zinc-400 mt-2 text-center">
                            Kamu tetap bisa booking untuk tanggal lain
                        </p>
                    @endif
                </div>
            </div>
        @empty
            <div class="col-span-full py-16 sm:py-20 text-center">
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

@endsection