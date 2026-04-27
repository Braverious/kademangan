<x-header :title="$data['title']" />

<main>
    <section class="py-5">
        <div class="container">

            <div class="page-head d-flex align-items-center flex-wrap gap-2 mb-4">
                <a href="{{ route('pelayanan.index') }}" class="back-icon ms-auto" aria-label="Kembali"
                    onclick="if (history.length > 1) { history.back(); return false; }">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                        fill="currentColor" viewBox="0 0 16 16" aria-hidden="true">
                        <path fill-rule="evenodd"
                            d="M15 8a.75.75 0 0 1-.75.75H3.56l3.22 3.22a.75.75 0 1 1-1.06 1.06l-4.5-4.5a.75.75 0 0 1 0-1.06l4.5-4.5a.75.75 0 1 1 1.06 1.06L3.56 7.25h10.69A.75.75 0 0 1 15 8z" />
                    </svg>
                    <span class="ms-2 fw-semibold d-none d-sm-inline">Kembali</span>
                </a>
            </div>

            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h4 mb-1 section-title">{{ $data['title'] }}</h1>
                    <p class="text-muted mb-0">{{ $data['subtitle'] }}</p>
                </div>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>Mohon periksa kembali data yang Anda isi.</strong>
                    <ul class="mb-0 mt-2">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="card shadow-sm brand-card">
                <div class="card-body p-4 p-md-5">
                    <form action="{{ route('pelayanan.sktm.submit') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <h5 class="mb-4 text-primary">Dokumen Pendukung</h5>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label required">Nomor Surat Pengantar RT/RW</label>
                                <input type="text"
                                    name="nomor_surat_rt"
                                    value="{{ old('nomor_surat_rt') }}"
                                    placeholder="Contoh: 012/RT01/RW02/2025"
                                    autocomplete="off"
                                    class="form-control @error('nomor_surat_rt') is-invalid @enderror"
                                    required>
                                @error('nomor_surat_rt')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label required">Tanggal Surat Pengantar RT/RW</label>
                                <input type="date"
                                    name="tanggal_surat_rt"
                                    value="{{ old('tanggal_surat_rt') }}"
                                    class="form-control @error('tanggal_surat_rt') is-invalid @enderror"
                                    required>
                                @error('tanggal_surat_rt')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label class="form-label required">Dokumen Pendukung</label>
                                <input type="file"
                                    name="dokumen_pendukung[]"
                                    class="form-control @error('dokumen_pendukung') is-invalid @enderror @error('dokumen_pendukung.*') is-invalid @enderror"
                                    accept=".jpg,.jpeg,.png,.pdf"
                                    multiple
                                    required>

                                @error('dokumen_pendukung')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror

                                @error('dokumen_pendukung.*')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror

                                <div class="form-text">
                                    Unggah minimal 1 dokumen seperti KTP, KK, dan/atau Surat Pengantar RT/RW.
                                    Maksimal 2 MB per file. Format JPG, PNG, atau PDF.
                                </div>

                                <ul id="dokList" class="small mt-2 text-muted"></ul>
                            </div>
                        </div>

                        <hr class="my-4">

                        <h5 class="mb-4 text-primary">Data Diri Pemohon</h5>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label required">Nama Pemohon</label>
                                <input type="text"
                                    name="nama_pemohon"
                                    value="{{ old('nama_pemohon') }}"
                                    placeholder="Nama lengkap sesuai KTP"
                                    autocomplete="name"
                                    class="form-control @error('nama_pemohon') is-invalid @enderror"
                                    required>
                                @error('nama_pemohon')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label required">NIK Pemohon</label>
                                <input type="text"
                                    name="nik"
                                    value="{{ old('nik') }}"
                                    placeholder="16 digit NIK tanpa spasi"
                                    autocomplete="off"
                                    inputmode="numeric"
                                    maxlength="16"
                                    class="form-control @error('nik') is-invalid @enderror"
                                    required>
                                @error('nik')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label required">Nomor Telepon / WhatsApp</label>
                                <input type="text"
                                    name="telepon_pemohon"
                                    value="{{ old('telepon_pemohon') }}"
                                    placeholder="Nomor WhatsApp aktif, contoh: 08xxxxxxxxxx"
                                    autocomplete="tel"
                                    inputmode="tel"
                                    class="form-control @error('telepon_pemohon') is-invalid @enderror"
                                    required>
                                @error('telepon_pemohon')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label d-block required">Jenis Kelamin</label>

                                <div class="form-check form-check-inline">
                                    <input class="form-check-input @error('jenis_kelamin') is-invalid @enderror"
                                        type="radio"
                                        name="jenis_kelamin"
                                        id="jk_l"
                                        value="Laki-laki"
                                        {{ old('jenis_kelamin', 'Laki-laki') === 'Laki-laki' ? 'checked' : '' }}
                                        required>
                                    <label class="form-check-label" for="jk_l">Laki-laki</label>
                                </div>

                                <div class="form-check form-check-inline">
                                    <input class="form-check-input @error('jenis_kelamin') is-invalid @enderror"
                                        type="radio"
                                        name="jenis_kelamin"
                                        id="jk_p"
                                        value="Perempuan"
                                        {{ old('jenis_kelamin') === 'Perempuan' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="jk_p">Perempuan</label>
                                </div>

                                @error('jenis_kelamin')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label required">Tempat Lahir</label>
                                <input type="text"
                                    name="tempat_lahir"
                                    value="{{ old('tempat_lahir') }}"
                                    placeholder="Kota/Kabupaten lahir"
                                    autocomplete="address-level2"
                                    class="form-control @error('tempat_lahir') is-invalid @enderror"
                                    required>
                                @error('tempat_lahir')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label required">Tanggal Lahir</label>
                                <input type="date"
                                    name="tanggal_lahir"
                                    value="{{ old('tanggal_lahir') }}"
                                    autocomplete="bday"
                                    class="form-control @error('tanggal_lahir') is-invalid @enderror"
                                    required>
                                @error('tanggal_lahir')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label required">Agama</label>
                                <input type="text"
                                    name="agama"
                                    value="{{ old('agama') }}"
                                    placeholder="Misal: Islam"
                                    autocomplete="off"
                                    class="form-control @error('agama') is-invalid @enderror"
                                    required>
                                @error('agama')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label required">Pekerjaan</label>
                                <input type="text"
                                    name="pekerjaan"
                                    value="{{ old('pekerjaan') }}"
                                    placeholder="Misal: Karyawan Swasta"
                                    autocomplete="organization-title"
                                    class="form-control @error('pekerjaan') is-invalid @enderror"
                                    required>
                                @error('pekerjaan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label required">Kewarganegaraan</label>
                                <input type="text"
                                    name="warganegara"
                                    value="{{ old('warganegara', 'Indonesia') }}"
                                    placeholder="Misal: Indonesia"
                                    autocomplete="country-name"
                                    class="form-control @error('warganegara') is-invalid @enderror"
                                    required>
                                @error('warganegara')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label required">Penghasilan Bulanan</label>
                                <select name="penghasilan_bulanan"
                                    class="form-select @error('penghasilan_bulanan') is-invalid @enderror"
                                    required>
                                    <option value="">— Pilih rentang penghasilan —</option>
                                    <option value="Kurang dari Rp 1.000.000" {{ old('penghasilan_bulanan') === 'Kurang dari Rp 1.000.000' ? 'selected' : '' }}>
                                        Kurang dari Rp 1.000.000
                                    </option>
                                    <option value="Rp 1.000.000 - Rp 2.500.000" {{ old('penghasilan_bulanan') === 'Rp 1.000.000 - Rp 2.500.000' ? 'selected' : '' }}>
                                        Rp 1.000.000 - Rp 2.500.000
                                    </option>
                                    <option value="Rp 2.500.001 - Rp 4.000.000" {{ old('penghasilan_bulanan') === 'Rp 2.500.001 - Rp 4.000.000' ? 'selected' : '' }}>
                                        Rp 2.500.001 - Rp 4.000.000
                                    </option>
                                    <option value="Lebih dari Rp 4.000.000" {{ old('penghasilan_bulanan') === 'Lebih dari Rp 4.000.000' ? 'selected' : '' }}>
                                        Lebih dari Rp 4.000.000
                                    </option>
                                </select>
                                @error('penghasilan_bulanan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label class="form-label required">Alamat</label>
                                <textarea name="alamat"
                                    rows="3"
                                    placeholder="Sesuai KTP: Jalan, RT/RW, Kelurahan, Kecamatan, Kota/Kabupaten, Kode Pos"
                                    autocomplete="street-address"
                                    class="form-control @error('alamat') is-invalid @enderror"
                                    required>{{ old('alamat') }}</textarea>
                                @error('alamat')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <hr class="my-4">

                        <h5 class="mb-4 text-primary">Data Keterangan</h5>

                        <div class="row g-4">
                            <div class="col-md-6">
                                <label class="form-label required">Nama Orang Tua</label>
                                <input type="text"
                                    name="nama_orang_tua"
                                    value="{{ old('nama_orang_tua') }}"
                                    placeholder="Nama lengkap ibu kandung"
                                    autocomplete="off"
                                    class="form-control @error('nama_orang_tua') is-invalid @enderror"
                                    required>
                                @error('nama_orang_tua')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">*Nama Ibu Kandung</div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">ID DTKS / DTSEN</label>
                                <input type="text"
                                    name="id_dtks"
                                    value="{{ old('id_dtks') }}"
                                    placeholder="Jika ada, masukkan ID DTKS / DTSEN"
                                    autocomplete="off"
                                    class="form-control @error('id_dtks') is-invalid @enderror">
                                @error('id_dtks')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label required">Keperluan Surat</label>
                                <input type="text"
                                    name="keperluan"
                                    value="{{ old('keperluan') }}"
                                    placeholder="Contoh: Pengajuan Beasiswa Pendidikan"
                                    class="form-control @error('keperluan') is-invalid @enderror"
                                    required>
                                @error('keperluan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12 mt-3">
                                <div class="form-check">
                                    <input class="form-check-input @error('agree') is-invalid @enderror"
                                        type="checkbox"
                                        name="agree"
                                        value="1"
                                        id="agree_sktm"
                                        {{ old('agree') ? 'checked' : '' }}
                                        required>
                                    <label class="form-check-label" for="agree_sktm">
                                        Saya menyatakan data yang saya isi adalah benar.
                                    </label>
                                    @error('agree')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="d-flex gap-2 justify-content-end mt-4">
                            <button type="reset" class="btn btn-light">Reset</button>
                            <button type="submit" class="btn btn-primary">Kirim Pengajuan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</main>

<x-footer />

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const input = document.querySelector('input[name="dokumen_pendukung[]"]');
        const list = document.getElementById('dokList');

        if (!input || !list) {
            return;
        }

        input.addEventListener('change', function () {
            list.innerHTML = '';

            Array.from(input.files).forEach(function (file) {
                const item = document.createElement('li');
                const sizeKb = Math.round(file.size / 1024);

                item.textContent = `${file.name} (${sizeKb} KB)`;
                list.appendChild(item);
            });
        });
    });
</script>