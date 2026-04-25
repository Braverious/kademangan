<x-admin.header :title="$title" />
<x-admin.sidebar />

@php
    $can_full = isset($can_full_edit) && $can_full_edit === true;
    $ro = $can_full ? '' : 'readonly';
    $dis = $can_full ? '' : 'disabled';

    $files = [];
    if (!empty($surat->dokumen_pendukung)) {
        $dec = json_decode($surat->dokumen_pendukung, true);
        $files = is_array($dec) ? $dec : [$surat->dokumen_pendukung];
    }
@endphp

<div class="page-inner">

    <!-- HEADER -->
    <div class="page-header">
        <h4 class="page-title">Edit Ket. Belum Bekerja</h4>
        <ul class="breadcrumbs">
            <li class="nav-home">
                <a href="{{ route('admin.dashboard') }}">
                    <i class="flaticon-home"></i>
                </a>
            </li>
            <li class="separator"><i class="flaticon-right-arrow"></i></li>
            <li class="nav-item">
                <a href="{{ route('admin.belum-bekerja.index') }}">Data Ket. Belum Bekerja</a>
            </li>
            <li class="separator"><i class="flaticon-right-arrow"></i></li>
            <li class="nav-item"><a>Edit Data</a></li>
        </ul>
    </div>

    @if (!$can_full)
        <div class="alert alert-info">
            Anda login sebagai <b>admin</b>. Hanya bisa ubah <b>Status</b> dan <b>Nomor Surat</b>.
        </div>
    @endif

    <div class="row">
        <div class="col-md-12">
            <div class="card">

                <!-- HEADER -->
                <div class="card-header d-flex align-items-center">
                    <h4 class="card-title">
                        Formulir Edit: {{ $surat->nama_pemohon }}
                    </h4>

                    <a href="{{ route('admin.belum-bekerja.detail', $surat->id) }}"
                        class="btn btn-secondary btn-round ml-auto">
                        Batal
                    </a>
                </div>

                <!-- FORM -->
                <form action="{{ route('admin.belum-bekerja.update', $surat->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="card-body">

                        <!-- ADMINISTRASI -->
                        <h5>Administrasi Surat</h5>
                        <div class="row">

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Nomor Surat</label>
                                    <input type="text" name="nomor_surat" class="form-control"
                                        value="{{ $surat->nomor_surat }}">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Status</label>
                                    <select name="status" class="form-control">
                                        <option value="Pending" {{ $surat->status == 'Pending' ? 'selected' : '' }}>
                                            Pending</option>
                                        <option value="Disetujui" {{ $surat->status == 'Disetujui' ? 'selected' : '' }}>
                                            Disetujui</option>
                                        <option value="Ditolak" {{ $surat->status == 'Ditolak' ? 'selected' : '' }}>
                                            Ditolak</option>
                                    </select>
                                </div>
                            </div>

                        </div>

                        <hr>

                        <!-- DATA DIRI -->
                        <h5>Data Diri Pemohon</h5>
                        <div class="row">

                            <div class="col-md-6">
                                <input type="text" name="nama_pemohon" class="form-control mb-2"
                                    value="{{ $surat->nama_pemohon }}" {{ $ro }} placeholder="Nama">
                            </div>

                            <div class="col-md-6">
                                <input type="text" name="nik" class="form-control mb-2"
                                    value="{{ $surat->nik }}" {{ $ro }} placeholder="NIK">
                            </div>

                            <div class="col-md-6">
                                <input type="text" name="telepon_pemohon" class="form-control mb-2"
                                    value="{{ $surat->telepon_pemohon }}" {{ $ro }}>
                            </div>

                            <div class="col-md-6">
                                <input type="text" name="tempat_lahir" class="form-control mb-2"
                                    value="{{ $surat->tempat_lahir }}" {{ $ro }}>
                            </div>

                            <div class="col-md-6">
                                <input type="date" name="tanggal_lahir" class="form-control mb-2"
                                    value="{{ $surat->tanggal_lahir }}" {{ $ro }}>
                            </div>

                            <div class="col-md-6">
                                <select name="jenis_kelamin" class="form-control mb-2" {{ $dis }}>
                                    <option value="Laki-laki"
                                        {{ $surat->jenis_kelamin == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="Perempuan"
                                        {{ $surat->jenis_kelamin == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <input type="text" name="warganegara" class="form-control mb-2"
                                    value="{{ $surat->warganegara }}" {{ $ro }}>
                            </div>

                            <div class="col-md-6">
                                <input type="text" name="agama" class="form-control mb-2"
                                    value="{{ $surat->agama }}" {{ $ro }}>
                            </div>

                            <div class="col-md-6">
                                <input type="text" name="pekerjaan" class="form-control mb-2"
                                    value="{{ $surat->pekerjaan }}" {{ $ro }}>
                            </div>

                            <div class="col-12">
                                <textarea name="alamat" class="form-control mb-2" {{ $ro }}>
{{ $surat->alamat }}
                                </textarea>
                            </div>

                            <div class="col-12">
                                <input type="text" name="keperluan" class="form-control mb-2"
                                    value="{{ $surat->keperluan }}" {{ $ro }}>
                            </div>

                        </div>

                        <hr>

                        <!-- DOKUMEN -->
                        <h5>Dokumen Pendukung</h5>

                        <div class="row">

                            <div class="col-md-6">
                                <input type="text" name="nomor_surat_rt" class="form-control mb-2"
                                    value="{{ $surat->nomor_surat_rt }}" {{ $ro }}>
                            </div>

                            <div class="col-md-6">
                                <input type="date" name="tanggal_surat_rt" class="form-control mb-2"
                                    value="{{ $surat->tanggal_surat_rt }}" {{ $ro }}>
                            </div>

                            <div class="col-12">
                                <input type="file" name="dokumen_pendukung[]" class="form-control" multiple
                                    {{ $dis }}>
                            </div>

                            <div class="col-12 mt-2">
                                @if (!empty($files))
                                    <ul>
                                        @foreach ($files as $fn)
                                            <li>
                                                <a href="{{ asset('uploads/pendukung/' . $fn) }}" target="_blank">
                                                    {{ $fn }}
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                @else
                                    <span class="text-muted">Belum ada file</span>
                                @endif
                            </div>

                        </div>

                    </div>

                    <!-- FOOTER -->
                    <div class="card-action">
                        <button class="btn btn-success">
                            <i class="fa fa-save"></i> Simpan
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</div>

<x-admin.footer />
