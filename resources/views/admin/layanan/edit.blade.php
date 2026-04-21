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
            <li class="nav-item"><a>Pengaturan</a></li>
            <li class="separator"><i class="flaticon-right-arrow"></i></li>
            <li class="nav-item">
                <a href="{{ route('admin.layanan.index') }}">Manajemen Layanan</a>
            </li>
            <li class="separator"><i class="flaticon-right-arrow"></i></li>
            <li class="nav-item">
                <a href="#">Edit</a>
            </li>
        </ul>
    </div>

    <div class="row">
        <div class="col-md-12">
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
                    <h4 class="card-title">Form Edit Layanan</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.layanan.update', $row->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label>Judul</label>
                            <input type="text"
                                name="judul"
                                value="{{ old('judul', $row->judul) }}"
                                class="form-control"
                                required>
                        </div>

                        <div class="form-group">
                            <label>Deskripsi</label>
                            <textarea name="deskripsi"
                                class="form-control"
                                rows="6"
                                required>{{ old('deskripsi', $row->deskripsi) }}</textarea>
                        </div>

                        <div class="form-group">
                            <label>Ganti Gambar (opsional)</label>
                            <input type="file"
                                name="gambar"
                                class="form-control"
                                accept=".jpg,.jpeg,.png,.webp">
                            <small class="text-muted">Kosongkan jika tidak ingin mengganti.</small>
                        </div>

                        <div class="form-group">
                            <label>Gambar Saat Ini</label><br>
                            @if (!empty($row->gambar))
                                <img src="{{ asset('storage/' . $row->gambar) }}"
                                    alt="gambar"
                                    style="max-width:220px;border:1px solid #eee;border-radius:6px;">
                            @else
                                <em>Belum ada gambar</em>
                            @endif
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                            <a href="{{ route('admin.layanan.index') }}" class="btn btn-secondary">Batal</a>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

<x-admin.footer />