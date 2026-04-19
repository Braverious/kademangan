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
            <li class="nav-item">
                <a href="{{ route('admin.layanan') }}">Layanan</a>
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

                        <!-- JUDUL -->
                        <div class="form-group">
                            <label>Judul</label>
                            <input type="text" name="judul" class="form-control" value="{{ old('judul') }}"
                                required>
                        </div>

                        <!-- DESKRIPSI -->
                        <div class="form-group">
                            <label>Deskripsi</label>
                            <textarea name="deskripsi" class="form-control" rows="6" required>{{ old('deskripsi') }}</textarea>
                        </div>

                        <!-- ROW -->
                        <div class="row">

                            <!-- URUT -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Urut</label>
                                    <input type="number" name="urut" value="{{ old('urut', 0) }}"
                                        class="form-control">
                                </div>
                            </div>

                            <!-- AKTIF -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Aktif?</label>
                                    <select name="aktif" class="form-control">
                                        <option value="1" {{ old('aktif', 1) == 1 ? 'selected' : '' }}>Ya</option>
                                        <option value="0" {{ old('aktif') == 0 ? 'selected' : '' }}>Tidak</option>
                                    </select>
                                </div>
                            </div>

                            <!-- GAMBAR -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Gambar (jpg/jpeg/png/webp, max 2MB)</label>
                                    <input type="file" name="gambar" class="form-control"
                                        accept=".jpg,.jpeg,.png,.webp" required>
                                </div>
                            </div>

                        </div>

                        <!-- BUTTON -->
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                Simpan
                            </button>

                            <a href="{{ route('admin.layanan') }}" class="btn btn-secondary">
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
