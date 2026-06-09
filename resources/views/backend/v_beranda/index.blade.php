@extends('backend.v_layouts.app')

@section('content')
    <!-- contentAwal -->

    <style>
        /* ── Hero Banner ── */
        .hero-banner {
            background: linear-gradient(135deg, var(--c-surface) 0%, var(--c-surface2) 70%, #1A2E3E 100%);
            border: 1px solid var(--c-border);
            border-left: 4px solid var(--c-red);
            border-radius: var(--radius);
            padding: 2rem 2rem 1.75rem;
            position: relative;
            overflow: hidden;
            margin-bottom: 1.25rem;
        }

        .hero-banner::after {
            content: '⚙';
            position: absolute;
            right: -10px;
            top: -20px;
            font-size: 180px;
            opacity: .03;
            line-height: 1;
            pointer-events: none;
            user-select: none;
        }

        .hero-eyebrow {
            font-family: var(--font-d);
            font-size: .72rem;
            letter-spacing: .2em;
            text-transform: uppercase;
            color: var(--c-orange);
            margin-bottom: .6rem;
        }

        .hero-greeting {
            display: flex;
            align-items: center;
            gap: .75rem;
            margin-bottom: .9rem;
        }

        .hero-avatar {
            width: 46px;
            height: 46px;
            border-radius: 10px;
            background: linear-gradient(135deg, var(--c-red), var(--c-orange));
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: var(--font-d);
            font-weight: 800;
            font-size: 1.3rem;
            color: #fff;
            flex-shrink: 0;
        }

        .hero-name {
            font-family: var(--font-d);
            font-size: 1.4rem;
            font-weight: 700;
            color: var(--c-white);
            line-height: 1.1;
        }

        .hero-date {
            font-size: .76rem;
            color: var(--c-muted);
            margin-top: .15rem;
        }

        .hero-title {
            font-family: var(--font-d);
            font-size: 1.9rem;
            font-weight: 800;
            color: var(--c-white);
            letter-spacing: .04em;
            margin: 0 0 .4rem;
            line-height: 1.15;
        }

        .hero-title span {
            color: var(--c-red);
        }

        .hero-sub {
            font-size: .87rem;
            color: var(--c-muted);
            margin-bottom: 1.25rem;
            max-width: 480px;
        }

        .role-badge {
            display: inline-flex;
            align-items: center;
            gap: .45rem;
            background: rgba(255, 255, 255, .06);
            border: 1px solid var(--c-border);
            border-radius: 999px;
            padding: .3rem .85rem;
            font-size: .78rem;
            color: var(--c-text);
            font-family: var(--font-b);
            font-weight: 500;
        }

        .role-badge .dot {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: var(--c-green);
            box-shadow: 0 0 0 3px rgba(39, 174, 96, .25);
        }

        /* ── Stat Grid ── */
        .stat-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(195px, 1fr));
            gap: 1rem;
            margin-bottom: 1.25rem;
        }

        .stat-card {
            background: var(--c-surface);
            border: 1px solid var(--c-border);
            border-radius: var(--radius);
            padding: 1.2rem 1.3rem;
            position: relative;
            overflow: hidden;
            transition: transform .2s, border-color .2s;
        }

        .stat-card:hover {
            transform: translateY(-3px);
            border-color: rgba(255, 255, 255, .14);
        }

        .sc-icon {
            width: 40px;
            height: 40px;
            border-radius: 9px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
            margin-bottom: .85rem;
        }

        .sc-label {
            font-family: var(--font-d);
            font-size: .68rem;
            text-transform: uppercase;
            letter-spacing: .13em;
            color: var(--c-muted);
            margin-bottom: .2rem;
        }

        .sc-value {
            font-family: var(--font-d);
            font-size: 1.7rem;
            font-weight: 800;
            color: var(--c-white);
            line-height: 1;
        }

        .sc-sub {
            font-size: .73rem;
            color: var(--c-green);
            margin-top: .3rem;
        }

        .sc-sub.warn {
            color: var(--c-orange);
        }

        .sc-sub.down {
            color: var(--c-red);
        }

        .sc-bar {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 3px;
            border-radius: 0 0 var(--radius) var(--radius);
        }

        .ic-red {
            background: rgba(217, 43, 43, .15);
            color: var(--c-red);
        }

        .ic-orange {
            background: rgba(240, 124, 28, .15);
            color: var(--c-orange);
        }

        .ic-green {
            background: rgba(39, 174, 96, .15);
            color: var(--c-green);
        }

        .ic-blue {
            background: rgba(46, 134, 222, .15);
            color: var(--c-blue);
        }

        .bar-red {
            background: linear-gradient(90deg, var(--c-red), var(--c-red-dk));
        }

        .bar-orange {
            background: linear-gradient(90deg, var(--c-orange), #c25e0c);
        }

        .bar-green {
            background: linear-gradient(90deg, var(--c-green), #1a7a43);
        }

        .bar-blue {
            background: linear-gradient(90deg, var(--c-blue), #1a5fa3);
        }

        /* ── Info Row ── */
        .info-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }

        @media (max-width: 768px) {
            .info-row {
                grid-template-columns: 1fr;
            }
        }

        .info-card {
            background: var(--c-surface);
            border: 1px solid var(--c-border);
            border-radius: var(--radius);
            padding: 1.3rem;
        }

        .info-card-title {
            font-family: var(--font-d);
            font-size: .95rem;
            font-weight: 700;
            letter-spacing: .08em;
            text-transform: uppercase;
            color: var(--c-white);
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: .5rem;
        }

        .badge-pill {
            background: rgba(217, 43, 43, .2);
            color: var(--c-red);
            font-size: .6rem;
            padding: .15rem .5rem;
            border-radius: 999px;
            letter-spacing: .08em;
            font-weight: 700;
        }

        /* Quick links */
        .quick-links {
            display: flex;
            flex-direction: column;
            gap: .55rem;
        }

        .quick-link-item {
            display: flex;
            align-items: center;
            gap: .7rem;
            background: rgba(255, 255, 255, .03);
            border: 1px solid var(--c-border);
            border-radius: 9px;
            padding: .65rem .95rem;
            text-decoration: none;
            color: var(--c-text);
            font-size: .84rem;
            font-family: var(--font-b);
            transition: background .18s, border-color .18s, color .18s;
        }

        .quick-link-item:hover {
            background: rgba(217, 43, 43, .1);
            border-color: rgba(217, 43, 43, .3);
            color: var(--c-white);
            text-decoration: none;
        }

        .ql-icon {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: .95rem;
            flex-shrink: 0;
        }

        .ql-arrow {
            margin-left: auto;
            opacity: .3;
            font-size: .8rem;
        }

        /* Activity */
        .activity-list {
            display: flex;
            flex-direction: column;
            gap: .75rem;
        }

        .activity-item {
            display: flex;
            gap: .7rem;
            align-items: flex-start;
        }

        .a-dot {
            width: 9px;
            height: 9px;
            border-radius: 50%;
            flex-shrink: 0;
            margin-top: .38rem;
        }

        .a-text {
            font-size: .82rem;
            color: var(--c-text);
            font-family: var(--font-b);
            line-height: 1.45;
        }

        .a-text strong {
            color: var(--c-white);
            font-weight: 500;
        }

        .a-time {
            font-size: .7rem;
            color: var(--c-muted);
            margin-top: .12rem;
        }

        /* Notice strip */
        .notice-strip {
            margin-top: 1.25rem;
            background: rgba(240, 124, 28, .07);
            border: 1px solid rgba(240, 124, 28, .2);
            border-left: 3px solid var(--c-orange);
            border-radius: var(--radius);
            padding: .85rem 1.1rem;
            display: flex;
            align-items: center;
            gap: .7rem;
            font-size: .82rem;
            color: var(--c-text);
            font-family: var(--font-b);
        }

        .ns-icon {
            font-size: 1rem;
            flex-shrink: 0;
        }

        .notice-strip strong {
            color: var(--c-orange);
        }
    </style>

    <div>

        {{-- ══════════════ HERO ══════════════ --}}
        <div class="hero-banner">
            <p class="hero-eyebrow">&#9881; Dashboard Manajemen — MaztechGarage</p>

            <div class="hero-greeting">
                <div class="hero-avatar">{{ strtoupper(substr(Auth::guard('admin')->user()->nama, 0, 1)) }}</div>
                <div>
                    <div class="hero-name">Selamat Datang, {{ Auth::guard('admin')->user()->nama }}</div>
                    <div class="hero-date">{{ now()->translatedFormat('l, d F Y') }}</div>
                </div>
            </div>

            <h1 class="hero-title">Toko <span>Sparepart</span> Mobil</h1>
            <p class="hero-sub">Kelola produk, stok, transaksi &amp; laporan penjualan dari satu panel terpadu.</p>

            <div class="role-badge">
                <span class="dot"></span>
                @if (Auth::guard('admin')->user()->role == 1)
                    Super Admin &mdash; Akses Penuh
                @elseif(Auth::guard('admin')->user()->role == 0)
                    Admin &mdash; Akses Terbatas
                @endif
            </div>
        </div>

        {{-- ══════════════ STAT CARDS ══════════════ --}}
        <div class="stat-grid">
            <div class="stat-card">
                <div class="sc-icon ic-red">🛒</div>
                <div class="sc-label">Pesanan Hari Ini</div>
                <div class="sc-value">{{ $pesananHariIni }}</div>
                <div class="sc-sub">Total pesanan masuk hari ini</div>
                <div class="sc-bar bar-red"></div>
            </div>
            <div class="stat-card">
                <div class="sc-icon ic-orange">⚙️</div>
                <div class="sc-label">Total Produk</div>
                <div class="sc-value">{{ $totalProduk }}</div>
                <div class="sc-sub">{{ $totalKategori }} kategori sparepart</div>
                <div class="sc-bar bar-orange"></div>
            </div>
            <div class="stat-card">
                <div class="sc-icon ic-green">💰</div>
                <div class="sc-label">Pendapatan Bulan Ini</div>
                <div class="sc-value">Rp {{ number_format($pendapatanBulanIni, 0, ',', '.') }}</div>
                <div class="sc-sub">Total pendapatan bulan {{ now()->translatedFormat('F') }}</div>
                <div class="sc-bar bar-green"></div>
            </div>
            <a href="{{ url('backend/produk?stok_menipis=1') }}" class="stat-card" style="display:block;text-decoration:none;color:inherit;">
                <div class="sc-icon ic-blue">📦</div>
                <div class="sc-label">Stok Menipis</div>
                <div class="sc-value">{{ $stokMenipis }}</div>
                <div class="sc-sub warn">&#9888; Perlu restock segera</div>
                <div class="sc-bar bar-blue"></div>
            </a>
        </div>

        {{-- ══════════════ INFO ROW ══════════════ --}}
        <div class="info-row reveal">

            {{-- Quick Links --}}
            <div class="info-card">
                <div class="info-card-title">
                    &#9889; Menu Cepat
                    <span class="badge-pill">SHORTCUT</span>
                </div>
                <div class="quick-links">
                    <a href="{{ url('backend/produk') }}" class="quick-link-item">
                        <div class="ql-icon ic-orange">🔩</div>
                        <span>Manajemen Produk Sparepart</span>
                        <span class="ql-arrow">&#8250;</span>
                    </a>
                    <a href="{{ url('backend/kategori') }}" class="quick-link-item">
                        <div class="ql-icon ic-blue">🗂️</div>
                        <span>Kategori Sparepart</span>
                        <span class="ql-arrow">&#8250;</span>
                    </a>
                    <a href="{{ url('backend/laporan/formproduk') }}" class="quick-link-item">
                        <div class="ql-icon ic-red">📊</div>
                        <span>Laporan Penjualan</span>
                        <span class="ql-arrow">&#8250;</span>
                    </a>
                    @if (Auth::guard('admin')->user()->role == 1)
                        <a href="{{ url('backend/user') }}" class="quick-link-item">
                            <div class="ql-icon ic-green">👤</div>
                            <span>Manajemen Pengguna</span>
                            <span class="ql-arrow">&#8250;</span>
                        </a>
                    @endif
                </div>
            </div>

            {{-- Activity Feed --}}
            <div class="info-card">
                <div class="info-card-title">
                    🕐 Aktivitas Terbaru
                    <span class="badge-pill">LIVE</span>
                </div>
                <div class="activity-list">
                    @forelse ($recentOrders as $ro)
                        <div class="activity-item">
                            <div class="a-dot" style="background:var(--c-green)"></div>
                            <div>
                                <div class="a-text">
                                    <strong>Pesanan #{{ str_pad($ro->id, 4, '0', STR_PAD_LEFT) }}</strong>
                                    — {{ $ro->customer->user->nama ?? 'Pelanggan' }}
                                    ({{ $ro->status }})
                                </div>
                                <div class="a-time">{{ $ro->created_at->diffForHumans() }}</div>
                            </div>
                        </div>
                    @empty
                        <div class="activity-item">
                            <div class="a-text" style="color:var(--c-muted)">Belum ada aktivitas terbaru.</div>
                        </div>
                    @endforelse
                </div>
            </div>

        </div>

        {{-- ══════════════ NOTICE ══════════════ --}}
        <div class="notice-strip reveal anm-d4">
            <span class="ns-icon">🚗</span>
            <span>
                <strong>Tips:</strong>
                Gunakan fitur <strong>Laporan Penjualan</strong> untuk memantau performa toko &amp; tren produk sparepart
                terlaris setiap harinya.
            </span>
        </div>

    </div>
    <!-- contentAkhir -->
@endsection
