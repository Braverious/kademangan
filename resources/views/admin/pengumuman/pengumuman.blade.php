<x-admin.header :title="$title" />
<x-admin.sidebar />

<div class="page-inner">
    <x-admin.breadcrumbs :title="$title" :breadcrumbs="$breadcrumbs" />
    <div class="row">
        <div class="col-md-12">
            <div class="card">

                <div class="card-header">
                    <div class="d-flex align-items-center flex-wrap gap-2 w-100">
                        <h4 class="card-title mb-0">Daftar Pengumuman</h4>

                        <a class="btn btn-primary btn-round ml-auto" href="{{ route('admin.pengumuman.create') }}">
                            <i class="fa fa-plus"></i> Tambah
                        </a>
                    </div>
                </div>

                <div class="card-body">

                    {{-- FLASH MESSAGE --}}
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    {{-- SEARCH --}}
                    <form class="mb-3" method="GET" id="searchPengumumanForm">
                        <div>
                            <input type="text" name="q" id="searchPengumumanInput" class="form-control"
                                value="{{ request('q') }}" placeholder="Cari judul/isi...">
                        </div>
                    </form>

                    <div class="table-responsive">
                        <table class="display table table-striped table-hover w-100 admin-table-wide">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Judul</th>
                                    <th>Tipe</th>
                                    <th>Mulai</th>
                                    <th>Berakhir</th>
                                    <th>Status</th> {{-- BARU --}}
                                    <th>Kondisi</th> {{-- BARU --}}
                                    <th style="width:12%">Aksi</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse ($pengumuman_list as $index => $p)
                                    @php
                                        $now = now();

                                        $isActive =
                                            $p->status === 'publish' &&
                                            $p->mulai_tayang <= $now &&
                                            (!$p->berakhir_tayang || $p->berakhir_tayang > $now);
                                    @endphp

                                    <tr>
                                        <td>{{ $index + 1 }}</td>

                                        <td>{{ $p->judul }}</td>

                                        {{-- TIPE --}}
                                        <td>
                                            <span
                                                class="badge 
                                                {{ $p->tipe === 'penting' ? 'badge-danger' : ($p->tipe === 'peringatan' ? 'badge-warning' : 'badge-info') }}">
                                                {{ ucfirst($p->tipe) }}
                                            </span>
                                        </td>

                                        {{-- MULAI --}}
                                        <td>
                                            {{ $p->mulai_tayang ? \Carbon\Carbon::parse($p->mulai_tayang)->format('d M Y H:i') : '-' }}
                                        </td>

                                        {{-- BERAKHIR --}}
                                        <td>
                                            {{ $p->berakhir_tayang ? \Carbon\Carbon::parse($p->berakhir_tayang)->format('d M Y H:i') : '-' }}
                                        </td>

                                        {{-- STATUS DATABASE --}}
                                        <td>
                                            @if ($p->status == 'publish')
                                                <span class="badge badge-success">Publish</span>
                                            @else
                                                <span class="badge badge-secondary">Draft</span>
                                            @endif
                                        </td>

                                        {{-- KONDISI DINAMIS --}}
                                        <td>
                                            @if ($p->status == 'draft')
                                                <span class="badge badge-secondary">Draft</span>
                                            @elseif ($isActive)
                                                <span class="badge badge-success">Aktif</span>
                                            @elseif ($p->mulai_tayang > $now)
                                                <span class="badge badge-warning">Akan Tayang</span>
                                            @else
                                                <span class="badge badge-dark">Selesai</span>
                                            @endif
                                        </td>

                                        {{-- AKSI --}}
                                        <td>
                                            <div class="form-button-action">

                                                <a href="{{ route('admin.pengumuman.edit', $p->id) }}"
                                                    class="btn btn-link btn-primary btn-lg" title="Edit">
                                                    <i class="fa fa-edit"></i>
                                                </a>

                                                <form action="{{ route('admin.pengumuman.destroy', $p->id) }}"
                                                    method="POST" style="display:inline;" class="js-delete-form"
                                                    data-delete-title="Hapus Pengumuman?"
                                                    data-delete-text="Apakah Anda yakin ingin menghapus pengumuman ini?">

                                                    @csrf
                                                    @method('DELETE')

                                                    <button class="btn btn-link btn-danger" title="Hapus">
                                                        <i class="fa fa-times"></i>
                                                    </button>
                                                </form>

                                            </div>
                                        </td>
                                    </tr>

                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center text-muted">
                                            Belum ada data.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>

                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<x-admin.footer />
