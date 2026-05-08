@extends('layouts.layout')
@section('title','Temukan lapangan')
@section('content')
@foreach ($lapangan as $lapangan)
    <div class="container">
       @if($lapangan->gambar_lapangan)
                        <img src="{{ asset('images/' . $lapangan->gambar_lapangan) }}" class="img-fluid rounded shadow-sm" alt="Foto Lapangan" width="60">
                    @else
                        <div class="bg-light py-5 text-muted">Tidak ada foto</div>
                    @endif
                    <h3>{{$lapangan->nama_lapangan}}</h3>
                    <p>{{$lapangan->jenisLapangan->nama_jenis}}</p>
                    <p>{{$lapangan->harga_sewa}}</p>
                    <p>{{$lapangan->deskripsi_lapangan}}</p>

                <div>
                    <button>Booking</button>
                </div>
    </div>
@endforeach
@endsection