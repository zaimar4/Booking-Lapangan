<h1>Dashboard Admin</h1>
<a href="{{ route('admin.tambah-lapangan') }}">Tambah Lapangan</a>
<a href="{{ route('jenis-lapangan') }}">Tambah Jenis lapangan(Kategori)</a>
<br>
<br>
<table border="1" cellpadding="10" cellspacing="0">
    <tr>
        <th>Nama Lapangan</th>
        <th>Jenis Lapangan</th>
        <th>Gambar Lapangan</th>
        <th>Deskripsi Lapangan</th>
        <th>Harga Sewa</th>
    </tr>
    @foreach ($lapangan as $item)
    <tr>
        <td>{{ $item->nama_lapangan }}</td>
        <td>{{ $item->jenis_lapangan }}</td>
        <td><img src="{{ asset('storage/' . $item->gambar_lapangan) }}" alt="{{ $item->nama_lapangan }}" width="100"></td>
        <td>{{ $item->deskripsi_lapangan }}</td>
        <td>{{ $item->harga_sewa }}</td>
    </tr>
    @endforeach
</table>