@extends('backend.v_layouts.app')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <form class="form-horizontal" action="{{ route('backend.voucher.store') }}" method="post">
                    @csrf
                    <div class="card-body">
                        <h4 class="card-title">{{ $judul }}</h4>

                        <div class="form-group">
                            <label>Kode Voucher</label>
                            <input type="text" name="kode" value="{{ old('kode') }}"
                                class="form-control @error('kode') is-invalid @enderror"
                                placeholder="Contoh: MAZDA15" required>
                            @error('kode')
                                <span class="invalid-feedback alert-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Tipe Diskon</label>
                                    <select name="tipe" class="form-control @error('tipe') is-invalid @enderror" required>
                                        <option value="persen" {{ old('tipe') == 'persen' ? 'selected' : '' }}>Persen (%)</option>
                                        <option value="nominal" {{ old('tipe') == 'nominal' ? 'selected' : '' }}>Nominal (Rp)</option>
                                    </select>
                                    @error('tipe')
                                        <span class="invalid-feedback alert-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Nilai Diskon</label>
                                    <input type="number" step="0.01" name="nilai" value="{{ old('nilai') }}"
                                        class="form-control @error('nilai') is-invalid @enderror"
                                        placeholder="Contoh: 15 atau 50000" required>
                                    @error('nilai')
                                        <span class="invalid-feedback alert-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Maksimal Diskon (Rp) <small>(opsional, hanya untuk tipe persen)</small></label>
                                    <input type="number" name="maks_diskon" value="{{ old('maks_diskon') }}"
                                        class="form-control @error('maks_diskon') is-invalid @enderror"
                                        placeholder="Kosongkan jika tidak ada">
                                    @error('maks_diskon')
                                        <span class="invalid-feedback alert-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Minimal Belanja (Rp)</label>
                                    <input type="number" name="min_belanja" value="{{ old('min_belanja', 0) }}"
                                        class="form-control @error('min_belanja') is-invalid @enderror"
                                        placeholder="0 = tanpa minimal">
                                    @error('min_belanja')
                                        <span class="invalid-feedback alert-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Tanggal Mulai</label>
                                    <input type="date" name="tanggal_mulai" value="{{ old('tanggal_mulai') }}"
                                        class="form-control @error('tanggal_mulai') is-invalid @enderror" required>
                                    @error('tanggal_mulai')
                                        <span class="invalid-feedback alert-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Tanggal Berakhir</label>
                                    <input type="date" name="tanggal_berakhir" value="{{ old('tanggal_berakhir') }}"
                                        class="form-control @error('tanggal_berakhir') is-invalid @enderror" required>
                                    @error('tanggal_berakhir')
                                        <span class="invalid-feedback alert-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Batas Pemakaian</label>
                                    <input type="number" name="batas_pakai" value="{{ old('batas_pakai', 0) }}"
                                        class="form-control @error('batas_pakai') is-invalid @enderror"
                                        placeholder="0 = tidak terbatas">
                                    @error('batas_pakai')
                                        <span class="invalid-feedback alert-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Status</label>
                                    <select name="status" class="form-control">
                                        <option value="aktif" selected>Aktif</option>
                                        <option value="nonaktif">Nonaktif</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Deskripsi <small>(opsional)</small></label>
                            <textarea name="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror"
                                placeholder="Keterangan voucher" rows="2">{{ old('deskripsi') }}</textarea>
                            @error('deskripsi')
                                <span class="invalid-feedback alert-danger">{{ $message }}</span>
                            @enderror
                        </div>

                    </div>
                    <div class="border-top">
                        <div class="card-body">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                            <a href="{{ route('backend.voucher.index') }}">
                                <button type="button" class="btn btn-secondary">Kembali</button>
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
