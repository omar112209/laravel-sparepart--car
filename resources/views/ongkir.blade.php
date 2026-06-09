<!DOCTYPE html>
<html>

<head>
    <title>Cek Ongkir</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body>
    <form id="ongkirForm">
        <select name="province" id="province">
            <option value="">Pilih Provinsi</option>
        </select>
        <select name="city" id="city">
            <option value="">Pilih Kota</option>
        </select>
        <input type="number" name="weight" id="weight" placeholder="Berat (gram)">
        <select name="courier" id="courier">
            <option value="">Pilih Kurir</option>
            <option value="jne">JNE</option>
            <option value="tiki">TIKI</option>
            <option value="pos">POS Indonesia</option>
        </select>
        <button type="submit" id="btnCekOngkir">Cek Ongkir</button>
    </form>

    <!-- Hasil Ongkir -->
    <div id="hasil-ongkir" style="display:none;">
        <h4>Pilih Layanan Pengiriman:</h4>
        <div id="list-layanan"></div>
        <br>
        <button id="btn-submit" disabled>Gunakan Layanan Ini</button>
    </div>

    <!-- Hidden inputs -->
    <input type="hidden" id="biaya_ongkir" name="biaya_ongkir">
    <input type="hidden" id="layanan_ongkir" name="layanan_ongkir">
    <input type="hidden" id="estimasi_ongkir" name="estimasi_ongkir">
    <input type="hidden" id="kurir_hidden" name="kurir_hidden">

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            // ================= PROVINCES =================
            fetch('/provinces')
                .then(res => res.json())
                .then(data => {
                    console.log('Provinces:', data);
                    let provinceSelect = document.getElementById('province');
                    if (data.meta && data.meta.code === 200) {
                        data.data.forEach(province => {
                            let option = document.createElement('option');
                            option.value = province.id;
                            option.textContent = province.name;
                            provinceSelect.appendChild(option);
                        });
                    } else {
                        console.error('Gagal ambil provinsi:', data);
                    }
                })
                .catch(err => console.error('Error provinsi:', err));

            // ================= CITIES =================
            document.getElementById('province').addEventListener('change', function() {
                let provinceId = this.value;
                if (!provinceId) return;

                fetch(`/cities?province_id=${provinceId}`)
                    .then(res => res.json())
                    .then(data => {
                        console.log('Cities:', data);
                        let citySelect = document.getElementById('city');
                        citySelect.innerHTML = '<option value="">Pilih Kota</option>';
                        if (data.meta && data.meta.code === 200) {
                            data.data.forEach(city => {
                                let option = document.createElement('option');
                                option.value = city.id;
                                option.textContent = city.name;
                                citySelect.appendChild(option);
                            });
                        } else {
                            console.error('Gagal ambil kota:', data);
                        }
                    })
                    .catch(err => console.error('Error kota:', err));
            });

            // ================= COST =================
            document.getElementById('ongkirForm').addEventListener('submit', function(e) {
                e.preventDefault();

                let origin = 501;
                let destination = document.getElementById('city').value;
                let weight = document.getElementById('weight').value;
                let courier = document.getElementById('courier').value;

                // Validasi
                if (!destination) {
                    alert('Pilih kota tujuan!');
                    return;
                }
                if (!weight || weight <= 0) {
                    alert('Masukkan berat paket!');
                    return;
                }
                if (!courier) {
                    alert('Pilih kurir!');
                    return;
                }

                let csrfToken = document.querySelector('meta[name="csrf-token"]');
                if (!csrfToken) {
                    alert('CSRF token tidak ditemukan!');
                    return;
                }

                // Reset tampilan
                const listLayanan = document.getElementById('list-layanan');
                listLayanan.innerHTML = '<p>Sedang mengambil data...</p>';
                document.getElementById('hasil-ongkir').style.display = 'block';
                document.getElementById('btn-submit').disabled = true;

                fetch('/cost', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .getAttribute('content')
                        },
                        body: JSON.stringify({
                            origin: 3855,
                            destination: destination,
                            weight: weight,
                            courier: courier
                        })
                    })
                    .then(res => res.json())
                    .then(data => {
                        console.log('FULL COST RESPONSE:', data);

                        listLayanan.innerHTML = '';

                        if (!data.meta || data.meta.code !== 200 || !data.data) {
                            listLayanan.innerHTML =
                                '<p style="color:red;">Layanan tidak tersedia.</p>';
                            return;
                        }

                        data.data.forEach(layanan => {
                            const div = document.createElement('div');
                            div.innerHTML = `
                                <label>
                                    <input type="radio" name="pilih_layanan"
                                        data-biaya="${layanan.cost}"
                                        data-etd="${layanan.etd}"
                                        data-layanan="${layanan.service}"
                                        data-kurir="${layanan.code}">
                                    ${layanan.name} - ${layanan.service}
                                    (${layanan.etd}) - Rp ${Number(layanan.cost).toLocaleString('id-ID')}
                                </label>
                            `;
                            listLayanan.appendChild(div);

                            div.querySelector('input[type="radio"]').addEventListener('change',
                                function() {
                                    document.getElementById('biaya_ongkir').value = this
                                        .dataset.biaya;
                                    document.getElementById('layanan_ongkir').value = this
                                        .dataset.layanan;
                                    document.getElementById('estimasi_ongkir').value = this
                                        .dataset.etd;
                                    document.getElementById('kurir_hidden').value = this
                                        .dataset.kurir;
                                    document.getElementById('btn-submit').disabled = false;
                                });
                        });
                    })
                    .catch(err => {
                        console.error('Error ongkir:', err);
                        listLayanan.innerHTML =
                        '<p style="color:red;">Gagal mengambil data ongkir.</p>';
                    });
            });

        });
    </script>
</body>

</html>
