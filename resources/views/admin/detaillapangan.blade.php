@extends('layouts.layout') 
@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Detail Lapangan: {{ $lapangan->nama_lapangan }}</h1>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary btn-sm shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Kembali
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
                        <img src="{{ $lapangan->gambar_lapangan) }}" class="img-fluid rounded shadow-sm" alt="Foto Lapangan" width="60">
                    @else
                        <div class="bg-light py-5 text-muted">Tidak ada foto</div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Informasi Lengkap</h6>
                    <div>
                        <a href="{{ route('edit-lapangan', $lapangan->id) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <th width="30%">Nama Lapangan</th>
                            <td>: {{ $lapangan->nama_lapangan }}</td>
                        </tr>
                        <tr>
                            <th>Jenis Lapangan</th>
                            <td>: <span class="badge badge-info">{{ $lapangan->jenis_lapangan}}</span></td>
                        </tr>
                        <tr>
                            <th>Harga per Jam</th>
                            <td>: <span class="text-success font-weight-bold">Rp {{ number_format($lapangan->harga_sewa, 0, ',', '.') }}</span></td>
                        </tr>
                       
                        <tr>
                            <th>Deskripsi</th>
                            <td>: {{ $lapangan->deskripsi ?? 'Tidak ada deskripsi.' }}</td>
                        </tr>
                    </table>
                    
                    <hr>
                    
                    <div class="mt-4">
                        <h6 class="font-weight-bold">Ringkasan Statistik:</h6>
                        <div class="row text-center mt-3">
                            <div class="col-md-4">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Booking</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $lapangan->bookings_count ?? 0 }}</div>
                            </div>
                            <div class="col-md-4">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Status</div>
                                <div class="h5 mb-0 font-weight-bold text-success">Aktif</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection