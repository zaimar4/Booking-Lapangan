<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SportField – Booking Lapangan Olahraga</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --green: #16a34a;
            --green-light: #22c55e;
            --green-dim: #dcfce7;
            --dark: #0f1a13;
            --surface: #111b14;
            --card: #172019;
            --border: rgba(255,255,255,0.08);
            --text: #f0fdf4;
            --muted: #86efac;
            --accent: #4ade80;
        }

        html { scroll-behavior: smooth; }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--dark);
            color: var(--text);
            overflow-x: hidden;
        }

        /* ── NAV ── */
        nav {
            position: fixed;
            top: 0; left: 0; right: 0;
            z-index: 100;
            padding: 18px 5%;
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: rgba(15,26,19,0.85);
            backdrop-filter: blur(16px);
            border-bottom: 1px solid var(--border);
        }
        .logo {
            font-family: 'Syne', sans-serif;
            font-weight: 800;
            font-size: 1.4rem;
            color: var(--text);
            text-decoration: none;
            letter-spacing: -0.5px;
        }
        .logo span { color: var(--accent); }
        .nav-links { display: flex; align-items: center; gap: 32px; }
        .nav-links a {
            color: var(--muted);
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 500;
            transition: color .2s;
        }
        .nav-links a:hover { color: var(--text); }
        .btn-nav {
            background: var(--green);
            color: #fff !important;
            padding: 9px 22px;
            border-radius: 8px;
            font-weight: 600 !important;
            transition: background .2s, transform .2s !important;
        }
        .btn-nav:hover { background: var(--green-light) !important; transform: translateY(-1px); }

        /* ── HERO ── */
        .hero {
            min-height: 100vh;
            display: flex;
            align-items: center;
            padding: 100px 5% 60px;
            position: relative;
            overflow: hidden;
        }
        .hero::before {
            content: '';
            position: absolute;
            top: -200px; right: -200px;
            width: 700px; height: 700px;
            background: radial-gradient(circle, rgba(22,163,74,0.18) 0%, transparent 70%);
            pointer-events: none;
        }
        .hero::after {
            content: '';
            position: absolute;
            bottom: -100px; left: -100px;
            width: 400px; height: 400px;
            background: radial-gradient(circle, rgba(74,222,128,0.08) 0%, transparent 70%);
            pointer-events: none;
        }
        .hero-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 60px;
            align-items: center;
            max-width: 1200px;
            margin: 0 auto;
            width: 100%;
        }
        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(22,163,74,0.15);
            border: 1px solid rgba(74,222,128,0.3);
            color: var(--accent);
            font-size: 0.78rem;
            font-weight: 600;
            padding: 6px 14px;
            border-radius: 100px;
            margin-bottom: 24px;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }
        .hero-badge::before {
            content: '';
            width: 7px; height: 7px;
            background: var(--accent);
            border-radius: 50%;
            animation: pulse 2s infinite;
        }
        @keyframes pulse {
            0%,100% { opacity:1; transform:scale(1); }
            50% { opacity:.4; transform:scale(1.5); }
        }
        h1 {
            font-family: 'Syne', sans-serif;
            font-size: clamp(2.6rem, 5vw, 4rem);
            font-weight: 800;
            line-height: 1.1;
            letter-spacing: -1px;
            margin-bottom: 20px;
            color: var(--text);
        }
        h1 .highlight {
            color: var(--accent);
            position: relative;
            display: inline-block;
        }
        .hero-desc {
            color: var(--muted);
            font-size: 1.05rem;
            line-height: 1.7;
            margin-bottom: 36px;
            max-width: 480px;
        }
        .hero-cta {
            display: flex;
            gap: 14px;
            flex-wrap: wrap;
        }
        .btn-primary {
            background: var(--green);
            color: #fff;
            padding: 14px 30px;
            border-radius: 10px;
            font-weight: 600;
            font-size: 0.95rem;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all .25s;
            box-shadow: 0 4px 20px rgba(22,163,74,0.35);
        }
        .btn-primary:hover {
            background: var(--green-light);
            transform: translateY(-2px);
            box-shadow: 0 8px 30px rgba(22,163,74,0.45);
        }
        .btn-secondary {
            background: transparent;
            color: var(--text);
            padding: 14px 30px;
            border-radius: 10px;
            font-weight: 500;
            font-size: 0.95rem;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            border: 1px solid var(--border);
            transition: all .25s;
        }
        .btn-secondary:hover {
            border-color: rgba(255,255,255,0.2);
            background: rgba(255,255,255,0.05);
        }

        /* Hero Visual */
        .hero-visual {
            position: relative;
            padding: 22px 26px 72px 26px;
        }
        .field-card {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 25px 60px rgba(0,0,0,0.5);
            transform: perspective(1000px) rotateY(-5deg) rotateX(3deg);
            transition: transform .3s;
        }
        .field-card:hover {
            transform: perspective(1000px) rotateY(0deg) rotateX(0deg);
        }
        .field-img {
            width: 100%;
            height: 220px;
            background: linear-gradient(135deg, #14532d 0%, #15803d 40%, #16a34a 70%, #22c55e 100%);
            position: relative;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        /* SVG field lines */
        .field-lines {
            position: absolute;
            inset: 0;
            opacity: 0.15;
        }
        .field-icon {
            position: relative;
            z-index: 1;
            width: 70px;
            height: 70px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .field-icon svg {
            width: 70px;
            height: 70px;
            filter: drop-shadow(0 4px 16px rgba(0,0,0,0.5));
        }
        .field-info {
            padding: 20px;
        }
        .field-info h3 {
            font-family: 'Syne', sans-serif;
            font-weight: 700;
            font-size: 1.1rem;
            margin-bottom: 6px;
        }
        .field-info p {
            color: var(--muted);
            font-size: 0.82rem;
        }
        .field-info .price {
            color: var(--accent);
            font-weight: 700;
            font-size: 1.05rem;
            margin-top: 12px;
        }
        .floating-badge {
            position: absolute;
            color: #fff;
            padding: 8px 14px;
            border-radius: 50px;
            font-size: 0.8rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 7px;
            white-space: nowrap;
            z-index: 10;
        }
        .floating-badge.badge-fire {
            background: rgba(234, 88, 12, 0.92);
            box-shadow: 0 4px 20px rgba(234,88,12,0.35);
            top: 4px; right: 10px;
        }
        .floating-badge.badge-confirm {
            background: rgba(22, 163, 74, 0.95);
            box-shadow: 0 4px 20px rgba(22,163,74,0.45);
            bottom: 12px; left: 6px;
        }
        .floating-badge svg {
            width: 14px;
            height: 14px;
            flex-shrink: 0;
        }

        /* ── STATS ── */
        .stats-section {
            padding: 40px 5%;
            border-top: 1px solid var(--border);
            border-bottom: 1px solid var(--border);
        }
        .stats-inner {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            text-align: center;
        }
        .stat-num {
            font-family: 'Syne', sans-serif;
            font-size: 2.2rem;
            font-weight: 800;
            color: var(--accent);
        }
        .stat-label {
            color: var(--muted);
            font-size: 0.85rem;
            margin-top: 4px;
        }

        /* ── SPORTS / CATEGORIES ── */
        .section {
            padding: 80px 5%;
            max-width: 1200px;
            margin: 0 auto;
        }
        .section-label {
            font-size: 0.78rem;
            font-weight: 600;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            color: var(--accent);
            margin-bottom: 12px;
        }
        .section-title {
            font-family: 'Syne', sans-serif;
            font-size: clamp(1.8rem, 3vw, 2.6rem);
            font-weight: 800;
            letter-spacing: -0.5px;
            margin-bottom: 14px;
        }
        .section-desc {
            color: var(--muted);
            font-size: 1rem;
            line-height: 1.6;
            max-width: 500px;
            margin-bottom: 48px;
        }

        .sports-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
        }
        .sport-card {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 28px 24px;
            cursor: pointer;
            transition: all .25s;
            position: relative;
            overflow: hidden;
        }
        .sport-card::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 2px;
            background: linear-gradient(90deg, transparent, var(--green), transparent);
            opacity: 0;
            transition: opacity .3s;
        }
        .sport-card:hover {
            border-color: rgba(74,222,128,0.3);
            transform: translateY(-4px);
            box-shadow: 0 12px 40px rgba(0,0,0,0.3);
        }
        .sport-card:hover::before { opacity: 1; }
        .sport-svg-icon { width: 52px; height: 52px; margin-bottom: 14px; display: block; }
        .sport-svg-icon svg { width: 52px; height: 52px; }
        .sport-name {
            font-family: 'Syne', sans-serif;
            font-weight: 700;
            font-size: 1rem;
            margin-bottom: 6px;
        }
        .sport-count {
            color: var(--muted);
            font-size: 0.82rem;
        }

        /* ── HOW IT WORKS ── */
        .how-section {
            background: var(--surface);
            padding: 80px 5%;
        }
        .how-inner {
            max-width: 1200px;
            margin: 0 auto;
        }
        .steps-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 30px;
            margin-top: 48px;
        }
        .step {
            text-align: center;
            position: relative;
        }
        .step:not(:last-child)::after {
            content: '→';
            position: absolute;
            top: 28px; right: -18px;
            color: var(--muted);
            font-size: 1.2rem;
        }
        .step-num {
            width: 56px; height: 56px;
            background: rgba(22,163,74,0.15);
            border: 1px solid rgba(74,222,128,0.3);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Syne', sans-serif;
            font-weight: 800;
            font-size: 1.2rem;
            color: var(--accent);
            margin: 0 auto 16px;
        }
        .step h4 {
            font-family: 'Syne', sans-serif;
            font-weight: 700;
            margin-bottom: 8px;
        }
        .step p {
            color: var(--muted);
            font-size: 0.85rem;
            line-height: 1.6;
        }

        /* ── FEATURES ── */
        .features-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
            margin-top: 48px;
        }
        .feature-card {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 28px;
            display: flex;
            gap: 20px;
            align-items: flex-start;
            transition: border-color .2s;
        }
        .feature-card:hover { border-color: rgba(74,222,128,0.2); }
        .feature-icon {
            width: 48px; height: 48px;
            background: rgba(22,163,74,0.12);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.4rem;
            flex-shrink: 0;
        }
        .feature-text h4 {
            font-family: 'Syne', sans-serif;
            font-weight: 700;
            margin-bottom: 6px;
        }
        .feature-text p {
            color: var(--muted);
            font-size: 0.87rem;
            line-height: 1.6;
        }

        /* ── TESTIMONIALS ── */
        .testi-section {
            background: var(--surface);
            padding: 80px 5%;
        }
        .testi-inner {
            max-width: 1200px;
            margin: 0 auto;
        }
        .testi-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-top: 48px;
        }
        .testi-card {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 28px;
        }
        .testi-stars {
            color: #fbbf24;
            font-size: 0.9rem;
            margin-bottom: 14px;
            letter-spacing: 2px;
        }
        .testi-text {
            color: #d1fae5;
            font-size: 0.9rem;
            line-height: 1.7;
            margin-bottom: 20px;
            font-style: italic;
        }
        .testi-author {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .testi-avatar {
            width: 40px; height: 40px;
            background: rgba(22,163,74,0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 0.9rem;
            color: var(--accent);
            border: 1px solid rgba(74,222,128,0.3);
        }
        .testi-name {
            font-weight: 600;
            font-size: 0.9rem;
        }
        .testi-role {
            color: var(--muted);
            font-size: 0.78rem;
        }

        /* ── CTA BANNER ── */
        .cta-section {
            padding: 80px 5%;
        }
        .cta-inner {
            max-width: 1200px;
            margin: 0 auto;
        }
        .cta-box {
            background: linear-gradient(135deg, #14532d 0%, #15803d 50%, #16a34a 100%);
            border-radius: 24px;
            padding: 64px 60px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 40px;
            position: relative;
            overflow: hidden;
        }
        .cta-box::before {
            content: '';
            position: absolute;
            top: -50px; right: -50px;
            width: 300px; height: 300px;
            background: rgba(255,255,255,0.05);
            border-radius: 50%;
        }
        .cta-box::after {
            content: '';
            position: absolute;
            bottom: -80px; right: 200px;
            width: 200px; height: 200px;
            background: rgba(255,255,255,0.04);
            border-radius: 50%;
        }
        .cta-text h2 {
            font-family: 'Syne', sans-serif;
            font-size: 2rem;
            font-weight: 800;
            margin-bottom: 10px;
        }
        .cta-text p {
            color: #bbf7d0;
            font-size: 1rem;
        }
        .btn-white {
            background: #fff;
            color: var(--green);
            padding: 14px 32px;
            border-radius: 10px;
            font-weight: 700;
            font-size: 0.95rem;
            text-decoration: none;
            white-space: nowrap;
            transition: all .25s;
            box-shadow: 0 4px 20px rgba(0,0,0,0.2);
        }
        .btn-white:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 30px rgba(0,0,0,0.25);
        }

        /* ── FOOTER ── */
        footer {
            border-top: 1px solid var(--border);
            padding: 40px 5%;
        }
        .footer-inner {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 16px;
        }
        .footer-copy {
            color: var(--muted);
            font-size: 0.85rem;
        }
        .footer-links {
            display: flex;
            gap: 24px;
        }
        .footer-links a {
            color: var(--muted);
            text-decoration: none;
            font-size: 0.85rem;
            transition: color .2s;
        }
        .footer-links a:hover { color: var(--text); }

        /* ── RESPONSIVE ── */
        @media (max-width: 900px) {
            .hero-grid { grid-template-columns: 1fr; }
            .hero-visual { display: none; }
            .stats-inner { grid-template-columns: repeat(2, 1fr); }
            .sports-grid { grid-template-columns: repeat(2, 1fr); }
            .steps-grid { grid-template-columns: repeat(2, 1fr); }
            .step:not(:last-child)::after { display: none; }
            .features-grid { grid-template-columns: 1fr; }
            .testi-grid { grid-template-columns: 1fr; }
            .cta-box { flex-direction: column; text-align: center; padding: 40px 30px; }
            .nav-links { gap: 16px; }
        }
        @media (max-width: 600px) {
            .stats-inner { grid-template-columns: repeat(2, 1fr); }
            .sports-grid { grid-template-columns: 1fr; }
            .steps-grid { grid-template-columns: 1fr; }
            h1 { font-size: 2.2rem; }
        }

        /* Animate on load */
        .fade-up {
            opacity: 0;
            transform: translateY(30px);
            animation: fadeUp .7s ease forwards;
        }
        .fade-up.delay-1 { animation-delay: .1s; }
        .fade-up.delay-2 { animation-delay: .2s; }
        .fade-up.delay-3 { animation-delay: .3s; }
        .fade-up.delay-4 { animation-delay: .4s; }
        @keyframes fadeUp {
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>

<!-- NAV -->
<nav>
    <a href="/" class="logo">Sport<span>Field</span></a>
    <div class="nav-links">
        <a href="#olahraga">Jenis Lapangan</a>
        <a href="#cara-kerja">Cara Kerja</a>
        <a href="#fitur">Fitur</a>
        @auth
            @if(Auth::user()->role === 'admin')
                <a href="{{ route('admin.dashboard') }}" class="btn-nav">Dashboard</a>
            @else
                <a href="{{ route('user.dashboard') }}" class="btn-nav">Dashboard</a>
            @endif
        @else
            <a href="{{ route('login') }}" class="btn-nav">Masuk / Daftar</a>
        @endauth
    </div>
</nav>

<!-- HERO -->
<section class="hero">
    <div class="hero-grid">
        <div class="hero-content">
            <div class="hero-badge fade-up">Booking Lapangan Online #1</div>
            <h1 class="fade-up delay-1">
                Main Lebih Mudah,<br>
                Booking <span class="highlight">Kapan Saja</span>
            </h1>
            <p class="hero-desc fade-up delay-2">
                Temukan dan booking lapangan olahraga favoritmu hanya dalam beberapa klik. Futsal, badminton, basket, tenis, dan banyak lagi tersedia dengan harga terbaik.
            </p>
            <div class="hero-cta fade-up delay-3">
                @auth
                    @if(Auth::user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="btn-primary">⚡ Go to Dashboard</a>
                    @else
                        <a href="{{ route('user.cari-lapangan') }}" class="btn-primary">⚡ Booking Sekarang</a>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="btn-primary">⚡ Booking Sekarang</a>
                @endauth
                <a href="#cara-kerja" class="btn-secondary">
                    Pelajari Cara Kerja →
                </a>
            </div>
        </div>

        <!-- Hero Visual Card -->
        <div class="hero-visual fade-up delay-4">
            <!-- Badge atas: Tersedia Hari Ini -->
            <div class="floating-badge badge-fire">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                    <path fill-rule="evenodd" d="M12.963 2.286a.75.75 0 0 0-1.071-.136 9.742 9.742 0 0 0-3.539 6.176 7.547 7.547 0 0 1-1.705-1.715.75.75 0 0 0-1.152-.082A9 9 0 1 0 15.68 4.534a7.46 7.46 0 0 1-2.717-2.248ZM15.75 14.25a3.75 3.75 0 1 1-7.313-1.172c.628.465 1.35.81 2.133 1a5.99 5.99 0 0 1 1.925-3.546 3.75 3.75 0 0 1 3.255 3.718Z" clip-rule="evenodd" />
                </svg>
                Tersedia Hari Ini
            </div>

            <div class="field-card">
                <div class="field-img">
                    <svg class="field-lines" viewBox="0 0 400 220" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect x="20" y="20" width="360" height="180" stroke="white" stroke-width="2"/>
                        <circle cx="200" cy="110" r="40" stroke="white" stroke-width="2"/>
                        <line x1="200" y1="20" x2="200" y2="200" stroke="white" stroke-width="2"/>
                        <rect x="20" y="65" width="60" height="90" stroke="white" stroke-width="2"/>
                        <rect x="320" y="65" width="60" height="90" stroke="white" stroke-width="2"/>
                        <rect x="20" y="85" width="30" height="50" stroke="white" stroke-width="2"/>
                        <rect x="350" y="85" width="30" height="50" stroke="white" stroke-width="2"/>
                    </svg>
                    <!-- Ikon bola futsal SVG (ganti emoji ⚽) -->
                    <span class="field-icon">
                        <svg viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="32" cy="32" r="28" fill="white" fill-opacity="0.95"/>
                            <circle cx="32" cy="32" r="28" stroke="rgba(0,0,0,0.15)" stroke-width="1.5"/>
                            <!-- pentagon center -->
                            <polygon points="32,18 40,24 37,33 27,33 24,24" fill="#1a1a1a"/>
                            <!-- surrounding hexagons partial -->
                            <polygon points="32,18 40,24 46,16 38,10 26,10 18,16 24,24" fill="none" stroke="#1a1a1a" stroke-width="1.2"/>
                            <polygon points="40,24 46,16 54,22 52,32 44,34 37,33" fill="#1a1a1a" fill-opacity="0.15" stroke="#1a1a1a" stroke-width="1"/>
                            <polygon points="24,24 27,33 20,38 12,32 12,22 18,16" fill="#1a1a1a" fill-opacity="0.15" stroke="#1a1a1a" stroke-width="1"/>
                            <polygon points="27,33 37,33 44,34 40,44 32,46 24,44 20,38" fill="none" stroke="#1a1a1a" stroke-width="1"/>
                            <polygon points="40,44 44,34 52,32 56,42 48,52 38,52" fill="#1a1a1a" fill-opacity="0.12" stroke="#1a1a1a" stroke-width="1"/>
                            <polygon points="24,44 20,38 12,32 8,42 16,52 26,52" fill="#1a1a1a" fill-opacity="0.12" stroke="#1a1a1a" stroke-width="1"/>
                        </svg>
                    </span>
                </div>
                <div class="field-info">
                    <h3>Lapangan Futsal A</h3>
                    <p>Tersedia · Jam 08.00 – 22.00</p>
                    <div class="price">Rp 75.000 / jam</div>
                </div>
            </div>

            <!-- Badge bawah: Booking Dikonfirmasi -->
            <div class="floating-badge badge-confirm">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                    <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12Zm13.36-1.814a.75.75 0 1 0-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 0 0-1.06 1.06l2.25 2.25a.75.75 0 0 0 1.14-.094l3.75-5.25Z" clip-rule="evenodd" />
                </svg>
                Booking Dikonfirmasi
            </div>
        </div>
    </div>
</section>

<!-- STATS -->
<div class="stats-section">
    <div class="stats-inner">
        <div>
            <div class="stat-num">500+</div>
            <div class="stat-label">Booking Berhasil</div>
        </div>
        <div>
            <div class="stat-num">20+</div>
            <div class="stat-label">Lapangan Aktif</div>
        </div>
        <div>
            <div class="stat-num">6</div>
            <div class="stat-label">Jenis Olahraga</div>
        </div>
        <div>
            <div class="stat-num">4.9★</div>
            <div class="stat-label">Rating Kepuasan</div>
        </div>
    </div>
</div>

<!-- SPORTS CATEGORIES -->
<section id="olahraga">
    <div class="section">
        <div class="section-label">Pilihan Olahraga</div>
        <h2 class="section-title">Berbagai Jenis Lapangan</h2>
        <p class="section-desc">Temukan lapangan yang cocok untuk semua jenis olahraga favoritmu.</p>
        <div class="sports-grid">
            @php
            $sportIcons = [
                'futsal' => '<svg viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="24" cy="24" r="20" fill="white" fill-opacity="0.12" stroke="#4ade80" stroke-width="1.5"/><circle cx="24" cy="24" r="20" fill="none" stroke="rgba(74,222,128,0.3)" stroke-width="1"/><polygon points="24,12 30,17 28,24 20,24 18,17" fill="#4ade80"/><polygon points="30,17 36,13 40,20 37,27 28,24" fill="rgba(74,222,128,0.4)" stroke="#4ade80" stroke-width="0.8"/><polygon points="18,17 12,13 8,20 11,27 20,24" fill="rgba(74,222,128,0.4)" stroke="#4ade80" stroke-width="0.8"/><polygon points="20,24 28,24 30,31 24,35 18,31" fill="rgba(74,222,128,0.3)" stroke="#4ade80" stroke-width="0.8"/></svg>',
                'basket' => '<svg viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="24" cy="24" r="20" fill="none" stroke="#4ade80" stroke-width="1.5"/><path d="M4 24h40" stroke="#4ade80" stroke-width="1.5"/><path d="M24 4v40" stroke="#4ade80" stroke-width="1.5"/><path d="M8 10 Q24 24 8 38" stroke="#4ade80" stroke-width="1.5" fill="none"/><path d="M40 10 Q24 24 40 38" stroke="#4ade80" stroke-width="1.5" fill="none"/></svg>',
                'badminton' => '<svg viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg"><line x1="10" y1="38" x2="32" y2="16" stroke="#4ade80" stroke-width="2" stroke-linecap="round"/><ellipse cx="35" cy="13" rx="9" ry="6" transform="rotate(-45 35 13)" fill="rgba(74,222,128,0.15)" stroke="#4ade80" stroke-width="1.5"/><line x1="28" y1="20" x2="42" y2="7" stroke="#4ade80" stroke-width="1" stroke-dasharray="2,2"/><line x1="31" y1="23" x2="45" y2="10" stroke="#4ade80" stroke-width="1" stroke-dasharray="2,2"/><circle cx="12" cy="36" r="3" fill="#4ade80" fill-opacity="0.3" stroke="#4ade80" stroke-width="1.5"/></svg>',
                'mini soccer' => '<svg viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="24" cy="24" r="20" fill="white" fill-opacity="0.12" stroke="#4ade80" stroke-width="1.5"/><polygon points="24,12 30,17 28,24 20,24 18,17" fill="#4ade80"/><polygon points="30,17 36,13 40,20 37,27 28,24" fill="rgba(74,222,128,0.4)" stroke="#4ade80" stroke-width="0.8"/><polygon points="18,17 12,13 8,20 11,27 20,24" fill="rgba(74,222,128,0.4)" stroke="#4ade80" stroke-width="0.8"/><polygon points="20,24 28,24 30,31 24,35 18,31" fill="rgba(74,222,128,0.3)" stroke="#4ade80" stroke-width="0.8"/></svg>',
                'voli' => '<svg viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="24" cy="24" r="20" fill="none" stroke="#4ade80" stroke-width="1.5"/><path d="M4 24h40" stroke="#4ade80" stroke-width="1.5"/><path d="M8 14 Q20 20 16 34" stroke="#4ade80" stroke-width="1.5" fill="none"/><path d="M40 14 Q28 20 32 34" stroke="#4ade80" stroke-width="1.5" fill="none"/><path d="M16 8 Q24 18 32 8" stroke="#4ade80" stroke-width="1.5" fill="none"/></svg>',
                'tenis' => '<svg viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="24" cy="24" r="20" fill="none" stroke="#4ade80" stroke-width="1.5"/><path d="M8 10 Q24 24 8 38" stroke="#4ade80" stroke-width="1.5" fill="none"/><path d="M40 10 Q24 24 40 38" stroke="#4ade80" stroke-width="1.5" fill="none"/></svg>',
                'default' => '<svg viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg"><rect x="6" y="10" width="36" height="28" rx="4" stroke="#4ade80" stroke-width="1.5"/><line x1="24" y1="10" x2="24" y2="38" stroke="#4ade80" stroke-width="1.5"/><circle cx="24" cy="24" r="6" stroke="#4ade80" stroke-width="1.5"/><rect x="6" y="16" width="8" height="16" stroke="#4ade80" stroke-width="1" rx="1"/><rect x="34" y="16" width="8" height="16" stroke="#4ade80" stroke-width="1" rx="1"/></svg>',
            ];
            @endphp

            @forelse ($jenisLapangans as $jenis)
            @php
                $key = strtolower(trim($jenis->nama_jenis));
                $icon = $sportIcons[$key] ?? $sportIcons['default'];
                $count = $jenis->lapangan_count;
            @endphp
            <div class="sport-card">
                <span class="sport-svg-icon">{!! $icon !!}</span>
                <div class="sport-name">{{ $jenis->nama_jenis }}</div>
                <div class="sport-count">
                    {{ $count > 0 ? $count . ' lapangan tersedia' : 'Belum ada lapangan' }}
                </div>
            </div>
            @empty
            <div class="sport-card" style="grid-column: 1/-1; text-align:center; opacity:0.5;">
                <div class="sport-name">Belum ada jenis lapangan</div>
            </div>
            @endforelse
        </div>
    </div>
</section>

<!-- HOW IT WORKS -->
<section id="cara-kerja" class="how-section">
    <div class="how-inner">
        <div class="section-label">Cara Kerja</div>
        <h2 class="section-title">Booking dalam 4 Langkah Mudah</h2>
        <p class="section-desc">Proses yang simpel agar kamu bisa langsung fokus bermain.</p>
        <div class="steps-grid">
            <div class="step">
                <div class="step-num">1</div>
                <h4>Daftar Akun</h4>
                <p>Buat akun gratis hanya dengan email dan password dalam hitungan detik.</p>
            </div>
            <div class="step">
                <div class="step-num">2</div>
                <h4>Pilih Lapangan</h4>
                <p>Cari lapangan berdasarkan jenis olahraga dan ketersediaan jadwal.</p>
            </div>
            <div class="step">
                <div class="step-num">3</div>
                <h4>Pilih Waktu</h4>
                <p>Tentukan tanggal dan jam bermain sesuai kebutuhan timmu.</p>
            </div>
            <div class="step">
                <div class="step-num">4</div>
                <h4>Konfirmasi & Main!</h4>
                <p>Tunggu konfirmasi admin, lalu datang dan nikmati pertandingan.</p>
            </div>
        </div>
    </div>
</section>

<!-- FEATURES -->
<section id="fitur">
    <div class="section">
        <div class="section-label">Fitur Unggulan</div>
        <h2 class="section-title">Semua yang Kamu Butuhkan</h2>
        <p class="section-desc">Platform kami dirancang untuk kenyamanan pemesan dan kemudahan pengelolaan admin.</p>
        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon">📅</div>
                <div class="feature-text">
                    <h4>Cek Ketersediaan Real-time</h4>
                    <p>Lihat slot waktu yang tersedia secara langsung tanpa perlu menghubungi admin terlebih dahulu.</p>
                </div>
            </div>
            <div class="feature-card">
                <div class="feature-icon">✅</div>
                <div class="feature-text">
                    <h4>Konfirmasi Cepat</h4>
                    <p>Admin memproses dan mengkonfirmasi booking kamu dengan cepat langsung dari dashboard.</p>
                </div>
            </div>
            <div class="feature-card">
                <div class="feature-icon">📊</div>
                <div class="feature-text">
                    <h4>Riwayat Booking Lengkap</h4>
                    <p>Pantau semua booking kamu – yang pending, dikonfirmasi, hingga selesai dalam satu halaman.</p>
                </div>
            </div>
            <div class="feature-card">
                <div class="feature-icon">🔒</div>
                <div class="feature-text">
                    <h4>Akun Aman & Terpercaya</h4>
                    <p>Data akun kamu dilindungi dengan enkripsi standar industri. Privasi adalah prioritas kami.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- TESTIMONIALS -->
<section class="testi-section">
    <div class="testi-inner">
        <div class="section-label">Testimoni</div>
        <h2 class="section-title">Kata Mereka yang Sudah Booking</h2>
        <div class="testi-grid">
            <div class="testi-card">
                <div class="testi-stars">★★★★★</div>
                <p class="testi-text">"Booking jadi super gampang! Dulu harus WA admin dulu, sekarang langsung pilih jam dan selesai. Lapangan futsalnya juga bersih banget."</p>
                <div class="testi-author">
                    <div class="testi-avatar">RD</div>
                    <div>
                        <div class="testi-name">Rudi Darmawan</div>
                        <div class="testi-role">Pemain Futsal Rutin</div>
                    </div>
                </div>
            </div>
            <div class="testi-card">
                <div class="testi-stars">★★★★★</div>
                <p class="testi-text">"Sebagai kapten tim badminton, saya sangat terbantu karena bisa lihat slot langsung. Tidak ada lagi double booking seperti dulu."</p>
                <div class="testi-author">
                    <div class="testi-avatar">SN</div>
                    <div>
                        <div class="testi-name">Siti Nurhaliza</div>
                        <div class="testi-role">Atlet Badminton</div>
                    </div>
                </div>
            </div>
            <div class="testi-card">
                <div class="testi-stars">★★★★☆</div>
                <p class="testi-text">"Aplikasinya simpel dan mudah dipakai. Riwayat booking jelas, harga transparan. Pokoknya recommended buat yang suka olahraga."</p>
                <div class="testi-author">
                    <div class="testi-avatar">AF</div>
                    <div>
                        <div class="testi-name">Andi Firmansyah</div>
                        <div class="testi-role">Pengguna Setia</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA -->
<section class="cta-section">
    <div class="cta-inner">
        <div class="cta-box">
            <div class="cta-text">
                <h2>Siap untuk Bermain? 🏆</h2>
                <p>Daftar gratis sekarang dan booking lapangan pertamamu dalam menit.</p>
            </div>
            @auth
                @if(Auth::user()->role === 'admin')
                    <a href="{{ route('admin.dashboard') }}" class="btn-white">Go to Dashboard →</a>
                @else
                    <a href="{{ route('user.cari-lapangan') }}" class="btn-white">Booking Sekarang →</a>
                @endif
            @else
                <a href="{{ route('register') }}" class="btn-white">Mulai Gratis →</a>
            @endauth
        </div>
    </div>
</section>

<!-- FOOTER -->
<footer>
    <div class="footer-inner">
        <div>
            <a href="/" class="logo">Sport<span>Field</span></a>
            <p class="footer-copy" style="margin-top:8px;">© {{ date('Y') }} SportField. All rights reserved.</p>
        </div>
        <div class="footer-links">
            <a href="{{ route('login') }}">Login</a>
            <a href="{{ route('register') }}">Daftar</a>
        </div>
    </div>
</footer>

</body>
</html>