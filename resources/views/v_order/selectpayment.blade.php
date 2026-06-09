@extends('v_layouts.app')
@section('content')
<style>
.cart-table{width:100%}
.cart-table th{font-family:var(--font-mono);font-size:9px;letter-spacing:2px;text-transform:uppercase;color:var(--color-text-3);font-weight:400;padding:12px 14px;border-bottom:1px solid var(--color-border)}
.cart-table td{padding:16px 14px;border-bottom:1px solid var(--color-border);vertical-align:middle;color:var(--color-text-2)}
.cart-table tbody tr:last-child td{border-bottom:none}
.cart-table img{width:68px;height:68px;object-fit:cover;border-radius:8px;border:1px solid var(--color-border);filter:saturate(.85)}
.qty-badge{display:inline-block;background:var(--color-steel);border:1px solid var(--color-border);border-radius:4px;padding:4px 14px;font-family:var(--font-mono);font-size:13px;color:var(--color-text)}
</style>

<div class="page-title">
    <h3>Pembayaran</h3>
    <div class="divider"></div>
    <div class="label">// Payment</div>
</div>

@if(session('success'))
<div class="alert alert-success"><i class="fa fa-check-circle"></i> {{ session('success') }}</div>
@endif
@if(session('error'))
<div class="alert alert-error"><i class="fa fa-exclamation-circle"></i> {{ session('error') }}</div>
@endif

<div class="card mb-5 animate-fade-up">
    <div style="overflow-x:auto;">
    <table class="cart-table">
        <thead><tr style="background:var(--color-steel);">
            <th colspan="2">Produk</th><th style="text-align:center;">Harga</th><th style="text-align:center;">Qty</th><th style="text-align:right;">Total</th>
        </tr></thead>
        <tbody>
            @foreach ($order->orderItems as $i => $item)
            <tr style="animation-delay:{{ $i*0.05 }}s;" class="animate-fade-up">
                <td style="width:84px;"><div class="img-skeleton" style="width:68px;height:68px;border-radius:8px;overflow:hidden;"><img src="{{ asset('storage/img-produk/'.$item->produk->foto) }}" alt="" class="w-full h-full object-cover img-lazy" loading="lazy" onerror="this.src='{{ asset('images/no-image.png') }}'"></div></td>
                <td><div class="text-sm font-medium" style="color:var(--color-text);">{{ $item->produk->nama_produk }}</div></td>
                <td class="text-center font-mono text-[13px]" style="color:var(--color-text-2);">Rp {{ number_format($item->harga,0,',','.') }}</td>
                <td class="text-center"><span class="qty-badge">{{ $item->quantity }}</span></td>
                <td class="text-right font-display text-lg font-bold" style="color:var(--color-red-primary);">Rp {{ number_format($item->harga*$item->quantity,0,',','.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    </div>
</div>

<div class="card-section mb-5 animate-fade-up" style="animation-delay:.1s;">
    <div class="flex items-center gap-2 font-mono text-[9px] tracking-[2px] uppercase mb-3" style="color:var(--color-text-3);"><i class="fa fa-ticket" style="color:var(--color-red-primary);"></i> Punya Kode Voucher?</div>
    <div class="flex gap-2">
        <input type="text" id="voucher-input" placeholder="Masukkan kode voucher" class="input-field flex-1">
        <button type="button" id="btn-apply-voucher" class="px-5 py-2.5 rounded-md text-white font-display text-[13px] font-bold tracking-[1px] uppercase cursor-pointer" style="background:var(--color-red-primary);">Gunakan</button>
    </div>
    <div id="voucher-status" class="mt-2.5 text-[12px] hidden"></div>
</div>

<div class="flex justify-end">
    <div class="w-full max-w-sm card animate-fade-up" style="animation-delay:.15s;">
        <div class="card-header"><span class="dot"></span> Ringkasan Pembayaran</div>
        <div class="px-4 py-3" style="border-bottom:1px solid var(--color-border);">
            <div class="flex justify-between text-[13px] py-2" style="color:var(--color-text-2);border-bottom:1px solid var(--color-border);"><span>Subtotal</span><span class="font-mono" id="summary-subtotal" style="color:var(--color-text);">Rp {{ number_format($totalHarga,0,',','.') }}</span></div>
            <div class="flex justify-between text-[13px] py-2" style="color:var(--color-text-2);border-bottom:1px solid var(--color-border);"><span>Ongkos Kirim</span><span class="font-mono" style="color:var(--color-text);">Rp {{ number_format($biaya_ongkir,0,',','.') }}</span></div>
            <div id="discount-row" class="flex justify-between text-[13px] py-2 {{ $diskon>0?'':'hidden' }}" style="color:#4ade80;border-bottom:1px solid var(--color-border);"><span>Diskon Voucher</span><span class="font-mono" id="summary-diskon">- Rp {{ number_format($diskon,0,',','.') }}</span></div>
            <div class="flex justify-between items-center py-3" style="background:var(--color-steel);margin:0 -16px;padding:12px 16px;border:1px solid var(--color-border-red);">
                <span class="font-display text-sm font-bold tracking-[1px] uppercase" style="color:var(--color-text);">Total Bayar</span>
                <span class="font-display text-2xl font-extrabold" id="summary-total" style="color:var(--color-red-primary);">Rp {{ number_format($totalBayar,0,',','.') }}</span>
            </div>
        </div>
        <button id="pay-button" class="w-full py-3.5 text-white font-display text-base font-bold tracking-[2px] uppercase cursor-pointer border-0 btn-loading-click" style="background:var(--color-red-primary);" onmouseover="this.style.background='var(--color-red-dark)'" onmouseout="this.style.background='var(--color-red-primary)'"><i class="fa fa-lock"></i> Bayar Sekarang</button>
    </div>
</div>

<script src="{{ config('midtrans.is_production') ? 'https://app.midtrans.com/snap/snap.js' : 'https://app.sandbox.midtrans.com/snap/snap.js' }}" data-client-key="{{ config('midtrans.client_key') }}"></script>
<script src="{{ asset('frontend/js/jquery.min.js') }}"></script>
<script>
const subtotal = {{ $totalHarga }}, ongkir = {{ $biaya_ongkir }};
const $status = $('#voucher-status'), $subtotal = $('#summary-subtotal'), $diskon = $('#summary-diskon'), $total = $('#summary-total'), $dRow = $('#discount-row');
function applyVoucher(kode){
    $('#btn-apply-voucher').prop('disabled',true).html('<i class="fa fa-spinner fa-spin"></i>');
    $.post('{{ route("voucher.apply") }}',{kode:kode,_token:'{{ csrf_token() }}'},function(d){
        $('#btn-apply-voucher').prop('disabled',false).html('Gunakan');
        if(d.success){$status.removeClass('hidden').addClass('flex').css('color','#4ade80').html('<i class="fa fa-check-circle"></i> '+d.message);setTimeout(function(){location.reload()},800)}
        else{$status.removeClass('hidden').addClass('flex').css('color','#f87171').html('<i class="fa fa-exclamation-circle"></i> '+d.message);setTimeout(function(){$status.addClass('hidden').removeClass('flex')},4000)}
    },'json').fail(function(){$('#btn-apply-voucher').prop('disabled',false).html('Gunakan');$status.removeClass('hidden').addClass('flex').css('color','#f87171').html('Terjadi kesalahan.')});
}
$('#btn-apply-voucher').on('click',function(){var k=$('#voucher-input').val().trim();if(!k){$status.removeClass('hidden').addClass('flex').css('color','#f87171').html('Masukkan kode voucher.');return}applyVoucher(k)});
document.getElementById('pay-button').onclick=function(){snap.pay('{{ $snapToken }}',{
    onSuccess:function(r){var p=new URLSearchParams();p.set('order_id',r.order_id||'{{ $order->id }}');p.set('transaction_status',r.transaction_status||'');p.set('status_code',r.status_code||'');p.set('gross_amount',r.gross_amount||'');p.set('signature_key',r.signature_key||'');window.location.href="{{ route('order.complete') }}?"+p.toString()},
    onPending:function(){window.location.href="{{ route('order.history') }}"},
    onError:function(){window.location.href="{{ route('order.history') }}"},
    onClose:function(){window.location.href="{{ route('order.history') }}"}
})};
</script>
@endsection
