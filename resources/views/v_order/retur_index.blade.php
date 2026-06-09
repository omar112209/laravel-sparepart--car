@extends('v_layouts.app')
@section('content')
<style>
.cart-table{width:100%}
.cart-table th{font-family:var(--font-mono);font-size:9px;letter-spacing:2px;text-transform:uppercase;color:var(--color-text-3);font-weight:400;padding:12px 14px;border-bottom:1px solid var(--color-border)}
.cart-table td{padding:16px 14px;border-bottom:1px solid var(--color-border);vertical-align:middle;color:var(--color-text-2)}
.cart-table tbody tr:last-child td{border-bottom:none}
.cart-table img{width:68px;height:68px;object-fit:cover;border-radius:8px;border:1px solid var(--color-border);filter:saturate(.85)}
.status-badge{display:inline-block;font-family:var(--font-mono);font-size:9px;letter-spacing:1px;text-transform:uppercase;padding:4px 10px;border-radius:4px;font-weight:700}
</style>

<div class="page-title">
    <h3>Retur <span>Pesanan</span></h3>
    <div class="divider"></div>
    <div class="label">// Retur</div>
</div>

@if(session('success'))
<div class="alert alert-success"><i class="fa fa-check-circle"></i> {{ session('success') }}</div>
@endif
@if(session('error'))
<div class="alert alert-error"><i class="fa fa-exclamation-circle"></i> {{ session('error') }}</div>
@endif

@forelse ($returOrders as $i => $order)
<div class="card mb-4 animate-fade-up" style="animation-delay:{{ $i*0.05 }}s;">
    <div class="flex items-center justify-between px-4 py-3.5 flex-wrap gap-2" style="background:var(--color-steel);border-bottom:1px solid var(--color-border);">
        <div class="flex items-center gap-3 text-sm" style="color:var(--color-text-2);">
            <i class="fa fa-undo" style="color:var(--color-red-primary);font-size:16px;"></i>
            <span class="font-mono text-[12px]">#{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</span>
            <span class="text-xs" style="color:var(--color-text-3);">· {{ $order->created_at->format('d M Y H:i') }}</span>
        </div>
        @php
        $s = $order->status;
        $badge = $s === 'Selesai' ? 'color:#4caf50;background:rgba(76,175,80,.15)' :
                 ($s === 'paid' ? 'color:#2196f3;background:rgba(33,150,243,.15)' :
                 ($s === 'Kirim' ? 'color:#ff9800;background:rgba(255,152,0,.15)' :
                 'color:var(--color-text-3);background:var(--color-dark-3)'));
        @endphp
        <span class="status-badge" style="{{ $badge }}">{{ $s }}</span>
    </div>
    @foreach ($order->orderItems as $item)
    @php
    $itemReturExists = $order->returs->where('order_item_id', $item->id)->count() > 0;
    @endphp
    <div class="flex items-center gap-3 px-4 py-2.5 text-sm" style="border-bottom:1px solid var(--color-border);">
        <div class="img-skeleton" style="width:44px;height:44px;border-radius:6px;overflow:hidden;flex-shrink:0;"><img src="{{ asset('storage/img-produk/'.$item->produk->foto) }}" alt="" class="w-full h-full object-cover img-lazy" loading="lazy" onerror="this.src='{{ asset('images/no-image.png') }}'" style="filter:saturate(.85);"></div>
        <div class="flex-1 min-w-0">
            <div style="color:var(--color-text);">{{ $item->produk->nama_produk }}</div>
            <span class="text-xs" style="color:var(--color-text-3);">x{{ $item->quantity }}</span>
        </div>
        <div class="font-mono text-xs text-right" style="color:var(--color-text-2);flex-shrink:0;">
            <div>Rp {{ number_format($item->harga*$item->quantity,0,',','.') }}</div>
            @if ($order->status === 'Selesai' && !$itemReturExists)
            <a href="{{ route('order.retur.create', $item->id) }}" class="inline-block mt-1 px-2 py-1 rounded-sm font-mono text-[9px] uppercase tracking-[1px] transition-all" style="background:var(--color-steel);border:1px solid var(--color-border);color:var(--color-text-3);" onmouseover="this.style.borderColor='var(--color-red-primary)';this.style.color='var(--color-text)'" onmouseout="this.style.borderColor='var(--color-border)';this.style.color='var(--color-text-3)'"><i class="fa fa-undo"></i> Retur</a>
            @elseif ($itemReturExists)
            <span class="inline-block mt-1 status-badge" style="color:#9c27b0;background:rgba(156,39,176,.15);">Sudah diretur</span>
            @endif
        </div>
    </div>
    @endforeach
    <div class="flex items-center justify-between px-4 py-3 text-xs" style="color:var(--color-text-3);">
        <div><i class="fa fa-calculator"></i> Grand Total: Rp {{ number_format(($order->total_harga ?? 0) + ($order->biaya_ongkir ?? 0) - ($order->voucher_discount ?? 0),0,',','.') }}</div>
    </div>
</div>
@empty
<div class="empty-state"><i class="fa fa-undo"></i><div><strong>Tidak ada retur</strong><span>Belum ada pengajuan retur.</span></div></div>
@endforelse

@if(method_exists($returOrders, 'links'))
<div class="mt-6">{{ $returOrders->links('v_pagination.paginator') }}</div>
@endif
@endsection
