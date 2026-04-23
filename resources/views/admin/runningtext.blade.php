<x-admin.header :title="$title" />
<x-admin.sidebar />

<div class="page-inner">
    {{-- <div class="page-header">
        <h4 class="page-title">{{ $title }}</h4>
        <ul class="breadcrumbs">
            <li class="nav-home">
                <a href="#"><i class="flaticon-home"></i></a>
            </li>
            <li class="separator"><i class="flaticon-right-arrow"></i></li>
            <li class="nav-item"><a>Pengaturan</a></li>
            <li class="separator"><i class="flaticon-right-arrow"></i></li>
            <li class="nav-item"><a>Running Text</a></li>
        </ul>
    </div> --}}
    <x-admin.breadcrumbs :title="$title" :breadcrumbs="$breadcrumbs" />
    <div class="row">
        <div class="col-md-12">
            @if (session('success'))
                <div class="alert alert-success shadow-sm">{{ session('success') }}</div>
            @endif
            @if ($errors->any())
                <div class="alert alert-danger shadow-sm">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h4 class="card-title">Running Text</h4>
                    <button form="form-runningtext" class="btn btn-primary btn-round">
                        <i class="fa fa-save mr-2"></i> Simpan
                    </button>
                </div>

                <div class="card-body">
                    <form action="{{ route('admin.settings.runningtext.update') }}" method="POST"
                        id="form-runningtext">
                        @csrf

                        {{-- ================= BLOCK TOP ================= --}}
                        <div class="setting-block">
                            <h5 class="font-weight-bold text-primary mb-4">
                                <i class="fa fa-arrow-up mr-2"></i> Posisi: Top
                            </h5>

                            <div class="row">
                                <div class="col-md-3 mb-3">
                                    <label class="form-label required">Arah Gerak</label>
                                    <select class="form-control form-select" name="top_direction" id="top_direction"
                                        required>
                                        <option value="left"
                                            {{ old('top_direction', $top->direction) == 'left' ? 'selected' : '' }}>Kiri
                                            (Left)</option>
                                        <option value="right"
                                            {{ old('top_direction', $top->direction) == 'right' ? 'selected' : '' }}>
                                            Kanan (Right)</option>
                                    </select>
                                </div>
                                <div class="col-md-2 mb-3">
                                    <label class="form-label required">Speed (1-10)</label>
                                    <input type="number" min="1" max="10" class="form-control"
                                        name="top_speed" id="top_speed" value="{{ old('top_speed', $top->speed) }}"
                                        required>
                                </div>
                                <div class="col-md-7 mb-3">
                                    <label class="form-label required">Konten Teks</label>
                                    <textarea class="form-control" name="top_content" id="top_content" rows="2" maxlength="255" required
                                        placeholder="Tulis pengumuman...">{{ old('top_content', $top->content) }}</textarea>
                                </div>
                            </div>

                            <div class="mt-2">
                                <label class="text-muted font-weight-bold"
                                    style="font-size: 0.85rem; text-transform: uppercase;">Live Preview Display</label>
                                <div class="preview-container">
                                    <marquee id="preview_marquee_top" behavior="scroll"
                                        direction="{{ $top->direction }}" scrollamount="{{ $top->speed }}">
                                        {{ $top->content ?: 'Preview teks akan muncul di sini...' }}
                                    </marquee>
                                </div>
                            </div>
                        </div>

                        {{-- ================= BLOCK BOTTOM ================= --}}
                        <div class="setting-block mb-0">
                            <h5 class="font-weight-bold text-info mb-4">
                                <i class="fa fa-arrow-down mr-2"></i> Posisi: Bottom
                            </h5>

                            <div class="row">
                                <div class="col-md-3 mb-3">
                                    <label class="form-label required">Arah Gerak</label>
                                    <select class="form-control form-select" name="bottom_direction"
                                        id="bottom_direction" required>
                                        <option value="left"
                                            {{ old('bottom_direction', $bottom->direction) == 'left' ? 'selected' : '' }}>
                                            Kiri (Left)</option>
                                        <option value="right"
                                            {{ old('bottom_direction', $bottom->direction) == 'right' ? 'selected' : '' }}>
                                            Kanan (Right)</option>
                                    </select>
                                </div>
                                <div class="col-md-2 mb-3">
                                    <label class="form-label required">Speed (1-10)</label>
                                    <input type="number" min="1" max="10" class="form-control"
                                        name="bottom_speed" id="bottom_speed"
                                        value="{{ old('bottom_speed', $bottom->speed) }}" required>
                                </div>
                                <div class="col-md-7 mb-3">
                                    <label class="form-label required">Konten Teks</label>
                                    <textarea class="form-control" name="bottom_content" id="bottom_content" rows="2" maxlength="255" required
                                        placeholder="Tulis pengumuman...">{{ old('bottom_content', $bottom->content) }}</textarea>
                                </div>
                            </div>

                            <div class="mt-2">
                                <label class="text-muted font-weight-bold"
                                    style="font-size: 0.85rem; text-transform: uppercase;">Live Preview Display</label>
                                <div class="preview-container">
                                    <marquee id="preview_marquee_bottom" behavior="scroll"
                                        direction="{{ $bottom->direction }}" scrollamount="{{ $bottom->speed }}">
                                        {{ $bottom->content ?: 'Preview teks akan muncul di sini...' }}
                                    </marquee>
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
