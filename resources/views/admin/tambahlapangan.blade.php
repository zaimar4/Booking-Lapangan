@extends('layouts.layout')

@section('title', 'Tambah Lapangan')

@section('content')

<div class="flex">
    <x-sidenavbar />

    <div class="flex-1 ml-64 p-8">

        <div class="mb-6">
            <h1 class="text-2xl font-bold text-zinc-900">Tambah Lapangan</h1>
            <p class="text-zinc-500 text-sm mt-1">Isi data lapangan baru yang ingin ditambahkan</p>
        </div>

        <div class="bg-white rounded-2xl border border-zinc-100 shadow-sm p-8">

            <form action="{{ route('admin.store-lapangan') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                @csrf

                {{-- Nama Lapangan --}}
                <div>
                    <label for="nama_lapangan" class="block text-sm font-semibold text-zinc-700 mb-1.5">Nama Lapangan</label>
                    <input type="text" id="nama_lapangan" name="nama_lapangan" required
                           placeholder="Contoh: Lapangan Basket GOR Utama"
                           class="w-full px-4 py-2.5 border border-zinc-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-zinc-900 bg-white">
                </div>

                {{-- Jenis Lapangan --}}
                <div>
                    <label for="jenis_lapangan" class="block text-sm font-semibold text-zinc-700 mb-1.5">Jenis Lapangan</label>
                    <select id="jenis_lapangan" name="jenis_lapangan"
                            class="w-full pl-4 pr-10 py-2.5 border border-zinc-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-zinc-900 bg-white text-zinc-700">
                        @foreach ($jenis_lapangan as $j)
                            <option value="{{ $j->id }}">{{ $j->nama_jenis }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Harga Sewa --}}
                <div>
                    <label for="harga_sewa" class="block text-sm font-semibold text-zinc-700 mb-1.5">Harga Sewa</label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-sm text-zinc-400 font-medium">Rp</span>
                        <input type="number" id="harga_sewa" name="harga_sewa" required min="0"
                               placeholder="0"
                               class="w-full pl-10 pr-4 py-2.5 border border-zinc-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-zinc-900 bg-white">
                        <span class="absolute right-4 top-1/2 -translate-y-1/2 text-sm text-zinc-400">/jam</span>
                    </div>
                </div>

                {{-- Deskripsi --}}
                <div>
                    <label for="deskripsi_lapangan" class="block text-sm font-semibold text-zinc-700 mb-1.5">Deskripsi Lapangan</label>
                    <textarea id="deskripsi_lapangan" name="deskripsi_lapangan" rows="4"
                              placeholder="Deskripsikan fasilitas dan kondisi lapangan..."
                              class="w-full px-4 py-2.5 border border-zinc-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-zinc-900 bg-white resize-none"></textarea>
                </div>

                {{-- Gambar --}}
                <div>
                    <label for="gambar_lapangan" class="block text-sm font-semibold text-zinc-700 mb-1.5">Gambar Lapangan</label>
                    <input type="file" id="gambar_lapangan" name="gambar_lapangan" required accept="image/*"
                           class="w-full px-4 py-2.5 border border-zinc-200 rounded-xl text-sm bg-white text-zinc-600
                                  file:mr-4 file:py-1 file:px-3 file:rounded-lg file:border-0
                                  file:text-xs file:font-semibold file:bg-zinc-900 file:text-white
                                  hover:file:bg-zinc-700 cursor-pointer">
                </div>

                {{-- Tombol --}}
                <div class="flex gap-3 pt-2">
                    <button type="submit"
                            class="px-6 py-2.5 bg-blue-500 hover:bg-blue-600 text-white text-sm font-bold rounded-xl transition-colors">
                        Tambah Lapangan
                    </button>
                    <a href="{{ route('admin.semua-lapangan') }}"
                       class="px-6 py-2.5 border border-zinc-200 text-zinc-600 text-sm font-semibold rounded-xl hover:bg-zinc-50 transition-colors">
                        Batal
                    </a>
                </div>

            </form>

        </div>

    </div>
</div>

@endsection