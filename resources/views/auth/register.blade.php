<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @php $siteSettings = \App\Models\SiteSetting::find(1); @endphp
    @if ($siteSettings && $siteSettings->favicon)
        <link rel="icon" href="{{ asset('storage/' . $siteSettings->favicon) }}?v={{ time() }}"
            type="image/x-icon">
    @endif

    <title>{{ $title ?? 'Register Warga' }}</title>

    <link rel="stylesheet" href="{{ asset('assets/css/login_custom.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        html {
            background-color: #f4f7f6 !important;
        }

        body.login {
            height: auto !important;
            min-height: 100vh;
            display: block !important;
            padding: 20px 15px;
            overflow-y: auto !important;
            background-color: #f4f7f6;
        }

        .register-container {
            max-width: 750px;
            margin: 0 auto;
            background: #fff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            position: relative;
            z-index: 10;
        }

        .register-title {
            text-align: center;
            font-size: 28px;
            color: #333;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .register-subtitle {
            text-align: center;
            color: #f39c12;
            font-weight: 600;
            font-size: 14px;
            margin-bottom: 30px;
        }

        .custom-tabs {
            display: flex;
            border-bottom: 2px solid #edf2f9;
            margin-bottom: 25px;
        }

        .custom-tab {
            flex: 1;
            text-align: center;
            padding: 12px 20px;
            cursor: pointer;
            font-weight: 600;
            color: #888;
            transition: 0.3s;
        }

        .custom-tab.active {
            color: #1a73e8;
            border-bottom: 2px solid #1a73e8;
            background: rgba(26, 115, 232, 0.03);
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px 20px;
            margin-bottom: 20px;
        }

        .form-group-full {
            grid-column: span 2;
        }

        .form-group label {
            display: block;
            font-weight: 600;
            color: #444;
            font-size: 13px;
            margin-bottom: 6px;
        }

        .form-control {
            width: 100%;
            padding: 10px 15px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 14px;
            box-sizing: border-box;
        }

        .input-group {
            display: flex;
            width: 100%;
        }

        .input-group-addon {
            display: flex;
            align-items: center;
            padding: 0 15px;
            background: #f1f5f9;
            border: 1px solid #ddd;
            border-right: none;
            color: #475569;
            border-radius: 6px 0 0 6px;
            font-weight: 600;
            font-size: 14px;
        }

        .input-group .form-control {
            border-radius: 0 6px 6px 0 !important;
        }

        h5.section-title {
            font-size: 1.1rem;
            margin-top: 24px !important;
            border-bottom: 2px solid #edf2f9;
            padding-bottom: 8px;
            color: #1a73e8;
        }

        .extra-fields {
            display: none;
            grid-column: span 2;
        }

        .modern-confirmation-card {
            display: flex;
            align-items: flex-start;
            gap: 16px;
            padding: 20px;
            border: 2px solid #edf2f7;
            border-radius: 12px;
            cursor: pointer;
            transition: 0.3s;
        }

        .hidden-checkbox {
            position: absolute;
            opacity: 0;
        }

        .checkbox-box {
            margin-top: 2px;
            width: 24px;
            height: 24px;
            border: 2px solid #cbd5e0;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            background: white;
        }

        .hidden-checkbox:checked~.checkbox-box {
            background: #1a73e8;
            border-color: #1a73e8;
        }

        .hidden-checkbox:checked~.checkbox-box i {
            display: block;
            color: white;
        }

        .checkbox-box i {
            display: none;
            font-size: 12px;
        }

        .confirmation-content p {
            margin: 0;
            line-height: 1.5;
        }

        .main-statement {
            color: #2d3748;
            font-size: 0.95rem;
            font-weight: 500;
        }

        .sub-statement {
            color: #718096;
            font-size: 0.85rem;
        }

        .btn-primary {
            background-color: #1a73e8;
            color: white;
            border: none;
            border-radius: 6px;
            padding: 14px;
            font-weight: bold;
            width: 100%;
            cursor: pointer;
            font-size: 16px;
            transition: 0.3s;
        }

        @media (max-width: 650px) {
            .form-grid {
                grid-template-columns: 1fr;
            }

            .form-group-full {
                grid-column: span 1;
            }

            .custom-tabs {
                flex-direction: column;
            }
        }
    </style>
</head>

<body class="login">
    <div class="register-container">
        <h1 class="register-title">Register Warga</h1>
        <p class="register-subtitle">Isi sesuai dengan data pada kartu identitas Anda.</p>

        <form action="{{ route('auth.register.process') }}" method="POST">
            @csrf
            <input type="hidden" name="is_kademangan" id="is_kademangan" value="{{ old('is_kademangan', '1') }}">

            <div class="custom-tabs">
                <div class="custom-tab {{ old('is_kademangan', '1') == '1' ? 'active' : '' }}" id="tab-lokal"
                    onclick="switchTab(1)">
                    Penduduk Kademangan
                </div>
                <div class="custom-tab {{ old('is_kademangan') == '0' ? 'active' : '' }}" id="tab-luar"
                    onclick="switchTab(0)">
                    Penduduk Non Kademangan
                </div>
            </div>

            <div class="form-grid">
                <div class="form-group form-group-full">
                    <h5 class="section-title">1. Informasi Akun</h5>
                </div>

                <div class="form-group">
                    <label>NIK (Username)</label>
                    <input type="text" name="nik" class="form-control" value="{{ old('nik') }}" required
                        maxlength="16">
                </div>
                <div class="form-group">
                    <label>No. KK</label>
                    <input type="text" name="no_kk" class="form-control" value="{{ old('no_kk') }}" required
                        maxlength="16">
                </div>

                <!-- Password Field -->
                <div class="form-group">
                    <label>Password</label>
                    <div style="position: relative;">
                        <input type="password" name="password" id="password" class="form-control" required
                            placeholder="Minimal 8 karakter">
                        <!-- PERBAIKAN: Tambah class toggle-password dan data-target -->
                        <i class="fas fa-eye toggle-password" data-target="password"
                            style="position: absolute; right: 15px; top: 50%; transform: translateY(-50%); cursor: pointer; color: #94a3b8;"></i>
                    </div>

                    <div class="password-strength-container" style="margin-top: 10px;">
                        <div
                            style="height: 6px; background: #e2e8f0; border-radius: 10px; overflow: hidden; display: flex; gap: 4px;">
                            <div id="bar-1" style="flex: 1; height: 100%; background: #e2e8f0; transition: 0.3s;">
                            </div>
                            <div id="bar-2" style="flex: 1; height: 100%; background: #e2e8f0; transition: 0.3s;">
                            </div>
                            <div id="bar-3" style="flex: 1; height: 100%; background: #e2e8f0; transition: 0.3s;">
                            </div>
                            <div id="bar-4" style="flex: 1; height: 100%; background: #e2e8f0; transition: 0.3s;">
                            </div>
                        </div>
                        <div style="display: flex; justify-content: space-between; margin-top: 5px;">
                            <small id="strength-text"
                                style="font-size: 11px; font-weight: 700; color: #94a3b8; text-transform: uppercase;">Kekuatan:
                                -</small>
                            <small id="match-text"
                                style="font-size: 11px; font-weight: 700; color: #e53e3e; display: none;">Password tidak
                                cocok!</small>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>Konfirmasi Password</label>
                    <div style="position: relative;">
                        <input type="password" name="password_confirmation" id="password_confirmation"
                            class="form-control" required placeholder="Ulangi password">
                        <i class="fas fa-eye toggle-password" data-target="password_confirmation"
                            style="position: absolute; right: 15px; top: 50%; transform: translateY(-50%); cursor: pointer; color: #94a3b8;"></i>
                    </div>
                </div>

                <div class="form-group form-group-full">
                    <h5 class="section-title">2. Data Pribadi Sesuai KTP</h5>
                </div>

                <div class="form-group form-group-full">
                    <label>Nama Lengkap</label>
                    <input type="text" name="full_name" class="form-control" value="{{ old('full_name') }}"
                        required>
                </div>
                <div class="form-group">
                    <label>Tempat Lahir</label>
                    <input type="text" name="birth_place" class="form-control" value="{{ old('birth_place') }}"
                        required>
                </div>
                <div class="form-group">
                    <label>Tanggal Lahir</label>
                    <input type="date" name="birth_date" class="form-control" value="{{ old('birth_date') }}"
                        required>
                </div>
                <div class="form-group">
                    <label>Agama</label>
                    <select name="religion" class="form-control" required>
                        <option value="">-- Pilih Agama --</option>
                        @foreach (['Islam', 'Kristen', 'Katolik', 'Hindu', 'Budha', 'Khonghucu'] as $r)
                            <option value="{{ $r }}">{{ $r }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>Status Perkawinan</label>
                    <select name="marital_status" class="form-control" required>
                        <option value="">-- Pilih Status --</option>
                        @foreach (['Belum Kawin', 'Kawin', 'Cerai Hidup', 'Cerai Mati'] as $s)
                            <option value="{{ $s }}">{{ $s }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>Pekerjaan</label>
                    <select name="occupation" class="form-control" required>
                        <option value="">-- Pilih Pekerjaan --</option>
                        @foreach (['PNS', 'TNI', 'POLRI', 'Karyawan Swasta', 'Wiraswasta', 'Buruh Harian Lepas', 'Petani/Pekebun', 'Ibu Rumah Tangga', 'Pelajar/Mahasiswa', 'Belum/Tidak Bekerja'] as $p)
                            <option value="{{ $p }}">{{ $p }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>No. Handphone (WhatsApp)</label>
                    <div class="input-group">
                        <span class="input-group-addon">+62</span>
                        <input type="text" name="notelp" class="form-control" value="{{ old('notelp') }}"
                            required>
                    </div>
                </div>

                <div class="form-group form-group-full">
                    <h5 class="section-title">3. Alamat & Hubungan Keluarga</h5>
                </div>

                <!-- Area Luar -->
                <div class="extra-fields" id="area-luar">
                    <div class="form-grid" style="margin-bottom: 0;">
                        <div class="form-group">
                            <label>Provinsi</label>
                            <select name="province" id="inp_province" class="form-control">
                                <option value="">-- Pilih Provinsi --</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Kota/Kabupaten</label>
                            <select name="city" id="inp_city" class="form-control" disabled>
                                <option value="">-- Pilih Kota --</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Kecamatan</label>
                            <select name="district" id="inp_district" class="form-control" disabled>
                                <option value="">-- Pilih Kecamatan --</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Kelurahan/Desa</label>
                            <select name="village" id="inp_village" class="form-control" disabled>
                                <option value="">-- Pilih Kelurahan --</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-group form-group-full">
                    <label>Nama Kepala Keluarga <small class="text-muted">(Opsional)</small></label>
                    <input type="text" name="family_head_name" class="form-control"
                        placeholder="Isi jika Anda anggota keluarga">
                </div>
                <div class="form-group form-group-full">
                    <label>Alamat Lengkap</label>
                    <input type="text" name="address" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>RT</label>
                    <input type="text" name="rt" class="form-control" placeholder="000" maxlength="3"
                        required>
                </div>
                <div class="form-group">
                    <label>RW</label>
                    <select name="rw" id="rw_kademangan" class="form-control" required>
                        <option value="">-- Pilih RW --</option>
                        @foreach (range(1, 9) as $i)
                            <option value="{{ str_pad($i, 3, '0', STR_PAD_LEFT) }}">
                                {{ str_pad($i, 3, '0', STR_PAD_LEFT) }}</option>
                        @endforeach
                    </select>
                    <input type="text" name="rw" id="rw_luar" class="form-control" placeholder="000"
                        maxlength="3" style="display:none;">
                </div>
            </div>

            <!-- Konfirmasi -->
            <div class="modern-checkbox-container">
                <label class="modern-confirmation-card">
                    <input type="checkbox" id="check_konfirmasi" class="hidden-checkbox" required>
                    <div class="checkbox-box"><i class="fas fa-check"></i></div>
                    <div class="confirmation-content">
                        <p class="main-statement">Saya menyatakan bahwa seluruh data yang saya masukkan adalah
                            <strong>benar dan sesuai dokumen asli.</strong>
                        </p>
                        <p class="sub-statement">Saya bersedia menanggung konsekuensi hukum jika data tidak valid.</p>
                    </div>
                </label>
            </div>

            <button type="submit" id="btn_submit" class="btn-primary">Daftar Sekarang</button>
        </form>

        <div class="login-footer" style="margin-top: 25px; text-align: center; font-size: 0.9em;">
            <p>Sudah punya akun? <a href="{{ route('login') }}"
                    style="color: #1a73e8; font-weight: bold; text-decoration: none;">Login di sini</a></p>
        </div>
    </div>

    <script>
        // 1. Fungsi Ganti Tab
        function switchTab(isKademangan) {
            document.getElementById('is_kademangan').value = isKademangan;
            const rwKademangan = document.getElementById('rw_kademangan');
            const rwLuar = document.getElementById('rw_luar');
            const areaLuar = document.getElementById('area-luar');

            if (isKademangan === 1) {
                document.getElementById('tab-lokal').classList.add('active');
                document.getElementById('tab-luar').classList.remove('active');
                areaLuar.style.display = 'none';
                rwKademangan.style.display = 'block';
                rwKademangan.disabled = false;
                rwLuar.style.display = 'none';
                rwLuar.disabled = true;
            } else {
                document.getElementById('tab-luar').classList.add('active');
                document.getElementById('tab-lokal').classList.remove('active');
                areaLuar.style.display = 'block';
                rwKademangan.style.display = 'none';
                rwKademangan.disabled = true;
                rwLuar.style.display = 'block';
                rwLuar.disabled = false;
            }
        }

        // 2. Logika Password & General DOM
        document.addEventListener('DOMContentLoaded', function() {
            const password = document.getElementById('password');
            const confirm = document.getElementById('password_confirmation');
            const strengthText = document.getElementById('strength-text');
            const matchText = document.getElementById('match-text');
            const btnSubmit = document.getElementById('btn_submit');
            const checkbox = document.getElementById('check_konfirmasi');
            const bars = [
                document.getElementById('bar-1'),
                document.getElementById('bar-2'),
                document.getElementById('bar-3'),
                document.getElementById('bar-4')
            ];

            // Toggle Mata
            document.querySelectorAll('.toggle-password').forEach(icon => {
                icon.addEventListener('click', function() {
                    const targetId = this.getAttribute('data-target');
                    const input = document.getElementById(targetId);
                    const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
                    input.setAttribute('type', type);
                    this.classList.toggle('fa-eye');
                    this.classList.toggle('fa-eye-slash');
                });
            });

            // Kekuatan Password
            password.addEventListener('input', function() {
                const val = this.value;
                let score = 0;
                if (val.length === 0) {
                    updateUI(0, "-", "#e2e8f0");
                    return;
                }
                if (val.length >= 8) score++;
                if (/[A-Z]/.test(val)) score++;
                if (/[0-9]/.test(val)) score++;
                if (/[^A-Za-z0-9]/.test(val)) score++;

                const levels = [{
                        text: "Sangat Lemah",
                        color: "#e53e3e"
                    },
                    {
                        text: "Lemah",
                        color: "#f6ad55"
                    },
                    {
                        text: "Cukup",
                        color: "#f6e05e"
                    },
                    {
                        text: "Kuat",
                        color: "#48bb78"
                    }
                ];

                if (score > 0) updateUI(score, levels[score - 1].text, levels[score - 1].color);
                else updateUI(1, "Terlalu Pendek", "#cbd5e0");
                checkMatch();
            });

            function updateUI(score, text, color) {
                strengthText.innerText = "Kekuatan: " + text;
                strengthText.style.color = score > 0 ? color : "#94a3b8";
                bars.forEach((bar, index) => {
                    bar.style.backgroundColor = (index < score) ? color : "#e2e8f0";
                });
            }

            function checkMatch() {
                if (confirm.value.length > 0) {
                    if (password.value !== confirm.value) {
                        matchText.style.display = "block";
                        confirm.style.borderColor = "#e53e3e";
                    } else {
                        matchText.style.display = "none";
                        confirm.style.borderColor = "#48bb78";
                    }
                }
            }
            confirm.addEventListener('input', checkMatch);

            // Checkbox Submit
            checkbox.addEventListener('change', function() {
                btnSubmit.disabled = !this.checked;
                btnSubmit.style.opacity = this.checked ? "1" : "0.6";
            });

            // Init awal
            switchTab(1);
            btnSubmit.disabled = true;
            btnSubmit.style.opacity = "0.6";
        });

        // 3. API Wilayah
        const apiUrl = 'https://www.emsifa.com/api-wilayah-indonesia/api';
        const elProv = document.getElementById('inp_province');
        const elKota = document.getElementById('inp_city');
        const elKec = document.getElementById('inp_district');
        const elKel = document.getElementById('inp_village');

        function sortData(data) {
            return data.sort((a, b) => a.name.localeCompare(b.name));
        }

        fetch(`${apiUrl}/provinces.json`)
            .then(res => res.json())
            .then(provinces => {
                sortData(provinces).forEach(prov => {
                    let option = new Option(prov.name, prov.name);
                    option.dataset.id = prov.id;
                    elProv.add(option);
                });
            });

        elProv.addEventListener('change', function() {
            const idProv = this.options[this.selectedIndex]?.dataset.id;
            elKota.innerHTML = '<option value="">-- Pilih Kota/Kabupaten --</option>';
            elKec.innerHTML = '<option value="">-- Pilih Kecamatan --</option>';
            elKel.innerHTML = '<option value="">-- Pilih Kelurahan/Desa --</option>';
            if (idProv) {
                elKota.disabled = false;
                fetch(`${apiUrl}/regencies/${idProv}.json`).then(res => res.json()).then(regencies => {
                    sortData(regencies).forEach(kota => {
                        let option = new Option(kota.name, kota.name);
                        option.dataset.id = kota.id;
                        elKota.add(option);
                    });
                });
            }
        });

        elKota.addEventListener('change', function() {
            const idKota = this.options[this.selectedIndex]?.dataset.id;
            elKec.innerHTML = '<option value="">-- Pilih Kecamatan --</option>';
            if (idKota) {
                elKec.disabled = false;
                fetch(`${apiUrl}/districts/${idKota}.json`).then(res => res.json()).then(districts => {
                    sortData(districts).forEach(kec => {
                        let option = new Option(kec.name, kec.name);
                        option.dataset.id = kec.id;
                        elKec.add(option);
                    });
                });
            }
        });

        elKec.addEventListener('change', function() {
            const idKec = this.options[this.selectedIndex]?.dataset.id;
            elKel.innerHTML = '<option value="">-- Pilih Kelurahan/Desa --</option>';
            if (idKec) {
                elKel.disabled = false;
                fetch(`${apiUrl}/villages/${idKec}.json`).then(res => res.json()).then(villages => {
                    sortData(villages).forEach(kel => {
                        let option = new Option(kel.name, kel.name);
                        option.dataset.id = kel.id;
                        elKel.add(option);
                    });
                });
            }
        });
    </script>
</body>

</html>
