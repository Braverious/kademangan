<x-admin.header :title="$title" />
<x-admin.sidebar />

<div class="page-inner">
    <x-admin.breadcrumbs :title="$title" :breadcrumbs="$breadcrumbs" />
    <div class="row">
        <div class="col-md-12">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{ $title ?? 'Website Settings' }}</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.settings.save') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <ul class="nav nav-pills nav-primary nav-pills-no-bd mb-4" id="pills-tab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="pills-home-tab" data-toggle="pill" data-bs-toggle="pill"
                                    href="#pills-home" role="tab" aria-selected="true">Konten Beranda</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="pills-general-tab" data-toggle="pill" data-bs-toggle="pill"
                                    href="#pills-general" role="tab" aria-selected="false">Identitas & Logo</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="pills-links-tab" data-toggle="pill" data-bs-toggle="pill"
                                    href="#pills-links" role="tab" aria-selected="false">Tautan & Sosial</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="pills-multimedia-tab" data-toggle="pill" data-bs-toggle="pill"
                                    href="#pills-multimedia" role="tab" aria-selected="false">Multimedia</a>
                            </li>
                        </ul>

                        <div class="tab-content mt-2 mb-3" id="pills-tabContent">

                            <div class="tab-pane fade show active" id="pills-home" role="tabpanel"
                                aria-labelledby="pills-home-tab">
                                <div class="card border">
                                    <div class="card-body">
                                        <div class="form-group p-0 mb-3">
                                            <label class="fw-bold">Judul Utama Beranda (H1)</label>
                                            <input type="text" name="home_title" class="form-control"
                                                value="{{ old('home_title', $settings['home_title'] ?? '') }}"
                                                placeholder="Masukkan judul layanan...">
                                        </div>
                                        <div class="form-group p-0">
                                            <label class="fw-bold">Deskripsi Hero (Lead)</label>
                                            <textarea name="home_description" class="form-control" rows="3">{{ old('home_description', $settings['home_description'] ?? '') }}</textarea>
                                        </div>
                                        <div class="form-group p-0 mt-3 mb-3">
                                            <label class="fw-bold mb-3">Atur Urutan Tampilan Beranda </label> <i
                                                class="fas fa-sort-amount-down-alt mr-2"></i>
                                            <div id="sortable-sections" class="list-group shadow-sm">
                                                @php
                                                    // Daftar ID section sesuai yang ada di home.blade.php kamu
                                                    $defaultOrder = [
                                                    'home',
                                                    'runningtext',
                                                    'Layanan',
                                                    'pengumuman',
                                                    'jangkauan',
                                                    'galeri',
                                                    'berita',
                                                    'video',
                                                ];
                                                    $currentOrder = $settings['section_order'] ?? $defaultOrder;
                                                @endphp

                                                @foreach ($currentOrder as $sec)
                                                    <div class="list-group-item d-flex align-items-center p-3"
                                                        data-id="{{ $sec }}"
                                                        style="cursor: move; border-left: 5px solid #ffc107;">
                                                        <i class="fas fa-grip-vertical mr-3 text-muted"></i>
                                                        <span class="fw-bold text-uppercase"
                                                            style="letter-spacing: 1px;">
                                                            {{ str_replace('-', ' ', $sec) }}
                                                        </span>
                                                        <input type="hidden" name="section_order[]"
                                                            value="{{ $sec }}">
                                                    </div>
                                                @endforeach
                                            </div>
                                            <small class="text-muted mt-2 d-block">* Drag & Drop untuk mengubah posisi.
                                                Section paling atas akan muncul pertama setelah Header.</small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="pills-general" role="tabpanel"
                                aria-labelledby="pills-general-tab">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="card border">
                                            <div class="card-body">
                                                <label class="fw-semibold mb-2">Favicon Website</label>
                                                <input type="file" name="favicon"
                                                    class="form-control form-control-sm">
                                                @if (!empty($settings['favicon']))
                                                    <img src="{{ asset('storage/' . $settings['favicon']) }}"
                                                        class="mt-2 border" width="40">
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="card border">
                                            <div class="card-body">
                                                <label class="fw-semibold mb-2">Logo Admin</label>
                                                <input type="file" name="logo"
                                                    class="form-control form-control-sm">
                                                @if (!empty($settings['logo']))
                                                    <img src="{{ asset('storage/' . $settings['logo']) }}"
                                                        alt="Logo Admin" class="img-thumbnail"
                                                        style="width: 120px; height: 64px; object-fit: contain; background: #eee;">
                                                @else
                                                    <img src="{{ asset('assets/img/logo.svg') }}" alt="Logo Default"
                                                        class="img-thumbnail"
                                                        style="width: 120px; height: 64px; object-fit: contain; background: #eee;">
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group p-0">
                                            <label class="fw-semibold">Tentang Web (Footer/HTML)</label>
                                            <textarea name="about_html" class="form-control" rows="4">{{ old('about_html', $settings['about_html'] ?? '') }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="pills-links" role="tabpanel"
                                aria-labelledby="pills-links-tab">

                                <div class="card border mb-4">
                                    <div class="card-header d-flex justify-content-between align-items-center py-2">
                                        <span class="fw-bold">Tautan Terkait</span>
                                        <button type="button" id="btnAddLink" class="btn btn-primary btn-xs">
                                            <i class="fas fa-plus"></i> Tambah Tautan
                                        </button>
                                    </div>
                                    <div class="card-body" id="linksRepeater">
                                        @foreach ($settings['related_links'] as $it)
                                            <div class="row g-2 mb-2 align-items-center link-item">
                                                <div class="col-md-4">
                                                    <input type="text" name="links_title[]"
                                                        class="form-control form-control-sm"
                                                        value="{{ $it['title'] }}">
                                                </div>
                                                <div class="col-md-7">
                                                    <input type="url" name="links_url[]"
                                                        class="form-control form-control-sm"
                                                        value="{{ $it['url'] }}">
                                                </div>
                                                <div class="col-md-1 text-right">
                                                    <button type="button"
                                                        class="btn btn-danger btn-xs btnRemoveLink"><i
                                                            class="fas fa-times"></i></button>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                <div class="card border">
                                    <div class="card-header d-flex justify-content-between align-items-center py-2">
                                        <span class="fw-bold">Sosial Media</span>
                                        <button type="button" id="btnAddSocial" class="btn btn-primary btn-xs">
                                            <i class="fas fa-plus"></i> Tambah Sosial
                                        </button>
                                    </div>
                                    <div class="card-body">

                                        <div id="socialRepeater" class="vstack gap-2">

                                            @if (!empty($settings['social_links']))

                                                @foreach ($settings['social_links'] as $it)
                                                    <div class="row g-2 align-items-end social-item mb-2">

                                                        <div class="col-md-4">

                                                            <label class="small fw-bold">Icon</label>

                                                            <select name="social_icon[]"
                                                                class="form-control form-control-sm">

                                                                @php

                                                                    $icons = [
                                                                        'fa-facebook-f' => 'Facebook',

                                                                        'fa-instagram' => 'Instagram',

                                                                        'fa-x-twitter' => 'X (Twitter)',

                                                                        'fa-youtube' => 'YouTube',

                                                                        'fa-tiktok' => 'TikTok',

                                                                        'fa-whatsapp' => 'WhatsApp',
                                                                    ];

                                                                    $sel = $it['icon'] ?? '';

                                                                @endphp

                                                                @foreach ($icons as $key => $label)
                                                                    <option value="{{ $key }}"
                                                                        {{ $sel === $key ? 'selected' : '' }}>

                                                                        {{ $label }}</option>
                                                                @endforeach

                                                            </select>

                                                        </div>

                                                        <div class="col-md-4">

                                                            <label class="small fw-bold">Label</label>

                                                            <input type="text" name="social_label[]"
                                                                class="form-control form-control-sm"
                                                                value="{{ $it['label'] ?? '' }}">

                                                        </div>

                                                        <div class="col-md-3">

                                                            <label class="small fw-bold">URL</label>

                                                            <input type="url" name="social_url[]"
                                                                class="form-control form-control-sm"
                                                                value="{{ $it['url'] ?? '' }}">

                                                        </div>

                                                        <div class="col-md-1 text-center">

                                                            <button type="button"
                                                                class="btn btn-danger btn-xs btnRemoveSocial">

                                                                <i class="fas fa-times"></i>

                                                            </button>

                                                        </div>

                                                    </div>
                                                @endforeach

                                            @endif

                                        </div>
                                    </div>
                                </div>
                            </div>
                        <div class="tab-pane fade" id="pills-multimedia" role="tabpanel"
                            aria-labelledby="pills-multimedia-tab">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group p-0">
                                        <label class="fw-semibold">Link YouTube</label>
                                        <input type="url" class="form-control" id="youtube_link"
                                            name="youtube_link"
                                            value="{{ old('youtube_link', $settings['youtube_link'] ?? '') }}"
                                            onkeyup="updateVideoPreview()">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div id="video_preview_container"
                                        class="border rounded bg-light d-flex align-items-center justify-content-center"
                                        style="height: 180px;">
                                        <iframe id="video_preview" class="d-none" width="100%" height="100%"
                                            frameborder="0" allowfullscreen></iframe>
                                        <div id="preview_placeholder"><i class="fab fa-youtube fa-3x text-danger"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                </div>
                <div class="separator-solid"></div>
                <div class="form-group">
                    <button type="submit" class="btn btn-success px-5">
                        <i class="fas fa-save mr-2"></i> Simpan Semua Perubahan
                    </button>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>

<template id="linkTemplate">
    <div class="row g-2 mb-2 align-items-center link-item">
        <div class="col-md-4"><input type="text" name="links_title[]" class="form-control form-control-sm"
                placeholder="Judul"></div>
        <div class="col-md-7"><input type="url" name="links_url[]" class="form-control form-control-sm"
                placeholder="https://..."></div>
        <div class="col-md-1 text-right"><button type="button" class="btn btn-danger btn-xs btnRemoveLink"><i
                    class="fas fa-times"></i></button></div>
    </div>
</template>

<template id="socialTemplate">
    <div class="row g-2 mb-2 align-items-center social-item">
        <div class="col-md-3">
            <select name="social_icon[]" class="form-control form-control-sm">
                <option value="fa-facebook-f">Facebook</option>
                <option value="fa-instagram">Instagram</option>
                <option value="fa-youtube">YouTube</option>
                <option value="fa-tiktok">TikTok</option>
                <option value="fa-whatsapp">WhatsApp</option>
            </select>
        </div>
        <div class="col-md-4"><input type="text" name="social_label[]" class="form-control form-control-sm"
                placeholder="Label"></div>
        <div class="col-md-4"><input type="url" name="social_url[]" class="form-control form-control-sm"
                placeholder="URL"></div>
        <div class="col-md-1 text-right"><button type="button" class="btn btn-danger btn-xs btnRemoveSocial"><i
                    class="fas fa-times"></i></button></div>
    </div>
</template>
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script>
// Tambah Baris Link
document.getElementById('btnAddLink').addEventListener('click', function() {
    const template = document.getElementById('linkTemplate').content.cloneNode(true);
    document.getElementById('linksRepeater').appendChild(template);
});

// Tambah Baris Sosial
document.getElementById('btnAddSocial').addEventListener('click', function() {
    const template = document.getElementById('socialTemplate').content.cloneNode(true);
    document.getElementById('socialRepeater').appendChild(template);
});

// Fungsi Hapus (Delegasi)
document.addEventListener('click', function(e) {
    if (e.target.closest('.btnRemoveLink')) e.target.closest('.link-item').remove();
    if (e.target.closest('.btnRemoveSocial')) e.target.closest('.social-item').remove();
});
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var el = document.getElementById('sortable-sections');
        Sortable.create(el, {
            animation: 150,
            ghostClass: 'bg-warning-subtle'
        });
    });
</script>

<script>
    function updateVideoPreview() {
        const url = document.getElementById('youtube_link').value;
        const regExp = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=)([^#\&\?]*).*/;
        const match = url.match(regExp);
        const preview = document.getElementById('video_preview');
        const container = document.getElementById('preview_placeholder');

        if (match && match[2].length == 11) {
            preview.src = 'https://www.youtube.com/embed/' + match[2];
            preview.classList.remove('d-none');
            container.classList.add('d-none');
        } else {
            preview.classList.add('d-none');
            container.classList.remove('d-none');
        }
    }
    window.onload = updateVideoPreview;
    document.addEventListener('DOMContentLoaded', function() {
        // Ambil semua elemen pemberi perintah (link tab)
        const tabLinks = document.querySelectorAll('#pills-tab .nav-link');

        tabLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();

                // 1. Matikan semua tab link yang sedang aktif
                tabLinks.forEach(item => item.classList.remove('active'));

                // 2. Sembunyikan semua konten tab
                const tabPanes = document.querySelectorAll('.tab-pane');
                tabPanes.forEach(pane => {
                    pane.classList.remove('show', 'active');
                });

                // 3. Aktifkan link yang diklik
                this.classList.add('active');

                // 4. Munculkan konten yang sesuai dengan href (#id)
                const targetId = this.getAttribute('href');
                const targetPane = document.querySelector(targetId);
                if (targetPane) {
                    targetPane.classList.add('show', 'active');
                }
            });
        });
    });
</script>

<x-admin.footer />
