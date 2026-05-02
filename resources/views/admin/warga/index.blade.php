<x-admin.header :title="$title" />
<x-admin.sidebar />

<div class="page-inner">
    <x-admin.breadcrumbs :title="$title" :breadcrumbs="$breadcrumbs" />
    <div class="card">
        <div class="card-header">
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
            <div class="d-flex align-items-center">
                <h4 class="card-title">Manajemen Warga</h4>
                <div class="ml-auto">
                    <button class="btn btn-success btn-round mr-2" data-toggle="modal" data-target="#importExcelModal">
                        <i class="fa fa-file-excel mr-2"></i> Import Warga
                    </button>
                    <a href="{{ route('admin.settings.citizens.create') }}" class="btn btn-primary btn-round">
                        <i class="fa fa-plus mr-2"></i> Tambah Warga
                    </a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <!-- Form Filter & Pencarian (Sudah Bersih dari Nested Form) -->
            <form action="{{ route('admin.settings.citizens.index') }}" method="GET" class="mb-4">
                <div class="row align-items-end">
                    <div class="col-md-4">
                        <div class="form-group p-0">
                            <label class="small fw-bold">Pencarian</label>
                            <input type="text" name="q" class="form-control"
                                placeholder="Cari NIK atau Nama..." value="{{ request('q') }}">
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group p-0">
                            <label class="small fw-bold">RT</label>
                            <input type="text" name="rt" class="form-control" placeholder="000"
                                value="{{ request('rt') }}">
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group p-0">
                            <label class="small fw-bold">RW</label>
                            <select name="rw" class="form-control">
                                <option value="">Semua</option>
                                @foreach (range(1, 9) as $i)
                                    @php $val = sprintf('%03d', $i); @endphp
                                    <option value="{{ $val }}" {{ request('rw') == $val ? 'selected' : '' }}>
                                        {{ $val }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group p-0">
                            <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> Filter</button>
                            <a href="{{ route('admin.settings.citizens.index') }}" class="btn btn-secondary border"><i
                                    class="fa fa-sync"></i> Reset</a>
                        </div>
                    </div>
                </div>
            </form>

            <div class="table-responsive">
                <table class="display table table-striped table-hover w-100" style="layout: fixed;">
                    <thead>
                        <tr>
                            <th style="width: 2%">No</th>
                            <th style="width: 20%">NIK & Nama</th>
                            <th style="width: 5%">Wilayah</th>
                            <th style="width: 10%">Status</th>
                            <th style="width: 10%">Pembuat</th>
                            <th style="width: 10%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($user_list as $user)
                            <tr>
                                <td>{{ ($user_list->currentPage() - 1) * $user_list->perPage() + $loop->iteration }}
                                </td>
                                <td>
                                    <strong>{{ $user->citizenDetail?->full_name }}</strong><br>
                                    <small class="text-muted">{{ $user->username }}</small>
                                </td>
                                <td>RT {{ $user->citizenDetail?->rt }} / RW {{ $user->citizenDetail?->rw }}</td>
                                <td>
                                    <span class="badge {{ $user->is_active ? 'badge-success' : 'badge-danger' }}"
                                        @if (!$user->is_active) data-toggle="tooltip" title="Alasan: {{ $user->inactive_reason }}" @endif>
                                        {{ $user->is_active ? 'Aktif' : 'Nonaktif' }}
                                    </span>
                                </td>
                                <td>
                                    @if (is_numeric($user->created_by))
                                        <span class="badge badge-primary">
                                            <i class="fa fa-user-tie mr-1"></i>
                                            {{ $user->creator->citizenDetail->full_name ?? ($user->creator->username ?? 'Staff') }}
                                        </span>
                                    @elseif($user->created_by == 'register')
                                        <span class="badge badge-info">
                                            <i class="fa fa- laptop mr-1"></i> Mandiri (Register)
                                        </span>
                                    @else
                                        <span class="badge badge-secondary">
                                            <i class="fa fa-database mr-1"></i> System (SQL)
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <div class="form-button-action">
                                        <a href="{{ route('admin.settings.citizens.edit', $user->id) }}"
                                            class="btn btn-link btn-primary p-1" title="Edit">
                                            <i class="fa fa-edit fa-lg"></i>
                                        </a>
                                        @if ($user->is_active)
                                            <button type="button" class="btn btn-link btn-warning p-1 btn-block-user"
                                                data-id="{{ $user->id }}"
                                                data-name="{{ $user->citizenDetail?->full_name }}" data-toggle="modal"
                                                data-target="#blockModal" title="Blokir Warga">
                                                <i class="fa fa-ban fa-lg"></i>
                                            </button>
                                        @else
                                            <form
                                                action="{{ route('admin.settings.citizens.toggle-status', $user->id) }}"
                                                method="POST" class="d-inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-link btn-success p-1"
                                                    title="Aktifkan Kembali">
                                                    <i class="fa fa-check-circle fa-lg"></i>
                                                </button>
                                            </form>
                                        @endif
                                        <form action="{{ route('admin.settings.citizens.destroy', $user->id) }}"
                                            method="POST" class="js-delete-form" data-delete-title="Hapus Data Warga?"
                                            data-delete-text="Seluruh data profil dan akun login untuk {{ $user->citizenDetail?->full_name }} akan dihapus permanen.">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-link btn-danger p-1" title="Hapus">
                                                <i class="fa fa-trash fa-lg"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">Data tidak ditemukan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-4 d-flex justify-content-center">
                {{ $user_list->links() }}
            </div>
        </div>
    </div>
</div>
<!-- Modal Alasan Blokir -->
<div class="modal fade" id="blockModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="formBlock" action="" method="POST">
                @csrf
                @method('PATCH')
                <div class="modal-header border-0">
                    <h5 class="modal-title">
                        <span class="fw-mediumbold">Blokir Akun</span>
                        <span class="fw-light" id="blockUserName"></span>
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Alasan Pemblokiran</label>
                        <textarea name="reason" class="form-control" rows="4" required
                            placeholder="Contoh: Akun terindikasi melakukan penyalahgunaan data atau sudah pindah domisili."></textarea>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="submit" class="btn btn-danger">Blokir Sekarang</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                </div>
            </form>
        </div>
    </div>
</div>
<x-admin.footer />
<script>
    $('.display').DataTable({
        "dom": 't', // 't' artinya hanya 'table', tanpa filter (f), length (l), atau info (i)
    });

    $(document).ready(function() {
        $('.btn-block-user').on('click', function() {
            let id = $(this).data('id');
            let name = $(this).data('name');
            let url = "{{ route('admin.settings.citizens.toggle-status', ':id') }}";
            url = url.replace(':id', id);

            $('#formBlock').attr('action', url);
            $('#blockUserName').text(name);
        });
    });
</script>
