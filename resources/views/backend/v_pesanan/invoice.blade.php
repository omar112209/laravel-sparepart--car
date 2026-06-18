<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Invoice #{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }} — MazdaParts</title>

    <link
        href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@400;600;700;800&family=Barlow:wght@300;400;500;600&family=Roboto+Mono:wght@400;500&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('frontend/css/font-awesome.min.css') }}">

    <style>
        /* ── RESET ── */
        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        :root {
            --red: #c8102e;
            --red-dark: #a00d25;
            --dark: #f5f5f0;
            --dark2: #ffffff;
            --dark3: #fafaf7;
            --steel: #eeeeea;
            --border: rgba(0, 0, 0, 0.08);
            --text: #1e1e1e;
            --text2: #555555;
            --text3: #888888;
            --accent: #c8102e;
            --font-disp: 'Barlow Condensed', sans-serif;
            --font-body: 'Barlow', sans-serif;
            --font-mono: 'Roboto Mono', monospace;
        }

        body {
            background: #e8e8e3;
            color: var(--text);
            font-family: var(--font-body);
            font-size: 13px;
            line-height: 1.6;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 32px 16px 60px;
        }

        /* ── INVOICE WRAPPER ── */
        .invoice-wrap {
            width: 100%;
            max-width: 820px;
            background: var(--dark2);
            border: 1px solid var(--border);
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 8px 40px rgba(0, 0, 0, 0.1);
        }

        /* ── HEADER BAND ── */
        .inv-header {
            background: var(--dark3);
            border-bottom: 3px solid var(--red);
            padding: 32px 40px;
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 24px;
            position: relative;
            overflow: hidden;
        }

        .inv-header::before {
            content: 'INVOICE';
            position: absolute;
            right: -10px;
            top: 50%;
            transform: translateY(-50%);
            font-family: var(--font-disp);
            font-size: 120px;
            font-weight: 800;
            color: rgba(0, 0, 0, 0.03);
            letter-spacing: 8px;
            pointer-events: none;
            user-select: none;
        }

        /* Logo */
        .inv-logo-name {
            font-family: var(--font-disp);
            font-size: 32px;
            font-weight: 800;
            letter-spacing: 4px;
            color: var(--text);
            line-height: 1;
        }

        .inv-logo-name span {
            color: var(--red);
        }

        .inv-logo-sub {
            font-family: var(--font-mono);
            font-size: 9px;
            letter-spacing: 3px;
            color: var(--text3);
            text-transform: uppercase;
            margin-top: 4px;
        }

        .inv-store-address {
            margin-top: 14px;
            font-size: 12px;
            color: var(--text3);
            line-height: 1.7;
        }

        .inv-store-address a {
            color: var(--text2);
        }

        /* Invoice meta */
        .inv-meta {
            text-align: right;
        }

        .inv-meta-title {
            font-family: var(--font-disp);
            font-size: 42px;
            font-weight: 800;
            letter-spacing: 4px;
            color: var(--text);
            text-transform: uppercase;
            line-height: 1;
            margin-bottom: 12px;
        }

        .inv-meta-table {
            margin-left: auto;
        }

        .inv-meta-row {
            display: flex;
            gap: 16px;
            justify-content: flex-end;
            margin-bottom: 4px;
        }

        .inv-meta-label {
            font-family: var(--font-mono);
            font-size: 10px;
            letter-spacing: 1.5px;
            color: var(--text3);
            text-transform: uppercase;
            white-space: nowrap;
        }

        .inv-meta-val {
            font-family: var(--font-mono);
            font-size: 11px;
            color: var(--text2);
            white-space: nowrap;
        }

        .inv-meta-val.highlight {
            color: var(--red);
            font-weight: 500;
        }

        /* Status pill */
        .inv-status {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 5px 14px;
            border-radius: 20px;
            font-family: var(--font-mono);
            font-size: 10px;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            margin-top: 10px;
            border: 1px solid;
        }

        .inv-status::before {
            content: '';
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: currentColor;
        }

        .status-diproses {
            background: rgba(59, 130, 246, 0.12);
            color: #60a5fa;
            border-color: rgba(59, 130, 246, 0.3);
        }

        .status-kirim {
            background: rgba(234, 179, 8, 0.12);
            color: #facc15;
            border-color: rgba(234, 179, 8, 0.3);
        }

        .status-selesai {
            background: rgba(34, 197, 94, 0.12);
            color: #4ade80;
            border-color: rgba(34, 197, 94, 0.3);
        }

        .status-unpaid {
            background: rgba(200, 16, 46, 0.15);
            color: #f87171;
            border-color: rgba(200, 16, 46, 0.4);
        }

        .status-default {
            background: rgba(255, 255, 255, 0.05);
            color: var(--text3);
            border-color: var(--border);
        }

        /* ── BODY ── */
        .inv-body {
            padding: 36px 40px;
        }

        /* Bill To / Ship To grid */
        .inv-address-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 24px;
            margin-bottom: 32px;
        }

        .inv-address-block {}

        .inv-block-label {
            font-family: var(--font-mono);
            font-size: 9px;
            letter-spacing: 2.5px;
            color: var(--red);
            text-transform: uppercase;
            margin-bottom: 10px;
            padding-bottom: 6px;
            border-bottom: 1px solid var(--border);
        }

        .inv-block-name {
            font-family: var(--font-disp);
            font-size: 16px;
            font-weight: 700;
            letter-spacing: 1px;
            color: var(--text);
            margin-bottom: 4px;
        }

        .inv-block-detail {
            font-size: 12px;
            color: var(--text2);
            line-height: 1.7;
        }

        /* ── ITEMS TABLE ── */
        .inv-table-label {
            font-family: var(--font-mono);
            font-size: 9px;
            letter-spacing: 2.5px;
            color: var(--red);
            text-transform: uppercase;
            margin-bottom: 10px;
        }

        .inv-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 28px;
        }

        .inv-table thead tr {
            background: var(--steel);
            border-top: 1px solid var(--border);
            border-bottom: 1px solid var(--border);
        }

        .inv-table thead th {
            padding: 10px 14px;
            font-family: var(--font-mono);
            font-size: 9px;
            letter-spacing: 2px;
            color: var(--text3);
            text-transform: uppercase;
            font-weight: 400;
            text-align: left;
        }

        .inv-table thead th:last-child {
            text-align: right;
        }

        .inv-table thead th.center {
            text-align: center;
        }

        .inv-table tbody tr {
            border-bottom: 1px solid var(--border);
            transition: background 0.15s;
        }

        .inv-table tbody tr:hover {
            background: rgba(0, 0, 0, 0.02);
        }

        .inv-table tbody td {
            padding: 14px;
            vertical-align: middle;
            font-size: 13px;
            color: var(--text2);
        }

        .inv-table tbody td:last-child {
            text-align: right;
            font-family: var(--font-mono);
            color: var(--text);
            font-size: 13px;
        }

        .inv-table tbody td.center {
            text-align: center;
        }

        /* Product cell */
        .item-product {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .item-img {
            width: 48px;
            height: 48px;
            border-radius: 6px;
            object-fit: cover;
            border: 1px solid var(--border);
            background: #f0f0eb;
        }

        .item-name {
            font-size: 13px;
            font-weight: 500;
            color: var(--text);
        }

        .item-sku {
            font-family: var(--font-mono);
            font-size: 10px;
            color: var(--text3);
            margin-top: 2px;
        }

        .item-qty {
            background: #f0f0eb;
            border: 1px solid var(--border);
            border-radius: 4px;
            padding: 3px 10px;
            font-family: var(--font-mono);
            font-size: 12px;
            color: var(--text2);
            display: inline-block;
        }

        /* ── TOTALS SECTION ── */
        .inv-totals-wrap {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 32px;
        }

        .inv-totals {
            width: 300px;
        }

        .totals-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 8px 0;
            border-bottom: 1px solid var(--border);
            font-size: 12px;
        }

        .totals-row:last-child {
            border-bottom: none;
        }

        .totals-label {
            color: var(--text2);
        }

        .totals-val {
            font-family: var(--font-mono);
            font-size: 13px;
            color: var(--text);
        }

        .totals-row.grand {
            background: var(--steel);
            margin: 8px -16px 0;
            padding: 12px 16px;
            border-radius: 6px;
            border: 1px solid var(--border-red, rgba(200, 16, 46, 0.3));
        }

        .totals-row.grand .totals-label {
            font-family: var(--font-disp);
            font-size: 15px;
            font-weight: 700;
            letter-spacing: 1px;
            text-transform: uppercase;
            color: var(--text);
        }

        .totals-row.grand .totals-val {
            font-family: var(--font-disp);
            font-size: 24px;
            font-weight: 800;
            color: var(--red);
            letter-spacing: 0.5px;
        }

        /* ── SHIPPING INFO ── */
        .inv-shipping {
            background: #fafaf7;
            border: 1px solid var(--border);
            border-radius: 10px;
            padding: 20px 24px;
            margin-bottom: 32px;
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
        }

        .inv-ship-item {}

        .inv-ship-item-label {
            font-family: var(--font-mono);
            font-size: 9px;
            letter-spacing: 2px;
            color: var(--red);
            text-transform: uppercase;
            margin-bottom: 6px;
        }

        .inv-ship-item-val {
            font-size: 13px;
            font-weight: 500;
            color: var(--text);
            line-height: 1.4;
        }

        .inv-ship-item-val small {
            display: block;
            font-size: 11px;
            color: var(--text3);
            font-weight: 400;
            margin-top: 2px;
        }

        .resi-pill {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: #fef2f2;
            border: 1px solid rgba(200, 16, 46, 0.3);
            border-radius: 4px;
            padding: 4px 10px;
            font-family: var(--font-mono);
            font-size: 11px;
            color: var(--red);
            margin-top: 4px;
        }

        /* ── FOOTER BAND ── */
        .inv-footer {
            background: #fafaf7;
            border-top: 1px solid var(--border);
            padding: 24px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 24px;
        }

        .inv-footer-note {
            font-size: 11px;
            color: var(--text3);
            max-width: 360px;
            line-height: 1.6;
        }

        .inv-footer-note strong {
            color: var(--text2);
        }

        .inv-footer-thanks {
            text-align: right;
        }

        .inv-footer-thanks-label {
            font-family: var(--font-mono);
            font-size: 9px;
            letter-spacing: 2px;
            color: var(--text3);
            text-transform: uppercase;
            margin-bottom: 4px;
        }

        .inv-footer-thanks-brand {
            font-family: var(--font-disp);
            font-size: 22px;
            font-weight: 800;
            letter-spacing: 3px;
            color: var(--text);
        }

        .inv-footer-thanks-brand span {
            color: var(--red);
        }

        /* ── PRINT TOOLBAR (hidden on print) ── */
        .print-toolbar {
            width: 100%;
            max-width: 820px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .print-back {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: #ffffff;
            border: 1px solid var(--border);
            color: var(--text2);
            padding: 9px 18px;
            border-radius: 6px;
            font-family: var(--font-disp);
            font-size: 13px;
            font-weight: 700;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.2s;
        }

        .print-back:hover {
            background: var(--steel);
            color: var(--text);
        }

        .print-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: var(--red);
            color: #fff;
            border: none;
            padding: 10px 24px;
            border-radius: 6px;
            font-family: var(--font-disp);
            font-size: 14px;
            font-weight: 700;
            letter-spacing: 2px;
            text-transform: uppercase;
            cursor: pointer;
            transition: background 0.2s;
        }

        .print-btn:hover {
            background: var(--red-dark, #DC2626);
        }

        /* ── PRINT MEDIA ── */
        @media print {
            body {
                background: #fff !important;
                color: #111 !important;
                padding: 0 !important;
            }

            .print-toolbar {
                display: none !important;
            }

            .invoice-wrap {
                border-radius: 0 !important;
                border: none !important;
                box-shadow: none !important;
                max-width: 100% !important;
            }

            .inv-header {
                background: #f4f4f4 !important;
                border-bottom: 3px solid #EF4444 !important;
            }

            .inv-header::before {
                display: none;
            }

            .inv-logo-name {
                color: #111 !important;
            }

            .inv-logo-name span {
                color: #EF4444 !important;
            }

            .inv-logo-sub,
            .inv-store-address,
            .inv-block-detail,
            .inv-meta-label,
            .inv-meta-val,
            .inv-table thead th,
            .inv-table tbody td,
            .totals-label,
            .totals-val,
            .inv-footer-note,
            .inv-ship-item-val {
                color: #333 !important;
            }

            .inv-meta-title,
            .inv-block-name,
            .item-name,
            .inv-footer-thanks-brand {
                color: #111 !important;
            }

            .inv-meta-val.highlight,
            .inv-block-label,
            .inv-ship-item-label,
            .inv-table-label {
                color: #EF4444 !important;
            }

            .inv-table thead tr {
                background: #f0f0f0 !important;
            }

            .inv-table tbody tr:hover {
                background: transparent !important;
            }

            .inv-totals-wrap .totals-row.grand {
                background: #f8f8f8 !important;
            }

            .totals-row.grand .totals-val {
                color: #EF4444 !important;
            }

            .inv-shipping {
                background: #f8f8f8 !important;
                border: 1px solid #ddd !important;
            }

            .inv-footer {
                background: #f4f4f4 !important;
                border-top: 1px solid #ddd !important;
            }

            .inv-footer-thanks-brand span {
                color: #EF4444 !important;
            }

            .resi-pill {
                background: #fef2f2 !important;
                border-color: #fca5a5 !important;
                color: #333 !important;
            }

            .item-img {
                border-color: #ddd !important;
            }

            .inv-table tbody td:last-child {
                color: #111 !important;
            }
        }
    </style>
</head>

<body>

    <!-- Toolbar -->
    <div class="print-toolbar">
        <a href="{{ url()->previous() }}" class="print-back">
            <i class="fa fa-arrow-left"></i> Kembali
        </a>
        <button class="print-btn" onclick="window.print()">
            <i class="fa fa-print"></i> Cetak Invoice
        </button>
    </div>

    <!-- Invoice Card -->
    <div class="invoice-wrap">

        {{-- ── HEADER ── --}}
        <div class="inv-header">
            <div>
                <div class="inv-logo-name">MAZDA<span>PARTS</span></div>
                <div class="inv-logo-sub">Sparepart &amp; Aksesori Resmi</div>
                <div class="inv-store-address">
                    Jl. Otomotif No. 1, Jakarta Selatan<br>
                    Telp: 0800-MAZDA-ID &nbsp;·&nbsp; parts@mazdastore.id<br>
                    www.mazdaparts.id
                </div>
            </div>
            <div class="inv-meta">
                <div class="inv-meta-title">Invoice</div>
                <div class="inv-meta-row">
                    <span class="inv-meta-label">No. Invoice</span>
                    <span class="inv-meta-val highlight">#{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</span>
                </div>
                <div class="inv-meta-row">
                    <span class="inv-meta-label">Tanggal</span>
                    <span class="inv-meta-val">{{ $order->created_at->format('d M Y') }}</span>
                </div>
                <div class="inv-meta-row">
                    <span class="inv-meta-label">Waktu</span>
                    <span class="inv-meta-val">{{ $order->created_at->format('H:i') }} WIB</span>
                </div>
                <div class="inv-meta-row">
                    <span class="inv-meta-label">Status</span>
                    <span class="inv-meta-val">
                        @if ($order->status == 'unpaid')
                            <span class="inv-status status-unpaid">Belum Dibayar</span>
                        @elseif ($order->status == 'paid')
                            <span class="inv-status status-diproses">Diproses</span>
                        @elseif ($order->status == 'Kirim')
                            <span class="inv-status status-kirim">Dikirim</span>
                        @elseif ($order->status == 'Selesai')
                            <span class="inv-status status-selesai">Selesai</span>
                        @else
                            <span class="inv-status status-default">{{ $order->status }}</span>
                        @endif
                    </span>
                </div>
            </div>
        </div>

        {{-- ── BODY ── --}}
        <div class="inv-body">

            {{-- Bill To / Customer --}}
            <div class="inv-address-grid">
                <div class="inv-address-block">
                    <div class="inv-block-label">// Ditagihkan Kepada</div>
                    <div class="inv-block-name">{{ $order->customer->user->nama ?? 'Pelanggan' }}</div>
                    <div class="inv-block-detail">
                        {{ $order->customer->user->email ?? '' }}<br>
                        {{ $order->customer->user->hp ?? '' }}
                    </div>
                </div>
                <div class="inv-address-block">
                    <div class="inv-block-label">// Alamat Pengiriman</div>
                    <div class="inv-block-detail">{{ $order->alamat }}</div>
                </div>
            </div>

            {{-- Items Table --}}
            <div class="inv-table-label">// Daftar Produk</div>
            <table class="inv-table">
                <thead>
                    <tr>
                        <th>Produk</th>
                        <th class="center">Qty</th>
                        <th>Harga Satuan</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($order->orderItems as $item)
                        <tr>
                            <td>
                                <div class="item-product">
                                    @if ($item->produk->foto)
                                        <img class="item-img"
                                            src="{{ asset('storage/img-produk/' . $item->produk->foto) }}"
                                            alt="{{ $item->produk->nama_produk }}"
                                            onerror="this.src='{{ asset('frontend/img/thumb-product01.jpg') }}'">
                                    @else
                                        <img class="item-img" src="{{ asset('frontend/img/thumb-product01.jpg') }}"
                                            alt="">
                                    @endif
                                    <div>
                                        <div class="item-name">{{ $item->produk->nama_produk }}</div>
                                        <div class="item-sku">SKU: {{ $item->produk->kode ?? '-' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="center">
                                <span class="item-qty">{{ $item->quantity }}</span>
                            </td>
                            <td>Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                            <td>Rp {{ number_format($item->harga * $item->quantity, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            {{-- Totals --}}
            <div class="inv-totals-wrap">
                <div class="inv-totals">
                    <div class="totals-row">
                        <span class="totals-label">Subtotal Produk</span>
                        <span class="totals-val">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</span>
                    </div>
                    <div class="totals-row">
                        <span class="totals-label">Ongkos Kirim</span>
                        <span class="totals-val">Rp {{ number_format($order->biaya_ongkir, 0, ',', '.') }}</span>
                    </div>
                    @if ($order->voucher_discount > 0)
                        <div class="totals-row" style="color:#4ade80;">
                            <span class="totals-label">Diskon Voucher ({{ $order->voucher_code }})</span>
                            <span class="totals-val">- Rp {{ number_format($order->voucher_discount, 0, ',', '.') }}</span>
                        </div>
                    @endif
                    <div class="totals-row grand">
                        <span class="totals-label">Total Bayar</span>
                        <span class="totals-val">Rp
                            {{ number_format($order->total_harga + $order->biaya_ongkir - $order->voucher_discount, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>

            {{-- Shipping Info --}}
            @if ($order->kurir && $order->alamat)
                <div class="inv-shipping">
                    <div class="inv-ship-item">
                        <div class="inv-ship-item-label">// Ekspedisi</div>
                        <div class="inv-ship-item-val">
                            {{ strtoupper($order->kurir) }}
                            <small>{{ $order->layanan_ongkir }}</small>
                        </div>
                    </div>
                    <div class="inv-ship-item">
                        <div class="inv-ship-item-label">// Estimasi Tiba</div>
                        <div class="inv-ship-item-val">
                            {{ $order->estimasi_ongkir }}
                            <small>Setelah pembayaran dikonfirmasi</small>
                        </div>
                    </div>
                    <div class="inv-ship-item">
                        <div class="inv-ship-item-label">// No. Resi</div>
                        <div class="inv-ship-item-val">
                            @if ($order->noresi)
                                <span class="resi-pill">
                                    <i class="fa fa-barcode"></i>
                                    {{ $order->noresi }}
                                </span>
                            @else
                                <small style="color: var(--text3);">Belum tersedia</small>
                            @endif
                        </div>
                    </div>
                </div>
            @else
                <div style="background:#fafaf7;border:1px solid var(--border);border-radius:10px;padding:20px 24px;margin-bottom:32px;text-align:center;">
                    <small style="color:var(--text3);">Data pengiriman belum diisi.</small>
                </div>
            @endif

        </div>{{-- /inv-body --}}

        {{-- ── FOOTER ── --}}
        <div class="inv-footer">
            <div class="inv-footer-note">
                <strong>Syarat &amp; Ketentuan:</strong><br>
                Part bergaransi sesuai ketentuan pabrik. Retur dapat dilakukan dalam 7 hari
                jika produk tidak sesuai pesanan. Simpan invoice ini sebagai bukti pembelian.
                Terima kasih telah berbelanja di MazdaParts!
            </div>
            <div class="inv-footer-thanks">
                <div class="inv-footer-thanks-label">// Powered By</div>
                <div class="inv-footer-thanks-brand">MAZDA<span>PARTS</span></div>
                <div style="font-family: var(--font-mono); font-size: 9px; color: var(--text3); margin-top: 4px;">
                    www.mazdaparts.id
                </div>
            </div>
        </div>

    </div>{{-- /invoice-wrap --}}

    <script>
        // Auto-open print dialog if ?print=1 in URL
        const params = new URLSearchParams(window.location.search);
        if (params.get('print') === '1') {
            window.onload = () => window.print();
        }
    </script>

</body>

</html>
