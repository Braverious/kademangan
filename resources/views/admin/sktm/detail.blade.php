<x-admin.header :title="$title" />
<x-admin.sidebar />

<div class="page-inner">

    <!-- HEADER -->
    <div class="page-header">
        <h4 class="page-title">Detail SKTM</h4>

        <ul class="breadcrumbs">
            <li class="nav-home">
                <a href="{{ route('admin.dashboard') }}">
                    <i class="flaticon-home"></i>
                </a>
            </li>

            <li class="separator"><i class="flaticon-right-arrow"></i></li>

            <li class="nav-item">
                <a href="{{ route('admin.sktm.index') }}">Data SKTM</a>
            </li>

            <li class="separator"><i class="flaticon-right-arrow"></i></li>

            <li class="nav-item"><a>Detail</a></li>
        </ul>
    </div>

    <div class="card">

        <!-- HEADER CARD -->
        <div class="card-header d-flex align-items-center">
            <h4 class="card-title">Detail Data Pemohon</h4>

            <a href="{{ route('admin.sktm.index') }}" class="btn btn-secondary btn-round ml-auto">
                <i class="fa fa-arrow-left"></i> Kembali
            </a>
        </div>

        <div class="card-body">

            @php
                $bisaCetak = true;
                $pesanError = [];

                if (empty($surat->nomor_surat)) {
                    $bisaCetak = false;
                    $pesanError[] = 'Nomor Surat belum diisi.';
                }

                if ($surat->status !== 'Disetujui') {
                    $bisaCetak = false;
                    $pesanError[] = 'Status belum Disetujui.';
                }
            @endphp

            <!-- ALERT -->
            @if (!$bisaCetak)
                <div class="alert alert-warning">
                    <h4>
                        <i class="fa fa-exclamation-triangle"></i>
                        Surat Belum Siap Cetak!
                    </h4>
                    <p class="mb-0">
                        Pastikan nomor surat sudah diisi dan status disetujui.
                    </p>
                </div>
            @endif

            <div class="row">

                <!-- DATA DIRI -->
                <div class="col-md-6">
                    <h5>Data Diri</h5>

                    <dl class="row">
                        <dt class="col-sm-4">Nama</dt>
                        <dd class="col-sm-8">: {{ $surat->nama_pemohon }}</dd>

                        <dt class="col-sm-4">NIK</dt>
                        <dd class="col-sm-8">: {{ $surat->nik }}</dd>

                        <dt class="col-sm-4">Telepon</dt>
                        <dd class="col-sm-8">: {{ $surat->telepon_pemohon ?? '-' }}</dd>

                        <dt class="col-sm-4">TTL</dt>
                        <dd class="col-sm-8">
                            :
                            {{ $surat->tempat_lahir }},
                            {{ $surat->tanggal_lahir ? \Carbon\Carbon::parse($surat->tanggal_lahir)->format('d M Y') : '-' }}
                        </dd>

                        <dt class="col-sm-4">JK</dt>
                        <dd class="col-sm-8">: {{ $surat->jenis_kelamin }}</dd>

                        <dt class="col-sm-4">Warganegara</dt>
                        <dd class="col-sm-8">: {{ $surat->warganegara }}</dd>

                        <dt class="col-sm-4">Agama</dt>
                        <dd class="col-sm-8">: {{ $surat->agama }}</dd>

                        <dt class="col-sm-4">Pekerjaan</dt>
                        <dd class="col-sm-8">: {{ $surat->pekerjaan }}</dd>

                        <dt class="col-sm-4">Orang Tua</dt>
                        <dd class="col-sm-8">: {{ $surat->nama_orang_tua }}</dd>

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
                            :
                            <span
                                class="badge 
                                {{ $surat->status == 'Pending'
                                    ? 'badge-warning'
                                    : ($surat->status == 'Disetujui'
                                        ? 'badge-success'
                                        : 'badge-danger') }}">
                                {{ $surat->status }}
                            </span>
                        </dd>

                        <dt class="col-sm-4">Nomor Surat</dt>
                        <dd class="col-sm-8">
                            :
                            <strong>
                                {{ $surat->nomor_surat ?? 'Belum diinput' }}
                            </strong>
                        </dd>

                        <dt class="col-sm-4">Keperluan</dt>
                        <dd class="col-sm-8">: {{ $surat->keperluan }}</dd>

                        <dt class="col-sm-4">ID DTKS</dt>
                        <dd class="col-sm-8">: {{ $surat->id_dtks ?? '-' }}</dd>

                        <dt class="col-sm-4">Penghasilan</dt>
                        <dd class="col-sm-8">: {{ $surat->penghasilan_bulanan }}</dd>

                        <dt class="col-sm-4">Tanggal</dt>
                        <dd class="col-sm-8">
                            :
                            {{ $surat->created_at ? \Carbon\Carbon::parse($surat->created_at)->format('d M Y, H:i') : '-' }}
                            WIB
                        </dd>
                    </dl>

                    <hr>

                    <!-- DOKUMEN -->
                    <h5>Dokumen Pendukung</h5>

                    @php
                        $files = [];
                        if ($surat->dokumen_pendukung) {
                            $decoded = json_decode($surat->dokumen_pendukung, true);
                            $files = is_array($decoded) ? $decoded : [$surat->dokumen_pendukung];
                        }
                    @endphp

                    @if (!empty($files))
                        <ul class="list-unstyled">
                            @foreach ($files as $file)
                                <li>
                                    <i class="fa fa-paperclip"></i>
                                    <a href="{{ asset('uploads/pendukung/' . $file) }}" target="_blank">
                                        {{ $file }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <span class="text-muted">Tidak ada dokumen</span>
                    @endif

                </div>

            </div>

        </div>

        <!-- FOOTER -->
        <div class="card-footer">

            <a href="{{ route('admin.sktm.edit', $surat->id) }}" class="btn btn-warning">
                <i class="fa fa-edit"></i> Edit
            </a>

            @if ($bisaCetak)
                <form action="{{ route('admin.sktm.cetak', $surat->id) }}" method="GET" target="_blank"
                    class="d-inline-flex align-items-center ml-2">

                    <button class="btn btn-success mr-2">
                        <i class="fa fa-print"></i> Cetak PDF
                    </button>

                    <select name="ttd" class="form-control" required>
                        @foreach ($signers as $s)
                            <option value="{{ $s->id }}" {{ $default_signer_id == $s->id ? 'selected' : '' }}>
                                {{ $s->jabatan_nama }} - {{ $s->nama }}
                            </option>
                        @endforeach
                    </select>

                </form>
            @else
                <button class="btn btn-success" disabled>
                    <i class="fa fa-print"></i> Cetak PDF
                </button>
            @endif

        </div>

    </div>

</div>

<x-admin.footer />
