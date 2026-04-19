<x-admin.header :title="$title" />
<x-admin.sidebar />

<div class="page-inner">
    <div class="page-header">
        <h4 class="page-title">{{ $title }}</h4>
        <ul class="breadcrumbs">
            <li class="nav-home"><a href="#"><i class="flaticon-home"></i></a></li>
            <li class="separator"><i class="flaticon-right-arrow"></i></li>
            <li class="nav-item"><a href="#">Administrator</a></li>
            <li class="separator"><i class="flaticon-right-arrow"></i></li>
            <li class="nav-item"><a href="#">{{ $title }}</a></li>
        </ul>
    </div>
    
    <div class="row">
        <div class="col-md-12">
            
            {{-- Alert Handling (Sukses / Error / Validasi) --}}
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
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
                    <div class="d-flex align-items-center">
                        <h4 class="card-title">Daftar User</h4>
                        <button class="btn btn-primary btn-round ml-auto" data-toggle="modal" data-target="#addUserModal">
                            <i class="fa fa-plus mr-2"></i> Tambah User
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="display table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th style="width: 5%">No</th>
                                    <th>Nama Lengkap & Info</th>
                                    <th>Username</th>
                                    <th>Level Akses</th>
                                    <th style="width: 10%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($user_list as $user)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            <strong>{{ $user->nama_lengkap }}</strong><br>
                                            
                                            {{-- Cek apakah user punya relasi jabatan --}}
                                            @if($user->jabatan_id)
                                                <small class="text-primary fw-bold">{{ $user->relasiJabatan->nama ?? 'Jabatan Tidak Diketahui' }}</small>
                                            @endif
                                            
                                            {{-- Cek apakah user punya NIP --}}
                                            @if($user->nip)
                                                <small class="text-muted"> | NIP: {{ $user->nip }}</small>
                                            @endif
                                        </td>
                                        <td>{{ $user->username }}</td>
                                        <td><span class="badge badge-info">{{ $user->level->nama_level ?? 'Staff' }}</span></td>
                                        <td>
                                            <div class="form-button-action d-flex">
                                                {{-- Tombol Edit selalu tampil agar profile Master tetap bisa diupdate --}}
                                                <button type="button" data-toggle="modal" data-target="#editUserModal{{ $user->id_user }}" title="Edit" class="btn btn-link btn-primary btn-lg">
                                                    <i class="fa fa-edit"></i>
                                                </button>
                                                
                                                {{-- Sembunyikan tombol Hapus KHUSUS untuk akun dengan ID 1 --}}
                                                @if($user->id_user != 1)
                                                    <form action="{{ route('admin.users.destroy', $user->id_user) }}" method="POST" onsubmit="return confirm('Yakin ingin hapus user ini?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" title="Hapus" class="btn btn-link btn-danger">
                                                            <i class="fa fa-times"></i>
                                                        </button>
                                                    </form>
                                                @endif
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

{{-- ================= MODAL TAMBAH USER ================= --}}
<div class="modal fade" id="addUserModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header no-bd">
                <h5 class="modal-title"><span class="fw-mediumbold">Tambah</span> Admin/Staff Baru</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <form action="{{ route('admin.users.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nama Lengkap</label>
                        <input type="text" name="nama_lengkap" class="form-control" value="{{ old('nama_lengkap') }}" required>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>NIP (Opsional)</label>
                                <input type="text" name="nip" class="form-control" placeholder="Masukkan NIP" value="{{ old('nip') }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Jabatan (Opsional)</label>
                                <select name="jabatan_id" class="form-control">
                                    <option value="">-- Tanpa Jabatan --</option>
                                    @foreach($jabatans as $jab)
                                        <option value="{{ $jab->id }}" {{ old('jabatan_id') == $jab->id ? 'selected' : '' }}>
                                            {{ $jab->nama }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Level Akses</label>
                        <select name="id_level" class="form-control" required>
                            <option value="">-- Pilih Level --</option>
                            @foreach($levels as $lvl)
                                <option value="{{ $lvl->id_level }}" {{ old('id_level') == $lvl->id_level ? 'selected' : '' }}>
                                    {{ $lvl->nama_level }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label>Username</label>
                        <input type="text" name="username" class="form-control" value="{{ old('username') }}" required>
                    </div>
                    
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer no-bd">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- ================= MODAL EDIT USER ================= --}}
@foreach ($user_list as $user)
    <div class="modal fade" id="editUserModal{{ $user->id_user }}" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header no-bd">
                    <h5 class="modal-title"><span class="fw-mediumbold">Edit</span> Data Staff</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <form action="{{ route('admin.users.update', $user->id_user) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
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
                                {{-- Proteksi UI: Superadmin ID 1 tidak bisa diubah levelnya via form --}}
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
                    </div>
                    <div class="modal-footer no-bd">
                        <button type="submit" class="btn btn-primary">Update</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endforeach

<x-admin.footer />