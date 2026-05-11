@extends('layouts.layout')

@section('title', 'Booking Lapangan')

@section('content')

<div class="p-6 ml-60">

    <h1 class="text-3xl font-bold text-gray-800 mb-6">
        Booking Lapangan
    </h1>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- INFORMASI LAPANGAN -->
        <div class="bg-white rounded-2xl shadow-md overflow-hidden">

            <img
                src="{{ asset('images/' . $lapangan->gambar_lapangan) }}"
                alt="{{ $lapangan->nama_lapangan }}"
                class="w-full h-56 object-cover">

            <div class="p-5">

                <h2 class="text-2xl font-bold text-gray-800 mb-2">
                    {{ $lapangan->nama_lapangan }}
                </h2>

                <span class="bg-gray-200 text-gray-700 text-xs px-2 py-1 rounded">
                    {{ $lapangan->jenisLapangan->nama_jenis }}
                </span>

                <p class="text-gray-600 mt-4 text-sm">
                    {{ $lapangan->deskripsi_lapangan }}
                </p>

                <div class="mt-5">

                    <p class="text-gray-500 text-sm">
                        Harga Sewa
                    </p>

                    <h3 class="text-2xl font-bold text-green-600">
                        Rp {{ number_format($lapangan->harga_sewa, 0, ',', '.') }}
                    </h3>

                </div>

            </div>

        </div>

        <!-- FORM BOOKING -->
        <div class="lg:col-span-2">

            <div class="bg-white rounded-2xl shadow-md p-6">

                <h2 class="text-xl font-semibold text-gray-700 mb-6">
                    Form Booking
                </h2>

                <form action="{{ route('booking.store') }}" method="POST" class="space-y-5">

                    @csrf

                    <input
                        type="hidden"
                        name="lapangan_id"
                        value="{{ $lapangan->id }}">

                    <!-- TANGGAL -->
                    <div>

                        <label class="block text-gray-700 mb-2 font-medium">
                            Tanggal Booking
                        </label>

                        <input
                            type="date"
                            name="tanggal"
                            class="w-full border rounded-lg p-3 focus:ring-2 focus:ring-blue-400 focus:outline-none">

                    </div>

                    <!-- JAM MULAI -->
                    <div>

                        <label class="block text-gray-700 mb-2 font-medium">
                            Jam Mulai
                        </label>

                        <input
                            type="time"
                            name="jam_mulai"
                            class="w-full border rounded-lg p-3 focus:ring-2 focus:ring-blue-400 focus:outline-none">

                    </div>

                    <!-- JAM SELESAI -->
                    <div>

                        <label class="block text-gray-700 mb-2 font-medium">
                            Jam Selesai
                        </label>

                        <input
                            type="time"
                            name="jam_selesai"
                            class="w-full border rounded-lg p-3 focus:ring-2 focus:ring-blue-400 focus:outline-none">

                    </div>

                    <!-- BUTTON -->
                    <button
                        type="submit"
                        class="w-full bg-blue-500 hover:bg-blue-600 text-white py-3 rounded-lg font-medium transition">

                        Booking Sekarang

                    </button>

                </form>

            </div>

        </div>

    </div>

</div>

@endsection