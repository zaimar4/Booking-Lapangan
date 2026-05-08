@extends('layouts.layout')

@section('title','Temukan lapangan')

@section('content')

<div class="container">
    @foreach ($lapangan as $item)
        <div class="mb-4 p-3 border rounded shadow-sm">

            @if($item->gambar_lapangan)
                <img src="{{ asset('images/' . $item->gambar_lapangan) }}"
                     class="img-fluid rounded shadow-sm"
                     alt="Foto Lapangan"
                     width="150">
            @else
                <div class="bg-light py-5 text-muted text-center">
                    Tidak ada foto
                </div>
            @endif

            <h3>{{ $item->nama_lapangan }}</h3>

            <p>
                {{ $item->jenisLapangan->nama_jenis ?? 'Tidak ada jenis' }}
            </p>

            <p>Rp {{ number_format($item->harga_sewa, 0, ',', '.') }}</p>

            <p>{{ $item->deskripsi_lapangan }}</p>

            <div>
                <a href="{{ route('user.detail-lapangan', $item->id) }}"
                   class="text-green-500">
                    Detail
                </a>

                <button>Booking</button>
            </div>

        </div>
    @endforeach
</div>

@endsection