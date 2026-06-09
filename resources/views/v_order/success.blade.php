@extends('v_layouts.app')
@section('content')
<div class="page-title">
    <h3>Pesanan <span>Berhasil</span></h3>
    <div class="divider"></div>
    <div class="label">// Success</div>
</div>

<div class="card animate-fade-up" style="border:1px solid var(--color-border-red);">
    <div class="p-8 text-center">
        <div class="w-16 h-16 flex items-center justify-center rounded-full mx-auto mb-4" style="background:rgba(76,175,80,.15);">
            <i class="fa fa-check" style="color:#4caf50;font-size:28px;"></i>
        </div>
        <h3 class="font-display text-2xl font-bold tracking-[1px] uppercase m-0 mb-2" style="color:var(--color-text);">Pembayaran Berhasil!</h3>
        <p class="text-sm mb-6 max-w-md mx-auto" style="color:var(--color-text-2);">Terima kasih, pesanan kamu sudah kami terima dan akan segera diproses.</p>

        <div class="flex flex-wrap justify-center gap-3">
            <a href="{{ route('order.history') }}" class="btn-primary px-6 py-3 text-[13px]"><i class="fa fa-receipt"></i> Lihat Status Pesanan</a>
            <a href="{{ route('beranda') }}" class="btn-outline px-6 py-3 text-[13px]"><i class="fa fa-home"></i> Kembali ke Beranda</a>
        </div>
    </div>
</div>
@endsection
