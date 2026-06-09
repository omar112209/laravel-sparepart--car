@extends('backend.v_layouts.app')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <form class="form-horizontal" action="{{ route('backend.voucher.update', $edit->id) }}" method="post">
                    @method('put')
                    @csrf
                    <div class="card-body">
                        <h4 class="card-title">{{ $judul }}</h4>

                        <div class="form-group">
                            <label>Kode Voucher</label>
                            <input type="text" name="kode" value="{{ old('kode', $edit->kode) }}"
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
                                    <select name="tipe" class="form-control" required>
                                        <option value="persen" {{ old('tipe', $edit->tipe) == 'persen' ? 'selected' : '' }}>Persen (%)</option>
                                        <option value="nominal" {{ old('tipe', $edit->tipe) == 'nominal' ? 'selected' : '' }}>Nominal (Rp)</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Nilai Diskon</label>
                                    <input type="number" step="0.01" name="nilai" value="{{ old('nilai', $edit->nilai) }}"
                                        class="form-control @error('nilai') is-invalid @enderror" required>
                                    @error('nilai')
                                        <span class="invalid-feedback alert-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Maksimal Diskon (Rp)</label>
                                    <input type="number" name="maks_diskon" value="{{ old('maks_diskon', $edit->maks_diskon) }}"
                                        class="form-control" placeholder="Kosongkan jika tidak ada">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Minimal Belanja (Rp)</label>
                                    <input type="number" name="min_belanja" value="{{ old('min_belanja', $edit->min_belanja) }}"
                                        class="form-control">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Tanggal Mulai</label>
                                    <input type="date" name="tanggal_mulai" value="{{ old('tanggal_mulai', $edit->tanggal_mulai) }}"
                                        class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Tanggal Berakhir</label>
                                    <input type="date" name="tanggal_berakhir" value="{{ old('tanggal_berakhir', $edit->tanggal_berakhir) }}"
                                        class="form-control" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Batas Pemakaian</label>
                                    <input type="number" name="batas_pakai" value="{{ old('batas_pakai', $edit->batas_pakai) }}"
                                        class="form-control" placeholder="0 = tidak terbatas">
                                    <small class="text-muted">Terpakai: {{ $edit->dipakai }} kali</small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Status</label>
                                    <select name="status" class="form-control">
                                        <option value="aktif" {{ old('status', $edit->status) == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                        <option value="nonaktif" {{ old('status', $edit->status) == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Deskripsi</label>
                            <textarea name="deskripsi" class="form-control" rows="2">{{ old('deskripsi', $edit->deskripsi) }}</textarea>
                        </div>

                    </div>
                    <div class="border-top">
                        <div class="card-body">
                            <button type="submit" class="btn btn-primary">Update</button>
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
