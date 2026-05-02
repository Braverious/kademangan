<x-admin.header :title="$title" />
<x-admin.sidebar />

<div class="page-inner">
    <x-admin.breadcrumbs :title="$title" :breadcrumbs="$breadcrumbs" />
    <div class="row">
        <div class="col-md-12">
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Form Tambah Warga Baru</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.settings.citizens.store') }}" method="POST">
                        @csrf

                        <!-- SECTION 1: DATA AKUN -->
                        <h5 class="fw-bold mb-3 text-primary">A. Data Akun & Keamanan</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>NIK (Username)</label>
                                    <input type="text" name="nik" class="form-control"
                                        value="{{ old('nik') }}" required maxlength="16">
                                    <small class="text-muted">NIK akan digunakan warga untuk login.</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Password</label>
                                    <input type="password" name="password" class="form-control" required>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <!-- SECTION 2: IDENTITAS PRIBADI -->
                        <h5 class="fw-bold mb-3 text-primary">B. Identitas Pribadi</h5>
                        <div class="form-group">
                            <label>Nama Lengkap (Sesuai KTP)</label>
                            <input type="text" name="full_name" class="form-control" value="{{ old('full_name') }}"
                                required>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Tempat Lahir</label>
                                    <input type="text" name="birth_place" class="form-control"
                                        value="{{ old('birth_place') }}" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Tanggal Lahir</label>
                                    <input type="date" name="birth_date" class="form-control"
                                        value="{{ old('birth_date') }}" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Agama</label>
                                    <select name="religion" class="form-control">
                                        @foreach (['Islam', 'Kristen', 'Katolik', 'Hindu', 'Budha', 'Khonghucu'] as $rel)
                                            <option value="{{ $rel }}"
                                                {{ old('religion') == $rel ? 'selected' : '' }}>{{ $rel }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Status Perkawinan</label>
                                    <select name="marital_status" class="form-control">
                                        @foreach (['Belum Kawin', 'Kawin', 'Cerai Hidup', 'Cerai Mati'] as $status)
                                            <option value="{{ $status }}"
                                                {{ old('marital_status') == $status ? 'selected' : '' }}>
                                                {{ $status }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Pekerjaan</label>
                                    <input type="text" name="occupation" class="form-control"
                                        value="{{ old('occupation') }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Kewarganegaraan</label>
                                    <input type="text" name="nationality" class="form-control"
                                        value="{{ old('nationality', 'WNI') }}" required>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <!-- SECTION 3: DATA KELUARGA & ALAMAT -->
                        <h5 class="fw-bold mb-3 text-primary">C. Data Keluarga & Domisili</h5>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>No. KK</label>
                                    <input type="text" name="no_kk" class="form-control"
                                        value="{{ old('no_kk') }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Nama Kepala Keluarga</label>
                                    <input type="text" name="family_head_name" class="form-control"
                                        value="{{ old('family_head_name') }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Masa Berlaku KTP</label>
                                    <input type="text" name="ktp_expiry" class="form-control"
                                        value="{{ old('ktp_expiry', 'Seumur Hidup') }}">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Alamat Lengkap</label>
                            <textarea name="address" class="form-control" rows="2">{{ old('address') }}</textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>RT</label>
                                    <input type="text" name="rt" class="form-control" placeholder="001"
                                        value="{{ old('rt') }}" required>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>RW <span class="text-danger">*</span></label>
                                    <select name="rw" class="form-control" required>
                                        <option value="">-- Pilih RW --</option>
                                        @foreach (range(1, 9) as $i)
                                            @php $val = sprintf('%03d', $i); @endphp
                                            <option value="{{ $val }}"
                                                {{ old('rw') == $val ? 'selected' : '' }}>
                                                RW {{ $val }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Kelurahan/Desa</label>
                                    <input type="text" name="village" class="form-control"
                                        value="{{ old('village', 'Kademangan') }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Kecamatan</label>
                                    <input type="text" name="district" class="form-control"
                                        value="{{ old('district', 'Setu') }}">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Kota/Kabupaten</label>
                            <input type="text" name="city" class="form-control"
                                value="{{ old('city', 'Tangerang Selatan') }}">
                        </div>

                        <div class="card-action mt-3">
                            <button type="submit" class="btn btn-primary mr-2">Simpan Data Warga</button>
                            <a href="{{ route('admin.settings.citizens.index') }}"
                                class="btn btn-secondary">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<x-admin.footer />
