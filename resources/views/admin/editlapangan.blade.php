

<h2>Edit Lapangan</h2>

<form action="{{ route('update-lapangan', $lapangan->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PATCH')

    <div>
        <label>Nama Lapangan</label><br>
        <input type="text" name="nama_lapangan"
               value="{{ old('nama_lapangan', $lapangan->nama_lapangan) }}">
        @error('nama_lapangan')
            <div style="color:red;">{{ $message }}</div>
        @enderror
    </div>

    <br>

    <div>
        <label>Jenis Lapangan</label><br>
        <select name="jenis_lapangan">
            @foreach ($jenis_lapangan as $jenis)
                <option value="{{ $jenis->id }}"
                    {{ $lapangan->jenis_lapangan == $jenis->id ? 'selected' : '' }}>
                    {{ $jenis->nama_jenis }}
                </option>
            @endforeach
        </select>
        @error('jenis_lapangan')
            <div style="color:red;">{{ $message }}</div>
        @enderror
    </div>

    <br>

    <div>
        <label>Gambar Saat Ini</label><br>
        <img src="{{ $lapangan->gambar_lapangan }}" width="120">
    </div>

    <br>

    <div>
        <label>Ganti Gambar (opsional)</label><br>
        <input type="file" name="gambar_lapangan">
        @error('gambar_lapangan')
            <div style="color:red;">{{ $message }}</div>
        @enderror
    </div>

    <br>

    <div>
        <label>Deskripsi</label><br>
        <textarea name="deskripsi_lapangan">{{ old('deskripsi_lapangan', $lapangan->deskripsi_lapangan) }}</textarea>
    </div>

    <br>

    <div>
        <label>Harga Sewa</label><br>
        <input type="number" name="harga_sewa" min="0"
               value="{{ old('harga_sewa', $lapangan->harga_sewa) }}">
        @error('harga_sewa')
            <div style="color:red;">{{ $message }}</div>
        @enderror
    </div>

    <br>

    <button type="submit">Update</button>
</form>
