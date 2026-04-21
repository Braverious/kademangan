<x-admin.header :title="$title" />
<x-admin.sidebar />

<div class="page-inner">
    <div class="page-header">
        <h4 class="page-title">{{ $title }}</h4>
        <ul class="breadcrumbs">
            <li class="nav-home">
                <a href="#"><i class="flaticon-home"></i></a>
            </li>
            <li class="separator"><i class="flaticon-right-arrow"></i></li>
            <li class="nav-item">
                <a href="#">Pengaturan</a>
            </li>
            <li class="separator"><i class="flaticon-right-arrow"></i></li>
            <li class="nav-item">
                <a href="#">Manajemen Jabatan</a>
            </li>
        </ul>
    </div>

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
                        <h4 class="card-title mb-0">Daftar Jabatan</h4>
                        <a href="{{ route('admin.jabatan.create') }}" class="btn btn-primary btn-round ml-auto">
                            <i class="fa fa-plus"></i> Tambah Jabatan
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <div class="alert alert-info">
                        Gunakan nonaktif jika jabatan tidak ingin ditampilkan di form user. Hapus hanya untuk jabatan yang belum dipakai siapa pun.
                    </div>

                    <div class="table-responsive">
                        <table class="display table table-striped table-hover w-100 admin-table-wide">
                            <thead>
                                <tr>
                                    <th style="width: 5%">No</th>
                                    <th>Nama Jabatan</th>
                                    <th style="width: 10%">Urut</th>
                                    <th style="width: 12%">Status</th>
                                    <th style="width: 12%">Dipakai User</th>
                                    <th style="width: 18%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($jabatans as $jabatan)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $jabatan->nama }}</td>
                                        <td>{{ $jabatan->urut }}</td>
                                        <td>
                                            @if ($jabatan->is_active)
                                                <span class="badge badge-success">Aktif</span>
                                            @else
                                                <span class="badge badge-secondary">Nonaktif</span>
                                            @endif
                                        </td>
                                        <td>{{ $jabatan->users_count }}</td>
                                        <td>
                                            <div class="form-button-action d-flex">
                                                <a href="{{ route('admin.jabatan.edit', $jabatan->id) }}"
                                                    class="btn btn-link btn-primary btn-lg"
                                                    title="Edit">
                                                    <i class="fa fa-edit"></i>
                                                </a>

                                                <form action="{{ route('admin.jabatan.toggle', $jabatan->id) }}"
                                                    method="POST"
                                                    style="display:inline;">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit"
                                                        class="btn btn-link {{ $jabatan->is_active ? 'btn-success' : 'btn-warning' }}"
                                                        title="{{ $jabatan->is_active ? 'Nonaktifkan' : 'Aktifkan' }}">
                                                        <i class="fa {{ $jabatan->is_active ? 'fa-toggle-on' : 'fa-toggle-off' }}"></i>
                                                    </button>
                                                </form>

                                                <form action="{{ route('admin.jabatan.destroy', $jabatan->id) }}"
                                                    method="POST"
                                                    style="display:inline;"
                                                    class="js-delete-form"
                                                    data-delete-title="Hapus Jabatan?"
                                                    data-delete-text="Apakah Anda yakin ingin menghapus jabatan ini?">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="btn btn-link btn-danger"
                                                        title="Hapus"
                                                        {{ $jabatan->users_count > 0 ? 'disabled' : '' }}>
                                                        <i class="fa fa-times"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-muted">Belum ada data jabatan.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<x-admin.footer />
