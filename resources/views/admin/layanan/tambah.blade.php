<x-admin.header :title="$title" />
<x-admin.sidebar />

<div class="page-inner">

    <!-- HEADER -->
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
                <a>Tambah</a>
            </li>
        </ul>
    </div>

    <div class="row">
        <div class="col-md-12">

            {{-- FLASH ERROR --}}
            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            {{-- VALIDATION ERROR --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Form Tambah Layanan</h4>
                </div>

                <div class="card-body">

                    <form action="{{ route('admin.layanan.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group">
                            <label class="required">Judul</label>
                            <input type="text" name="judul" class="form-control" value="{{ old('judul') }}" required>
                        </div>

                        <div class="form-group">
                            <label class="required">Gambar Layanan (jpg/jpeg/png/webp, max 2MB)</label>
                            <input type="file" name="gambar" class="form-control" accept=".jpg,.jpeg,.png,.webp" required>
                        </div>

                        <div class="form-group">
                            <label class="required">Deskripsi</label>
                            <textarea name="deskripsi" class="form-control" rows="6" required>{{ old('deskripsi') }}</textarea>
                        </div>

                        <div class="form-group d-flex gap-2 mt-3">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-save mr-2"></i> Simpan
                            </button>
                            <a href="{{ route('admin.layanan.index') }}" class="btn btn-secondary">
                                Batal
                            </a>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>
</div>

<x-admin.footer />
