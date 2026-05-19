@extends('layouts.layout')

@section('content')

<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');

    .detail-wrapper {
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    /* ── Page Header ── */
    .page-header-bar {
        background: linear-gradient(135deg, #1a1f3c 0%, #2d3561 60%, #3b4abf 100%);
        border-radius: 18px;
        padding: 28px 32px;
        margin-bottom: 28px;
        position: relative;
        overflow: hidden;
    }
    .page-header-bar::before {
        content: '';
        position: absolute;
        right: -40px; top: -40px;
        width: 220px; height: 220px;
        border-radius: 50%;
        background: rgba(255,255,255,0.05);
    }
    .page-header-bar::after {
        content: '';
        position: absolute;
        right: 60px; bottom: -60px;
        width: 140px; height: 140px;
        border-radius: 50%;
        background: rgba(255,255,255,0.04);
    }
    .page-header-bar h1 {
        color: #fff;
        font-size: 1.45rem;
        font-weight: 700;
        margin: 0 0 4px;
    }
    .page-header-bar .breadcrumb-sub {
        color: rgba(255,255,255,0.55);
        font-size: 0.82rem;
        margin: 0;
    }
    .btn-back {
        background: rgba(255,255,255,0.12);
        border: 1px solid rgba(255,255,255,0.22);
        color: #fff;
        border-radius: 10px;
        padding: 8px 18px;
        font-size: 0.84rem;
        font-weight: 600;
        transition: all .2s;
        backdrop-filter: blur(4px);
    }
    .btn-back:hover {
        background: rgba(255,255,255,0.22);
        color: #fff;
        text-decoration: none;
    }

    /* ── Photo Card ── */
    .photo-card {
        border: none;
        border-radius: 18px;
        box-shadow: 0 4px 24px rgba(30,40,100,0.10);
        overflow: hidden;
    }
    .photo-card .card-header-custom {
        background: linear-gradient(90deg, #f8f9fd, #eef0fb);
        border-bottom: 1px solid #e8eaf4;
        padding: 16px 22px;
        font-size: 0.82rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .08em;
        color: #3b4abf;
    }
    .photo-frame {
        background: linear-gradient(135deg, #f0f2ff 0%, #e8ecff 100%);
        min-height: 280px;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 24px;
    }
    .photo-frame img {
        width: 100%;
        max-height: 320px;
        object-fit: cover;
        border-radius: 14px;
        box-shadow: 0 8px 32px rgba(59,74,191,0.18);
    }
    .no-photo {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 10px;
        color: #9fa3c7;
    }
    .no-photo i { font-size: 3rem; }

    /* ── Stat Badges ── */
    .stat-pills {
        display: flex;
        flex-direction: column;
        gap: 10px;
        padding: 18px 22px 22px;
    }
    .stat-pill {
        display: flex;
        align-items: center;
        gap: 12px;
        background: #f5f6fd;
        border-radius: 12px;
        padding: 12px 16px;
        border-left: 4px solid #3b4abf;
    }
    .stat-pill.green  { border-left-color: #22c55e; }
    .stat-pill.orange { border-left-color: #f59e0b; }
    .stat-pill .pill-icon {
        width: 38px; height: 38px;
        border-radius: 10px;
        display: flex; align-items: center; justify-content: center;
        font-size: 1rem;
        flex-shrink: 0;
    }
    .stat-pill .pill-icon.blue   { background:#ede9ff; color:#3b4abf; }
    .stat-pill .pill-icon.green  { background:#dcfce7; color:#16a34a; }
    .stat-pill .pill-icon.orange { background:#fef3c7; color:#d97706; }
    .stat-pill .pill-label { font-size:0.74rem; color:#8b90b8; font-weight:600; text-transform:uppercase; letter-spacing:.05em; }
    .stat-pill .pill-value { font-size:1.05rem; font-weight:800; color:#1a1f3c; margin-top:1px; }

    /* ── Info Card ── */
    .info-card {
        border: none;
        border-radius: 18px;
        box-shadow: 0 4px 24px rgba(30,40,100,0.10);
        overflow: hidden;
    }
    .info-card .card-header-custom {
        background: linear-gradient(90deg, #f8f9fd, #eef0fb);
        border-bottom: 1px solid #e8eaf4;
        padding: 16px 24px;
        font-size: 0.82rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .08em;
        color: #3b4abf;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .btn-edit-custom {
        background: linear-gradient(135deg, #f59e0b, #f97316);
        border: none;
        color: #fff;
        border-radius: 9px;
        padding: 7px 16px;
        font-size: 0.82rem;
        font-weight: 700;
        box-shadow: 0 3px 10px rgba(249,115,22,0.28);
        transition: all .2s;
    }
    .btn-edit-custom:hover {
        transform: translateY(-1px);
        box-shadow: 0 5px 16px rgba(249,115,22,0.38);
        color: #fff;
        text-decoration: none;
    }

    /* ── Detail Rows ── */
    .info-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 0;
    }
    .info-item {
        padding: 20px 24px;
        border-bottom: 1px solid #f0f2fa;
        display: flex;
        flex-direction: column;
        gap: 5px;
    }
    .info-item:nth-child(odd) { border-right: 1px solid #f0f2fa; }
    .info-item.full-width {
        grid-column: 1 / -1;
        border-right: none;
    }
    .info-label {
        font-size: 0.72rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .07em;
        color: #9fa3c7;
    }
    .info-value {
        font-size: 0.97rem;
        font-weight: 600;
        color: #1a1f3c;
    }
    .badge-jenis {
        display: inline-block;
        background: linear-gradient(135deg, #3b4abf, #6366f1);
        color: #fff;
        border-radius: 8px;
        padding: 4px 12px;
        font-size: 0.82rem;
        font-weight: 700;
        letter-spacing: .03em;
    }
    .price-highlight {
        font-size: 1.2rem;
        font-weight: 800;
        background: linear-gradient(90deg, #16a34a, #22c55e);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }
    .desc-box {
        background: #f8f9fd;
        border-radius: 10px;
        padding: 12px 16px;
        font-size: 0.9rem;
        color: #4a4f7a;
        line-height: 1.65;
        font-weight: 400;
    }

    /* ── Status Badge ── */
    .status-active {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: #dcfce7;
        color: #15803d;
        border-radius: 20px;
        padding: 4px 14px;
        font-size: 0.82rem;
        font-weight: 700;
    }
    .status-dot {
        width: 7px; height: 7px;
        border-radius: 50%;
        background: #22c55e;
        animation: pulse-dot 1.5s ease-in-out infinite;
    }
    @keyframes pulse-dot {
        0%,100% { opacity:1; transform:scale(1); }
        50%      { opacity:.6; transform:scale(1.35); }
    }

    /* ── Responsive ── */
    @media (max-width: 600px) {
        .info-grid { grid-template-columns: 1fr; }
        .info-item:nth-child(odd) { border-right: none; }
        .info-item.full-width { grid-column: auto; }
        .page-header-bar { padding: 20px 18px; }
    }
</style>

<div class="detail-wrapper">

    {{-- ── Page Header ── --}}
    <div class="page-header-bar d-flex align-items-center justify-content-between flex-wrap gap-2">
        <div>
            <h1><i class="fas fa-map-marker-alt mr-2" style="opacity:.75"></i>{{ $lapangan->nama_lapangan }}</h1>
            <p class="breadcrumb-sub">Admin &rsaquo; Lapangan &rsaquo; Detail</p>
        </div>
        <a href="{{ route('admin.dashboard') }}" class="btn-back">
            <i class="fas fa-arrow-left mr-1"></i> Kembali
        </a>
    </div>

    <div class="row">

        {{-- ── Left: Photo + Stat Pills ── --}}
        <div class="col-xl-4 col-lg-5 mb-4">
            <div class="photo-card card">
                <div class="card-header-custom">
                    <i class="fas fa-image mr-1"></i> Foto Lapangan
                </div>
                <div class="photo-frame">
                    @if($lapangan->gambar_lapangan)
                        <img src="{{ $lapangan->gambar_lapangan }}" alt="Foto {{ $lapangan->nama_lapangan }}">
                    @else
                        <div class="no-photo">
                            <i class="fas fa-image"></i>
                            <span style="font-size:.85rem;font-weight:600">Belum ada foto</span>
                        </div>
                    @endif
                </div>

                <div class="stat-pills">
                    <div class="stat-pill">
                        <div class="pill-icon blue"><i class="fas fa-calendar-check"></i></div>
                        <div>
                            <div class="pill-label">Total Booking</div>
                            <div class="pill-value">{{ $lapangan->bookings_count ?? 0 }}</div>
                        </div>
                    </div>
                    <div class="stat-pill green">
                        <div class="pill-icon green"><i class="fas fa-check-circle"></i></div>
                        <div>
                            <div class="pill-label">Status</div>
                            <div class="pill-value">
                                <span class="status-active">
                                    <span class="status-dot"></span> Aktif
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="stat-pill orange">
                        <div class="pill-icon orange"><i class="fas fa-tag"></i></div>
                        <div>
                            <div class="pill-label">Harga per Jam</div>
                            <div class="pill-value">Rp {{ number_format($lapangan->harga_sewa, 0, ',', '.') }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ── Right: Info Detail ── --}}
        <div class="col-xl-8 col-lg-7 mb-4">
            <div class="info-card card h-100">
                <div class="card-header-custom">
                    <span><i class="fas fa-info-circle mr-1"></i> Informasi Lengkap</span>
                    <a href="{{ route('edit-lapangan', $lapangan->id) }}" class="btn-edit-custom">
                        <i class="fas fa-pen mr-1"></i> Edit
                    </a>
                </div>

                <div class="info-grid">
                    <div class="info-item">
                        <span class="info-label">Nama Lapangan</span>
                        <span class="info-value">{{ $lapangan->nama_lapangan }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Jenis Lapangan</span>
                        <span class="info-value">
                            <span class="badge-jenis">{{ $lapangan->jenis_lapangan }}</span>
                        </span>
                    </div>
                    <div class="info-item full-width">
                        <span class="info-label">Harga Sewa per Jam</span>
                        <span class="price-highlight">Rp {{ number_format($lapangan->harga_sewa, 0, ',', '.') }}</span>
                    </div>
                    <div class="info-item full-width">
                        <span class="info-label">Deskripsi</span>
                        <div class="desc-box">
                            {{ $lapangan->deskripsi ?? 'Tidak ada deskripsi untuk lapangan ini.' }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection