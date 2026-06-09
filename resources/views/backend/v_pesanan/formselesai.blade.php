<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan Pesanan Selesai</title>
</head>

<body>

    @extends('backend.v_layouts.app')

    @section('content')
        <div class="container">
            <h4>{{ $judul }} - {{ $subJudul }}</h4>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('laporan.selesai.cetak') }}" method="POST" target="_blank">
                @csrf
                <div class="mb-3">
                    <label>Tanggal Awal</label>
                    <input type="date" name="tanggal_awal" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Tanggal Akhir</label>
                    <input type="date" name="tanggal_akhir" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary">🖨️ Cetak Laporan</button>
            </form>
        </div>
    @endsection

</body>

</html>
