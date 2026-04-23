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
            <li class="nav-item"><a href="#">Pengaturan</a></li>
            <li class="separator"><i class="flaticon-right-arrow"></i></li>
            <li class="nav-item">
                <a href="{{ route('admin.settings.jabatan.index') }}">Manajemen Jabatan</a>
            </li>
            <li class="separator"><i class="flaticon-right-arrow"></i></li>
            <li class="nav-item"><a>Tambah</a></li>
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
                    <h4 class="card-title">Form Tambah Jabatan</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.settings.jabatan.store') }}" method="POST">
                        @csrf

                        <div class="form-group">
                            <label>Nama Jabatan</label>
                            <input type="text" name="nama" class="form-control" value="{{ old('nama') }}" required>
                        </div>

                        <div class="form-group">
                            <label>Urut</label>
                            <input type="number" name="urut" class="form-control" value="{{ old('urut', 0) }}" min="0">
                        </div>

                        <div class="form-group">
                            <label>Status</label>
                            <select name="is_active" class="form-control">
                                <option value="1" {{ old('is_active', '1') == '1' ? 'selected' : '' }}>Aktif</option>
                                <option value="0" {{ old('is_active') == '0' ? 'selected' : '' }}>Nonaktif</option>
                            </select>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                            <a href="{{ route('admin.settings.jabatan.index') }}" class="btn btn-secondary">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<x-admin.footer />
