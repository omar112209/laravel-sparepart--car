@extends('backend.v_layouts.app')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h4 class="card-title mb-4 text-center">{{ $judul }}</h4>

                    <div class="row">
                        {{-- Kolom kiri: informasi produk --}}
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label>Kategori</label>
                                <select name="kategori_id"
                                    class="form-control @error('kategori_id') is-invalid @enderror"
                                    disabled>
                                    <option value="" selected> - Pilih Kategori - </option>
                                    @foreach ($kategori as $row)
                                        <option value="{{ $row->id }}"
                                            {{ old('kategori_id', $show->kategori_id) == $row->id ? 'selected' : '' }}>
                                            {{ $row->nama_kategori }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('kategori_id')
                                    <span class="invalid-feedback alert-danger" role="alert">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label>Nama Produk</label>
                                <input type="text" name="nama_produk"
                                    value="{{ old('nama_produk', $show->nama_produk) }}"
                                    class="form-control @error('nama_produk') is-invalid @enderror"
                                    placeholder="Masukkan Nama Produk" disabled>
                                @error('nama_produk')
                                    <span class="invalid-feedback alert-danger" role="alert">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label>Detail</label>
                                <textarea name="detail"
                                    class="form-control @error('detail') is-invalid @enderror"
                                    id="ckeditor" disabled>{{ old('detail', $show->detail) }}</textarea>
                                @error('detail')
                                    <span class="invalid-feedback alert-danger" role="alert">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                        </div>

                        {{-- Kolom kanan: foto utama dan tambahan --}}
                        <div class="col-md-6 text-center">
                            <div class="form-group mb-4">
                                <label class="d-block mb-2 fw-semibold">Foto Utama</label>
                                <img src="{{ asset('storage/img-produk/' . $show->foto) }}"
                                    class="rounded shadow-sm mx-auto d-block border"
                                    style="width: 60%; max-width: 300px; object-fit: cover;"
                                    alt="Foto Produk">
                            </div>

                            <hr>

                            <label class="fw-semibold d-block mb-3">Foto Tambahan</label>
                            <div id="foto-container">
                                <div class="row justify-content-center">
                                    @foreach ($show->fotoproduk as $foto)
                                        <div class="col-md-6 mb-3 text-center">
                                            <img src="{{ asset('storage/img-produk/' . $foto->foto) }}"
                                                class="rounded border shadow-sm mb-2"
                                                style="width: 80%; max-width: 250px; object-fit: cover;">
                                            <form action="{{ route('backend.foto_produk.destroy', $foto->id) }}"
                                                method="post">
                                                @csrf
                                                @method('delete')
                                                <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                            </form>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <button type="button" class="btn btn-primary add-foto mt-3">Tambah Foto</button>
                        </div>
                    </div>
                </div>

                <div class="border-top">
                    <div class="card-body text-center">
                        <a href="{{ route('backend.produk.index') }}" class="btn btn-secondary">
                            Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Tambah Foto --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const fotoContainer = document.getElementById('foto-container');
        const addFotoButton = document.querySelector('.add-foto');
        addFotoButton.addEventListener('click', function() {
            const fotoRow = document.createElement('div');
            fotoRow.classList.add('form-group', 'row', 'justify-content-center');
            fotoRow.innerHTML = `
                <form action="{{ route('backend.foto_produk.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="col-md-12 text-center">
                        <input type="hidden" name="produk_id" value="{{ $show->id }}">
                        <input type="file" name="foto_produk[]" class="form-control mb-2">
                        <button type="submit" class="btn btn-success btn-sm">Simpan</button>
                    </div>
                </form>
            `;
            fotoContainer.appendChild(fotoRow);
        });
    });
</script>
@endsection
