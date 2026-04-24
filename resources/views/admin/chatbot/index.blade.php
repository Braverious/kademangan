<x-admin.header :title="$title" />
<x-admin.sidebar />

<div class="page-inner">
    <x-admin.breadcrumbs :title="$title" :breadcrumbs="$breadcrumbs" />

    <div class="row">
        {{-- Ubah col-lg-9 menjadi col-12 agar full width --}}
        <div class="col-12">

            {{-- Alert Tips --}}
            <div class="alert alert-info border-0 shadow-sm rounded-4 p-4 mb-4" role="alert">
                <div class="d-flex">
                    <div class="me-3">
                        <i class="bi bi-lightbulb-fill fs-2 text-warning"></i>
                    </div>
                    <div>
                        <h5 class="fw-bold text-info">Tips Memberikan Instruksi AI</h5>
                        <p class="mb-2">Agar Chatbot melayani warga dengan maksimal, gunakan struktur instruksi
                            berikut:</p>
                        <ul class="mb-0 small text-dark">
                            <li><strong>Identitas:</strong> Beritahu AI bahwa dia adalah "Asisten Virtual Kelurahan
                                Kademangan".</li>
                            <li><strong>Gaya Bahasa:</strong> Instruksikan untuk memakai bahasa yang "Ramah, Sopan, dan
                                Mudah dimengerti".</li>
                            <li><strong>Pengetahuan Khusus:</strong> Masukkan data penting (Nama Lurah, Jam Kerja,
                                Syarat KTP, dsb).</li>
                            <li><strong>Batasan:</strong> Perintahkan untuk menolak menjawab di luar urusan kelurahan.
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            {{-- Card Konfigurasi --}}
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-header bg-primary text-white py-4 px-4"
                    style="background: linear-gradient(45deg, #0d6efd, #0b5ed7);">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h4 class="mb-1 fw-bold"><i class="bi bi-robot me-2"></i>Konfigurasi Otak AI</h4>
                            <p class="mb-0 small opacity-75">Kelola cara chatbot merespon pertanyaan warga secara
                                otomatis.</p>
                        </div>
                        <div class="fs-1 opacity-25">
                            <i class="bi bi-cpu-fill"></i>
                        </div>
                    </div>
                </div>

                <div class="card-body p-4 p-md-5">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show rounded-3 mb-4" role="alert">
                            <div class="d-flex align-items-center">
                                <i class="bi bi-check-circle-fill me-2 fs-5"></i>
                                <div><strong>Berhasil!</strong> {{ session('success') }}</div>
                            </div>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                aria-label="Close"></button>
                        </div>
                    @endif
                    <form action="{{ route('admin.chatbot.update') }}" method="POST">
                        @csrf

                        <div class="row mb-4">
                            {{-- Konfigurasi Nama Chatbot --}}
                            <div class="col-md-4">
                                <label class="form-label fw-bold">Nama Chatbot</label>
                                <input type="text" name="chatbot_name" class="form-control rounded-3"
                                    value="{{ $settings['chatbot_name'] ?? '' }}"
                                    placeholder="Contoh: Bantuan Kademangan">
                            </div>

                            {{-- Konfigurasi Subtitle --}}
                            <div class="col-md-4">
                                <label class="form-label fw-bold">Subtitle</label>
                                <input type="text" name="chatbot_subtitle" class="form-control rounded-3"
                                    value="{{ $settings['chatbot_subtitle'] ?? '' }}"
                                    placeholder="Contoh: AI Assistant">
                            </div>

                            {{-- Konfigurasi Warna Tema --}}
                            <div class="col-md-4">
                                <label class="form-label fw-bold">Warna Tema (Branding)</label>
                                <div class="d-flex gap-2">
                                    <input type="color" name="chatbot_color"
                                        class="form-control form-control-color rounded-3"
                                        value="{{ $settings['chatbot_color'] ?? '#0d6efd' }}"
                                        title="Pilih warna chatbot">
                                    <input type="text" class="form-control rounded-3" readonly
                                        value="{{ $settings['chatbot_color'] ?? '#0d6efd' }}">
                                </div>
                            </div>
                        </div>

                        <hr class="my-4 opacity-25">

                        {{-- Textarea Prompt yang lama --}}
                        <div class="mb-4">
                            <label for="promptValue" class="form-label fw-bold text-dark">System Prompt (Instruksi
                                Utama)</label>
                            <textarea class="form-control rounded-4 p-4 shadow-sm" id="promptValue" name="system_prompt" rows="10"
                                style="font-family: 'Fira Code', monospace; font-size: 0.95rem; background-color: #fcfcfc;">{{ $settings['system_prompt'] ?? '' }}</textarea>
                        </div>

                        <div class="text-end">
                            <button type="submit" class="btn btn-primary btn-lg rounded-pill px-5 shadow-sm fw-bold">
                                <i class="bi bi-save-fill me-2"></i>Terapkan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- System Status --}}
            <div class="d-flex align-items-center justify-content-center mt-4 gap-3">
                <p class="text-muted small mb-0">Engine: <span class="fw-bold text-primary">Gemini 2.5 Flash Lite</span>
                </p>
                <div class="vr"></div>
                <p class="text-muted small mb-0">Status:
                    <span
                        class="badge bg-success-subtle text-success border border-success-subtle px-3 py-2 rounded-pill">
                        <span class="spinner-grow spinner-grow-sm me-1" role="status" aria-hidden="true"></span>
                        API Active
                    </span>
                </p>
            </div>

        </div>
    </div>
</div>

<x-admin.footer />
