@extends('layouts.layout')

@section('content')

<div class="p-4 sm:p-8">

    <h1 class="text-2xl font-bold mb-6">
        Booking Lapangan
    </h1>

    @if (session('success'))
        <div class="bg-green-200 text-green-800 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="bg-red-200 text-red-800 p-3 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    <div class="bg-white shadow rounded-xl p-6 w-full max-w-xl">

        <h2 class="text-xl font-semibold mb-4">
            {{ $lapangan->nama_lapangan }}
        </h2>

        <form action="{{ route('booking.store') }}" method="POST">

            @csrf

            <input type="hidden"
                   name="lapangan_id"
                   value="{{ $lapangan->id }}">

            <div class="mb-4">
                <label class="block mb-2">
                    Tanggal
                </label>

                <input type="date"
                       name="tanggal"
                       class="w-full border rounded-lg p-2">
            </div>

            <div class="mb-4">
                <label class="block mb-2">
                    Jam Mulai
                </label>

                <input type="time"
                       name="jam_mulai"
                       class="w-full border rounded-lg p-2">
            </div>

            <div class="mb-4">
                <label class="block mb-2">
                    Jam Selesai
                </label>

                <input type="time"
                       name="jam_selesai"
                       class="w-full border rounded-lg p-2">
            </div>

            <button type="submit"
                    class="bg-black text-white px-4 py-2 rounded-lg">
                Booking Sekarang
            </button>

        </form>

    </div>

</div>

@endsection