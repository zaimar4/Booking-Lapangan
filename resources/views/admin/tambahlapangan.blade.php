@extends('layouts.layout')

@section('title', 'Tambah Lapangan')

@section('content')

<div class="p-4 sm:p-8">

    <div class="mb-6">
        <h1 class="text-2xl font-bold text-zinc-900">Tambah Lapangan</h1>
        <p class="text-zinc-500 text-sm mt-1">Isi data lapangan baru yang ingin ditambahkan</p>
    </div>

    @if($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl mb-5 text-sm">
            <ul class="list-disc ml-4 space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white rounded-2xl border border-zinc-100 shadow-sm p-4 sm:p-8">

        <form action="{{ route('admin.store-lapangan') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf

            {{-- Nama Lapangan --}}
            <div>
                <label for="nama_lapangan" class="block text-sm font-semibold text-zinc-700 mb-1.5">
                    Nama Lapangan <span class="text-red-500">*</span>
                </label>
                <input type="text" id="nama_lapangan" name="nama_lapangan"
                       value="{{ old('nama_lapangan') }}"
                       required
                       placeholder="Contoh: Lapangan Basket GOR Utama"
                       class="w-full px-4 py-2.5 border border-zinc-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-zinc-900 bg-white @error('nama_lapangan') border-red-400 @enderror">
            </div>

            {{-- Jenis Lapangan --}}
            <div>
                <label for="jenis_lapangan" class="block text-sm font-semibold text-zinc-700 mb-1.5">
                    Jenis Lapangan <span class="text-red-500">*</span>
                </label>
                <select id="jenis_lapangan" name="jenis_lapangan" required
                        class="w-full pl-4 pr-10 py-2.5 border border-zinc-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-zinc-900 bg-white text-zinc-700 @error('jenis_lapangan') border-red-400 @enderror">
                    <option value="" disabled selected>-- Pilih jenis lapangan --</option>
                    @foreach ($jenis_lapangan as $j)
                        <option value="{{ $j->id }}" {{ old('jenis_lapangan') == $j->id ? 'selected' : '' }}>
                            {{ $j->nama_jenis }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Harga Sewa --}}
            <div>
                <label for="harga_sewa" class="block text-sm font-semibold text-zinc-700 mb-1.5">
                    Harga Sewa <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-sm text-zinc-400 font-medium select-none">Rp</span>
                    <input type="number" id="harga_sewa" name="harga_sewa"
                           value="{{ old('harga_sewa') }}"
                           required min="0"
                           placeholder="50000"
                           class="w-full pl-10 pr-14 py-2.5 border border-zinc-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-zinc-900 bg-white @error('harga_sewa') border-red-400 @enderror">
                    <span class="absolute right-4 top-1/2 -translate-y-1/2 text-sm text-zinc-400 select-none">/jam</span>
                </div>
            </div>

            {{-- Jam Operasional --}}
            <div>
                <label class="block text-sm font-semibold text-zinc-700 mb-1.5">
                    Jam Operasional <span class="text-red-500">*</span>
                </label>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label for="jam_buka" class="block text-xs text-zinc-500 mb-1">Jam Buka</label>
                        <input type="time" id="jam_buka" name="jam_buka"
                               value="{{ old('jam_buka', '08:00') }}"
                               required
                               class="w-full px-4 py-2.5 border border-zinc-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-zinc-900 bg-white @error('jam_buka') border-red-400 @enderror">
                    </div>
                    <div>
                        <label for="jam_tutup" class="block text-xs text-zinc-500 mb-1">Jam Tutup</label>
                        <input type="time" id="jam_tutup" name="jam_tutup"
                               value="{{ old('jam_tutup', '22:00') }}"
                               required
                               class="w-full px-4 py-2.5 border border-zinc-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-zinc-900 bg-white @error('jam_tutup') border-red-400 @enderror">
                    </div>
                </div>
                <p class="text-xs text-zinc-400 mt-1.5">Jam tutup harus lebih dari jam buka</p>
            </div>

            {{-- Deskripsi --}}
            <div>
                <label for="deskripsi_lapangan" class="block text-sm font-semibold text-zinc-700 mb-1.5">Deskripsi Lapangan</label>
                <textarea id="deskripsi_lapangan" name="deskripsi_lapangan" rows="4"
                          placeholder="Deskripsikan fasilitas dan kondisi lapangan..."
                          class="w-full px-4 py-2.5 border border-zinc-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-zinc-900 bg-white resize-none">{{ old('deskripsi_lapangan') }}</textarea>
            </div>

            {{-- Gambar --}}
            <div>
                <label class="block text-sm font-semibold text-zinc-700 mb-1.5">
                    Gambar Lapangan <span class="text-red-500">*</span>
                </label>

                {{-- Drop zone --}}
                <label for="gambar_lapangan"
                       class="flex flex-col items-center justify-center w-full h-36 border-2 border-dashed border-zinc-200 rounded-xl cursor-pointer hover:border-zinc-400 hover:bg-zinc-50 transition-colors"
                       id="dropZone">
                    <div id="dropPlaceholder" class="flex flex-col items-center gap-1.5 text-center px-4">
                        <svg class="w-8 h-8 text-zinc-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                  d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <p class="text-sm text-zinc-500">Klik untuk unggah gambar</p>
                        <p class="text-xs text-zinc-400">JPG, PNG, GIF · Maks. 2 MB</p>
                    </div>
                    <img id="previewImg" src="" alt="Preview" class="hidden h-28 w-auto rounded-lg object-cover">
                </label>
                <input type="file" id="gambar_lapangan" name="gambar_lapangan"
                       required accept="image/*" class="hidden">
            </div>

            {{-- Tombol --}}
            <div class="flex gap-3 pt-2">
                <button type="submit"
                        class="px-6 py-2.5 bg-zinc-900 hover:bg-zinc-700 text-white text-sm font-bold rounded-xl transition-colors">
                    Tambah Lapangan
                </button>
                <a href="{{ route('admin.semua-lapangan') }}"
                   class="px-6 py-2.5 border border-zinc-200 text-zinc-600 text-sm font-semibold rounded-xl hover:bg-zinc-50 transition-colors">
                    Batal
                </a>
            </div>

        </form>

    </div>

</div>

<script>
    // Image preview
    document.getElementById('gambar_lapangan').addEventListener('change', function () {
        const file = this.files[0];
        if (!file) return;

        const reader = new FileReader();
        reader.onload = function (e) {
            const preview     = document.getElementById('previewImg');
            const placeholder = document.getElementById('dropPlaceholder');
            preview.src       = e.target.result;
            preview.classList.remove('hidden');
            placeholder.classList.add('hidden');
        };
        reader.readAsDataURL(file);
    });

    // Validasi jam tutup > jam buka (client-side hint)
    document.getElementById('jam_tutup').addEventListener('change', function () {
        const buka   = document.getElementById('jam_buka').value;
        const tutup  = this.value;
        if (buka && tutup && tutup <= buka) {
            this.setCustomValidity('Jam tutup harus lebih dari jam buka');
        } else {
            this.setCustomValidity('');
        }
    });

    document.getElementById('jam_buka').addEventListener('change', function () {
        const tutupInput = document.getElementById('jam_tutup');
        if (tutupInput.value && tutupInput.value <= this.value) {
            tutupInput.setCustomValidity('Jam tutup harus lebih dari jam buka');
        } else {
            tutupInput.setCustomValidity('');
        }
    });
</script>

@endsection