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
                        <a href="{{ route('admin.users.create') }}" class="btn btn-primary btn-round ml-auto">
                            <i class="fa fa-plus mr-2"></i> Tambah User
                        </a>
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
                                                <a href="{{ route('admin.users.edit', $user->id_user) }}" title="Edit" class="btn btn-link btn-primary btn-lg">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                                
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

<x-admin.footer />
