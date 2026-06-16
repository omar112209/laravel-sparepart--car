@extends('backend.v_layouts.app')
@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <h1 class="m-0">{{ $subJudul }}</h1>
            </div>
        </div>

        <section class="content">
            <div class="container-fluid">

                @if (session()->has('success'))
                    <div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <strong>{{ session('success') }}</strong>
                    </div>
                @endif
                @if (session()->has('error'))
                    <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <strong>{{ session('error') }}</strong>
                    </div>
                @endif

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">{{ $subJudul }}</h3>
                        <div class="card-tools">
                            <a href="{{ route('laporan.proses') }}" class="btn btn-sm btn-primary">
                                <i class="fas fa-print"></i> Cetak Laporan
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-striped table-hover" id="tabel-proses">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>ID Order</th>
                                    <th>Customer</th>
                                    <th>Total Harga</th>
                                    <th>Ongkir</th>
                                    <th>Kurir</th>
                                    <th>Status</th>
                                    <th>Pembayaran</th>
                                    <th>Tanggal</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($index as $key => $row)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>#{{ $row->id }}</td>
                                        <td>{{ $row->customer->nama ?? '-' }}</td>
                                        <td>Rp. {{ number_format($row->total_harga, 0, ',', '.') }}</td>
                                        <td>Rp. {{ number_format($row->biaya_ongkir, 0, ',', '.') }}</td>
                                        <td>{{ strtoupper($row->kurir ?? '-') }} - {{ $row->layanan_ongkir ?? '-' }}</td>
                                        <td>
                                            @if ($row->status == 'paid')
                                                <span class="badge badge-success">Paid</span>
                                            @elseif ($row->status == 'Kirim')
                                                <span class="badge badge-info">Dikirim</span>
                                            @else
                                                <span class="badge badge-secondary">{{ $row->status }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($row->status == 'unpaid')
                                                <span class="badge badge-danger">Belum Dibayar</span>
                                            @elseif ($row->status == 'cancel')
                                                <span class="badge badge-secondary">Dibatalkan</span>
                                            @else
                                                <span class="badge badge-success">Lunas</span>
                                            @endif
                                        </td>
                                        <td>{{ $row->created_at->format('d/m/Y') }}</td>
                                        <td>
                                            <a href="{{ route('pesanan.detail', $row->id) }}" class="btn btn-sm btn-info">
                                                <i class="fas fa-eye"></i> Detail
                                            </a>
                                            <a href="{{ route('pesanan.invoice', $row->id) }}"
                                                class="btn btn-sm btn-warning">
                                                <i class="fas fa-file-invoice"></i> Invoice
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="10" class="text-center">Tidak ada data pesanan.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#tabel-proses').DataTable();
        });
    </script>
@endpush
