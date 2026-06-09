<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan Pesanan Selesai</title>
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
            padding: 30px 20px 60px;
        }

        /* --- Tombol cetak --- */
        .print-btn {
            max-width: 860px;
            margin: 0 auto 16px;
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
            background: #C8102E;
            color: #fff;
        }

        .print-btn button:first-child:hover {
            background: #9A0C23;
        }

        .print-btn button:last-child {
            background: #ddd;
            color: #444;
        }

        /* --- Wrapper card --- */
        .wrapper {
            max-width: 860px;
            margin: 0 auto;
            background: #fff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 16px rgba(0, 0, 0, 0.1);
        }

        /* --- Header (h2 + h4) --- */
        .wrapper h2 {
            background: #1a1a1a;
            border-bottom: 4px solid #C8102E;
            color: #fff;
            text-align: center;
            padding: 18px 20px 10px;
            font-size: 20px;
            letter-spacing: 2px;
            margin: 0;
        }

        .wrapper h2+h4 {
            background: #1a1a1a;
            color: #aaa;
            text-align: center;
            padding: 0 20px 6px;
            font-size: 13px;
            font-weight: normal;
            margin: 0;
        }

        .wrapper h2+h4+h4 {
            background: #1a1a1a;
            color: #888;
            text-align: center;
            padding: 0 20px 16px;
            font-size: 12px;
            font-weight: normal;
            margin: 0;
            border-bottom: 1px solid #333;
        }

        /* --- Table --- */
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 0;
        }

        thead tr {
            background: #1a1a1a;
        }

        thead th {
            padding: 10px 10px;
            color: #aaa;
            font-size: 10px;
            letter-spacing: 1px;
            text-transform: uppercase;
            font-weight: normal;
            border: none;
        }

        thead th {
            text-align: center;
        }

        tbody tr {
            border-bottom: 1px solid #f0f0f0;
        }

        tbody tr:hover {
            background: #fafafa;
        }

        tbody td {
            border: none;
            border-bottom: 1px solid #f0f0f0;
            padding: 10px;
            color: #444;
            vertical-align: middle;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
            font-weight: 600;
            color: #222;
        }

        .text-left {
            text-align: left;
        }

        /* ID Order */
        tbody td:nth-child(2) {
            color: #C8102E;
            font-weight: bold;
            text-align: center;
        }

        /* Total row */
        tfoot tr td {
            background: #f8f8f8;
            border-top: 2px solid #C8102E;
            font-weight: bold;
            padding: 10px;
            border-bottom: none;
        }

        tfoot tr td:last-child {
            color: #C8102E;
            font-size: 15px;
            font-weight: 900;
            text-align: right;
        }

        /* Print timestamp */
        .timestamp {
            padding: 12px 20px;
            text-align: right;
            font-size: 11px;
            color: #aaa;
            border-top: 1px solid #eee;
            background: #f9f9f9;
        }

        /* --- Print --- */
        @media print {
            body {
                background: #fff;
                padding: 0;
            }

            .print-btn {
                display: none;
            }

            .wrapper {
                box-shadow: none;
                border-radius: 0;
            }

            .wrapper h2,
            .wrapper h2+h4,
            .wrapper h2+h4+h4,
            thead tr {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
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

    <div class="wrapper">

        <h2>MaztechGarage</h2>
        <h4>Laporan Pesanan Selesai</h4>
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
                    <th>No Resi</th>
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
                        <td class="text-right">Rp.
                            {{ number_format($row->total_harga + $row->biaya_ongkir, 0, ',', '.') }}</td>
                        <td class="text-center">{{ strtoupper($row->kurir ?? '-') }}</td>
                        <td class="text-center">{{ $row->noresi ?? '-' }}</td>
                        <td class="text-center">{{ $row->created_at->format('d/m/Y') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10" class="text-center" style="padding:32px;color:#aaa;">
                            Tidak ada data pesanan selesai.
                        </td>
                    </tr>
                @endforelse
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="6"
                        style="text-align:left;font-size:12px;letter-spacing:1px;text-transform:uppercase;">
                        Total Pendapatan
                    </td>
                    <td>Rp. {{ number_format($cetak->sum(fn($r) => $r->total_harga + $r->biaya_ongkir), 0, ',', '.') }}
                    </td>
                    <td colspan="3"></td>
                </tr>
            </tfoot>
        </table>

        <div class="timestamp">
            Dicetak pada: {{ now()->format('d/m/Y H:i') }}
        </div>

    </div>

</body>

</html>
