@extends('backend.v_layouts.app')
@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{ $subJudul ?? 'Retur' }}</h1>
                </div>
            </div>
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
                    <h3 class="card-title">Daftar Pengajuan Retur</h3>
                    <div class="card-tools" style="display:flex;gap:6px;align-items:center;">
                        <a href="{{ route('retur.admin.index') }}" class="btn btn-sm btn-secondary">Semua</a>
                        <a href="{{ route('retur.admin.index') }}?status=pending" class="btn btn-sm btn-warning">Menunggu</a>
                        <a href="{{ route('retur.admin.index') }}?status=disetujui" class="btn btn-sm btn-info">Disetujui</a>
                        <a href="{{ route('retur.admin.index') }}?status=selesai" class="btn btn-sm btn-success">Selesai</a>
                        <a href="{{ route('retur.admin.index') }}?status=ditolak" class="btn btn-sm btn-danger">Ditolak</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" id="dataTable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>ID Retur</th>
                                    <th>Order</th>
                                    <th>Customer</th>
                                    <th>Produk</th>
                                    <th>Qty</th>
                                    <th>Status</th>
                                    <th>Tanggal</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($returs as $index => $retur)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>#{{ str_pad($retur->id, 4, '0', STR_PAD_LEFT) }}</td>
                                        <td>#{{ str_pad($retur->order_id, 5, '0', STR_PAD_LEFT) }}</td>
                                        <td>{{ $retur->customer->nama ?? '-' }}</td>
                                        <td>{{ $retur->produk->nama_produk ?? 'Produk telah dihapus' }}</td>
                                        <td>{{ $retur->quantity }}</td>
                                        <td>
                                            @php
                                                $badgeClass = match($retur->status) {
                                                    'pending' => 'badge-warning',
                                                    'disetujui' => 'badge-info',
                                                    'ditolak' => 'badge-danger',
                                                    'selesai' => 'badge-success',
                                                    default => 'badge-secondary'
                                                };
                                                $badgeLabel = match($retur->status) {
                                                    'pending' => 'Menunggu',
                                                    'disetujui' => 'Disetujui',
                                                    'ditolak' => 'Ditolak',
                                                    'selesai' => 'Selesai',
                                                    default => $retur->status
                                                };
                                            @endphp
                                            <span class="badge {{ $badgeClass }}">{{ $badgeLabel }}</span>
                                        </td>
                                        <td>{{ $retur->created_at->format('d M Y H:i') }}</td>
                                        <td>
                                            <a href="{{ route('retur.admin.detail', $retur->id) }}" class="btn btn-sm btn-primary">
                                                <i class="mdi mdi-eye"></i> Detail
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </section>
</div>
@endsection
