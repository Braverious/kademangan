<x-admin.header :title="$title" />
<x-admin.sidebar />

<div class="page-inner">

    <!-- HEADER & BREADCRUMB -->
    <div class="page-header">
        <h4 class="page-title">Jangkauan Layanan</h4>
        <ul class="breadcrumbs">
            <li class="nav-home">
                <a href="{{ route('admin.dashboard') }}">
                    <i class="flaticon-home"></i>
                </a>
            </li>
            <li class="separator"><i class="flaticon-right-arrow"></i></li>
            <li class="nav-item"><a>Manajemen Konten</a></li>
            <li class="separator"><i class="flaticon-right-arrow"></i></li>
            <li class="nav-item"><a>Jangkauan Layanan</a></li>
        </ul>
    </div>

    <div class="row">
        <div class="col-md-12">

            <!-- FLASH -->
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <!-- CARD -->
            <div class="card">

                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <h4 class="card-title">Jangkauan Layanan</h4>

                        <button form="form-coverage" class="btn btn-primary btn-round ml-auto">
                            <i class="fa fa-save mr-2"></i>
                            Simpan
                        </button>
                    </div>
                </div>

                <!-- FORM -->
                <form id="form-coverage" action="{{ route('admin.coverage.update') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf

                    <div class="card-body p-0">
                        <div class="table-responsive">

                            <table class="table table-striped">
                                <thead class="thead-light">
                                    <tr>
                                        <th style="width:220px">Item</th>
                                        <th style="width:180px">Jumlah</th>
                                        <th style="width:200px">Ikon Saat Ini</th>
                                        <th>Upload Ikon Baru</th>
                                    </tr>
                                </thead>

                                <tbody>

                                    <!-- KK -->
                                    <tr>
                                        <td>
                                            <span class="badge badge-info px-3 py-2">
                                                KK yang Dilayani
                                            </span>
                                        </td>

                                        <td>
                                            <input type="number" min="0" class="form-control" name="jumlah_kk"
                                                value="{{ $coverage->jumlah_kk ?? 0 }}" required>
                                        </td>

                                        <td>
                                            @if (!empty($coverage->icon_kk))
                                                <img src="{{ asset('storage/' . $coverage->icon_kk) }}"
                                                    class="img-thumbnail" style="max-height:70px">
                                            @else
                                                <small class="text-muted">Belum ada ikon.</small>
                                            @endif
                                        </td>

                                        <td>
                                            <input type="file" name="icon_kk" class="form-control"
                                                accept=".png,.jpg,.jpeg,.webp,.svg">
                                            <small class="text-muted">
                                                Rekomendasi 256×256, background transparan.
                                            </small>
                                        </td>
                                    </tr>

                                    <!-- PENDUDUK -->
                                    <tr>
                                        <td>
                                            <span class="badge badge-info px-3 py-2">
                                                Jumlah Penduduk
                                            </span>
                                        </td>

                                        <td>
                                            <input type="number" min="0" class="form-control"
                                                name="jumlah_penduduk" value="{{ $coverage->jumlah_penduduk ?? 0 }}"
                                                required>
                                        </td>

                                        <td>
                                            @if (!empty($coverage->icon_penduduk))
                                                <img src="{{ asset('storage/' . $coverage->icon_penduduk) }}"
                                                    class="img-thumbnail" style="max-height:70px">
                                            @else
                                                <small class="text-muted">Belum ada ikon.</small>
                                            @endif
                                        </td>

                                        <td>
                                            <input type="file" name="icon_penduduk" class="form-control"
                                                accept=".png,.jpg,.jpeg,.webp,.svg">
                                            <small class="text-muted">
                                                Rekomendasi 256×256, background transparan.
                                            </small>
                                        </td>
                                    </tr>

                                    <!-- RW -->
                                    <tr>
                                        <td>
                                            <span class="badge badge-info px-3 py-2">
                                                Jumlah RW
                                            </span>
                                        </td>

                                        <td>
                                            <input type="number" min="0" class="form-control" name="jumlah_rw"
                                                value="{{ $coverage->jumlah_rw ?? 0 }}" required>
                                        </td>

                                        <td>
                                            @if (!empty($coverage->icon_rw))
                                                <img src="{{ asset('storage/' . $coverage->icon_rw) }}"
                                                    class="img-thumbnail" style="max-height:70px">
                                            @else
                                                <small class="text-muted">Belum ada ikon.</small>
                                            @endif
                                        </td>

                                        <td>
                                            <input type="file" name="icon_rw" class="form-control"
                                                accept=".png,.jpg,.jpeg,.webp,.svg">
                                            <small class="text-muted">
                                                Rekomendasi 256×256, background transparan.
                                            </small>
                                        </td>
                                    </tr>

                                    <!-- RT -->
                                    <tr>
                                        <td>
                                            <span class="badge badge-info px-3 py-2">
                                                Jumlah RT
                                            </span>
                                        </td>

                                        <td>
                                            <input type="number" min="0" class="form-control" name="jumlah_rt"
                                                value="{{ $coverage->jumlah_rt ?? 0 }}" required>
                                        </td>

                                        <td>
                                            @if (!empty($coverage->icon_rt))
                                                <img src="{{ asset('storage/' . $coverage->icon_rt) }}"
                                                    class="img-thumbnail" style="max-height:70px">
                                            @else
                                                <small class="text-muted">Belum ada ikon.</small>
                                            @endif
                                        </td>

                                        <td>
                                            <input type="file" name="icon_rt" class="form-control"
                                                accept=".png,.jpg,.jpeg,.webp,.svg">
                                            <small class="text-muted">
                                                Rekomendasi 256×256, background transparan.
                                            </small>
                                        </td>
                                    </tr>

                                </tbody>
                            </table>

                        </div>
                    </div>

                </form>

            </div>

        </div>
    </div>
</div>

<x-admin.footer />
