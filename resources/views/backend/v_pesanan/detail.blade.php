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

                <div class="row">
                    <!-- Info Order -->
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header bg-info">
                                <h3 class="card-title text-white">Info Pesanan #{{ $order->id }}</h3>
                            </div>
                            <div class="card-body">
                                <table class="table table-sm">
                                    <tr>
                                        <td width="160"><strong>Customer</strong></td>
                                        <td>{{ $order->customer->nama ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Email</strong></td>
                                        <td>{{ $order->customer->email ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>No HP</strong></td>
                                        <td>{{ $order->customer->hp ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Alamat</strong></td>
                                        <td>{{ $order->alamat }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Kode Pos</strong></td>
                                        <td>{{ $order->pos ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Status</strong></td>
                                        <td>
                                            @if ($order->status == 'paid')
                                                <span class="badge badge-success">Diproses</span>
                                            @elseif ($order->status == 'Kirim')
                                                <span class="badge badge-info">Dikirim</span>
                                            @elseif ($order->status == 'Selesai')
                                                <span class="badge badge-primary">Selesai</span>
                                            @else
                                                <span class="badge badge-secondary">{{ $order->status }}</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Tanggal</strong></td>
                                        <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Info Pengiriman -->
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header bg-warning">
                                <h3 class="card-title">Info Pengiriman</h3>
                            </div>
                            <div class="card-body">
                                <table class="table table-sm">
                                    <tr>
                                        <td width="160"><strong>Kurir</strong></td>
                                        <td>{{ strtoupper($order->kurir ?? '-') }} - {{ $order->layanan_ongkir ?? '-' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Biaya Ongkir</strong></td>
                                        <td>Rp. {{ number_format($order->biaya_ongkir, 0, ',', '.') }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Estimasi</strong></td>
                                        <td>{{ $order->estimasi_ongkir ?? '-' }} hari</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Berat</strong></td>
                                        <td>{{ $order->total_berat ?? '-' }} gram</td>
                                    </tr>
                                    <tr>
                                        <td><strong>No Resi</strong></td>
                                        <td>{{ $order->noresi ?? '-' }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Item Produk -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Daftar Produk</h3>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Produk</th>
                                    <th>Harga Satuan</th>
                                    <th>Qty</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($order->orderItems as $key => $item)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $item->produk->nama_produk ?? '-' }}</td>
                                        <td>Rp. {{ number_format($item->harga, 0, ',', '.') }}</td>
                                        <td>{{ $item->quantity }}</td>
                                        <td>Rp. {{ number_format($item->harga * $item->quantity, 0, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="4" class="text-right">Subtotal Produk</th>
                                    <th>Rp. {{ number_format($order->total_harga, 0, ',', '.') }}</th>
                                </tr>
                                <tr>
                                    <th colspan="4" class="text-right">Ongkos Kirim</th>
                                    <th>Rp. {{ number_format($order->biaya_ongkir, 0, ',', '.') }}</th>
                                </tr>
                                <tr>
                                    <th colspan="4" class="text-right">Grand Total</th>
                                    <th>Rp. {{ number_format($order->total_harga + $order->biaya_ongkir, 0, ',', '.') }}
                                    </th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

                <!-- Form Update Status -->
                <div class="card">
                    <div class="card-header bg-secondary">
                        <h3 class="card-title text-white">Update Status Pesanan</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('pesanan.update', $order->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Status</label>
                                        <select name="status" class="form-control">
                                            <option value="unpaid" {{ $order->status == 'unpaid' ? 'selected' : '' }}>Unpaid
                                            </option>
                                            <option value="paid" {{ $order->status == 'paid' ? 'selected' : '' }}>Diproses
                                            </option>
                                            <option value="Kirim" {{ $order->status == 'Kirim' ? 'selected' : '' }}>Kirim
                                            </option>
                                            <option value="Selesai" {{ $order->status == 'Selesai' ? 'selected' : '' }}>
                                                Selesai</option>
                                            <option value="cancel" {{ $order->status == 'cancel' ? 'selected' : '' }}>
                                                Cancel</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>No Resi</label>
                                        <input type="text" name="noresi" class="form-control"
                                            value="{{ $order->noresi }}" placeholder="Nomor resi pengiriman">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Kode Pos</label>
                                        <input type="text" name="pos" class="form-control"
                                            value="{{ $order->pos }}" placeholder="Kode Pos">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Alamat</label>
                                <textarea name="alamat" class="form-control" rows="3" required>{{ strip_tags($order->alamat) }}</textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Simpan Perubahan
                            </button>
                            <a href="{{ route('pesanan.proses') }}" class="btn btn-default">Kembali</a>
                        </form>
                    </div>
                </div>

            </div>
        </section>
    </div>
@endsection
