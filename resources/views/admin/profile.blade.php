<x-admin.header :title="$title" />
<x-admin.sidebar />
<div class="page-inner admin-profile">
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
                                        class="avatar-img rounded-circle mb-2 profile-avatar-preview">
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
