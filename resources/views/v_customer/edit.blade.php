@extends('v_layouts.app')
@section('content')
<style>
.profile-card { position: relative; max-width: 820px; margin: 0 auto; animation: fadeUp 0.5s ease both; }
.profile-card-inner { position: relative; background: var(--color-dark-3); border-radius: 20px; padding: 36px; border: 1px solid var(--color-border); overflow: hidden; }
.profile-card-inner::before { content: ''; position: absolute; top: 0; left: 0; right: 0; height: 3px; background: linear-gradient(90deg, transparent, var(--color-red-primary), transparent); }
.auth-input { width: 100%; padding: 13px 16px; background: var(--color-dark-2); border: 1.5px solid var(--color-border); border-radius: 12px; color: var(--color-text); font-size: 14px; outline: none; transition: all 0.25s; }
.auth-input:focus { border-color: var(--color-red-primary); box-shadow: 0 0 0 4px rgba(200,16,46,0.08); }
.auth-input::placeholder { color: var(--color-text-3); }
.auth-select { width: 100%; padding: 13px 16px; background: var(--color-dark-2); border: 1.5px solid var(--color-border); border-radius: 12px; color: var(--color-text); font-size: 14px; outline: none; transition: all 0.25s; appearance: none; cursor: pointer; }
.auth-select:focus { border-color: var(--color-red-primary); box-shadow: 0 0 0 4px rgba(200,16,46,0.08); }
.auth-select option { background: var(--color-dark-3); color: var(--color-text); }
.auth-label { display: block; font-family: var(--font-mono); font-size: 10px; letter-spacing: 1.5px; text-transform: uppercase; margin-bottom: 8px; color: var(--color-text-3); }
.avatar-wrap { position: relative; width: 130px; height: 130px; border-radius: 20px; overflow: hidden; background: var(--color-dark-2); border: 2px dashed var(--color-border); margin: 0 auto 16px; transition: border-color 0.3s; }
.avatar-wrap:hover { border-color: var(--color-red-primary); }
.avatar-wrap img, .avatar-placeholder { width: 100%; height: 100%; object-fit: cover; }
.avatar-placeholder { display: flex; align-items: center; justify-content: center; font-size: 42px; color: var(--color-text-3); }
.avatar-overlay { position: absolute; inset: 0; display: flex; align-items: center; justify-content: center; background: rgba(0,0,0,0.55); opacity: 0; transition: opacity 0.3s; cursor: pointer; border-radius: 18px; }
.avatar-wrap:hover .avatar-overlay { opacity: 1; }
.avatar-overlay span { color: #fff; font-family: var(--font-display); font-size: 13px; font-weight: 700; letter-spacing: 1px; text-transform: uppercase; display: flex; align-items: center; gap: 6px; }
.success-box { display: flex; align-items: center; gap: 10px; padding: 12px 16px; border-radius: 12px; margin-bottom: 20px; font-size: 13px; background: rgba(34,197,94,0.08); border: 1px solid rgba(34,197,94,0.2); color: #4ade80; animation: fadeUp 0.4s ease both; }
.error-box { display: flex; align-items: center; gap: 10px; padding: 12px 16px; border-radius: 12px; margin-bottom: 20px; font-size: 13px; background: rgba(200,16,46,0.08); border: 1px solid rgba(200,16,46,0.2); color: #f87171; animation: fadeUp 0.4s ease both; }
.loading-spinner { display: inline-block; width: 16px; height: 16px; border: 2px solid var(--color-border); border-top-color: var(--color-red-primary); border-radius: 50%; animation: spin 0.6s linear infinite; margin-right: 6px; vertical-align: middle; }
@keyframes spin { to { transform: rotate(360deg); } }
</style>

<div class="py-8 px-4">
    <div class="flex items-baseline gap-3.5 mb-8 animate-fade-up" style="max-width:820px;margin:0 auto 32px;">
        <h3 class="font-display text-2xl font-extrabold tracking-[2px] uppercase m-0" style="color:var(--color-text);">Akun <span style="color:var(--color-red-primary);">Saya</span></h3>
        <div class="flex-1 h-px" style="background:linear-gradient(90deg,var(--color-border),transparent);"></div>
        <div class="font-mono text-[9px] tracking-[2px]" style="color:var(--color-text-3);">// Profile</div>
    </div>

    <div class="profile-card">
        <div class="profile-card-inner">
            @if(session('success'))
            <div class="success-box"><i class="fa fa-check-circle"></i> {{ session('success') }}</div>
            @endif
            @if($errors->any())
            <div class="error-box"><i class="fa fa-exclamation-circle"></i> {{ $errors->first() }}</div>
            @endif

            <form action="{{ route('customer.updateakun',['id'=>$customer->user_id]) }}" method="post" enctype="multipart/form-data">
                @csrf @method('PUT')

                <div class="flex flex-col md:flex-row gap-8 md:gap-10">
                    <div class="w-full md:w-[180px] shrink-0 text-center">
                        <div class="avatar-wrap">
                            @if ($customer->foto)
                            <img src="{{ asset('storage/' . $customer->foto) }}" alt="" id="avatar-preview">
                            @else
                            <div class="avatar-placeholder" id="avatar-preview"><i class="fa fa-user"></i></div>
                            @endif
                            <div class="avatar-overlay" onclick="document.getElementById('foto-input').click()">
                                <span><i class="fa fa-camera"></i> Ganti</span>
                            </div>
                        </div>
                        <label class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-[12px] cursor-pointer transition-all font-mono tracking-[1px] uppercase" style="background:var(--color-steel);border:1px solid var(--color-border);color:var(--color-text-2);" onmouseover="this.style.borderColor='var(--color-border-red)'" onmouseout="this.style.borderColor='var(--color-border)'">
                            <i class="fa fa-upload"></i> Upload
                            <input type="file" name="foto" id="foto-input" class="hidden" accept="image/*">
                        </label>
                        <p class="text-[11px] mt-2" style="color:var(--color-text-3);">JPG/PNG, maks 2MB</p>
                    </div>

                    <div class="flex-1 min-w-0">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-5 gap-y-4">
                            <div>
                                <label class="auth-label"><i class="fa fa-user" style="color:var(--color-red-primary);font-size:9px;"></i> Nama</label>
                                <input type="text" name="nama" value="{{ $customer->nama }}" required class="auth-input">
                            </div>
                            <div>
                                <label class="auth-label"><i class="fa fa-envelope" style="color:var(--color-red-primary);font-size:9px;"></i> Email</label>
                                <input type="email" name="email" value="{{ $customer->email }}" required class="auth-input">
                            </div>
                            <div>
                                <label class="auth-label"><i class="fa fa-phone" style="color:var(--color-red-primary);font-size:9px;"></i> No. HP</label>
                                <input type="text" name="hp" value="{{ $customer->hp }}" class="auth-input">
                            </div>
                            <div>
                                <label class="auth-label"><i class="fa fa-map-pin" style="color:var(--color-red-primary);font-size:9px;"></i> Kode Pos</label>
                                <input type="text" name="pos" value="{{ $customer->pos }}" class="auth-input">
                            </div>
                            <div>
                                <label class="auth-label"><i class="fa fa-globe" style="color:var(--color-red-primary);font-size:9px;"></i> Provinsi</label>
                                <select name="provinsi_id" id="provinsi" class="auth-select">
                                    <option value="">Pilih Provinsi</option>
                                </select>
                                <input type="hidden" name="provinsi" id="provinsi_nama" value="{{ $customer->provinsi }}">
                            </div>
                            <div>
                                <label class="auth-label"><i class="fa fa-city" style="color:var(--color-red-primary);font-size:9px;"></i> Kota/Kabupaten</label>
                                <select name="kota_id" id="kota" class="auth-select">
                                    <option value="">Pilih Kota</option>
                                </select>
                                <input type="hidden" name="kota_kabupaten" id="kota_nama" value="{{ $customer->kota_kabupaten }}">
                            </div>
                            <div>
                                <label class="auth-label"><i class="fa fa-map" style="color:var(--color-red-primary);font-size:9px;"></i> Kecamatan</label>
                                <select name="kecamatan_id" id="kecamatan" class="auth-select">
                                    <option value="">Pilih Kecamatan</option>
                                </select>
                                <input type="hidden" name="kecamatan" id="kecamatan_nama" value="{{ $customer->kecamatan }}">
                            </div>
                            <div class="md:col-span-2">
                                <label class="auth-label"><i class="fa fa-home" style="color:var(--color-red-primary);font-size:9px;"></i> Detail Alamat</label>
                                <textarea name="detail_alamat" rows="2" class="auth-input" style="min-height:70px;resize:vertical;" placeholder="Nama jalan, gedung, no. rumah">{{ $customer->detail_alamat }}</textarea>
                            </div>
                        </div>
                        <div class="flex justify-end mt-6 pt-5" style="border-top:1px solid var(--color-border);">
                            <button type="submit" class="inline-flex items-center gap-2 px-7 py-3 rounded-xl text-white font-display font-bold text-[14px] tracking-[1.5px] uppercase border-0 cursor-pointer transition-all btn-loading-click" style="background:var(--color-red-primary);" onmouseover="this.style.background='var(--color-red-dark)'" onmouseout="this.style.background='var(--color-red-primary)'"><i class="fa fa-save"></i> Simpan Perubahan</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.getElementById('foto-input')?.addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = function(ev) {
        const el = document.getElementById('avatar-preview');
        if (el.tagName === 'IMG') {
            el.src = ev.target.result;
        } else {
            el.outerHTML = '<img id="avatar-preview" src="' + ev.target.result + '" class="w-full h-full object-cover">';
        }
    };
    reader.readAsDataURL(file);
});

const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || '';

function setLoading(el, loading) {
    if (loading) {
        el.disabled = true;
        el.innerHTML = '<option value=""><span class="loading-spinner"></span> Memuat...</option>';
    } else {
        el.disabled = false;
    }
}

// Load Provinces
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
                if (p.id === '{{ $customer->provinsi_id }}') opt.selected = true;
                sel.appendChild(opt);
            });
        }
        if (sel.dataset.loaded) return;
        sel.dataset.loaded = '1';
        // Trigger city load if province already selected
        if (sel.value) sel.dispatchEvent(new Event('change'));
    });

// Load Cities on province change
document.getElementById('provinsi').addEventListener('change', function() {
    const provId = this.value;
    const provNama = this.options[this.selectedIndex]?.text || '';
    document.getElementById('provinsi_nama').value = provNama;
    const citySel = document.getElementById('kota');
    const distSel = document.getElementById('kecamatan');
    citySel.innerHTML = '<option value="">Pilih Kota</option>';
    distSel.innerHTML = '<option value="">Pilih Kecamatan</option>';
    document.getElementById('kota_nama').value = '';
    document.getElementById('kecamatan_nama').value = '';
    if (!provId) return;
    setLoading(citySel, true);
    fetch('/cities?province_id=' + provId)
        .then(res => res.json())
        .then(data => {
            citySel.innerHTML = '<option value="">Pilih Kota</option>';
            if (data.meta?.code === 200 && data.data) {
                const selectedCity = '{{ $customer->kota_id }}';
                data.data.forEach(c => {
                    const opt = document.createElement('option');
                    opt.value = c.id;
                    opt.textContent = c.name;
                    if (c.id === selectedCity) opt.selected = true;
                    citySel.appendChild(opt);
                });
            }
            citySel.disabled = false;
            if (citySel.value) citySel.dispatchEvent(new Event('change'));
        })
        .finally(() => { citySel.disabled = false; });
});

// Load Districts on city change
document.getElementById('kota').addEventListener('change', function() {
    const cityId = this.value;
    const cityNama = this.options[this.selectedIndex]?.text || '';
    document.getElementById('kota_nama').value = cityNama;
    const distSel = document.getElementById('kecamatan');
    distSel.innerHTML = '<option value="">Pilih Kecamatan</option>';
    document.getElementById('kecamatan_nama').value = '';
    if (!cityId) return;
    setLoading(distSel, true);
    fetch('/districts/' + cityId)
        .then(res => res.json())
        .then(data => {
            distSel.innerHTML = '<option value="">Pilih Kecamatan</option>';
            if (data.meta?.code === 200 && data.data) {
                const selectedDist = '{{ $customer->kecamatan_id }}';
                data.data.forEach(d => {
                    const opt = document.createElement('option');
                    opt.value = d.id;
                    opt.textContent = d.name;
                    if (d.id === selectedDist) opt.selected = true;
                    distSel.appendChild(opt);
                });
            }
            distSel.disabled = false;
        })
        .finally(() => { distSel.disabled = false; });
});

// Set district name on change
document.getElementById('kecamatan').addEventListener('change', function() {
    const nama = this.options[this.selectedIndex]?.text || '';
    document.getElementById('kecamatan_nama').value = nama;
});
</script>
@endsection