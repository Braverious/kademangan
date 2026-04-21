<x-admin.header :title="$title" />
<x-admin.sidebar />

<div class="page-inner">

    <div class="page-header mb-4">
        <h4 class="page-title font-weight-bold">Jangkauan Wilayah</h4>
        <ul class="breadcrumbs">
            <li class="nav-home">
                <a href="{{ route('admin.dashboard') }}" class="text-muted">
                    <i class="flaticon-home"></i>
                </a>
            </li>
            <li class="separator"><i class="flaticon-right-arrow"></i></li>
            <li class="nav-item"><a href="#">Pengaturan</a></li>
            <li class="separator"><i class="flaticon-right-arrow text-muted"></i></li>
            <li class="nav-item"><a href="#">Jangkauan Layanan</a></li>
        </ul>
    </div>

    <div class="row">
        <div class="col-md-12">

            @if (session('success'))
                <div class="alert alert-success shadow-sm rounded d-flex align-items-center mb-4">
                    <i class="fa fa-check-circle mr-2" style="font-size: 1.2rem;"></i>
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger shadow-sm rounded d-flex align-items-center mb-4">
                    <i class="fa fa-exclamation-circle mr-2" style="font-size: 1.2rem;"></i>
                    {{ session('error') }}
                </div>
            @endif

            <div class="card border-0 shadow-sm" style="border-radius: 16px;">
                
                <div class="card-header bg-white pt-4 pb-3" style="border-radius: 16px 16px 0 0;">
                    <div class="d-flex align-items-center justify-content-between">
                        <h4 class="card-title font-weight-bold m-0 text-primary">Update Jangkauan</h4>
                        <button form="form-coverage" class="btn btn-primary btn-round px-4 shadow-sm">
                            <i class="fa fa-save mr-2"></i> Simpan Perubahan
                        </button>
                    </div>
                </div>

                <div class="card-body bg-light p-4">
                    <form id="form-coverage" action="{{ route('admin.coverage.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="coverage-item-card item-card-info bg-white p-3 mb-3 rounded border">
                            <div class="row align-items-center">
                                <div class="col-md-3 mb-3 mb-md-0 border-right-md pl-md-4">
                                    <h6 class="font-weight-bold m-0 text-dark">Jumlah KK</h6>
                                </div>
                                <div class="col-md-3 mb-3 mb-md-0 border-right-md px-md-4">
                                    <label class="text-muted font-weight-bold text-uppercase d-block" style="font-size: 0.75rem;">Total Jumlah</label>
                                    <input type="number" min="0" class="form-control font-weight-bold text-primary" name="jumlah_kk" value="{{ $coverage->jumlah_kk ?? 0 }}" required>
                                </div>
                                <div class="col-md-2 mb-3 mb-md-0 border-right-md text-center">
                                    <label class="text-muted font-weight-bold text-uppercase d-block" style="font-size: 0.75rem;">Ikon Aktif</label>
                                    <div class="current-icon-box mx-auto">
                                        @if (!empty($coverage->icon_kk))
                                            <img src="{{ asset('storage/' . $coverage->icon_kk) }}" alt="Ikon KK">
                                        @else
                                            <div class="empty-icon text-muted"><i class="fa fa-image fa-lg"></i></div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-4 px-md-4">
                                    <label class="text-muted font-weight-bold text-uppercase d-block" style="font-size: 0.75rem;">Upload Ikon Baru</label>
                                    <input type="file" name="icon_kk" class="form-control coverage-file-input" accept=".png,.jpg,.jpeg,.webp,.svg" data-preview="preview_kk">
                                    <div class="d-flex justify-content-between align-items-center mt-2">
                                        <small class="text-muted"><i class="fa fa-info-circle mr-1"></i> Rekomendasi 256×256</small>
                                        <img id="preview_kk" class="upload-preview-img d-none" src="" alt="Preview">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="coverage-item-card item-card-success bg-white p-3 mb-3 rounded border">
                            <div class="row align-items-center">
                                <div class="col-md-3 mb-3 mb-md-0 border-right-md pl-md-4">
                                    <h6 class="font-weight-bold m-0 text-dark">Jumlah Penduduk</h6>
                                </div>
                                <div class="col-md-3 mb-3 mb-md-0 border-right-md px-md-4">
                                    <label class="text-muted font-weight-bold text-uppercase d-block" style="font-size: 0.75rem;">Total Jumlah</label>
                                    <input type="number" min="0" class="form-control font-weight-bold text-primary" name="jumlah_penduduk" value="{{ $coverage->jumlah_penduduk ?? 0 }}" required>
                                </div>
                                <div class="col-md-2 mb-3 mb-md-0 border-right-md text-center">
                                    <label class="text-muted font-weight-bold text-uppercase d-block" style="font-size: 0.75rem;">Ikon Aktif</label>
                                    <div class="current-icon-box mx-auto">
                                        @if (!empty($coverage->icon_penduduk))
                                            <img src="{{ asset('storage/' . $coverage->icon_penduduk) }}" alt="Ikon Penduduk">
                                        @else
                                            <div class="empty-icon text-muted"><i class="fa fa-image fa-lg"></i></div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-4 px-md-4">
                                    <label class="text-muted font-weight-bold text-uppercase d-block" style="font-size: 0.75rem;">Upload Ikon Baru</label>
                                    <input type="file" name="icon_penduduk" class="form-control coverage-file-input" accept=".png,.jpg,.jpeg,.webp,.svg" data-preview="preview_penduduk">
                                    <div class="d-flex justify-content-between align-items-center mt-2">
                                        <small class="text-muted"><i class="fa fa-info-circle mr-1"></i> Rekomendasi 256×256</small>
                                        <img id="preview_penduduk" class="upload-preview-img d-none" src="" alt="Preview">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="coverage-item-card item-card-warning bg-white p-3 mb-3 rounded border">
                            <div class="row align-items-center">
                                <div class="col-md-3 mb-3 mb-md-0 border-right-md pl-md-4">
                                    <h6 class="font-weight-bold m-0 text-dark">Jumlah RW</h6>
                                </div>
                                <div class="col-md-3 mb-3 mb-md-0 border-right-md px-md-4">
                                    <label class="text-muted font-weight-bold text-uppercase d-block" style="font-size: 0.75rem;">Total Jumlah</label>
                                    <input type="number" min="0" class="form-control font-weight-bold text-primary" name="jumlah_rw" value="{{ $coverage->jumlah_rw ?? 0 }}" required>
                                </div>
                                <div class="col-md-2 mb-3 mb-md-0 border-right-md text-center">
                                    <label class="text-muted font-weight-bold text-uppercase d-block" style="font-size: 0.75rem;">Ikon Aktif</label>
                                    <div class="current-icon-box mx-auto">
                                        @if (!empty($coverage->icon_rw))
                                            <img src="{{ asset('storage/' . $coverage->icon_rw) }}" alt="Ikon RW">
                                        @else
                                            <div class="empty-icon text-muted"><i class="fa fa-image fa-lg"></i></div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-4 px-md-4">
                                    <label class="text-muted font-weight-bold text-uppercase d-block" style="font-size: 0.75rem;">Upload Ikon Baru</label>
                                    <input type="file" name="icon_rw" class="form-control coverage-file-input" accept=".png,.jpg,.jpeg,.webp,.svg" data-preview="preview_rw">
                                    <div class="d-flex justify-content-between align-items-center mt-2">
                                        <small class="text-muted"><i class="fa fa-info-circle mr-1"></i> Rekomendasi 256×256</small>
                                        <img id="preview_rw" class="upload-preview-img d-none" src="" alt="Preview">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="coverage-item-card item-card-danger bg-white p-3 mb-0 rounded border">
                            <div class="row align-items-center">
                                <div class="col-md-3 mb-3 mb-md-0 border-right-md pl-md-4">
                                    <h6 class="font-weight-bold m-0 text-dark">Jumlah RT</h6>
                                </div>
                                <div class="col-md-3 mb-3 mb-md-0 border-right-md px-md-4">
                                    <label class="text-muted font-weight-bold text-uppercase d-block" style="font-size: 0.75rem;">Total Jumlah</label>
                                    <input type="number" min="0" class="form-control font-weight-bold text-primary" name="jumlah_rt" value="{{ $coverage->jumlah_rt ?? 0 }}" required>
                                </div>
                                <div class="col-md-2 mb-3 mb-md-0 border-right-md text-center">
                                    <label class="text-muted font-weight-bold text-uppercase d-block" style="font-size: 0.75rem;">Ikon Aktif</label>
                                    <div class="current-icon-box mx-auto">
                                        @if (!empty($coverage->icon_rt))
                                            <img src="{{ asset('storage/' . $coverage->icon_rt) }}" alt="Ikon RT">
                                        @else
                                            <div class="empty-icon text-muted"><i class="fa fa-image fa-lg"></i></div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-4 px-md-4">
                                    <label class="text-muted font-weight-bold text-uppercase d-block" style="font-size: 0.75rem;">Upload Ikon Baru</label>
                                    <input type="file" name="icon_rt" class="form-control coverage-file-input" accept=".png,.jpg,.jpeg,.webp,.svg" data-preview="preview_rt">
                                    <div class="d-flex justify-content-between align-items-center mt-2">
                                        <small class="text-muted"><i class="fa fa-info-circle mr-1"></i> Rekomendasi 256×256</small>
                                        <img id="preview_rt" class="upload-preview-img d-none" src="" alt="Preview">
                                    </div>
                                </div>
                            </div>
                        </div>

                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

<x-admin.footer />