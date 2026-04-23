<x-admin.header :title="$title" />
<x-admin.sidebar />

<div class="page-inner">
    <x-admin.breadcrumbs :title="$title" :breadcrumbs="$breadcrumbs" />
    <div class="row">
        <div class="col-md-12">

            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center flex-wrap gap-2">
                        <h4 class="card-title">Daftar Layanan</h4>

                        <a href="{{ route('admin.settings.layanan.create') }}" class="btn btn-primary btn-round ml-auto">
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
                        <table class="display table table-striped table-hover w-100 admin-table-wide">
                            <thead>
                                <tr>
                                    <th style="width: 5%">No</th>
                                    <th style="width: 15%">Gambar</th>
                                    <th>Judul</th>
                                    <th>Deskripsi</th>
                                    <th style="width: 10%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($rows as $i => $r)
                                    <tr>
                                        <td>{{ $i + 1 }}</td>

                                        <td>
                                            @if ($r->gambar)
                                                <img src="{{ asset('storage/' . $r->gambar) }}" width="100"
                                                    class="img-thumbnail">
                                            @endif
                                        </td>

                                        <td><strong>{{ $r->judul }}</strong></td>

                                        <td class="text-muted" style="max-width:360px;">
                                            {{ \Illuminate\Support\Str::limit(strip_tags($r->deskripsi), 120) }}
                                        </td>

                                        <td>
                                            <div class="form-button-action d-flex">
                                                <a href="{{ route('admin.settings.layanan.edit', $r->id) }}"
                                                    class="btn btn-link btn-primary btn-lg" title="Edit">
                                                    <i class="fa fa-edit"></i>
                                                </a>

                                                <form action="{{ route('admin.settings.layanan.destroy', $r->id) }}"
                                                    method="POST" style="display:inline;" class="js-delete-form"
                                                    data-delete-title="Hapus Layanan?"
                                                    data-delete-text="Apakah Anda yakin ingin menghapus layanan ini?">
                                                    @csrf
                                                    @method('DELETE')

                                                    <button type="submit" class="btn btn-link btn-danger"
                                                        title="Hapus">
                                                        <i class="fa fa-times"></i>
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
    </div>
</div>

<x-admin.footer />
