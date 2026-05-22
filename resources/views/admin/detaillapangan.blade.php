@extends('layouts.layout')

@section('content')

<div class="font-sans pb-8">

    {{-- ── Top Bar ── --}}
    <div class="flex items-center justify-between px-5 py-3 bg-white border border-green-200 rounded-xl mb-4">
        <div class="flex items-center gap-2 text-xs text-green-700">
            <i class="fas fa-home text-green-400"></i>
            Admin
            <i class="fas fa-chevron-right text-green-300 text-xs"></i>
            Lapangan
            <i class="fas fa-chevron-right text-green-300 text-xs"></i>
            <span class="font-semibold text-green-800">Detail</span>
        </div>
        <a href="{{ route('admin.dashboard') }}"
           class="inline-flex items-center gap-2 text-xs font-medium text-green-700 bg-green-50 border border-green-200 rounded-lg px-4 py-2 hover:bg-green-100 transition-colors">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    {{-- ── Page Header ── --}}
    <div class="flex items-center justify-between bg-green-50 border border-green-200 rounded-xl px-6 py-5 mb-4">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-green-100 border border-green-200 flex items-center justify-center text-green-700 text-xl flex-shrink-0">
                <i class="fas fa-map-marker-alt"></i>
            </div>
            <div>
                <div class="text-base font-semibold text-green-900">{{ $lapangan->nama_lapangan }}</div>
                <div class="text-xs text-green-500 mt-0.5">
                    ID: LPG-{{ str_pad($lapangan->id, 3, '0', STR_PAD_LEFT) }} &middot; Ditambahkan {{ \Carbon\Carbon::parse($lapangan->created_at)->format('d M Y') }}
                </div>
            </div>
        </div>
        <span class="inline-flex items-center gap-2 bg-white border border-green-200 text-green-700 text-xs font-medium rounded-full px-4 py-1.5">
            <span class="w-1.5 h-1.5 rounded-full bg-green-500 animate-pulse"></span>
            Aktif
        </span>
    </div>

    {{-- ── Stat Row ── --}}
    <div class="grid grid-cols-3 gap-3 mb-4">
        <div class="bg-white border border-green-200 rounded-xl px-5 py-4 flex items-center gap-3">
            <div class="w-9 h-9 rounded-lg bg-green-50 border border-green-200 flex items-center justify-center text-green-600 flex-shrink-0">
                <i class="fas fa-calendar-check text-sm"></i>
            </div>
            <div>
                <div class="text-xs text-green-500 uppercase tracking-wide font-medium">Total Booking</div>
                <div class="text-base font-semibold text-green-900 mt-0.5">{{ $lapangan->bookings_count ?? 0 }}</div>
            </div>
        </div>
        <div class="bg-white border border-green-200 rounded-xl px-5 py-4 flex items-center gap-3">
            <div class="w-9 h-9 rounded-lg bg-green-50 border border-green-200 flex items-center justify-center text-green-600 flex-shrink-0">
                <i class="fas fa-clock text-sm"></i>
            </div>
            <div>
                <div class="text-xs text-green-500 uppercase tracking-wide font-medium">Jam Terpakai</div>
                <div class="text-base font-semibold text-green-900 mt-0.5">{{ ($lapangan->bookings_count ?? 0) * 2 }} jam</div>
            </div>
        </div>
        <div class="bg-white border border-green-200 rounded-xl px-5 py-4 flex items-center gap-3">
            <div class="w-9 h-9 rounded-lg bg-green-50 border border-green-200 flex items-center justify-center text-green-600 flex-shrink-0">
                <i class="fas fa-tag text-sm"></i>
            </div>
            <div>
                <div class="text-xs text-green-500 uppercase tracking-wide font-medium">Harga / Jam</div>
                <div class="text-base font-semibold text-green-900 mt-0.5">Rp {{ number_format($lapangan->harga_sewa, 0, ',', '.') }}</div>
            </div>
        </div>
    </div>

    {{-- ── Body Grid ── --}}
    <div class="grid grid-cols-12 gap-4">

        {{-- ── Left: Photo Card ── --}}
        <div class="col-span-4">
            <div class="bg-white border border-green-200 rounded-xl overflow-hidden h-full">

                {{-- Photo Frame --}}
                <div class="bg-green-50 h-48 flex items-center justify-center border-b border-green-100">
                    @if($lapangan->gambar_lapangan)
                        <img src="{{ $lapangan->gambar_lapangan }}"
                             alt="Foto {{ $lapangan->nama_lapangan }}"
                             class="w-full h-48 object-cover">
                    @else
                        <div class="flex flex-col items-center gap-2 text-green-300">
                            <i class="fas fa-image text-4xl"></i>
                            <span class="text-xs">Belum ada foto</span>
                        </div>
                    @endif
                </div>

                {{-- Quick Fields --}}
                <div class="divide-y divide-green-50">
                    <div class="flex items-center justify-between px-5 py-3">
                        <span class="flex items-center gap-2 text-xs text-green-500">
                            <i class="fas fa-futbol text-green-400"></i> Jenis
                        </span>
                        <span class="text-xs font-medium text-green-800 bg-green-50 border border-green-200 rounded-md px-2.5 py-0.5">
                            {{ $lapangan->jenis_lapangan }}
                        </span>
                    </div>
                    <div class="flex items-center justify-between px-5 py-3">
                        <span class="flex items-center gap-2 text-xs text-green-500">
                            <i class="fas fa-users text-green-400"></i> Status
                        </span>
                        <span class="inline-flex items-center gap-1.5 text-xs font-medium text-green-700">
                            <span class="w-1.5 h-1.5 rounded-full bg-green-500 animate-pulse"></span>
                            Aktif
                        </span>
                    </div>
                    <div class="flex items-center justify-between px-5 py-3">
                        <span class="flex items-center gap-2 text-xs text-green-500">
                            <i class="fas fa-calendar text-green-400"></i> Dibuat
                        </span>
                        <span class="text-xs font-medium text-green-800">
                            {{ \Carbon\Carbon::parse($lapangan->created_at)->format('d M Y') }}
                        </span>
                    </div>
                </div>

            </div>
        </div>

        {{-- ── Right: Info Card ── --}}
        <div class="col-span-8">
            <div class="bg-white border border-green-200 rounded-xl overflow-hidden h-full">

                {{-- Card Header --}}
                <div class="flex items-center justify-between px-6 py-4 bg-green-50 border-b border-green-200">
                    <span class="text-xs font-semibold text-green-600 uppercase tracking-widest flex items-center gap-2">
                        <i class="fas fa-info-circle"></i> Informasi Lapangan
                    </span>
                    <a href="{{ route('edit-lapangan', $lapangan->id) }}"
                       class="inline-flex items-center gap-2 text-xs font-semibold text-white bg-green-700 hover:bg-green-800 rounded-lg px-4 py-2 transition-colors">
                        <i class="fas fa-pen"></i> Edit
                    </a>
                </div>

                {{-- Info Grid --}}
                <div class="grid grid-cols-2 divide-x divide-green-50">

                    <div class="px-6 py-5 border-b border-green-50">
                        <div class="text-xs font-medium text-green-400 uppercase tracking-wider mb-1.5">Nama Lapangan</div>
                        <div class="text-sm font-semibold text-green-900">{{ $lapangan->nama_lapangan }}</div>
                    </div>

                    <div class="px-6 py-5 border-b border-green-50">
                        <div class="text-xs font-medium text-green-400 uppercase tracking-wider mb-1.5">Jenis Lapangan</div>
                        <span class="inline-block text-xs font-semibold text-green-700 bg-green-50 border border-green-200 rounded-md px-3 py-1">
                            {{ $lapangan->jenisLapangan->nama_jenis }}
                        </span>
                    </div>

                    <div class="col-span-2 px-6 py-5 border-b border-green-50">
                        <div class="text-xs font-medium text-green-400 uppercase tracking-wider mb-1.5">Harga Sewa per Jam</div>
                        <div class="text-lg font-semibold text-green-700">
                            Rp {{ number_format($lapangan->harga_sewa, 0, ',', '.') }}
                        </div>
                    </div>

                    <div class="col-span-2 px-6 py-5">
                        <div class="text-xs font-medium text-green-400 uppercase tracking-wider mb-2">Deskripsi</div>
                        <div class="text-sm text-green-700 leading-relaxed bg-green-50 border border-green-100 rounded-lg px-4 py-3">
                            {{ $lapangan->deskripsi ?? 'Tidak ada deskripsi untuk lapangan ini.' }}
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>
</div>

@endsection