@extends('v_layouts.app')
@section('content')
<div class="page-title">
    <h3>Detail <span>Produk</span></h3>
    <div class="divider"></div>
    <div class="label">// {{ $row->kategori->nama_kategori ?? 'Produk' }}</div>
</div>

@if(session('success'))
<div class="alert alert-success"><i class="fa fa-check-circle"></i> {{ session('success') }}</div>
@endif

<div class="flex flex-wrap -mx-4">
    <div class="w-full lg:w-5/12 px-4 mb-6 lg:mb-0 animate-fade-up">
        <div class="card group">
            <div class="p-4 overflow-hidden">
                <div class="img-skeleton w-full rounded-lg overflow-hidden">
                    <img id="main-image" src="{{ asset('storage/img-produk/'.$row->foto) }}" alt="{{ $row->nama_produk }}" class="w-full h-auto transition-all duration-500 group-hover:scale-105 img-lazy" style="filter:saturate(.85);" loading="lazy">
                </div>
            </div>
            @if ($fotoProdukTambahan->count() > 0)
            <div class="flex gap-2 p-4 pt-0 overflow-x-auto">
                @foreach ($fotoProdukTambahan as $i => $foto)
                <div class="w-16 h-16 shrink-0 rounded-md overflow-hidden cursor-pointer border-2 transition-all" style="border-color:transparent;" onmouseover="this.style.borderColor='var(--color-red-primary)';this.style.transform='scale(1.08)';document.getElementById('main-image').src='{{ asset('storage/img-produk/'.$foto->foto) }}'" onmouseout="this.style.borderColor='transparent';this.style.transform='scale(1)'">
                    <img src="{{ asset('storage/img-produk/'.$foto->foto) }}" alt="" class="w-full h-full object-cover">
                </div>
                @endforeach
            </div>
            @endif
        </div>
    </div>
    <div class="w-full lg:w-7/12 px-4 animate-fade-up" style="animation-delay:.1s;">
        <h1 class="font-display text-3xl font-extrabold tracking-[1px] uppercase mt-0 mb-4" style="color:var(--color-text);">{{ $row->nama_produk }}</h1>

        <div class="flex items-baseline gap-4 mb-6">
            <span class="font-display text-4xl font-extrabold" style="color:var(--color-red-primary);">Rp {{ number_format($row->harga,0,',','.') }}</span>
        </div>

        <div class="flex flex-wrap gap-4 mb-6 reveal visible" style="transition-delay:0.15s;">
            <div class="px-4 py-2.5 rounded-lg text-center flex-1 min-w-[120px] transition-all" style="background:var(--color-dark-3);border:1px solid var(--color-border);" onmouseover="this.style.borderColor='var(--color-red-primary)';this.style.transform='translateY(-2px)'" onmouseout="this.style.borderColor='var(--color-border)';this.style.transform='translateY(0)'">
                <div class="font-mono text-[9px] tracking-[2px] uppercase mb-1" style="color:var(--color-text-3);">Stok</div>
                <div class="font-display text-xl font-bold" style="color:var(--color-text);">{{ $row->stok }}</div>
            </div>
            <div class="px-4 py-2.5 rounded-lg text-center flex-1 min-w-[120px] transition-all" style="background:var(--color-dark-3);border:1px solid var(--color-border);" onmouseover="this.style.borderColor='var(--color-red-primary)';this.style.transform='translateY(-2px)'" onmouseout="this.style.borderColor='var(--color-border)';this.style.transform='translateY(0)'">
                <div class="font-mono text-[9px] tracking-[2px] uppercase mb-1" style="color:var(--color-text-3);">Berat</div>
                <div class="font-display text-xl font-bold" style="color:var(--color-text);">{{ $row->berat }} Gr</div>
            </div>
            <div class="px-4 py-2.5 rounded-lg text-center flex-1 min-w-[120px] transition-all" style="background:var(--color-dark-3);border:1px solid var(--color-border);" onmouseover="this.style.borderColor='var(--color-red-primary)';this.style.transform='translateY(-2px)'" onmouseout="this.style.borderColor='var(--color-border)';this.style.transform='translateY(0)'">
                <div class="font-mono text-[9px] tracking-[2px] uppercase mb-1" style="color:var(--color-text-3);">Kategori</div>
                <div class="font-display text-xl font-bold" style="color:var(--color-text);">{{ $row->kategori->nama_kategori ?? '-' }}</div>
            </div>
        </div>

        <div class="mb-6">
            <div class="font-mono text-[9px] tracking-[2px] uppercase mb-3" style="color:var(--color-text-3);">Deskripsi</div>
            <div class="text-sm leading-relaxed" style="color:var(--color-text-2);">{!! strip_tags($row->detail, '<p><br><ul><ol><li><strong><em><b><i><u><span><h1><h2><h3><h4><h5><h6><hr><blockquote><pre><code><table><thead><tbody><tr><th><td><div>') !!}</div>
        </div>

        @if ($row->stok > 0)
        <form action="{{ route('order.addToCart',$row->id) }}" method="post">
            @csrf
            <button type="submit" class="btn-primary px-8 py-4 text-base btn-loading-click"><i class="fa fa-shopping-cart"></i> Tambah ke Keranjang</button>
        </form>
        @else
        <div class="alert alert-error"><i class="fa fa-times-circle"></i> Stok produk sedang habis</div>
        @endif
    </div>
</div>
@endsection
