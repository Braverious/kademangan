<x-admin.header :title="$title" />
<x-admin.sidebar />

<div class="page-inner">
    <div class="page-header">
        <h4 class="page-title">Data Surat Keterangan Belum Bekerja</h4>

        <ul class="breadcrumbs">
            <li class="nav-home">
                <a href="{{ route('admin.dashboard') }}">
                    <i class="flaticon-home"></i>
                </a>
            </li>
            <li class="separator"><i class="flaticon-right-arrow"></i></li>
            <li class="nav-item"><a href="#">Surat Pelayanan</a></li>
            <li class="separator"><i class="flaticon-right-arrow"></i></li>
            <li class="nav-item"><a>Data Surat Keterangan Belum Bekerja</a></li>
        </ul>
    </div>

    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center flex-wrap">

                <!-- KIRI -->
                <h4 class="card-title mb-0">Daftar Pengajuan</h4>

                <!-- KANAN -->
                <form action="{{ route('admin.belum-bekerja.export') }}" method="GET" target="_blank"
                    class="d-flex align-items-center">

                    <div class="mr-2">
                        <label class="mb-0 small">Rekap Bulan</label>
                        <input type="month" name="bulan" class="form-control form-control-sm"
                            value="{{ request('bulan', date('Y-m')) }}" max="{{ date('Y-m') }}">
                    </div>

                    <button class="btn btn-success btn-sm mt-3">
                        <i class="fa fa-file-excel"></i> Export Excel
                    </button>

                </form>

            </div>
        </div>

        <div class="card-body">

            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Pemohon</th>
                            <th>NIK</th>
                            <th>Tanggal Pengajuan</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($list as $i => $item)
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td>{{ $item->nama_pemohon }}</td>
                                <td>{{ $item->nik }}</td>
                                <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d M Y') }}</td>

                                <td>
                                    @php
                                        $badge = match ($item->status) {
                                            'Pending' => 'badge-warning',
                                            'Disetujui' => 'badge-success',
                                            default => 'badge-danger',
                                        };
                                    @endphp

                                    <span class="badge {{ $badge }}">
                                        {{ $item->status }}
                                    </span>
                                </td>

                                <td>
                                    <div class="form-button-action">

                                        <a href="{{ route('admin.belum-bekerja.detail', $item->id) }}"
                                            class="btn btn-link btn-info">
                                            👁
                                        </a>

                                        <a href="{{ route('admin.belum-bekerja.edit', $item->id) }}"
                                            class="btn btn-link btn-warning">
                                            ✏️
                                        </a>

                                        <form action="{{ route('admin.belum-bekerja.delete', $item->id) }}"
                                            method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')

                                            <button onclick="return confirm('Yakin hapus?')"
                                                class="btn btn-link btn-danger">
                                                🗑
                                            </button>
                                        </form>

                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>
        </div>
    </div>
</div>

<x-admin.footer />
