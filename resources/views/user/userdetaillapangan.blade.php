@extends('layouts.layout')

@section('title','Detail lapangan')

@section('content')

<div class="container-fluid">

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            Detail Lapangan: {{ $lapangan->nama_lapangan }}
        </h1>

        <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary btn-sm shadow-sm">
            Kembali
        </a>
    </div>

    <div class="row">

        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4">

                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Foto Utama</h6>
                </div>

                <div class="card-body text-center">
                    @if($lapangan->gambar_lapangan)
                        <img src="{{ asset('images/' . $lapangan->gambar_lapangan) }}"
                             class="img-fluid rounded shadow-sm"
                             alt="Foto Lapangan">
                    @else
                        <div class="bg-light py-5 text-muted">
                            Tidak ada foto
                        </div>
                    @endif
                </div>

            </div>
        </div>

        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4">

                <div class="card-header py-3 d-flex justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">
                        Informasi Lengkap
                    </h6>

                </div>

                <div class="card-body">
                    <table class="table table-borderless">

                        <tr>
                            <th>Nama</th>
                            <td>{{ $lapangan->nama_lapangan }}</td>
                        </tr>

                        <tr>
                            <th>Jenis</th>
                            <td>
                                <span class="badge badge-info">
                                    {{ $lapangan->jenisLapangan->nama_jenis ?? 'Tidak ada' }}
                                </span>
                            </td>
                        </tr>

                        <tr>
                            <th>Harga</th>
                            <td>
                                Rp {{ number_format($lapangan->harga_sewa, 0, ',', '.') }}
                            </td>
                        </tr>

                        <tr>
                            <th>Deskripsi</th>
                            <td>
                                {{ $lapangan->deskripsi_lapangan ?? 'Tidak ada deskripsi.' }}
                            </td>
                        </tr>

                    </table>
                </div>

            </div>
        </div>

    </div>
</div>

@endsection