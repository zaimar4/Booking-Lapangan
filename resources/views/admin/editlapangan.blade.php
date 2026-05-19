{{-- resources/views/edit-lapangan.blade.php --}}

@extends('layouts.layout')

@section('styles')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap');

    * {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
    }

    body {
        font-family: 'Plus Jakarta Sans', sans-serif;
        background: #f0f4f8;
        min-height: 100vh;
        color: #1a202c;
    }

    .page-wrapper {
        max-width: 780px;
        margin: 48px auto;
        padding: 0 24px 64px;
    }

    /* ── Header ── */
    .page-header {
        margin-bottom: 36px;
    }

    .breadcrumb {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 13px;
        color: #718096;
        margin-bottom: 12px;
    }

    .breadcrumb a {
        color: #3182ce;
        text-decoration: none;
    }

    .breadcrumb a:hover { text-decoration: underline; }

    .breadcrumb-sep { color: #cbd5e0; }

    .page-title {
        font-size: 28px;
        font-weight: 700;
        color: #1a202c;
        letter-spacing: -0.5px;
    }

    .page-subtitle {
        font-size: 14px;
        color: #718096;
        margin-top: 6px;
    }

    /* ── Card ── */
    .card {
        background: #ffffff;
        border-radius: 20px;
        box-shadow: 0 1px 3px rgba(0,0,0,.06), 0 4px 24px rgba(0,0,0,.07);
        overflow: hidden;
    }

    .card-section {
        padding: 32px 36px;
        border-bottom: 1px solid #edf2f7;
    }

    .card-section:last-child { border-bottom: none; }

    .section-label {
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 1px;
        text-transform: uppercase;
        color: #a0aec0;
        margin-bottom: 20px;
    }

    /* ── Form Controls ── */
    .form-group {
        margin-bottom: 22px;
    }

    .form-group:last-child { margin-bottom: 0; }

    label {
        display: block;
        font-size: 14px;
        font-weight: 600;
        color: #2d3748;
        margin-bottom: 8px;
    }

    .required-mark {
        color: #e53e3e;
        margin-left: 3px;
    }

    input[type="text"],
    input[type="number"],
    select,
    textarea {
        width: 100%;
        padding: 11px 14px;
        font-family: inherit;
        font-size: 14px;
        color: #2d3748;
        background: #f7fafc;
        border: 1.5px solid #e2e8f0;
        border-radius: 10px;
        outline: none;
        transition: border-color .2s, box-shadow .2s, background .2s;
        appearance: none;
    }

    input[type="text"]:focus,
    input[type="number"]:focus,
    select:focus,
    textarea:focus {
        border-color: #3182ce;
        background: #fff;
        box-shadow: 0 0 0 3px rgba(49,130,206,.12);
    }

    select {
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%23718096' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 12px center;
        padding-right: 40px;
        cursor: pointer;
    }

    textarea {
        resize: vertical;
        min-height: 110px;
        line-height: 1.6;
    }

    /* Harga prefix wrapper */
    .input-prefix-group {
        display: flex;
        align-items: stretch;
    }

    .input-prefix {
        display: flex;
        align-items: center;
        padding: 0 14px;
        background: #edf2f7;
        border: 1.5px solid #e2e8f0;
        border-right: none;
        border-radius: 10px 0 0 10px;
        font-size: 13px;
        font-weight: 600;
        color: #718096;
        white-space: nowrap;
    }

    .input-prefix-group input {
        border-radius: 0 10px 10px 0;
    }

    /* Error */
    .error-msg {
        display: flex;
        align-items: center;
        gap: 6px;
        margin-top: 6px;
        font-size: 12.5px;
        color: #c53030;
        font-weight: 500;
    }

    .error-msg::before {
        content: "⚠";
        font-size: 11px;
    }

    /* ── Image Preview ── */
    .image-section {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 24px;
        align-items: start;
    }

    .image-preview-box {
        aspect-ratio: 4/3;
        border-radius: 12px;
        overflow: hidden;
        border: 1.5px solid #e2e8f0;
        background: #f7fafc;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .image-preview-box img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    .image-upload-area {
        border: 2px dashed #cbd5e0;
        border-radius: 12px;
        padding: 28px 20px;
        text-align: center;
        background: #f7fafc;
        cursor: pointer;
        transition: border-color .2s, background .2s;
        position: relative;
    }

    .image-upload-area:hover {
        border-color: #3182ce;
        background: #ebf4ff;
    }

    .image-upload-area input[type="file"] {
        position: absolute;
        inset: 0;
        opacity: 0;
        cursor: pointer;
        width: 100%;
        height: 100%;
    }

    .upload-icon {
        font-size: 28px;
        margin-bottom: 8px;
    }

    .upload-text {
        font-size: 13px;
        color: #4a5568;
        font-weight: 500;
        line-height: 1.5;
    }

    .upload-hint {
        font-size: 11.5px;
        color: #a0aec0;
        margin-top: 4px;
    }

    /* ── Footer / Buttons ── */
    .card-footer {
        padding: 24px 36px;
        background: #f7fafc;
        border-top: 1px solid #edf2f7;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
    }

    .btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 11px 24px;
        border-radius: 10px;
        font-family: inherit;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        border: none;
        transition: transform .15s, box-shadow .15s, background .2s;
        text-decoration: none;
    }

    .btn:active { transform: translateY(1px); }

    .btn-primary {
        background: #2563eb;
        color: #fff;
        box-shadow: 0 2px 8px rgba(37,99,235,.35);
    }

    .btn-primary:hover {
        background: #1d4ed8;
        box-shadow: 0 4px 14px rgba(37,99,235,.4);
    }

    .btn-secondary {
        background: #fff;
        color: #4a5568;
        border: 1.5px solid #e2e8f0;
    }

    .btn-secondary:hover {
        background: #f7fafc;
        border-color: #cbd5e0;
    }

    /* Two-column grid */
    .two-col {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }

    @media (max-width: 600px) {
        .page-wrapper { margin: 24px auto; padding: 0 16px 48px; }
        .card-section { padding: 24px 20px; }
        .card-footer { padding: 20px; flex-direction: column-reverse; }
        .btn { width: 100%; justify-content: center; }
        .two-col { grid-template-columns: 1fr; }
        .image-section { grid-template-columns: 1fr; }
    }
</style>
@endsection

@section('content')
<div class="page-wrapper">

    {{-- Header --}}
    <div class="page-header">
        <div class="breadcrumb">
            <a href="{{ route('dashboard') }}">Dashboard</a>
            <span class="breadcrumb-sep">›</span>
          
            <span>Edit</span>
        </div>
        <h1 class="page-title">Edit Lapangan</h1>
        <p class="page-subtitle">Perbarui informasi lapangan olahraga Anda</p>
    </div>

    {{-- Form --}}
    <form action="{{ route('update-lapangan', $lapangan->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PATCH')

        {{-- Informasi Dasar --}}
        <div class="card" style="margin-bottom: 20px;">
            <div class="card-section">
                <div class="section-label">Informasi Dasar</div>

                <div class="two-col">
                    <div class="form-group">
                        <label for="nama_lapangan">Nama Lapangan <span class="required-mark">*</span></label>
                        <input
                            type="text"
                            id="nama_lapangan"
                            name="nama_lapangan"
                            placeholder="cth. Lapangan Futsal A"
                            value="{{ old('nama_lapangan', $lapangan->nama_lapangan) }}"
                        >
                        @error('nama_lapangan')
                            <div class="error-msg">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="jenis_lapangan">Jenis Lapangan <span class="required-mark">*</span></label>
                        <select id="jenis_lapangan" name="jenis_lapangan">
                            <option value="" disabled>Pilih jenis...</option>
                            @foreach ($jenis_lapangan as $jenis)
                                <option value="{{ $jenis->id }}"
                                    {{ $lapangan->jenis_lapangan == $jenis->id ? 'selected' : '' }}>
                                    {{ $jenis->nama_jenis }}
                                </option>
                            @endforeach
                        </select>
                        @error('jenis_lapangan')
                            <div class="error-msg">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label for="deskripsi_lapangan">Deskripsi</label>
                    <textarea
                        id="deskripsi_lapangan"
                        name="deskripsi_lapangan"
                        placeholder="Jelaskan fasilitas, ukuran lapangan, dll..."
                    >{{ old('deskripsi_lapangan', $lapangan->deskripsi_lapangan) }}</textarea>
                </div>

                <div class="form-group" style="max-width: 280px;">
                    <label for="harga_sewa">Harga Sewa / Jam <span class="required-mark">*</span></label>
                    <div class="input-prefix-group">
                        <span class="input-prefix">Rp</span>
                        <input
                            type="number"
                            id="harga_sewa"
                            name="harga_sewa"
                            min="0"
                            step="1000"
                            placeholder="0"
                            value="{{ old('harga_sewa', $lapangan->harga_sewa) }}"
                        >
                    </div>
                    @error('harga_sewa')
                        <div class="error-msg">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        {{-- Gambar --}}
        <div class="card" style="margin-bottom: 20px;">
            <div class="card-section">
                <div class="section-label">Foto Lapangan</div>

                <div class="image-section">
                    <div>
                        <label style="margin-bottom: 10px;">Foto Saat Ini</label>
                        <div class="image-preview-box">
                            <img
                                src="{{ $lapangan->gambar_lapangan }}"
                                alt="Foto {{ $lapangan->nama_lapangan }}"
                                id="current-preview"
                            >
                        </div>
                    </div>

                    <div>
                        <label style="margin-bottom: 10px;">Ganti Foto <span style="color:#a0aec0;font-weight:400">(opsional)</span></label>
                        <div class="image-upload-area" id="upload-area">
                            <input
                                type="file"
                                name="gambar_lapangan"
                                accept="image/*"
                                id="gambar_input"
                                onchange="previewImage(event)"
                            >
                            <div class="upload-icon">📸</div>
                            <div class="upload-text">Klik atau seret foto ke sini</div>
                            <div class="upload-hint">PNG, JPG, WEBP · Maks. 2 MB</div>
                        </div>
                        @error('gambar_lapangan')
                            <div class="error-msg">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        {{-- Footer --}}
        <div class="card">
            <div class="card-footer">
                <a href="{{ route('admin.semua-lapangan') }}" class="btn btn-secondary">
                    ← Batal
                </a>
                <button type="submit" class="btn btn-primary">
                     Simpan Perubahan
                </button>
            </div>
        </div>

    </form>
</div>
@endsection

@section('scripts')
<script>
    function previewImage(event) {
        const file = event.target.files[0];
        if (!file) return;

        const reader = new FileReader();
        reader.onload = function(e) {
            const preview = document.getElementById('current-preview');
            preview.src = e.target.result;

            const area = document.getElementById('upload-area');
            area.style.borderColor = '#3182ce';
            area.style.background = '#ebf4ff';
            area.querySelector('.upload-text').textContent = file.name;
            area.querySelector('.upload-hint').textContent =
                (file.size / 1024).toFixed(0) + ' KB';
        };
        reader.readAsDataURL(file);
    }
</script>
@endsection