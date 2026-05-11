@extends('layouts.layout')

@section('title', 'Detail ' . $lapangan->nama_lapangan)

@section('content')
<div class="bg-gray-50 min-h-screen py-10">
    <div class="container mx-auto px-4 max-w-6xl">
        
        <div class="mb-8 flex items-center justify-between ">
            <a href="{{ route('user.cari-lapangan') }}" class="inline-flex items-center text-sm font-semibold text-gray-600 hover:text-green-600 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali ke Katalog
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            
            <div class="lg:col-span-7">
                <div class="bg-white rounded-3xl overflow-hidden shadow-sm border border-gray-100">
                    @if($lapangan->gambar_lapangan)
                        <img src="{{ asset('images/' . $lapangan->gambar_lapangan) }}"
                             class="w-full h-[400px] object-cover"
                             alt="Foto {{ $lapangan->nama_lapangan }}">
                    @else
                        <div class="w-full h-[400px] bg-gray-200 flex flex-col items-center justify-center text-gray-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <span>Foto tidak tersedia</span>
                        </div>
                    @endif
                </div>

                <div class="mt-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-4">Deskripsi Lapangan</h2>
                    <div class="prose max-w-none text-gray-600 leading-relaxed">
                        {{ $lapangan->deskripsi_lapangan ?? 'Tidak ada deskripsi tambahan untuk lapangan ini.' }}
                    </div>
                </div>
            </div>

            <div class="lg:col-span-5">
                <div class="bg-white rounded-3xl p-8 shadow-lg shadow-gray-200/50 border border-gray-100 sticky top-8">
                    <div class="mb-6">
                        <span class="inline-block px-3 py-1 rounded-full bg-green-100 text-green-700 text-xs font-bold uppercase tracking-wider mb-3">
                            {{ $lapangan->jenisLapangan->nama_jenis ?? 'Umum' }}
                        </span>
                        <h1 class="text-3xl font-black text-gray-900 leading-tight">
                            {{ $lapangan->nama_lapangan }}
                        </h1>
                    </div>

                    <div class="space-y-4 py-6 border-y border-gray-100 mb-6">
                        <div class="flex justify-between items-center">
                            <span class="text-gray-500">Harga Sewa</span>
                            <span class="text-2xl font-black text-green-600">
                                Rp{{ number_format($lapangan->harga_sewa, 0, ',', '.') }} <span class="text-sm text-gray-400 font-normal">/jam</span>
                            </span>
                        </div>
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-gray-500">Status</span>
                            <span class="text-green-600 font-semibold flex items-center">
                                <span class="w-2 h-2 bg-green-500 rounded-full mr-2"></span>
                                Tersedia
                            </span>
                        </div>
                    </div>

                    <div class="space-y-3">
                        <button class="w-full bg-green-500 hover:bg-green-600 text-white font-bold py-4 rounded-2xl shadow-md shadow-green-100 transition-all active:scale-[0.98]">
                            Booking Sekarang
                        </button>
                        
                        <p class="text-center text-xs text-gray-400">
                            Masuk untuk melakukan pemesanan jadwal
                        </p>
                    </div>

                    <div class="mt-8 pt-6 border-t border-gray-50">
                        <h4 class="text-sm font-bold text-gray-900 mb-3">Fasilitas Standar:</h4>
                        <div class="grid grid-cols-2 gap-y-2">
                            <div class="flex items-center text-xs text-gray-600">
                                <svg class="w-4 h-4 mr-2 text-green-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                Area Parkir
                            </div>
                            <div class="flex items-center text-xs text-gray-600">
                                <svg class="w-4 h-4 mr-2 text-green-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                Ruang Ganti
                            </div>
                            <div class="flex items-center text-xs text-gray-600">
                                <svg class="w-4 h-4 mr-2 text-green-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                Toilet
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection