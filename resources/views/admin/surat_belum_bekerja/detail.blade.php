<x-admin.header :title="$title" />
<x-admin.sidebar />

@php
    $bisaCetak = $bisaCetak ?? !empty($surat->nomor_surat) && $surat->status == 'Disetujui';

    $files = [];
    if (!empty($surat->dokumen_pendukung)) {
        $dec = json_decode($surat->dokumen_pendukung, true);
        $files = is_array($dec) ? $dec : [$surat->dokumen_pendukung];
    }
@endphp

<div class="page-inner">
    <div class="page-header">
        <h4 class="page-title">Detail Ket. Belum Bekerja</h4>
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
            <li class="nav-item"><a>Detail</a></li>
        </ul>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">

                <!-- HEADER -->
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <h4 class="card-title">
                            Detail Pengajuan an. {{ $surat->nama_pemohon }}
                        </h4>

                        <a href="{{ route('admin.belum-bekerja.index') }}" class="btn btn-secondary btn-round ml-auto">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>

                <!-- BODY -->
                <div class="card-body">

                    @if (!$bisaCetak)
                        <div class="alert alert-warning">
                            <h4 class="alert-heading">
                                <i class="fas fa-exclamation-triangle"></i>
                                Surat Belum Siap Cetak!
                            </h4>
                            <p class="mb-0">
                                Pastikan <b>Nomor Surat</b> sudah diisi dan
                                <b>Status</b> telah "Disetujui".
                            </p>
                        </div>
                    @endif

                    <div class="row">

                        <!-- DATA DIRI -->
                        <div class="col-md-6">
                            <h5>Data Diri Pemohon</h5>

                            <dl class="row">
                                <dt class="col-sm-4">Nama Lengkap</dt>
                                <dd class="col-sm-8">: {{ $surat->nama_pemohon }}</dd>

                                <dt class="col-sm-4">NIK</dt>
                                <dd class="col-sm-8">: {{ $surat->nik }}</dd>

                                <dt class="col-sm-4">No. Telepon</dt>
                                <dd class="col-sm-8">: {{ $surat->telepon_pemohon }}</dd>

                                <dt class="col-sm-4">Tempat, Tgl Lahir</dt>
                                <dd class="col-sm-8">
                                    : {{ $surat->tempat_lahir }},
                                    {{ \Carbon\Carbon::parse($surat->tanggal_lahir)->format('d M Y') }}
                                </dd>

                                <dt class="col-sm-4">Jenis Kelamin</dt>
                                <dd class="col-sm-8">: {{ $surat->jenis_kelamin }}</dd>

                                <dt class="col-sm-4">Alamat</dt>
                                <dd class="col-sm-8">: {{ $surat->alamat }}</dd>
                            </dl>
                        </div>

                        <!-- DATA PENGAJUAN -->
                        <div class="col-md-6">
                            <h5>Data Pengajuan</h5>

                            <dl class="row">
                                <dt class="col-sm-4">Status</dt>
                                <dd class="col-sm-8">
                                    @php
                                        $badge = match ($surat->status) {
                                            'Pending' => 'badge-warning',
                                            'Disetujui' => 'badge-success',
                                            default => 'badge-danger',
                                        };
                                    @endphp
                                    <span class="badge {{ $badge }}">{{ $surat->status }}</span>
                                </dd>

                                <dt class="col-sm-4">Nomor Surat</dt>
                                <dd class="col-sm-8">
                                    :
                                    <strong>
                                        {!! $surat->nomor_surat ? $surat->nomor_surat : '<span class="text-muted">Belum diinput</span>' !!}
                                    </strong>
                                </dd>

                                <dt class="col-sm-4">Keperluan</dt>
                                <dd class="col-sm-8">: {{ $surat->keperluan }}</dd>

                                <dt class="col-sm-4">Tgl. Pengajuan</dt>
                                <dd class="col-sm-8">
                                    : {{ \Carbon\Carbon::parse($surat->created_at)->format('d M Y, H:i') }} WIB
                                </dd>
                            </dl>

                            <hr>

                            <!-- DOKUMEN -->
                            <h5>Dokumen Pendukung</h5>

                            <dl class="row">
                                <dt class="col-sm-4">No. Surat RT/RW</dt>
                                <dd class="col-sm-8">: {{ $surat->nomor_surat_rt }}</dd>

                                <dt class="col-sm-4">Tgl. Surat RT/RW</dt>
                                <dd class="col-sm-8">
                                    : {{ \Carbon\Carbon::parse($surat->tanggal_surat_rt)->format('d M Y') }}
                                </dd>

                                <dt class="col-sm-12 mt-2">Lampiran</dt>
                                <dd class="col-sm-12">

                                    @if (!empty($files))
                                        <ul class="list-unstyled">
                                            @foreach ($files as $fn)
                                                <li class="mb-1">
                                                    <i class="fa fa-paperclip"></i>
                                                    <a href="{{ asset('uploads/pendukung/' . $fn) }}" target="_blank">
                                                        {{ $fn }}
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @else
                                        <span class="text-muted">
                                            Tidak ada dokumen terunggah.
                                        </span>
                                    @endif

                                </dd>
                            </dl>
                        </div>

                    </div>
                </div>

                <!-- FOOTER -->
                <div class="card-footer">

                    <a href="{{ route('admin.belum-bekerja.edit', $surat->id) }}" class="btn btn-warning">
                        <i class="fa fa-edit"></i> Edit Data Ini
                    </a>

                    @if ($bisaCetak)
                        @if (!empty($signers))
                            <form class="form-inline d-inline-flex align-items-center ml-2"
                                action="{{ route('admin.belum-bekerja.cetak', $surat->id) }}" method="GET"
                                target="_blank">

                                <button class="btn btn-success mr-2">
                                    <i class="fa fa-print"></i> Cetak PDF
                                </button>

                                <label class="mr-2 mb-0">Penandatangan:</label>

                                <select name="ttd" class="form-control" required>
                                    @foreach ($signers as $s)
                                        <option value="{{ $s->id }}"
                                            {{ $default_signer_id == $s->id ? 'selected' : '' }}>
                                            {{ $s->jabatan_nama }} - {{ $s->nama }}
                                        </option>
                                    @endforeach
                                </select>
                            </form>
                        @else
                            <button class="btn btn-success ml-2" disabled>
                                Cetak PDF
                            </button>
                        @endif
                    @else
                        <button class="btn btn-success" disabled>
                            Cetak PDF
                        </button>
                    @endif

                </div>

            </div>
        </div>
    </div>
</div>

<x-admin.footer />
