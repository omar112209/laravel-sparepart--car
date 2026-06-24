@extends('v_layouts.app')
@section('content')
<div class="page-title">
    <h3>Pencarian <span>Produk</span></h3>
    <div class="divider"></div>
    <div class="label">// {{ $produk->count() }} hasil</div>
</div>

@if(session('error'))
<div class="alert alert-error"><i class="fa fa-exclamation-circle"></i> {{ session('error') }}</div>
@endif

<div class="flex flex-wrap -mx-2.5" id="store">
    @forelse ($produk as $i => $row)
    <div class="w-full md:w-6/12 xl:w-4/12 px-2.5 mb-5 flex flex-col animate-fade-up" style="animation-delay:{{ $i*0.05 }}s;">
        <div class="product-card flex-1 flex flex-col group">
            <div class="relative w-full h-[200px] overflow-hidden shrink-0" style="background:var(--color-dark-2);border-bottom:1px solid var(--color-border);">
                <span class="absolute top-2.5 left-2.5 z-[2] font-mono text-[9px] tracking-[1px] uppercase px-2 py-[3px] rounded-sm text-white" style="background:var(--color-red-primary);">{{ $row->kategori->nama_kategori }}</span>
                @if($row->stok <= 0)
                <div class="absolute inset-0 z-[2] flex items-center justify-center" style="background:rgba(0,0,0,0.55);">
                    <span class="font-display text-lg font-bold tracking-[2px] uppercase px-4 py-2 rounded" style="color:var(--color-red-primary);border:2px solid var(--color-red-primary);">STOK HABIS</span>
                </div>
                @endif
                <a href="{{ route('produk.detail',$row->id) }}" class="absolute inset-0 flex items-center justify-center z-[1] transition-all duration-300">
                    <span class="px-4 py-2 rounded-md font-display text-[12px] font-bold tracking-[1px] cursor-pointer transition-all duration-300 opacity-0 group-hover:opacity-100 translate-y-2 group-hover:translate-y-0" style="background:var(--color-dark-3);border:1px solid var(--color-border);color:var(--color-text);"><i class="fa fa-search-plus"></i> Detail</span>
                </a>
                <div class="img-skeleton w-full h-full">
                    <img src="{{ asset('storage/img-produk/thumb_md_'.$row->foto) }}" alt="" class="w-full h-full object-cover saturate-[0.85] transition-all duration-500 group-hover:scale-105 img-lazy" loading="lazy">
                </div>
            </div>
            <div class="p-4 flex flex-col flex-1">
                <h3 class="font-display text-xl font-bold tracking-[0.5px] m-0 mb-1.5" style="color:var(--color-text);">Rp {{ number_format($row->harga,0,',','.') }}
                    <span class="text-[11px] font-normal ml-1.5" style="color:var(--color-text-3);">{{ $row->kategori->nama_kategori }}</span>
                </h3>
                <h2 class="text-sm font-medium leading-relaxed m-0 flex-1" style="color:var(--color-text-2);"><a href="{{ route('produk.detail',$row->id) }}">{{ $row->nama_produk }}</a></h2>
                <div class="flex items-center gap-2 mt-3.5 pt-3.5" style="border-top:1px solid var(--color-border);">
                    <a href="{{ route('produk.detail',$row->id) }}" class="w-9 h-9 flex items-center justify-center rounded-md shrink-0 transition-all" style="background:var(--color-steel);border:1px solid var(--color-border);color:var(--color-text-2);font-size:14px;" onmouseover="this.style.background='var(--color-red-primary)';this.style.color='#fff'" onmouseout="this.style.background='var(--color-steel)';this.style.color='var(--color-text-2)'"><i class="fa fa-search-plus"></i></a>
                    @if($row->stok > 0)
                    <form action="{{ route('order.addToCart',$row->id) }}" method="post" class="flex-1">
                        @csrf
                        <button type="submit" class="w-full justify-center px-3 py-2.5 btn-primary btn-loading-click text-[13px]" style="letter-spacing:1px;"><i class="fa fa-shopping-cart"></i> Pesan</button>
                    </form>
                    @else
                    <span class="flex-1 flex items-center justify-center px-3 py-2.5 rounded-md font-display text-[13px] font-bold tracking-[1px] cursor-not-allowed" style="background:var(--color-dark-3);border:1px solid var(--color-border);color:var(--color-text-3);letter-spacing:1px;"><i class="fa fa-times-circle"></i> Stok Habis</span>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @empty
    <div class="w-full px-2.5">
        <div class="empty-state"><i class="fa fa-search"></i><div><strong>Produk tidak ditemukan</strong><span>Coba kata kunci lain.</span></div></div>
    </div>
    @endforelse
</div>
@endsection
