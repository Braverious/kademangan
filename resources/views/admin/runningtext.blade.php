<x-admin.header :title="$title" />
<x-admin.sidebar />

<style>
    /* Styling tambahan agar UI lebih clean dan modern */
    .setting-block {
        background-color: #f8f9fa;
        border: 1px solid #e9ecef;
        border-radius: 8px;
        padding: 24px;
        margin-bottom: 24px;
        transition: all 0.2s ease;
    }
    .setting-block:hover {
        border-color: #ced4da;
        box-shadow: 0 4px 12px rgba(0,0,0,0.03);
    }
    .preview-container {
        background-color: #1e1e2d; /* Kesan dark mode/LED board */
        color: #00ffcc; /* Warna text yang kontras */
        border-radius: 6px;
        padding: 12px 15px;
        font-family: 'Courier New', Courier, monospace;
        box-shadow: inset 0 2px 4px rgba(0,0,0,0.4);
        border: 1px solid #151521;
    }
    .preview-label {
        font-size: 0.85rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #6c757d;
        margin-bottom: 8px;
        display: block;
    }
</style>

<div class="page-inner">
    <div class="row">
        <div class="col-md-12">

            @if (session('success'))
                <div class="alert alert-success shadow-sm rounded">{{ session('success') }}</div>
            @endif
            @if ($errors->any())
                <div class="alert alert-danger shadow-sm rounded">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="card shadow-sm border-0">
                <div class="card-header bg-white pt-4 pb-3">
                    <div class="d-flex align-items-center justify-content-between">
                        <h4 class="card-title font-weight-bold m-0">Pengaturan Running Text</h4>
                        <button form="form-runningtext" class="btn btn-primary btn-round px-4 shadow-sm">
                            <i class="fa fa-save mr-2"></i> Simpan Perubahan
                        </button>
                    </div>
                </div>

                <div class="card-body">
                    <form action="{{ route('admin.settings.runningtext.update') }}" method="POST" id="form-runningtext">
                        @csrf

                        {{-- ================= BLOCK TOP ================= --}}
                        <div class="setting-block">
                            <div class="d-flex align-items-center mb-4">
                                <h5 class="m-0 font-weight-bold text-primary">
                                    <i class="fa fa-arrow-up mr-2"></i>Posisi: Top
                                </h5>
                            </div>

                            <div class="row">
                                <div class="col-md-3 col-sm-6 mb-3">
                                    <label class="form-label font-weight-bold text-muted">Arah Gerak</label>
                                    <select class="form-control" name="top_direction" id="top_direction" required>
                                        <option value="left" {{ old('top_direction', $top->direction) == 'left' ? 'selected' : '' }}>Kiri (Left)</option>
                                        <option value="right" {{ old('top_direction', $top->direction) == 'right' ? 'selected' : '' }}>Kanan (Right)</option>
                                    </select>
                                </div>
                                <div class="col-md-2 col-sm-6 mb-3">
                                    <label class="form-label font-weight-bold text-muted">Speed (1-10)</label>
                                    <input type="number" min="1" max="10" class="form-control" name="top_speed" id="top_speed" value="{{ old('top_speed', $top->speed) }}" required>
                                </div>
                                <div class="col-md-7 mb-3">
                                    <label class="form-label font-weight-bold text-muted">Konten Teks</label>
                                    <textarea class="form-control" name="top_content" id="top_content" rows="2" maxlength="255" required placeholder="Masukkan pengumuman di sini...">{{ old('top_content', $top->content) }}</textarea>
                                </div>
                            </div>

                            <div class="mt-2">
                                <span class="preview-label">Live Preview Display</span>
                                <div class="preview-container">
                                    <marquee id="preview_marquee_top" behavior="scroll" direction="{{ $top->direction }}" scrollamount="{{ $top->speed }}">
                                        {{ $top->content ?: 'Preview teks akan muncul di sini...' }}
                                    </marquee>
                                </div>
                            </div>
                        </div>

                        {{-- ================= BLOCK BOTTOM ================= --}}
                        <div class="setting-block">
                            <div class="d-flex align-items-center mb-4">
                                <h5 class="m-0 font-weight-bold text-info">
                                    <i class="fa fa-arrow-down mr-2"></i>Posisi: Bottom
                                </h5>
                            </div>

                            <div class="row">
                                <div class="col-md-3 col-sm-6 mb-3">
                                    <label class="form-label font-weight-bold text-muted">Arah Gerak</label>
                                    <select class="form-control" name="bottom_direction" id="bottom_direction" required>
                                        <option value="left" {{ old('bottom_direction', $bottom->direction) == 'left' ? 'selected' : '' }}>Kiri (Left)</option>
                                        <option value="right" {{ old('bottom_direction', $bottom->direction) == 'right' ? 'selected' : '' }}>Kanan (Right)</option>
                                    </select>
                                </div>
                                <div class="col-md-2 col-sm-6 mb-3">
                                    <label class="form-label font-weight-bold text-muted">Speed (1-10)</label>
                                    <input type="number" min="1" max="10" class="form-control" name="bottom_speed" id="bottom_speed" value="{{ old('bottom_speed', $bottom->speed) }}" required>
                                </div>
                                <div class="col-md-7 mb-3">
                                    <label class="form-label font-weight-bold text-muted">Konten Teks</label>
                                    <textarea class="form-control" name="bottom_content" id="bottom_content" rows="2" maxlength="255" required placeholder="Masukkan pengumuman di sini...">{{ old('bottom_content', $bottom->content) }}</textarea>
                                </div>
                            </div>

                            <div class="mt-2">
                                <span class="preview-label">Live Preview Display</span>
                                <div class="preview-container">
                                    <marquee id="preview_marquee_bottom" behavior="scroll" direction="{{ $bottom->direction }}" scrollamount="{{ $bottom->speed }}">
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

<script>
    document.addEventListener('DOMContentLoaded', () => {
        /**
         * Best Practice: Gunakan ID spesifik untuk menarget elemen daripada querySelector attribute
         * karena query sebelumnya akan error/bug jika attribute arahnya berubah atau ada duplikasi.
         */
        const setupLivePreview = (pos) => {
            const contentInput = document.getElementById(`${pos}_content`);
            const directionInput = document.getElementById(`${pos}_direction`);
            const speedInput = document.getElementById(`${pos}_speed`);
            const marquee = document.getElementById(`preview_marquee_${pos}`);

            if (!contentInput || !marquee) return;

            // Update text realtime
            contentInput.addEventListener('input', (e) => {
                marquee.innerText = e.target.value || 'Preview teks akan muncul di sini...';
            });

            // Update direction realtime
            directionInput.addEventListener('change', (e) => {
                marquee.setAttribute('direction', e.target.value);
            });

            // Update speed realtime
            speedInput.addEventListener('input', (e) => {
                marquee.setAttribute('scrollamount', e.target.value || '5');
            });
        };

        setupLivePreview('top');
        setupLivePreview('bottom');
    });
</script>

<x-admin.footer />