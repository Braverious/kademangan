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
            <li class="nav-item"><a href="#">Manajemen Berita</a></li>
        </ul>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center flex-wrap gap-2">
                        <h4 class="card-title">Daftar Berita</h4>
                        <a href="{{ route('admin.berita.create') }}" class="btn btn-primary btn-round ml-auto">
                            <i class="fa fa-plus"></i> Tambah Berita
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    <form class="mb-3" id="searchBeritaForm">
                        <div>
                            <input type="text"
                                id="searchBeritaInput"
                                class="form-control"
                                placeholder="Cari judul/kategori/penulis...">
                        </div>
                    </form>

                    <div class="table-responsive">
                        <table id="basic-datatables" class="display table table-striped table-hover w-100 admin-table-wide">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Gambar</th>
                                    <th>Judul</th>
                                    <th>Kategori</th>
                                    <th>Penulis</th>
                                    <th>Tanggal Publish</th>
                                    <th style="width: 10%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($berita_list as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            @if ($item->gambar)
                                                <img src="{{ asset('storage/' . $item->gambar) }}"
                                                    alt="{{ $item->judul_berita }}"
                                                    width="100"
                                                    class="img-thumbnail">
                                            @endif
                                        </td>
                                        <td>
                                            <strong>{{ $item->judul_berita }}</strong>
                                            <br>
                                            <small class="text-muted">{{ $item->slug_berita }}</small>
                                        </td>
                                        <td>
                                            <span class="badge badge-info">{{ $item->kategori }}</span>
                                        </td>
                                        <td>{{ $item->user->nama_lengkap ?? '-' }}</td>
                                        <td>{{ $item->tgl_publish ? $item->tgl_publish->format('d M Y H:i') : '-' }}</td>
                                        <td>
                                            <div class="form-button-action d-flex">
                                                <a href="{{ route('admin.berita.edit', $item->id_berita) }}"
                                                    class="btn btn-link btn-primary btn-lg"
                                                    title="Edit">
                                                    <i class="fa fa-edit"></i>
                                                </a>

                                                <form action="{{ route('admin.berita.destroy', $item->id_berita) }}"
                                                    method="POST"
                                                    class="js-delete-form"
                                                    data-delete-title="Hapus Berita?"
                                                    data-delete-text="Apakah Anda yakin ingin menghapus berita ini?">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-link btn-danger" title="Hapus">
                                                        <i class="fa fa-times"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center text-muted">Belum ada data berita.</td>
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
