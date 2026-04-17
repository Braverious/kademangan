<x-admin.header :title="$title" />
<x-admin.sidebar />

<style>
    :root {
        --blue-900: #0a2a66;
        --blue-700: #0f3a8a;
        --blue-600: #1147a7;
        --blue-500: #1666cc;
        --blue-100: #eaf2ff;
        --yellow-500: #ffc107;
        --paper: #ffffff;
        --ink: #0b1220;
        --line: #e9eef5;
    }

    .page-header {
        position: relative;
        padding-bottom: 10px;
        margin-bottom: 14px;
        border: 0;
    }

    .page-header .page-title {
        color: var(--blue-700);
        font-weight: 700;
    }

    .page-header::after {
        content: "";
        display: block;
        height: 3px;
        background: var(--yellow-500);
        border-radius: 2px;
    }

    .card {
        border: 0;
        border-radius: 16px;
        background: #fff;
        box-shadow: 0 10px 28px rgba(17, 71, 167, .08);
    }

    .card-header {
        border: 0;
        padding: 16px 20px;
        background: linear-gradient(180deg, #fff, #f9fbff);
        border-radius: 16px 16px 0 0;
        box-shadow: inset 0 -3px 0 0 var(--yellow-500);
    }

    .card-title {
        margin: 0;
        font-weight: 700;
        color: var(--blue-700);
    }

    .card-body {
        padding: 20px;
    }

    .card-action {
        border-top: 1px solid var(--line);
        background: #fafcff;
        border-radius: 0 0 16px 16px;
        padding: 14px 20px;
    }

    .form-group label {
        font-weight: 600;
        color: #45526b;
    }

    .form-text {
        color: #6c7a91;
    }

    .form-control {
        border: 1px solid #e6e8ef;
        border-radius: 12px;
        padding: .6rem .8rem;
        background: #fff;
        box-shadow: none;
        transition: all .15s ease;
    }

    .form-control:focus {
        border-color: var(--blue-600);
        box-shadow: 0 0 0 4px rgba(17, 71, 167, .12);
    }

    .form-group:focus-within label {
        color: var(--blue-600);
    }

    input[type="file"].form-control {
        padding: .4rem .8rem;
    }

    input[type="file"].form-control::file-selector-button {
        margin-right: .8rem;
        padding: .45rem .8rem;
        border: 0;
        border-radius: 10px;
        background: var(--blue-600);
        color: #fff;
        cursor: pointer;
        transition: filter .15s;
    }

    input[type="file"].form-control::file-selector-button:hover {
        filter: brightness(.95);
    }

    .avatar-img.rounded-circle {
        box-shadow: 0 0 0 4px var(--paper), 0 0 0 6px var(--blue-100), 0 8px 20px rgba(17, 71, 167, .15);
    }

    .card .btn-primary {
        background: var(--blue-600);
        border-color: var(--blue-600);
        border-radius: 12px;
        padding: .55rem 1.1rem;
        box-shadow: 0 8px 20px rgba(17, 71, 167, .18);
        transition: transform .12s ease, box-shadow .12s ease, background .12s;
    }

    .card .btn-primary:hover {
        background: var(--blue-700);
        border-color: var(--blue-700);
        transform: translateY(-1px);
        box-shadow: 0 12px 26px rgba(17, 71, 167, .24);
    }

    .card .btn-primary:focus {
        box-shadow: 0 0 0 4px rgba(17, 71, 167, .20);
    }

    .alert {
        border-radius: 12px;
    }

    .alert-success {
        border-left: 4px solid #16a34a;
    }

    .alert-danger {
        border-left: 4px solid #e11d48;
    }

    @media (max-width: 575.98px) {
        .card-body .row>[class*="col-"] {
            margin-bottom: .75rem;
        }
    }
</style>

<div class="page-inner">
    <div class="page-header">
        <h4 class="page-title">Profil Saya</h4>
    </div>

    <div class="row">
        <div class="col-md-12">

            @if (session('success'))
                <div class="alert alert-success" role="alert">{{ session('success') }}</div>
            @endif

            @if (session('error') || $errors->any())
                <div class="alert alert-danger" role="alert">
                    {{ session('error') }}
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <div class="card">
                <div class="card-header">
                    <div class="card-title">Edit Profil</div>
                </div>
                <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group text-center">
                                    <label>Foto Profil</label><br>
                                    <img src="{{ asset('uploads/profil/' . $user->foto) }}" alt="Foto Profil"
                                        class="avatar-img rounded-circle mb-2"
                                        style="width: 150px; height: 150px; object-fit: cover;">
                                    <input type="file" name="foto" class="form-control mt-2">
                                    <small class="form-text text-muted">Kosongkan jika tidak ingin mengubah
                                        foto.</small>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="nama_lengkap">Nama Lengkap</label>
                                            <input type="text" class="form-control" name="nama_lengkap"
                                                value="{{ old('nama_lengkap', $user->nama_lengkap) }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="username">Username</label>
                                            <input type="text" class="form-control" name="username"
                                                value="{{ old('username', $user->username) }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="password_lama">Password Lama</label>
                                            <input type="password" class="form-control" name="password_lama">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="password_baru">Password Baru</label>
                                            <input type="password" class="form-control" name="password_baru">
                                            <small class="form-text text-muted">Kosongkan jika tidak ingin mengubah
                                                password.</small>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="konfirmasi_password">Konfirmasi Password Baru</label>
                                            <input type="password" class="form-control" name="konfirmasi_password">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-action">
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<x-admin.footer />
