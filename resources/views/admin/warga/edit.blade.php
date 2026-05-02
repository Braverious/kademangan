<x-admin.header :title="$title" />
<x-admin.sidebar />
<div class="page-inner">
    <x-admin.breadcrumbs :title="$title" :breadcrumbs="$breadcrumbs" />
    <div class="row">
        <div class="col-md-12">
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
                    <h4 class="card-title">Edit Data: {{ $user->citizenDetail->full_name }}</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.settings.citizens.update', $user->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- A. DATA AKUN -->
                        <h5 class="fw-bold mb-3 text-primary">A. Data Akun & Keamanan</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>NIK (Username)</label>
                                    <input type="text" name="nik" class="form-control"
                                        value="{{ old('nik', $user->username) }}" required maxlength="16">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Password <small class="text-danger">(Kosongkan jika tidak ingin
                                            mengubah)</small></label>
                                    <input type="password" name="password" class="form-control">
                                </div>
                            </div>
                        </div>

                        <hr>

                        <!-- B. IDENTITAS PRIBADI -->
                        <h5 class="fw-bold mb-3 text-primary">B. Identitas Pribadi</h5>
                        <div class="form-group">
                            <label>Nama Lengkap</label>
                            <input type="text" name="full_name" class="form-control"
                                value="{{ old('full_name', $user->citizenDetail->full_name) }}" required>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Tempat Lahir</label>
                                    <input type="text" name="birth_place" class="form-control"
                                        value="{{ old('birth_place', $user->citizenDetail->birth_place) }}" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Tanggal Lahir</label>
                                    <input type="date" name="birth_date" class="form-control"
                                        value="{{ old('birth_date', $user->citizenDetail->birth_date) }}" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Agama</label>
                                    <select name="religion" class="form-control">
                                        @foreach (['Islam', 'Kristen', 'Katolik', 'Hindu', 'Budha', 'Khonghucu'] as $rel)
                                            <option value="{{ $rel }}"
                                                {{ old('religion', $user->citizenDetail->religion) == $rel ? 'selected' : '' }}>
                                                {{ $rel }}</option>
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
                                        @foreach (['Belum Kawin', 'Kawin', 'Cerai Hidup', 'Cerai Mati'] as $st)
                                            <option value="{{ $st }}"
                                                {{ old('marital_status', $user->citizenDetail->marital_status) == $st ? 'selected' : '' }}>
                                                {{ $st }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Pekerjaan</label>
                                    <input type="text" name="occupation" class="form-control"
                                        value="{{ old('occupation', $user->citizenDetail->occupation) }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Kewarganegaraan</label>
                                    <input type="text" name="nationality" class="form-control"
                                        value="{{ old('nationality', $user->citizenDetail->nationality) }}" required>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <!-- C. DATA KELUARGA & DOMISILI -->
                        <h5 class="fw-bold mb-3 text-primary">C. Data Keluarga & Domisili</h5>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>No. KK</label>
                                    <input type="text" name="no_kk" class="form-control"
                                        value="{{ old('no_kk', $user->citizenDetail->no_kk) }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Nama Kepala Keluarga</label>
                                    <input type="text" name="family_head_name" class="form-control"
                                        value="{{ old('family_head_name', $user->citizenDetail->family_head_name) }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Masa Berlaku KTP</label>
                                    <input type="text" name="ktp_expiry" class="form-control"
                                        value="{{ old('ktp_expiry', $user->citizenDetail->ktp_expiry) }}">
                                </div>
                            </div>
                        </div>

                        <div class="row mt-2">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>RT</label>
                                    <input type="text" name="rt" class="form-control"
                                        value="{{ old('rt', $user->citizenDetail->rt) }}" required>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>RW</label>
                                    <select name="rw" class="form-control" required>
                                        @foreach (range(1, 9) as $i)
                                            @php $val = sprintf('%03d', $i); @endphp
                                            <option value="{{ $val }}"
                                                {{ old('rw', $user->citizenDetail->rw) == $val ? 'selected' : '' }}>RW
                                                {{ $val }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="card-action mt-3">
                            <button type="submit" class="btn btn-success">Update Data Warga</button>
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
