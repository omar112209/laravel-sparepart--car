@extends('v_layouts.app')
@section('content')
<style>
.cart-table{width:100%}
.cart-table th{font-family:var(--font-mono);font-size:9px;letter-spacing:2px;text-transform:uppercase;color:var(--color-text-3);font-weight:400;padding:12px 14px;border-bottom:1px solid var(--color-border)}
.cart-table td{padding:16px 14px;border-bottom:1px solid var(--color-border);vertical-align:middle;color:var(--color-text-2)}
.cart-table tbody tr:last-child td{border-bottom:none}
.cart-table tbody tr:hover{background:rgba(255,255,255,.02)}
.cart-table img{width:68px;height:68px;object-fit:cover;border-radius:8px;border:1px solid var(--color-border);filter:saturate(.85)}
.qty-badge{display:inline-block;background:var(--color-steel);border:1px solid var(--color-border);border-radius:4px;padding:4px 14px;font-family:var(--font-mono);font-size:13px;color:var(--color-text)}
</style>

<div class="page-title">
    <h3>Keranjang <span>Belanja</span></h3>
    <div class="divider"></div>
    <div class="label">// Cart</div>
</div>

@if(session('success'))
<div class="alert alert-success"><i class="fa fa-check-circle"></i> {{ session('success') }}</div>
@endif
@if(session('error'))
<div class="alert alert-error"><i class="fa fa-exclamation-circle"></i> {{ session('error') }}</div>
@endif

@if($order && $order->orderItems->count() > 0)
<div class="card">
    <div style="overflow-x:auto;">
    <table class="cart-table">
        <thead><tr style="background:var(--color-steel);">
            <th colspan="2">Produk</th><th style="text-align:center;">Harga</th><th style="text-align:center;">Qty</th><th style="text-align:right;">Subtotal</th><th></th>
        </tr></thead>
        <tbody>
            @foreach ($order->orderItems as $i => $item)
            <tr class="animate-fade-up" style="animation-delay:{{ $i*0.05 }}s;">
                <td style="width:84px;">
                    <div class="img-skeleton" style="width:68px;height:68px;border-radius:8px;overflow:hidden;">
                        <img src="{{ asset('storage/img-produk/'.$item->produk->foto) }}" alt="{{ $item->produk->nama_produk }}" class="w-full h-full object-cover img-lazy" loading="lazy" onerror="this.src='{{ asset('images/no-image.png') }}'">
                    </div>
                </td>
                <td>
                    <div class="text-sm font-medium mb-1" style="color:var(--color-text);">{{ $item->produk->nama_produk }}</div>
                    <div class="font-mono text-[10px]" style="color:var(--color-text-3);"><i class="fa fa-weight" style="color:var(--color-red-primary);font-size:9px;"></i> Berat: {{ $item->produk->berat ?? 0 }} Gr &nbsp; <i class="fa fa-cubes" style="color:var(--color-red-primary);font-size:9px;"></i> Stok: {{ $item->produk->stok }}</div>
                </td>
                <td class="text-center font-mono text-[13px]" style="color:var(--color-text-2);">Rp {{ number_format($item->harga,0,',','.') }}</td>
                <td class="text-center">
                    <form action="{{ route('order.updateCart',$item->id) }}" method="post" class="inline-flex items-center gap-2">
                        @csrf
                        <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" max="{{ $item->produk->stok + $item->quantity }}" class="qty-badge w-16 text-center outline-none" style="background:var(--color-steel);border:1px solid var(--color-border);color:var(--color-text);font-family:var(--font-mono);font-size:13px;border-radius:4px;padding:4px 8px;" onchange="this.form.submit()">
                    </form>
                </td>
                <td class="text-right font-display text-lg font-bold tracking-[0.3px]" style="color:var(--color-red-primary);">Rp {{ number_format($item->harga * $item->quantity,0,',','.') }}</td>
                <td>
                    <form action="{{ route('order.remove',$item->produk_id) }}" method="post">
                        @csrf
                        <button type="submit" class="w-8 h-8 flex items-center justify-center rounded-md border-0 cursor-pointer transition-all" style="background:transparent;color:var(--color-text-3);" onmouseover="this.style.color='#f87171'" onmouseout="this.style.color='var(--color-text-3)'"><i class="fa fa-trash"></i></button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    </div>
</div>

<div class="flex justify-end mt-6">
    <div class="w-full max-w-sm card">
        <div class="card-header"><span class="dot"></span> Ringkasan Belanja</div>
        <div class="px-4 py-3.5" style="border-bottom:1px solid var(--color-border);">
            <div class="flex justify-between items-center text-[13px]" style="color:var(--color-text-2);"><span>Subtotal</span><span class="font-mono" style="color:var(--color-text);">Rp {{ number_format($order->total_harga,0,',','.') }}</span></div>
        </div>
        <div class="px-4 py-3.5" style="background:var(--color-steel);">
            <a href="{{ route('order.selectShipping') }}" class="btn-primary btn-block btn-loading-click"><i class="fa fa-truck"></i> Checkout</a>
        </div>
    </div>
</div>
@else
<div class="empty-state"><i class="fa fa-shopping-cart"></i><div><strong>Keranjang kosong</strong><span>Belum ada produk di keranjang.</span></div></div>
@endif
@endsection
