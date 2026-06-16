@extends('backend.v_layouts.app')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h4 class="card-title mb-4 text-center">{{ $judul }}</h4>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label>Nama</label>
                                <input type="text" class="form-control" value="{{ $show->user->nama }}" disabled>
                            </div>
                            <div class="form-group mb-3">
                                <label>Email</label>
                                <input type="text" class="form-control" value="{{ $show->user->email }}" disabled>
                            </div>
                            <div class="form-group mb-3">
                                <label>No. HP</label>
                                <input type="text" class="form-control" value="{{ $show->user->hp ?? '-' }}" disabled>
                            </div>
                            <div class="form-group mb-3">
                                <label>Status</label>
                                <input type="text" class="form-control" value="{{ $show->user->status == 1 ? 'Aktif' : 'NonAktif' }}" disabled>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label>Provinsi</label>
                                <input type="text" class="form-control" value="{{ $show->provinsi ?? '-' }}" disabled>
                            </div>
                            <div class="form-group mb-3">
                                <label>Kota/Kabupaten</label>
                                <input type="text" class="form-control" value="{{ $show->kota_kabupaten ?? '-' }}" disabled>
                            </div>
                            <div class="form-group mb-3">
                                <label>Kecamatan</label>
                                <input type="text" class="form-control" value="{{ $show->kecamatan ?? '-' }}" disabled>
                            </div>
                            <div class="form-group mb-3">
                                <label>Kode Pos</label>
                                <input type="text" class="form-control" value="{{ $show->pos ?? '-' }}" disabled>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group mb-3">
                                <label>Detail Alamat</label>
                                <textarea class="form-control" rows="3" disabled>{{ $show->detail_alamat ?? '-' }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="border-top">
                    <div class="card-body text-center">
                        <a href="{{ route('backend.customer.index') }}" class="btn btn-secondary">Kembali</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection