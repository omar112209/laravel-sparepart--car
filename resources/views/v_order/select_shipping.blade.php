@extends('v_layouts.app')
@section('content')
<style>
.cart-table{width:100%}
.cart-table th{font-family:var(--font-mono);font-size:9px;letter-spacing:2px;text-transform:uppercase;color:var(--color-text-3);font-weight:400;padding:12px 14px;border-bottom:1px solid var(--color-border)}
.cart-table td{padding:16px 14px;border-bottom:1px solid var(--color-border);vertical-align:middle;color:var(--color-text-2)}
.cart-table tbody tr:last-child td{border-bottom:none}
.cart-table img{width:68px;height:68px;object-fit:cover;border-radius:8px;border:1px solid var(--color-border);filter:saturate(.85)}
.qty-badge{display:inline-block;background:var(--color-steel);border:1px solid var(--color-border);border-radius:4px;padding:4px 14px;font-family:var(--font-mono);font-size:13px;color:var(--color-text)}
.auth-select{width:100%;padding:11px 14px;background:var(--color-dark-2);border:1.5px solid var(--color-border);border-radius:10px;color:var(--color-text);font-size:13px;outline:none;transition:all 0.25s;appearance:none;cursor:pointer}
.auth-select:focus{border-color:var(--color-red-primary);box-shadow:0 0 0 4px rgba(200,16,46,0.08)}
.auth-select option{background:var(--color-dark-3);color:var(--color-text)}
.input-field{width:100%;padding:11px 14px;background:var(--color-dark-2);border:1.5px solid var(--color-border);border-radius:10px;color:var(--color-text);font-size:13px;outline:none;transition:all 0.25s}
.input-field:focus{border-color:var(--color-red-primary);box-shadow:0 0 0 4px rgba(200,16,46,0.08)}
.input-field::placeholder{color:var(--color-text-3)}
.courier-radio{display:none}
.courier-label{display:flex;align-items:center;gap:12px;padding:14px 18px;border-radius:12px;cursor:pointer;transition:all 0.25s;border:2px solid var(--color-border);background:var(--color-steel)}
.courier-radio:checked+.courier-label{border-color:var(--color-red-primary);background:rgba(200,16,46,0.06)}
.courier-label:hover{border-color:var(--color-red-primary)}
.loading{display:inline-block;width:16px;height:16px;border:2px solid var(--color-border);border-top-color:var(--color-red-primary);border-radius:50%;animation:spin 0.6s linear infinite}
@keyframes spin{to{transform:rotate(360deg)}}
</style>

<div class="page-title">
    <h3>Pengiriman</h3>
    <div class="divider"></div>
    <div class="label">// Shipping</div>
</div>

@if(session('error'))
<div class="alert alert-error"><i class="fa fa-exclamation-circle"></i> {{ session('error') }}</div>
@endif

<div class="flex flex-wrap -mx-4">
    <div class="w-full lg:w-8/12 px-4 mb-6 lg:mb-0">

        {{-- Product List --}}
        <div class="card animate-fade-up">
            <div class="card-header"><span class="dot"></span> Daftar Produk</div>
            <div style="overflow-x:auto;">
            <table class="cart-table">
                <thead><tr style="background:var(--color-steel);">
                    <th colspan="2">Produk</th><th style="text-align:center;">Qty</th><th style="text-align:right;">Subtotal</th>
                </tr></thead>
                <tbody>
                    @foreach ($order->orderItems as $i => $item)
                    <tr class="animate-fade-up" style="animation-delay:{{ $i*0.05 }}s;">
                        <td style="width:84px;"><div class="img-skeleton" style="width:68px;height:68px;border-radius:8px;overflow:hidden;"><img src="{{ asset('storage/img-produk/'.$item->produk->foto) }}" alt="" class="w-full h-full object-cover img-lazy" loading="lazy" onerror="this.src='{{ asset('images/no-image.png') }}'"></div></td>
                        <td><div class="text-sm" style="color:var(--color-text);">{{ $item->produk->nama_produk }}</div></td>
                        <td class="text-center"><span class="qty-badge">{{ $item->quantity }}</span></td>
                        <td class="text-right font-display text-lg font-bold" style="color:var(--color-red-primary);">Rp {{ number_format($item->harga*$item->quantity,0,',','.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            </div>
        </div>

        {{-- Address Selection --}}
        <div class="card mt-5 animate-fade-up" style="animation-delay:.1s;">
            <div class="card-header"><span class="dot"></span> Alamat Pengiriman</div>
            <div class="p-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="font-mono text-[9px] tracking-[1.5px] uppercase mb-1.5 block" style="color:var(--color-text-3);"><i class="fa fa-globe" style="color:var(--color-red-primary);font-size:8px;"></i> Provinsi</label>
                        <select id="provinsi" class="auth-select">
                            <option value="">Pilih Provinsi</option>
                        </select>
                        <input type="hidden" id="provinsi_nama" value="{{ $customer->provinsi ?? '' }}">
                    </div>
                    <div>
                        <label class="font-mono text-[9px] tracking-[1.5px] uppercase mb-1.5 block" style="color:var(--color-text-3);"><i class="fa fa-city" style="color:var(--color-red-primary);font-size:8px;"></i> Kota/Kabupaten</label>
                        <select id="kota" class="auth-select">
                            <option value="">Pilih Kota</option>
                        </select>
                        <input type="hidden" id="kota_nama" value="{{ $customer->kota_kabupaten ?? '' }}">
                    </div>
                    <div>
                        <label class="font-mono text-[9px] tracking-[1.5px] uppercase mb-1.5 block" style="color:var(--color-text-3);"><i class="fa fa-map" style="color:var(--color-red-primary);font-size:8px;"></i> Kecamatan</label>
                        <select id="kecamatan" class="auth-select">
                            <option value="">Pilih Kecamatan</option>
                        </select>
                        <input type="hidden" id="kecamatan_nama" value="{{ $customer->kecamatan ?? '' }}">
                    </div>
                    <div>
                        <label class="font-mono text-[9px] tracking-[1.5px] uppercase mb-1.5 block" style="color:var(--color-text-3);"><i class="fa fa-map-pin" style="color:var(--color-red-primary);font-size:8px;"></i> Kode Pos</label>
                        <input type="text" id="pos" class="input-field" value="{{ $customer->pos ?? '' }}" placeholder="Kode pos">
                    </div>
                    <div class="md:col-span-2">
                        <label class="font-mono text-[9px] tracking-[1.5px] uppercase mb-1.5 block" style="color:var(--color-text-3);"><i class="fa fa-home" style="color:var(--color-red-primary);font-size:8px;"></i> Detail Alamat</label>
                        <textarea id="detail_alamat" rows="2" class="input-field" style="min-height:60px;resize:vertical;" placeholder="Nama jalan, gedung, no. rumah">{{ $customer->detail_alamat ?? '' }}</textarea>
                    </div>
                </div>
                <button type="button" id="cek-ongkir-btn" class="btn-primary mt-4 px-8 py-3 text-sm" onclick="cekOngkir()"><i class="fa fa-truck"></i> Cek Ongkos Kirim</button>
            </div>
        </div>

        {{-- Courier Selection --}}
        <div class="card mt-5 animate-fade-up" style="animation-delay:.15s;display:none;" id="courier-section">
            <div class="card-header"><span class="dot"></span> Pilih Kurir</div>
            <form action="{{ route('order.selectShippingStore') }}" method="post" id="shipping-form">
                @csrf
                <div class="p-4">
                    <div id="courier-list"></div>
                    <button type="submit" id="submit-btn" class="btn-primary mt-5 px-8 py-3.5 text-sm btn-loading-click" disabled><i class="fa fa-arrow-right"></i> Lanjut ke Pembayaran</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Summary --}}
    <div class="w-full lg:w-4/12 px-4">
        <div class="card animate-fade-up" style="animation-delay:.2s;">
            <div class="card-header"><span class="dot"></span> Ringkasan</div>
            <div class="px-4 py-3 text-[13px]" style="border-bottom:1px solid var(--color-border);">
                <div class="flex justify-between py-2" style="color:var(--color-text-2);"><span>Total Belanja</span><span class="font-mono" style="color:var(--color-text);">Rp {{ number_format($order->total_harga,0,',','.') }}</span></div>
            </div>
            <div class="px-4 py-4 text-center text-xs" style="color:var(--color-text-3);background:var(--color-steel);">
                <i class="fa fa-shield-alt" style="color:var(--color-red-primary);"></i> Transaksi aman & terpercaya
            </div>
        </div>
    </div>
</div>

<script>
const totalWeight = {{ $totalBerat }};
const storedProvId = '{{ $customer->provinsi_id ?? '' }}';
const storedCityId = '{{ $customer->kota_id ?? '' }}';
const storedDistId = '{{ $customer->kecamatan_id ?? '' }}';

// Load provinces on page load
fetch('/provinces')
    .then(res => res.json())
    .then(data => {
        const sel = document.getElementById('provinsi');
        sel.innerHTML = '<option value="">Pilih Provinsi</option>';
        if (data.meta?.code === 200 && data.data) {
            data.data.forEach(p => {
                const opt = document.createElement('option');
                opt.value = p.id;
                opt.textContent = p.name;
                if (p.id === storedProvId) opt.selected = true;
                sel.appendChild(opt);
            });
        }
        if (storedProvId) loadCities(storedProvId);
    });

function loadCities(provId) {
    const citySel = document.getElementById('kota');
    const distSel = document.getElementById('kecamatan');
    citySel.innerHTML = '<option value="">Pilih Kota</option>';
    distSel.innerHTML = '<option value="">Pilih Kecamatan</option>';
    document.getElementById('kota_nama').value = '';
    document.getElementById('kecamatan_nama').value = '';
    if (!provId) return;
    citySel.disabled = true;
    fetch('/cities?province_id=' + provId)
        .then(res => res.json())
        .then(data => {
            citySel.innerHTML = '<option value="">Pilih Kota</option>';
            if (data.meta?.code === 200 && data.data) {
                data.data.forEach(c => {
                    const opt = document.createElement('option');
                    opt.value = c.id;
                    opt.textContent = c.name;
                    if (c.id === storedCityId) opt.selected = true;
                    citySel.appendChild(opt);
                });
            }
            citySel.disabled = false;
            if (storedCityId) loadDistricts(storedCityId);
        })
        .catch(() => { citySel.disabled = false; });
}

function loadDistricts(cityId) {
    const distSel = document.getElementById('kecamatan');
    distSel.innerHTML = '<option value="">Pilih Kecamatan</option>';
    document.getElementById('kecamatan_nama').value = '';
    if (!cityId) return;
    distSel.disabled = true;
    fetch('/districts/' + cityId)
        .then(res => res.json())
        .then(data => {
            distSel.innerHTML = '<option value="">Pilih Kecamatan</option>';
            if (data.meta?.code === 200 && data.data) {
                data.data.forEach(d => {
                    const opt = document.createElement('option');
                    opt.value = d.id;
                    opt.textContent = d.name;
                    if (d.id === storedDistId) opt.selected = true;
                    distSel.appendChild(opt);
                });
            }
            distSel.disabled = false;
        })
        .catch(() => { distSel.disabled = false; });
}

// Province change — load cities, reset district
document.getElementById('provinsi').addEventListener('change', function() {
    document.getElementById('provinsi_nama').value = this.options[this.selectedIndex]?.text || '';
    loadCities(this.value);
});

// City change — save name + load districts
document.getElementById('kota').addEventListener('change', function() {
    document.getElementById('kota_nama').value = this.options[this.selectedIndex]?.text || '';
    loadDistricts(this.value);
});

// District change — save name only
document.getElementById('kecamatan').addEventListener('change', function() {
    document.getElementById('kecamatan_nama').value = this.options[this.selectedIndex]?.text || '';
});

function cekOngkir() {
    const provId = document.getElementById('provinsi').value;
    const cityId = document.getElementById('kota').value;
    const distId = document.getElementById('kecamatan').value;

    if (!provId || !cityId || !distId) {
        alert('Silakan pilih provinsi, kota, dan kecamatan tujuan.');
        return;
    }

    const btn = document.getElementById('cek-ongkir-btn');
    btn.disabled = true;
    btn.innerHTML = '<span class="loading"></span> Mencari kurir...';

    const courierSection = document.getElementById('courier-section');
    courierSection.style.display = 'none';

    const courierList = ['jne', 'tiki', 'pos'];
    let allData = [];

    Promise.all(courierList.map(courier =>
        fetch('/cost', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content },
            body: JSON.stringify({
                origin: '{{ config('services.rajaongkir.origin') }}',
                destination: distId,
                weight: Math.max(totalWeight, 1),
                courier: courier
            })
        }).then(async r => {
            if (!r.ok) {
                const text = await r.text();
                throw new Error('HTTP ' + r.status + ': ' + text.slice(0, 200));
            }
            return r.json();
        }).then(data => ({ courier, data }))
    )).then(results => {
        const container = document.getElementById('courier-list');
        container.innerHTML = '';

        results.forEach(({ courier, data }) => {
            if (data.meta?.code === 200 && data.data) {
                data.data.forEach(l => {
                    const label = document.createElement('label');
                    label.className = 'courier-option block mb-2';
                    label.innerHTML = `
                        <input type="radio" name="courier" value="${courier.toUpperCase()} - ${l.service}|${l.cost}|${l.etd || '-'}" class="courier-radio" onchange="enableSubmit()">
                        <div class="courier-label">
                            <div class="w-10 h-10 rounded-lg flex items-center justify-center font-display font-bold text-xs" style="background:var(--color-dark-2);color:var(--color-red-primary);">${courier.toUpperCase()}</div>
                            <div class="flex-1">
                                <div class="font-display text-sm font-bold" style="color:var(--color-text);">${l.service}</div>
                                <div class="text-[11px]" style="color:var(--color-text-3);">Estimasi ${l.etd || '-'} hari</div>
                            </div>
                            <div class="font-display text-base font-bold" style="color:var(--color-red-primary);">Rp ${Number(l.cost).toLocaleString('id-ID')}</div>
                        </div>
                    `;
                    container.appendChild(label);
                });
            } else {
                console.warn('RajaOngkir response:', data);
            }
        });

        if (container.children.length === 0) {
            container.innerHTML = '<div class="text-center py-6" style="color:var(--color-text-3);"><i class="fa fa-exclamation-circle fa-lg mb-2"></i><div class="text-sm">Tidak ada layanan kurir tersedia untuk tujuan ini.</div></div>';
        }

        courierSection.style.display = 'block';
        btn.disabled = false;
        btn.innerHTML = '<i class="fa fa-truck"></i> Cek Ongkos Kirim';
    }).catch(err => {
        console.error(err);
        alert('Gagal: ' + err.message);
        btn.disabled = false;
        btn.innerHTML = '<i class="fa fa-truck"></i> Cek Ongkos Kirim';
    });
}

function enableSubmit() {
    document.getElementById('submit-btn').disabled = false;
}

// Add address fields to form on submit
document.getElementById('shipping-form').addEventListener('submit', function(e) {
    const inputs = [
        { name: 'provinsi_id', value: document.getElementById('provinsi').value },
        { name: 'provinsi', value: document.getElementById('provinsi_nama').value },
        { name: 'kota_id', value: document.getElementById('kota').value },
        { name: 'kota_kabupaten', value: document.getElementById('kota_nama').value },
        { name: 'kecamatan_id', value: document.getElementById('kecamatan').value },
        { name: 'kecamatan', value: document.getElementById('kecamatan_nama').value },
        { name: 'detail_alamat', value: document.getElementById('detail_alamat').value },
        { name: 'pos', value: document.getElementById('pos').value },
    ];
    inputs.forEach(({ name, value }) => {
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = name;
        input.value = value;
        this.appendChild(input);
    });
});
</script>
@endsection