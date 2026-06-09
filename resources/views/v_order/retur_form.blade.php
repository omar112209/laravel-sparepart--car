@extends('v_layouts.app')
@section('content')
<div class="page-title">
    <h3>Form <span>Retur</span></h3>
    <div class="divider"></div>
    <div class="label">// Retur Form</div>
</div>

@if(session('error'))
<div class="alert alert-error"><i class="fa fa-exclamation-circle"></i> {{ session('error') }}</div>
@endif

<div class="flex flex-wrap -mx-4">
    <div class="w-full lg:w-7/12 px-4 mb-6 lg:mb-0">
        <div class="card animate-fade-up">
            <div class="card-header"><span class="dot"></span> Info Pesanan</div>
            <div class="p-4" style="border-bottom:1px solid var(--color-border);">
                <div class="flex items-center gap-3 mb-3">
                    <i class="fa fa-receipt" style="color:var(--color-red-primary);font-size:20px;"></i>
                    <div>
                        <div class="font-mono text-[12px] font-bold" style="color:var(--color-text);">#{{ str_pad($orderItem->order->id, 4, '0', STR_PAD_LEFT) }}</div>
                        <div class="text-xs" style="color:var(--color-text-3);">{{ $orderItem->order->created_at->format('d M Y H:i') }}</div>
                    </div>
                </div>
                <div class="flex items-center gap-3 py-2 text-sm">
                    <div class="img-skeleton" style="width:48px;height:48px;border-radius:6px;overflow:hidden;flex-shrink:0;"><img src="{{ asset('storage/img-produk/'.$orderItem->produk->foto) }}" alt="" class="w-full h-full object-cover img-lazy" loading="lazy" onerror="this.src='{{ asset('images/no-image.png') }}'" style="filter:saturate(.85);"></div>
                    <div class="flex-1"><span style="color:var(--color-text);">{{ $orderItem->produk->nama_produk }}</span><span class="text-xs ml-2" style="color:var(--color-text-3);">x{{ $orderItem->quantity }}</span></div>
                    <div class="font-mono text-xs" style="color:var(--color-text-2);">Rp {{ number_format($orderItem->harga*$orderItem->quantity,0,',','.') }}</div>
                </div>
            </div>
            <div class="p-4 text-xs" style="color:var(--color-text-3);">
                <i class="fa fa-truck"></i> {{ $orderItem->order->kurir ?? '-' }} &nbsp;·&nbsp; Grand Total: <span class="font-mono" style="color:var(--color-text);">Rp {{ number_format(($orderItem->order->total_harga ?? 0) + ($orderItem->order->biaya_ongkir ?? 0) - ($orderItem->order->voucher_discount ?? 0),0,',','.') }}</span>
            </div>
        </div>

        <div class="card mt-5 animate-fade-up" style="animation-delay:.1s;">
            <div class="card-header"><span class="dot"></span> Form Pengajuan Retur</div>
            <form action="{{ route('order.retur.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="order_item_id" value="{{ $orderItem->id }}">
                <div class="p-4 space-y-4">
                    <div>
                        <label class="input-label"><i class="fa fa-cube"></i> Produk</label>
                        <div class="flex items-center gap-3 py-2 px-3" style="background:var(--color-steel);border-radius:8px;border:1px solid var(--color-border);">
                            <div class="img-skeleton" style="width:40px;height:40px;border-radius:6px;overflow:hidden;flex-shrink:0;"><img src="{{ asset('storage/img-produk/'.$orderItem->produk->foto) }}" alt="" class="w-full h-full object-cover" loading="lazy" onerror="this.src='{{ asset('images/no-image.png') }}'"></div>
                            <div class="flex-1 min-w-0">
                                <div style="color:var(--color-text);font-size:13px;">{{ $orderItem->produk->nama_produk }}</div>
                                <span class="text-xs" style="color:var(--color-text-3);">Dibeli: x{{ $orderItem->quantity }}</span>
                            </div>
                        </div>
                    </div>
                    <div>
                        <label class="input-label"><i class="fa fa-calculator"></i> Jumlah Retur</label>
                        <input type="number" name="quantity" min="1" max="{{ $orderItem->quantity }}" value="1" class="input-field" required>
                        <span class="text-xs" style="color:var(--color-text-3);">Maksimal {{ $orderItem->quantity }} unit</span>
                    </div>
                    <div>
                        <label class="input-label"><i class="fa fa-align-left"></i> Alasan Retur</label>
                        <textarea name="alasan" rows="3" class="input-field" placeholder="Jelaskan alasan retur..." required></textarea>
                    </div>
                    <div>
                        <label class="input-label"><i class="fa fa-camera"></i> Foto Bukti</label>
                        <div class="relative">
                            <input type="file" name="foto" accept="image/jpeg,image/png,image/jpg" class="input-field file:cursor-pointer file:border-0 file:bg-transparent file:text-[13px] file:font-mono file:tracking-[1px] file:uppercase file:px-3 file:py-1.5" style="padding:10px 14px;">
                        </div>
                    </div>
                    <button type="submit" class="btn-primary px-8 py-3.5 text-sm btn-loading-click"><i class="fa fa-paper-plane"></i> Ajukan Retur</button>
                </div>
            </form>
        </div>
    </div>

    <div class="w-full lg:w-5/12 px-4">
        <div class="card animate-fade-up" style="animation-delay:.15s;">
            <div class="card-header"><span class="dot"></span> Ketentuan Retur</div>
            <div class="p-4 space-y-3 text-xs leading-relaxed" style="color:var(--color-text-2);">
                <p>Retur hanya berlaku untuk pesanan dengan status <span class="status-badge" style="color:#4caf50;background:rgba(76,175,80,.15);padding:2px 6px;">completed</span>.</p>
                <p>Pastikan melampirkan foto bukti sebagai bahan verifikasi.</p>
                <p>Proses review memakan waktu 1×24 jam.</p>
                <p>Jika disetujui, dana akan dikembalikan ke saldo akun kamu.</p>
                <p style="border-top:1px solid var(--color-border);padding-top:12px;" class="mt-3">Ada pertanyaan? Hubungi kami via WhatsApp.</p>
            </div>
            <div class="px-4 py-3" style="background:var(--color-steel);border-top:1px solid var(--color-border);">
                <a href="https://wa.me/6281234567890" target="_blank" class="btn-outline btn-block text-[13px]"><i class="fa fa-whatsapp" style="color:#25d366;"></i> Hubungi CS</a>
            </div>
        </div>
    </div>
</div>
@endsection
