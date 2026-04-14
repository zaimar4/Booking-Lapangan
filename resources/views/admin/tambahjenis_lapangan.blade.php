<h1>BUAT JENIS LAPANGAN ATAU KATEGORI LAPANGAN</h1>
<form action="{{ route('tambah-jenis') }}" method="POST">
    @csrf
    <label for="nama_jenis">Nama Jenis Lapangan:</label>
    <input type="text" name="nama_jenis" id="nama_jenis" required>
    <button type="submit">Simpan</button>
</form>