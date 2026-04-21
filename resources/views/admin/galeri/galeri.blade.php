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
            <li class="nav-item"><a href="#">Manajemen Galeri</a></li>
        </ul>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <h4 class="card-title">Daftar Foto Galeri</h4>
                        <a class="btn btn-primary btn-round ml-auto" href="{{ route('admin.galeri.create') }}">
                            <i class="fa fa-plus"></i> Tambah Foto
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">{{ session('success') }}</div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger" role="alert">{{ session('error') }}</div>
                    @endif

                    <div class="table-responsive">
                        <table id="add-row" class="display table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Foto</th>
                                    <th>Judul Foto</th>
                                    <th>Pengupload</th>
                                    <th>Tanggal</th>
                                    <th style="width: 10%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($galeri_list as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            @if (!empty($item->foto))
                                                <a href="{{ asset('storage/' . $item->foto) }}" target="_blank" rel="noopener">
                                                    <img src="{{ asset('storage/' . $item->foto) }}"
                                                        alt="{{ $item->judul_foto }}"
                                                        width="100">
                                                </a>
                                            @endif
                                        </td>
                                        <td>{{ $item->judul_foto }}</td>
                                        <td>{{ $item->user->nama_lengkap ?? '-' }}</td>
                                        <td>{{ $item->tgl_upload ? \Carbon\Carbon::parse($item->tgl_upload)->format('d M Y H:i') : '-' }}</td>
                                        <td>
                                            <div class="form-button-action">
                                                <a href="{{ route('admin.galeri.edit', $item->id_galeri) }}"
                                                    title="Edit"
                                                    class="btn btn-link btn-primary btn-lg">
                                                    <i class="fa fa-edit"></i>
                                                </a>

                                                <form action="{{ route('admin.galeri.destroy', $item->id_galeri) }}"
                                                    method="POST"
                                                    style="display:inline;"
                                                    class="js-delete-form"
                                                    data-delete-title="Hapus Foto?"
                                                    data-delete-text="Apakah Anda yakin ingin menghapus foto ini?">
                                                    @csrf
                                                    @method('DELETE')

                                                    <button type="submit" title="Hapus" class="btn btn-link btn-danger">
                                                        <i class="fa fa-times"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-muted">Belum ada foto galeri.</td>
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
