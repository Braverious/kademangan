<x-admin.header :title="$title" />
<x-admin.sidebar />

<div class="page-inner">
    <div class="page-header">
        <h4 class="page-title">{{ $title }}</h4>
        <ul class="breadcrumbs">
            <li class="nav-home"><a href="#"><i class="flaticon-home"></i></a></li>
            <li class="separator"><i class="flaticon-right-arrow"></i></li>
            <li class="nav-item"><a>Pengaturan</a></li>
            <li class="separator"><i class="flaticon-right-arrow"></i></li>
            <li class="nav-item"><a href="{{ route('admin.users.index') }}">Manajemen User</a></li>
            <li class="separator"><i class="flaticon-right-arrow"></i></li>
            <li class="nav-item"><a>Edit</a></li>
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
                    <h4 class="card-title">Form Edit User</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.users.update', $user->id_user) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label>Nama Lengkap</label>
                            <input type="text" name="nama_lengkap" class="form-control" value="{{ old('nama_lengkap', $user->nama_lengkap) }}" required>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>NIP (Opsional)</label>
                                    <input type="text" name="nip" class="form-control" value="{{ old('nip', $user->nip) }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Jabatan (Opsional)</label>
                                    <select name="jabatan_id" class="form-control">
                                        <option value="">-- Tanpa Jabatan --</option>
                                        @foreach($jabatans as $jab)
                                            <option value="{{ $jab->id }}" {{ old('jabatan_id', $user->jabatan_id) == $jab->id ? 'selected' : '' }}>
                                                {{ $jab->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Level Akses</label>
                            @if($user->id_user == 1)
                                <input type="text" class="form-control" value="Superadmin (Absolut)" readonly>
                                <input type="hidden" name="id_level" value="1">
                            @else
                                <select name="id_level" class="form-control" required>
                                    @foreach($levels as $lvl)
                                        <option value="{{ $lvl->id_level }}" {{ old('id_level', $user->id_level) == $lvl->id_level ? 'selected' : '' }}>
                                            {{ $lvl->nama_level }}
                                        </option>
                                    @endforeach
                                </select>
                            @endif
                        </div>

                        <div class="form-group">
                            <label>Username</label>
                            <input type="text" name="username" class="form-control" value="{{ old('username', $user->username) }}" required>
                        </div>

                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control">
                            <small class="form-text text-muted">Kosongkan jika tidak ingin mengubah password.</small>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">Update</button>
                            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<x-admin.footer />
