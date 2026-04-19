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
            <li class="nav-item"><a>Manajemen Konten</a></li>
            <li class="separator"><i class="flaticon-right-arrow"></i></li>
            <li class="nav-item"><a>Layanan</a></li>
        </ul>
    </div>

    <div class="row">
        <div class="col-md-12">

            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <h4 class="card-title">Daftar Layanan</h4>

                        <a href="{{ route('admin.layanan.create') }}" class="btn btn-primary btn-round ml-auto">
                            <i class="fa fa-plus"></i> Tambah Layanan
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

                    <div class="table-responsive">
                        <table class="display table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Gambar</th>
                                    <th>Judul</th>
                                    <th>Deskripsi</th>
                                    <th>Urut</th>
                                    <th>Aktif</th>
                                    <th style="width:10%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($rows as $i => $r)
                                    <tr>
                                        <td>{{ $i + 1 }}</td>

                                        <td>
                                            @if ($r->gambar)
                                                <img src="{{ asset('storage/' . $r->gambar) }}" width="100">
                                            @endif
                                        </td>

                                        <td>{{ $r->judul }}</td>

                                        <td class="text-muted" style="max-width:360px;">
                                            {{ \Illuminate\Support\Str::limit(strip_tags($r->deskripsi), 120) }}
                                        </td>

                                        <td>{{ $r->urut }}</td>

                                        <td>
                                            @if ($r->aktif == 1)
                                                <span class="badge badge-success">Aktif</span>
                                            @else
                                                <span class="badge badge-secondary">Nonaktif</span>
                                            @endif
                                        </td>

                                        <td>
                                            <div class="form-button-action">
                                                <a href="{{ route('admin.layanan.edit', $r->id) }}"
                                                    class="btn btn-link btn-primary btn-lg">
                                                    <i class="fa fa-edit"></i>
                                                </a>

                                                <a href="{{ route('admin.layanan.delete', $r->id) }}"
                                                    onclick="return confirm('Hapus layanan ini?')"
                                                    class="btn btn-link btn-danger">
                                                    <i class="fa fa-times"></i>
                                                </a>
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
    </div>
</div>

<x-admin.footer />
