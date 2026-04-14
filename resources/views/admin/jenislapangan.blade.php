<h1>TAMBAH JENIS ATAU KATEGORI LAPANGAN</h1>
<br>
<a href="{{ route('tambah-jenis') }}">Tambah Jenis Lapangan</a>
<a href="{{ route('admin.dashboard') }}">DASHBOARD</a>
<table border="1" cellpadding="10" cellspacing="0">
    <tr>
        <th>NO</th>
        <th>Nama Jenis Lapangan</th>
    </tr>
    @foreach ($JenisLapangan as $item)
    <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $item->nama_jenis }}</td>
    </tr>
    @endforeach