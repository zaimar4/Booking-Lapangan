<h1>SEMUA LAPANGAN </h1>
<a href="{{ route('admin.tambah-lapangan') }}">Tambah Lapangan</a>
<a href="{{ route('jenis-lapangan') }}">Tambah Jenis lapangan(Kategori)</a>
<br>
<br>
<h2>total lapangan : {{ $totalLapangan }}</h2>
<table border="1" cellpadding="10" cellspacing="0">
    <tr>
        <th>Nama Lapangan</th>
        <th>Jenis Lapangan</th>
        <th>Gambar Lapangan</th>
        <th>Deskripsi Lapangan</th>
        <th>Harga Sewa</th>
        <th>Aksi</th>
    </tr>
    @foreach ($lapangan as $item)
    <tr>
        <td>{{ $item->nama_lapangan }}</td>
        <td>{{ $item->jenis_lapangan }}</td>
        <td><img src="{{ asset('images/' . $item->gambar_lapangan) }}" alt="{{ $item->nama_lapangan }}" width="100"></td>
        <td>{{ $item->deskripsi_lapangan }}</td>
        <td>{{ $item->harga_sewa }}</td>
        <td>
    <a href="{{ route('edit-lapangan', $item->id) }}">Edit</a>

    <form action="{{ route('delete-lapangan', $item->id) }}" method="POST" style="display:inline;">
        @csrf
        @method('DELETE')
        <button type="submit" onclick="return confirm('Yakin hapus?')">Hapus</button>
    </form>
    </td>

    </tr>
    @endforeach
</table>