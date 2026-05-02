<x-admin.header :title="$title" />
<x-admin.sidebar />

<div class="page-inner">
    <x-admin.breadcrumbs :title="$title" :breadcrumbs="$breadcrumbs" />
    <div class="row">
        <div class="col-md-12">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
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
                    <div class="d-flex align-items-center flex-wrap gap-2">
                        <h4 class="card-title">Daftar Staff</h4>
                        <div class="ml-auto d-flex gap-2">
                            <button class="btn btn-success btn-round mr-2" data-toggle="modal"
                                data-target="#importExcelModal">
                                <i class="fa fa-file-excel mr-2"></i> Import Staff
                            </button>
                            <a href="{{ route('admin.settings.staff.create') }}"
                                class="btn btn-primary btn-round ml-auto">
                                <i class="fa fa-plus mr-2"></i> Tambah Staff
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="display table table-striped table-hover w-100 admin-table-wide">
                            <thead>
                                <tr>
                                    <th style="width: 5%">No</th>
                                    <th>Nama Lengkap & Info</th>
                                    <th>Username</th>
                                    <th>Level Akses</th>
                                    <th>Pembuat</th>
                                    <th style="width: 10%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($user_list as $user)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            <strong>{{ $user->nama_lengkap }}</strong><br>
                                            {{-- Cek apakah user punya relasi jabatan --}}
                                            @if ($user->jabatan_id)
                                                <small
                                                    class="text-primary fw-bold">{{ $user->relasiJabatan->nama ?? 'Jabatan Tidak Diketahui' }}</small>
                                            @endif

                                            {{-- Cek apakah user punya NIP --}}
                                            @if ($user->nip)
                                                <small class="text-muted"> | NIP: {{ $user->nip }}</small>
                                            @endif
                                        </td>
                                        <td>{{ $user->username }}</td>
                                        <td><span
                                                class="badge badge-info">{{ $user->level->nama_level ?? 'Staff' }}</span>
                                        </td>
                                        <td>
                                            @if (is_numeric($user->created_by))
                                                <span class="badge badge-primary">
                                                    <i class="fa fa-user-tie mr-1"></i>
                                                    {{ $user->creator->staffDetail->full_name ?? ($user->creator->username ?? 'Staff') }}
                                                </span>
                                            @elseif ($user->created_by === 'sysadmin' || empty($user->created_by))
                                                <span class="badge badge-secondary">
                                                    <i class="fa fa-database mr-1"></i> System (SQL)
                                                </span>
                                            @else
                                                <span class="badge badge-info">
                                                    <i class="fa fa-laptop mr-1"></i> {{ ucfirst($user->created_by) }}
                                                </span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="form-button-action d-flex">
                                                <a href="{{ route('admin.settings.staff.edit', $user->id) }}"
                                                    title="Edit" class="btn btn-link btn-primary btn-lg">
                                                    <i class="fa fa-edit"></i>
                                                </a>

                                                @if ($user->id != 1)
                                                    <form
                                                        action="{{ route('admin.settings.staff.destroy', $user->id) }}"
                                                        method="POST" class="js-delete-form"
                                                        data-delete-title="Hapus Staff?"
                                                        data-delete-text="Apakah Anda yakin ingin menghapus staff ini?">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" title="Hapus"
                                                            class="btn btn-link btn-danger">
                                                            <i class="fa fa-times"></i>
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-3 d-flex justify-content-between align-items-center">
                        <div class="text-muted small">
                            <i class="fa fa-info-circle mr-1"></i>
                            Gunakan templat standar agar data terbaca sempurna oleh sistem.
                        </div>
                        <a href="{{ asset('assets/templates/template_user.xlsx') }}"
                            class="btn btn-success btn-sm shadow-sm">
                            <i class="fa fa-download mr-2"></i> Unduh Templat Excel
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="importExcelModal" tabindex="-1" aria-labelledby="importExcelModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold" id="importExcelModalLabel">
                    <i class="fa fa-file-excel text-success mr-2"></i> Import Data Staff
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.settings.staff.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="alert alert-info small">
                        <strong>Panduan Format Excel:</strong><br>
                        Pastikan file Excel (.xlsx) memiliki judul kolom (Header) di baris pertama persis seperti
                        berikut (huruf kecil semua menggunakan underscore):<br>
                        <code>nama_lengkap</code>, <code>username</code>, <code>level_id</code>,
                        <code>nip</code>, <code>jabatan_id</code>.
                    </div>
                    <div class="alert alert-warning small">
                        <i class="fa fa-exclamation-triangle mr-1"></i>
                        <strong>Penting:</strong> Password untuk semua akun baru akan otomatis diset menjadi tanggal
                        hari ini dengan format <strong>{{ now()->format('d-m-Y') }}</strong>.
                    </div>
                    <div class="form-group p-0">
                        <label for="file_excel">Pilih File Excel <span class="text-danger">*</span></label>
                        <input type="file" name="file_excel" id="file_excel" class="form-control"
                            accept=".xlsx, .xls, .csv" required>
                        <small class="text-muted mt-1 d-block">Ukuran maksimal 2MB.</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button> <button
                        type="submit" class="btn btn-success">Upload & Proses</button>
                </div>
            </form>
        </div>
    </div>
</div>
<x-admin.footer />
