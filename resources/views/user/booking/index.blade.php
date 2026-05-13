@extends('layouts.layout')

@section('content')

<h1>Halaman Cari Lapangan</h1>

@foreach ($lapangan as $item)

    <p>{{ $item->nama_lapangan }}</p>


    <a href="{{ route('booking.create', $item->id) }}"
   class="bg-black text-white px-3 py-2 rounded-lg">
    Booking
</a>
@endforeach

@endsection