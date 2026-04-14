<h1>Tambah Lapangan</h1>
<form action="{{ route('admin.store-lapangan') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <label for="nama_lapangan">Nama Lapangan</label>
    <input type="text" id="nama_lapangan" name="nama_lapangan">
    <label for="jenis_lapangan">Jenis Lapangan</label>
   
    <select id="jenis_lapangan" name="jenis_lapangan">
         @foreach ($jenis_lapangan as $j )
              <option value="{{ $j->id }}">{{ $j->nama_jenis }}</option>
      
    @endforeach
      
    </select>
    <label for="gambar_lapangan">Gambar Lapangan</label>
    <input type="file" id="gambar_lapangan" name="gambar_lapangan">
    <label for="deskripsi_lapangan">Deskripsi Lapangan</label>
    <textarea id="deskripsi_lapangan" name="deskripsi_lapangan"></textarea>
    <label for="harga_sewa">Harga Sewa</label>
    <input type="number" id="harga_sewa" name="harga_sewa">
    <button type="submit">Tambah Lapangan</button>

</form>