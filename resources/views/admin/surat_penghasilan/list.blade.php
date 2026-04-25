<x-admin.header :title="$title" />
<x-admin.sidebar />

<div class="page-inner">
    <div class="page-header">
        <h4 class="page-title">Data Surat Keterangan Penghasilan</h4>

        <ul class="breadcrumbs">
            <li class="nav-home">
                <a href="{{ route('admin.dashboard') }}">
                    <i class="flaticon-home"></i>
                </a>
            </li>
            <li class="separator"><i class="flaticon-right-arrow"></i></li>
            <li class="nav-item"><a>Surat Pelayanan</a></li>
            <li class="separator"><i class="flaticon-right-arrow"></i></li>
            <li class="nav-item"><a>Surat Penghasilan</a></li>
        </ul>
    </div>

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center flex-wrap">

            <!-- KIRI -->
            <h4 class="card-title mb-0">Daftar Pengajuan</h4>

            <!-- KANAN -->
            <form action="{{ route('admin.penghasilan.export') }}" method="GET"
                class="d-flex align-items-center gap-2 flex-wrap">

                <span class="text-muted mr-2">Rekap Bulan</span>

                <input type="month" name="bulan" class="form-control form-control-sm" style="width: 160px;"
                    value="{{ request('bulan', date('Y-m')) }}" max="{{ date('Y-m') }}">

                <button class="btn btn-success btn-sm ml-2">
                    <i class="fa fa-file-excel mr-1"></i> Export Excel
                </button>

            </form>

        </div>

        <div class="card-body">

            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <div class="table-responsive">
                <table id="datatable-penghasilan" class="display table table-striped table-hover w-100">

                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Pemohon</th>
                            <th>NIK</th>
                            <th>Tanggal Pengajuan</th>
                            <th>Status</th>
                            <th class="text-center">Aksi</th>
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

                                <td class="text-center">
                                    <div class="form-button-action d-flex justify-content-center">

                                        <a href="{{ route('admin.penghasilan.detail', $item->id) }}"
                                            class="btn btn-link btn-info">
                                            <i class="fa fa-eye"></i>
                                        </a>

                                        <a href="{{ route('admin.penghasilan.edit', $item->id) }}"
                                            class="btn btn-link btn-warning">
                                            <i class="fa fa-edit"></i>
                                        </a>

                                        <form action="{{ route('admin.penghasilan.delete', $item->id) }}"
                                            method="POST" onsubmit="return confirm('Yakin hapus?')">
                                            @csrf
                                            @method('DELETE')

                                            <button class="btn btn-link btn-danger">
                                                <i class="fa fa-trash"></i>
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
