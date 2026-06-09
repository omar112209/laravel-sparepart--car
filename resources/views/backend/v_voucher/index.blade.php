@extends('backend.v_layouts.app')
@section('content')
<div class="row">
    <div class="col-12">
        <a href="{{ route('backend.voucher.create') }}">
            <button type="button" class="btn btn-primary"><i class="fas fa-plus"></i> Tambah Voucher</button>
        </a>
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">{{ $judul }}</h5>
                <div class="table-responsive">
                    <table id="zero_config" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kode</th>
                                <th>Tipe</th>
                                <th>Nilai</th>
                                <th>Min Belanja</th>
                                <th>Maks Diskon</th>
                                <th>Berlaku</th>
                                <th>Pemakaian</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($index as $row)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td><strong>{{ $row->kode }}</strong></td>
                                    <td>{{ $row->tipe == 'persen' ? 'Persen (%)' : 'Nominal (Rp)' }}</td>
                                    <td>
                                        {{ $row->tipe == 'persen' ? $row->nilai . '%' : 'Rp ' . number_format($row->nilai, 0, ',', '.') }}
                                    </td>
                                    <td>Rp {{ number_format($row->min_belanja, 0, ',', '.') }}</td>
                                    <td>{{ $row->maks_diskon ? 'Rp ' . number_format($row->maks_diskon, 0, ',', '.') : '-' }}</td>
                                    <td>
                                        {{ date('d/m/Y', strtotime($row->tanggal_mulai)) }} -
                                        {{ date('d/m/Y', strtotime($row->tanggal_berakhir)) }}
                                    </td>
                                    <td>
                                        <span class="badge badge-info">{{ $row->dipakai }}</span>
                                        @if ($row->batas_pakai > 0)
                                            / {{ $row->batas_pakai }}
                                        @else
                                            / &infin;
                                        @endif
                                    </td>
                                    <td>
                                        @php
                                            $now = now()->format('Y-m-d');
                                            $isExpired = $row->tanggal_berakhir < $now;
                                        @endphp
                                        @if ($isExpired)
                                            <span class="badge badge-secondary">Expired</span>
                                        @elseif ($row->status == 'aktif')
                                            <span class="badge badge-success">Aktif</span>
                                        @else
                                            <span class="badge badge-danger">Nonaktif</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('backend.voucher.edit', $row->id) }}" title="Ubah Data">
                                            <button type="button" class="btn btn-cyan btn-sm"><i class="far fa-edit"></i> Ubah</button>
                                        </a>
                                        <form method="POST" action="{{ route('backend.voucher.destroy', $row->id) }}" style="display: inline-block;">
                                            @method('delete')
                                            @csrf
                                            <button type="submit" class="btn btn-danger btn-sm show_confirm"
                                                data-konf-delete="{{ $row->kode }}" title='Hapus Data'>
                                                <i class="fas fa-trash"></i> Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
