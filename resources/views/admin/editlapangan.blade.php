{{-- resources/views/edit-lapangan.blade.php --}}

@extends('layouts.layout')

@section('content')
<div class="min-h-screen bg-slate-100">
    <div class="max-w-3xl mx-auto px-4 py-10 pb-20">

        {{-- Header --}}
        <div class="mb-8">
            <nav class="flex items-center gap-2 text-sm text-slate-500 mb-3">
                <a href="{{ route('dashboard') }}" class="text-blue-600 hover:underline transition-colors">Dashboard</a>
                <span class="text-slate-300"></span>
                <span class="text-slate-500">Edit</span>
            </nav>
            <h1 class="text-2xl font-bold text-slate-800 tracking-tight">Edit Lapangan</h1>
            <p class="text-sm text-slate-500 mt-1">Perbarui informasi lapangan olahraga Anda</p>
        </div>

        {{-- Form --}}
        <form action="{{ route('update-lapangan', $lapangan->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PATCH')

            {{-- Card: Informasi Dasar --}}
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden mb-5">
                <div class="px-8 py-7">

                    <p class="text-[11px] font-bold tracking-widest uppercase text-slate-400 mb-6">
                        Informasi Dasar
                    </p>

                    {{-- Nama & Jenis (2 kolom) --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 mb-5">

                        {{-- Nama Lapangan --}}
                        <div>
                            <label for="nama_lapangan" class="block text-sm font-semibold text-slate-700 mb-2">
                                Nama Lapangan <span class="text-red-500">*</span>
                            </label>
                            <input
                                type="text"
                                id="nama_lapangan"
                                name="nama_lapangan"
                                placeholder="cth. Lapangan Futsal A"
                                value="{{ old('nama_lapangan', $lapangan->nama_lapangan) }}"
                                class="w-full px-4 py-2.5 text-sm text-slate-700 bg-slate-50 border border-slate-200 rounded-xl outline-none transition duration-200 focus:border-blue-500 focus:bg-white focus:ring-2 focus:ring-blue-100 @error('nama_lapangan') border-red-400 bg-red-50 focus:ring-red-100 focus:border-red-400 @enderror"
                            >
                            @error('nama_lapangan')
                                <p class="flex items-center gap-1.5 mt-1.5 text-xs font-medium text-red-600">
                                    <svg class="w-3.5 h-3.5 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- Jenis Lapangan --}}
                        <div>
                            <label for="jenis_lapangan" class="block text-sm font-semibold text-slate-700 mb-2">
                                Jenis Lapangan <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <select
                                    id="jenis_lapangan"
                                    name="jenis_lapangan"
                                    class="w-full px-4 py-2.5 pr-10 text-sm text-slate-700 bg-slate-50 border border-slate-200 rounded-xl outline-none appearance-none cursor-pointer transition duration-200 focus:border-blue-500 focus:bg-white focus:ring-2 focus:ring-blue-100 @error('jenis_lapangan') border-red-400 bg-red-50 @enderror"
                                >
                                    <option value="" disabled>Pilih jenis...</option>
                                    @foreach ($jenis_lapangan as $jenis)
                                        <option value="{{ $jenis->id }}"
                                            {{ $lapangan->jenis_lapangan == $jenis->id ? 'selected' : '' }}>
                                            {{ $jenis->nama_jenis }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-3 flex items-center">
                                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                    </svg>
                                </div>
                            </div>
                            @error('jenis_lapangan')
                                <p class="flex items-center gap-1.5 mt-1.5 text-xs font-medium text-red-600">
                                    <svg class="w-3.5 h-3.5 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>

                    {{-- Deskripsi --}}
                    <div class="mb-5">
                        <label for="deskripsi_lapangan" class="block text-sm font-semibold text-slate-700 mb-2">
                            Deskripsi
                        </label>
                        <textarea
                            id="deskripsi_lapangan"
                            name="deskripsi_lapangan"
                            rows="4"
                            placeholder="Jelaskan fasilitas, ukuran lapangan, dll..."
                            class="w-full px-4 py-2.5 text-sm text-slate-700 bg-slate-50 border border-slate-200 rounded-xl outline-none resize-y leading-relaxed transition duration-200 focus:border-blue-500 focus:bg-white focus:ring-2 focus:ring-blue-100"
                        >{{ old('deskripsi_lapangan', $lapangan->deskripsi_lapangan) }}</textarea>
                    </div>

                    {{-- Harga Sewa --}}
                    <div class="max-w-xs">
                        <label for="harga_sewa" class="block text-sm font-semibold text-slate-700 mb-2">
                            Harga Sewa / Jam <span class="text-red-500">*</span>
                        </label>
                        <div class="flex">
                            <span class="inline-flex items-center px-4 text-sm font-semibold text-slate-500 bg-slate-100 border border-r-0 border-slate-200 rounded-l-xl whitespace-nowrap">
                                Rp
                            </span>
                            <input
                                type="number"
                                id="harga_sewa"
                                name="harga_sewa"
                                min="0"
                                step="1000"
                                placeholder="0"
                                value="{{ old('harga_sewa', $lapangan->harga_sewa) }}"
                                class="w-full px-4 py-2.5 text-sm text-slate-700 bg-slate-50 border border-slate-200 rounded-r-xl outline-none transition duration-200 focus:border-blue-500 focus:bg-white focus:ring-2 focus:ring-blue-100 @error('harga_sewa') border-red-400 bg-red-50 @enderror"
                            >
                        </div>
                        @error('harga_sewa')
                            <p class="flex items-center gap-1.5 mt-1.5 text-xs font-medium text-red-600">
                                <svg class="w-3.5 h-3.5 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                </div>
            </div>

            {{-- Card: Foto Lapangan --}}
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden mb-5">
                <div class="px-8 py-7">

                    <p class="text-[11px] font-bold tracking-widest uppercase text-slate-400 mb-6">
                        Foto Lapangan
                    </p>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 items-start">

                        {{-- Preview Saat Ini --}}
                        <div>
                            <p class="text-sm font-semibold text-slate-700 mb-2">Foto Saat Ini</p>
                            <div class="aspect-[4/3] rounded-xl overflow-hidden border border-slate-200 bg-slate-50">
                                <img
                                    id="current-preview"
                                    src="{{ $lapangan->gambar_lapangan }}"
                                    alt="Foto {{ $lapangan->nama_lapangan }}"
                                    class="w-full h-full object-cover"
                                >
                            </div>
                        </div>

                        {{-- Upload Baru --}}
                        <div>
                            <p class="text-sm font-semibold text-slate-700 mb-2">
                                Ganti Foto
                                <span class="text-slate-400 font-normal">(opsional)</span>
                            </p>
                            <label
                                for="gambar_input"
                                id="upload-area"
                                class="flex flex-col items-center justify-center aspect-[4/3] border-2 border-dashed border-slate-300 rounded-xl bg-slate-50 cursor-pointer text-center px-5 transition duration-200 hover:border-blue-400 hover:bg-blue-50"
                            >
                                <span class="text-3xl mb-2">📸</span>
                                <span id="upload-text" class="text-sm font-medium text-slate-600 leading-snug">
                                    Klik atau seret foto ke sini
                                </span>
                                <span id="upload-hint" class="text-xs text-slate-400 mt-1">
                                    PNG, JPG, WEBP · Maks. 2 MB
                                </span>
                                <input
                                    type="file"
                                    name="gambar_lapangan"
                                    id="gambar_input"
                                    accept="image/*"
                                    class="hidden"
                                    onchange="previewImage(event)"
                                >
                            </label>
                            @error('gambar_lapangan')
                                <p class="flex items-center gap-1.5 mt-1.5 text-xs font-medium text-red-600">
                                    <svg class="w-3.5 h-3.5 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>

                </div>
            </div>

            {{-- Card: Footer Aksi --}}
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
                <div class="px-8 py-5 bg-slate-50 flex flex-col-reverse sm:flex-row items-center justify-between gap-3">

                    <a href="{{ route('admin.semua-lapangan') }}"
                       class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-6 py-2.5 rounded-xl text-sm font-semibold text-slate-600 bg-white border border-slate-200 hover:bg-slate-100 hover:border-slate-300 transition duration-200 active:scale-95">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        Batal
                    </a>

                    <button type="submit"
                            class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-6 py-2.5 rounded-xl text-sm font-semibold text-white bg-blue-600 shadow-md shadow-blue-200 hover:bg-blue-700 hover:shadow-blue-300 transition duration-200 active:scale-95">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Simpan Perubahan
                    </button>

                </div>
            </div>

        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function previewImage(event) {
        const file = event.target.files[0];
        if (!file) return;

        const reader = new FileReader();
        reader.onload = function (e) {
            // Update preview kiri
            document.getElementById('current-preview').src = e.target.result;

            // Update tampilan area upload
            const area = document.getElementById('upload-area');
            area.classList.remove('border-slate-300', 'bg-slate-50');
            area.classList.add('border-blue-400', 'bg-blue-50');

            document.getElementById('upload-text').textContent = file.name;
            document.getElementById('upload-hint').textContent =
                (file.size / 1024).toFixed(0) + ' KB · Siap diupload';
        };
        reader.readAsDataURL(file);
    }
</script>
@endsection