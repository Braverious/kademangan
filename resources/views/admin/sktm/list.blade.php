<x-admin.header :title="$title" />
<x-admin.sidebar />

<div class="page-inner">

    <!-- HEADER -->
    <div class="page-header mb-0.5">
        <x-admin.breadcrumbs :title="$title" :breadcrumbs="$breadcrumbs" />
    </div>
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center flex-wrap">
            <h4 class="card-title mb-0">Daftar Pengajuan</h4>
            <form method="GET" action="{{ route('admin.sktm.export') }}"
                class="d-flex align-items-center gap-2 flex-wrap">
                <span class="text-muted mr-2">Rekap Bulan</span>
                <input type="month" name="bulan" class="form-control form-control-sm" style="width: 160px;"
                    value="{{ request('bulan', date('Y-m')) }}" max="{{ date('Y-m') }}">
                <button class="btn btn-success btn-sm ml-2">
                    <i class="fa fa-file-excel mr-1"></i> Export Excel
                </button>
            </form>
        </div>
        <!-- BODY -->
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            <div class="table-responsive">
                <table id="datatable-sktm" class="display table table-striped table-hover w-100">

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
                                    @if ($item->status == 'Pending')
                                        <span class="badge badge-warning">Pending</span>
                                    @elseif ($item->status == 'Disetujui')
                                        <span class="badge badge-success">Disetujui</span>
                                    @else
                                        <span class="badge badge-danger">Ditolak</span>
                                    @endif
                                </td>

                                <td class="text-center">
                                    <div class="form-button-action d-flex justify-content-center">

                                        <!-- LIHAT -->
                                        <a href="{{ route('admin.sktm.detail', $item->id) }}"
                                            class="btn btn-link btn-info" title="Lihat">
                                            <i class="fa fa-eye"></i>
                                        </a>

                                        <!-- EDIT -->
                                        <a href="{{ route('admin.sktm.edit', $item->id) }}"
                                            class="btn btn-link btn-warning" title="Edit">
                                            <i class="fa fa-edit"></i>
                                        </a>

                                        <!-- HAPUS -->
                                        <form action="{{ route('admin.sktm.delete', $item->id) }}" method="POST"
                                            onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                            @csrf
                                            @method('DELETE')

                                            <button class="btn btn-link btn-danger" title="Hapus">
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
