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
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Form Cetak Laporan Pesanan Proses</h3>
                    </div>
                    <form action="{{ route('laporan.proses.cetak') }}" method="POST">
                        @csrf
                        <div class="card-body">

                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <div class="form-group">
                                <label>Tanggal Awal</label>
                                <input type="date" name="tanggal_awal"
                                    class="form-control @error('tanggal_awal') is-invalid @enderror"
                                    value="{{ old('tanggal_awal') }}" required>
                                @error('tanggal_awal')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Tanggal Akhir</label>
                                <input type="date" name="tanggal_akhir"
                                    class="form-control @error('tanggal_akhir') is-invalid @enderror"
                                    value="{{ old('tanggal_akhir') }}" required>
                                @error('tanggal_akhir')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-print"></i> Cetak Laporan
                            </button>
                            <a href="{{ route('pesanan.proses') }}" class="btn btn-default">Kembali</a>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>
@endsection
