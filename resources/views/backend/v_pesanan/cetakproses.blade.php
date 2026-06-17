<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan Pesanan Proses</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 13px;
            background: #f5f5f5;
            padding: 24px 20px 60px;
        }

        /* Judul */
        h2,
        h4 {
            text-align: center;
            margin: 0;
        }

        /* Wrapper semua konten */
        body>h2,
        body>h4,
        body>table,
        body>br,
        body>p {
            max-width: 900px;
            margin-left: auto;
            margin-right: auto;
        }

        /* Header hitam */
        h2 {
            background: #1a1a1a;
            border-bottom: none;
            color: #fff;
            padding: 18px 20px 8px;
            font-size: 20px;
            letter-spacing: 2px;
            border-radius: 8px 8px 0 0;
            max-width: 900px;
        }

        h2+h4 {
            background: #1a1a1a;
            color: #aaa;
            padding: 4px 20px;
            font-size: 13px;
            font-weight: normal;
            max-width: 900px;
        }

        h2+h4+h4 {
            background: #1a1a1a;
            border-bottom: 4px solid #EF4444;
            color: #777;
            padding: 4px 20px 14px;
            font-size: 12px;
            font-weight: normal;
            max-width: 900px;
        }

        /* Tabel */
        table {
            width: 100%;
            max-width: 900px;
            border-collapse: collapse;
            margin: 0 auto;
            background: #fff;
            box-shadow: 0 2px 16px rgba(0, 0, 0, 0.08);
        }

        th,
        td {
            border: none;
            border-bottom: 1px solid #f0f0f0;
            padding: 10px 10px;
        }

        thead tr {
            background: #1a1a1a;
        }

        th {
            background: #1a1a1a;
            color: #aaa;
            font-size: 10px;
            letter-spacing: 1px;
            text-transform: uppercase;
            font-weight: normal;
            text-align: center;
        }

        td {
            text-align: left;
            color: #444;
            vertical-align: middle;
        }

        tbody tr:hover {
            background: #fafafa;
        }

        /* ID Order merah */
        tbody td:nth-child(2) {
            color: #EF4444;
            font-weight: bold;
            text-align: center;
        }

        .text-right {
            text-align: right;
            font-weight: 600;
            color: #222;
        }

        .text-center {
            text-align: center;
        }

        /* Timestamp */
        body>p {
            background: #fff;
            max-width: 900px;
            border-top: 1px solid #eee;
            padding: 10px 16px;
            text-align: right;
            font-size: 11px;
            color: #aaa;
            border-radius: 0 0 8px 8px;
            box-shadow: 0 2px 16px rgba(0, 0, 0, 0.08);
        }

        /* Tombol */
        .print-btn {
            max-width: 900px;
            margin: 0 auto 14px;
            display: flex;
            gap: 8px;
        }

        .print-btn button {
            padding: 8px 18px;
            border: none;
            border-radius: 4px;
            font-size: 12px;
            font-weight: bold;
            cursor: pointer;
        }

        .print-btn button:first-child {
            background: #EF4444;
            color: #fff;
        }

        .print-btn button:first-child:hover {
            background: #DC2626;
        }

        .print-btn button:last-child {
            background: #ddd;
            color: #444;
        }

        /* Print */
        @media print {
            body {
                background: #fff;
                padding: 0;
            }

            .print-btn {
                display: none;
            }

            h2 {
                border-radius: 0;
            }

            h2,
            h2+h4,
            h2+h4+h4,
            thead tr {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            table {
                box-shadow: none;
            }

            body>p {
                box-shadow: none;
            }

            @page {
                margin: 1cm;
            }
        }
    </style>
</head>

<body>

    <div class="print-btn">
        <button onclick="window.print()">🖨️ Cetak</button>
        <button onclick="window.close()">✖ Tutup</button>
    </div>

    <h2>MaztechGarage</h2>
    <h4>Laporan Pesanan Proses</h4>
    <h4>Periode:
        {{ isset($tanggalAwal) ? \Carbon\Carbon::parse($tanggalAwal)->format('d/m/Y') : '-' }}
        s/d
        {{ isset($tanggalAkhir) ? \Carbon\Carbon::parse($tanggalAkhir)->format('d/m/Y') : '-' }}
    </h4>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>ID Order</th>
                <th>Customer</th>
                <th>Produk</th>
                <th>Total Harga</th>
                <th>Ongkir</th>
                <th>Grand Total</th>
                <th>Kurir</th>
                <th>Status</th>
                <th>Pembayaran</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($cetak as $key => $row)
                <tr>
                    <td class="text-center">{{ $key + 1 }}</td>
                    <td class="text-center">#{{ $row->id }}</td>
                    <td>{{ $row->customer->nama ?? '-' }}</td>
                    <td>
                        @foreach ($row->orderItems as $item)
                            {{ $item->produk->nama_produk ?? '-' }} (x{{ $item->quantity }})<br>
                        @endforeach
                    </td>
                    <td class="text-right">Rp. {{ number_format($row->total_harga, 0, ',', '.') }}</td>
                    <td class="text-right">Rp. {{ number_format($row->biaya_ongkir, 0, ',', '.') }}</td>
                    <td class="text-right">Rp. {{ number_format($row->total_harga + $row->biaya_ongkir, 0, ',', '.') }}
                    </td>
                    <td class="text-center">{{ strtoupper($row->kurir ?? '-') }}</td>
                    <td class="text-center">{{ $row->status }}</td>
                    <td class="text-center">
                        @if ($row->status == 'unpaid')
                            <span style="color:#EF4444;font-weight:bold;">Belum Dibayar</span>
                        @else
                            <span style="color:#28a745;font-weight:bold;">Lunas</span>
                        @endif
                    </td>
                    <td class="text-center">{{ $row->created_at->format('d/m/Y') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="11" class="text-center">Tidak ada data pesanan proses.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <br>
    <p style="text-align:right;">Dicetak pada: {{ now()->format('d/m/Y H:i') }}</p>

</body>

</html>
