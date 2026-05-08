@extends('layouts.layout')

@section('content')

<div class="p-10">

    <h1 class="text-2xl font-bold mb-5">
        Booking Lapangan
    </h1>

    <form action="{{ route('booking.store') }}" method="POST">

        @csrf

        <input
            type="hidden"
            name="lapangan_id"
            value="{{ $lapangan->id }}">

        <p class="mb-3">
            {{ $lapangan->nama_lapangan }}
        </p>

        <input type="date" name="tanggal" class="border p-2">

        <br><br>

        <input type="time" name="jam_mulai" class="border p-2">

        <br><br>

        <input type="time" name="jam_selesai" class="border p-2">

        <br><br>

        <button class="bg-blue-500 text-white px-4 py-2 rounded">
            Booking
        </button>

    </form>

</div>

@endsection