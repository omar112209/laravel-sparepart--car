@extends('backend.v_layouts.app')
@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{ $subJudul ?? 'Detail Retur' }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('retur.admin.index') }}">Retur</a></li>
                        <li class="breadcrumb-item active">Detail</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Informasi Retur</h3>
                        </div>
                        <div class="card-body">
                            <table class="table table-borderless">
                                <tr>
                                    <th style="width:160px;">ID Retur</th>
                                    <td>#{{ str_pad($retur->id, 4, '0', STR_PAD_LEFT) }}</td>
                                </tr>
                                <tr>
                                    <th>Order</th>
                                    <td>#{{ str_pad($retur->order_id, 5, '0', STR_PAD_LEFT) }}</td>
                                </tr>
                                <tr>
                                    <th>Customer</th>
                                    <td>{{ $retur->customer->nama ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Produk</th>
                                    <td>{{ $retur->produk->nama_produk ?? 'Produk telah dihapus' }}</td>
                                </tr>
                                <tr>
                                    <th>Jumlah</th>
                                    <td>{{ $retur->quantity }} unit</td>
                                </tr>
                                <tr>
                                    <th>Status</th>
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
                                </tr>
                                <tr>
                                    <th>Tanggal Pengajuan</th>
                                    <td>{{ $retur->created_at->format('d M Y H:i') }} WIB</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Alasan & Foto</h3>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label>Alasan Retur</label>
                                <p class="form-control-static">{{ $retur->alasan }}</p>
                            </div>
                            @if ($retur->foto)
                                <div class="form-group">
                                    <label>Foto Bukti</label><br>
                                    <a href="{{ asset('storage/' . $retur->foto) }}" target="_blank">
                                        <img src="{{ asset('storage/' . $retur->foto) }}"
                                            style="max-width:250px;border-radius:8px;border:1px solid #ddd;">
                                    </a>
                                </div>
                            @else
                                <p class="text-muted">Tidak ada foto</p>
                            @endif
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Tindakan Admin</h3>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('retur.admin.update', $retur->id) }}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="form-group">
                                    <label>Ubah Status</label>
                                    <select name="status" class="form-control" {{ $retur->status === 'selesai' || $retur->status === 'ditolak' ? 'disabled' : '' }}>
                                        <option value="disetujui" {{ $retur->status === 'disetujui' ? 'selected' : '' }}>Disetujui</option>
                                        <option value="ditolak" {{ $retur->status === 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                                        <option value="selesai" {{ $retur->status === 'selesai' ? 'selected' : '' }}>Selesai</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>Catatan Admin</label>
                                    <textarea name="catatan_admin" class="form-control" rows="3" {{ $retur->status === 'selesai' || $retur->status === 'ditolak' ? 'disabled' : '' }}>{{ $retur->catatan_admin }}</textarea>
                                </div>

                                @if ($retur->status !== 'selesai' && $retur->status !== 'ditolak')
                                    <button type="submit" class="btn btn-primary">
                                        <i class="mdi mdi-check"></i> Simpan
                                    </button>
                                @endif

                                <a href="{{ route('retur.admin.index') }}" class="btn btn-secondary">
                                    <i class="mdi mdi-arrow-left"></i> Kembali
                                </a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
</div>
@endsection
