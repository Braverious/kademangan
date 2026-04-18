<x-header :title="$title" />
<main>
<section id="home" class="py-5 d-flex align-items-center mb-5 mt-5">
    <div class="container-fluid px-lg-5">
        <div class="row align-items-center">
            <div class="col-lg-7">
                <h1 class="display-5 fw-bold mb-3">Layanan Publik Kelurahan yang Mudah & Transparan</h1>
                <p class="lead text-muted">Akses informasi, ajukan layanan, dan baca berita terbaru seputar kelurahan
                    Anda dalam satu halaman.</p>
                <a href="#" class="btn btn-primary btn-lg me-2">Ajukan Layanan</a>
                <a href="#Layanan" class="btn btn-outline-primary btn-lg">Layanan kami</a>
            </div>
        </div>
    </div>
</section>

@if ($runningTexts->count() > 0)
    <section id="marquee-info" class="py-2">
        <div class="container-fluid px-lg-5">

            {{-- Bagian Atas (Top) --}}
            @if (isset($runningTexts['top']))
                <marquee behavior="scroll" direction="{{ $runningTexts['top']->direction }}"
                    scrollamount="{{ $runningTexts['top']->speed }}"
                    style="display:block;background:#0d6efd;color:#fff;padding:.45rem .75rem;border-radius:8px;margin-bottom:10px;">
                    {{ $runningTexts['top']->content }}
                </marquee>
            @endif

            {{-- Bagian Bawah (Bottom) --}}
            @if (isset($runningTexts['bottom']))
                <marquee behavior="scroll" direction="{{ $runningTexts['bottom']->direction }}"
                    scrollamount="{{ $runningTexts['bottom']->speed }}"
                    style="display:block;background:#ffc107;color:#212529;padding:.45rem .75rem;border-radius:8px;">
                    {{ $runningTexts['bottom']->content }}
                </marquee>
            @endif

        </div>
    </section>
@endif

<section id="Layanan" class="py-5 section-abstract">
    <div class="container-fluid px-lg-5">
        <div class="row mb-4">
            <div class="col-12 text-center">
                <h2 class="section-title mb-1">Layanan Kami</h2>
                <p class="text-muted">Solusi layanan publik yang mudah, cepat, dan transparan.</p>
            </div>
        </div>

        <div class="position-relative">
            <button id="layananPrev"
                class="nav-arrow btn btn-outline-primary btn-sm position-absolute top-50 start-0 translate-middle-y d-none d-lg-inline-flex"
                type="button">
                <i class="bi bi-chevron-left"></i>
            </button>
            <button id="layananNext"
                class="nav-arrow btn btn-outline-primary btn-sm position-absolute top-50 end-0 translate-middle-y d-none d-lg-inline-flex"
                type="button">
                <i class="bi bi-chevron-right"></i>
            </button>

            <div id="layananSlider" class="d-flex flex-nowrap gap-4 overflow-auto pb-2"
                style="scroll-snap-type:x mandatory; scroll-behavior:smooth;">
                @for ($i = 1; $i <= 4; $i++)
                    <div class="slider-item col-10 col-sm-6 col-lg-3 p-0 flex-shrink-0"
                        style="scroll-snap-align:start;">
                        <div class="card service-card h-100 overflow-hidden">
                            <div class="card-img-top bg-light d-flex align-items-center justify-content-center"
                                style="height: 150px;">
                                <i class="bi bi-file-earmark-text display-4 text-secondary"></i>
                            </div>
                            <div class="card-body">
                                <h5 class="card-title mb-1">Layanan Proyek {{ $i }}</h5>
                                <span class="title-underline"></span>
                                <p class="card-text small text-muted mb-0">
                                    Deskripsi singkat mengenai jenis layanan publik yang tersedia untuk warga.
                                </p>
                            </div>
                        </div>
                    </div>
                @endfor
            </div>
        </div>
    </div>
</section>

<section id="BeritaDadakan" class="py-5 section-abstract">
    <div class="container-fluid px-lg-5">
        <div class="row mb-3">
            <div class="col-12 text-center">
                <h2 class="section-title mb-1">Breaking News</h2>
                <p class="text-muted mb-0">Info penting/terbaru dari Kelurahan.</p>
            </div>
        </div>

        <div id="flashSlider" class="flash-track d-flex flex-nowrap gap-4 pb-1"
            style="scroll-snap-type:x mandatory; scroll-behavior:smooth;">
            <article class="flash-item flash-col" style="scroll-snap-align:start;">
                <div class="card flash-card h-100">
                    <div class="card-body d-flex flex-column">
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <span class="flash-icon"><i class="bi bi-megaphone-fill"></i></span>
                            <span class="badge bg-warning text-dark fw-semibold">Penting</span>
                            <small class="text-muted ms-auto">20 Apr 2024</small>
                        </div>
                        <h5 class="card-title mb-2 line-clamp-2">Waspada Cuaca Ekstrem di Wilayah Kademangan</h5>
                        <p class="card-text text-muted mb-3 line-clamp-3">Dihimbau kepada seluruh warga untuk tetap
                            waspada terhadap potensi hujan lebat disertai angin kencang...</p>
                        <div class="mt-auto"><a href="#" class="btn btn-primary btn-sm">Baca selengkapnya</a>
                        </div>
                    </div>
                </div>
            </article>
        </div>
    </div>
</section>

<section id="coverage" class="py-5 section-abstract">
    <div class="container-fluid px-lg-5">
        <div class="row mb-4">
            <div class="col-12 text-center">
                <h2 class="section-title mb-1">Skala Kami</h2>
                <p class="text-muted">Berpengalaman melayani lingkungan pemerintahan & warga secara transparan.</p>
            </div>
        </div>

        <div class="row g-4">
            @php
                $stats = [
                    ['title' => 'KK yang Dilayani', 'val' => '7.884', 'icon' => 'people'],
                    ['title' => 'Jumlah Penduduk', 'val' => '25.724', 'icon' => 'person-badge'],
                    ['title' => 'Jumlah RW', 'val' => '12', 'icon' => 'building'],
                    ['title' => 'Jumlah RT', 'val' => '48', 'icon' => 'house-door'],
                ];
            @endphp

            @foreach ($stats as $s)
                <div class="col-12 col-md-6 col-lg-4 col-xl-3">
                    <div class="card metric-card news-card h-100 overflow-hidden rounded-4 shadow-sm">
                        <div class="card-body text-center d-flex flex-column">
                            <div class="mx-auto mb-2"><i class="bi bi-{{ $s['icon'] }} display-6 text-primary"></i>
                            </div>
                            <h5 class="metric-title mb-1">{{ $s['title'] }}</h5>
                            <p class="metric-desc text-muted mb-4">Data statistik wilayah Kademangan saat ini.</p>
                            <div class="metric-value mt-auto fw-bold h3 text-primary">{{ $s['val'] }}</div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
<section id="galeri" class="py-5">
    <div class="container-fluid px-lg-5">
        <div class="row mb-4">
            <div class="col-12 text-center">
                <h2 class="section-title">Galeri Kademangan</h2>
                <p class="text-muted">Area Kademangan.</p>
            </div>
        </div>

        {{-- Carousel Statis untuk Preview --}}
        <div id="carouselGaleri" class="carousel slide carousel-smooth force-motion shadow-sm rounded-4 overflow-hidden"
            data-bs-ride="carousel" data-bs-interval="9000" data-bs-touch="true" data-bs-keyboard="true"
            data-bs-pause="hover" data-bs-wrap="true">

            <div class="carousel-indicators">
                <button type="button" data-bs-target="#carouselGaleri" data-bs-slide-to="0" class="active"
                    aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#carouselGaleri" data-bs-slide-to="1"
                    aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#carouselGaleri" data-bs-slide-to="2"
                    aria-label="Slide 3"></button>
            </div>

            <div class="carousel-inner">
                {{-- Slide 1 --}}
                <div class="carousel-item active">
                    <img src="https://placehold.co/1200x500?text=Foto+Galeri+1" class="d-block w-100" alt="Galeri 1">
                    <div class="carousel-caption d-none d-md-block text-start">
                        <h5>Judul Foto Galeri 1</h5>
                    </div>
                </div>

                {{-- Slide 2 --}}
                <div class="carousel-item">
                    <img src="https://placehold.co/1200x500?text=Foto+Galeri+2" class="d-block w-100" alt="Galeri 2">
                    <div class="carousel-caption d-none d-md-block text-start">
                        <h5>Judul Foto Galeri 2</h5>
                    </div>
                </div>

                {{-- Slide 3 --}}
                <div class="carousel-item">
                    <img src="https://placehold.co/1200x500?text=Foto+Galeri+3" class="d-block w-100" alt="Galeri 3">
                    <div class="carousel-caption d-none d-md-block text-start">
                        <h5>Judul Foto Galeri 3</h5>
                    </div>
                </div>
            </div>

            <button class="carousel-control-prev" type="button" data-bs-target="#carouselGaleri"
                data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Sebelumnya</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselGaleri"
                data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Berikutnya</span>
            </button>
        </div>
    </div>
</section>
<section id="berita" class="py-5 bg-light section-abstract">
    <div class="container-fluid px-lg-5">
        <div class="row mb-4">
            <div class="col-12 text-center">
                <h2 class="section-title">Berita Terbaru</h2>
                <p class="text-muted">Kegiatan kelurahan dan informasi aktual untuk warga.</p>
            </div>
        </div>

        <div class="row g-4">
            {{-- Loop Statis untuk Preview (3 Berita) --}}
            @for ($i = 1; $i <= 3; $i++)
                <div class="col-md-4">
                    <div class="card news-card h-100 overflow-hidden rounded-4 shadow-sm">
                        <img src="https://placehold.co/600x400?text=Berita+Kelurahan+{{ $i }}"
                            class="card-img-top news-img" alt="Berita {{ $i }}"
                            style="height: 200px; object-fit: cover;">

                        <div class="card-body d-flex flex-column">
                            <span class="badge bg-primary-subtle text-primary align-self-start mb-2">
                                Pengumuman
                            </span>

                            <div class="text-muted small mb-1">
                                Dipublikasikan oleh
                                <span class="fw-semibold text-primary">Admin Kelurahan</span>
                                • <time datetime="2024-04-17">17 Apr 2024</time>
                            </div>

                            <h5 class="card-title mb-2">Kegiatan Kerja Bakti Rutin Lingkungan Kademangan</h5>

                            <p class="card-text small text-muted mb-3 flex-grow-1 home-news-excerpt">
                                Ini adalah contoh teks ringkasan berita kelurahan. Warga diharapkan berpartisipasi dalam
                                menjaga kebersihan lingkungan sekitar demi kenyamanan bersama...
                            </p>

                            <a href="#" class="btn btn-outline-primary btn-sm mt-auto">
                                Baca Selengkapnya
                            </a>
                        </div>
                    </div>
                </div>
            @endfor
        </div>
    </div>
</section>
<section id="video" class="py-5">
    <div class="container-fluid px-lg-5">
        <div class="row mb-4">
            <div class="col-12 text-center">
                <h2 class="section-title">Video Profil</h2>
                <p class="text-muted">Kenali lebih dekat Kelurahan Kademangan.</p>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="video-card brand-card shadow-sm rounded-4 overflow-hidden">
                    <div class="ratio ratio-16x9">
                        <iframe src="https://www.youtube.com/embed/dQw4w9WgXcQ" title="YouTube video player"
                            frameborder="0" allowfullscreen></iframe>
                        <!-- Bar info bawah -->
                        <div class="video-info d-flex justify-content-between align-items-center px-4 py-3">
                            <div class="d-flex align-items-center gap-3">
                                <span class="yt-badge" aria-hidden="true">
                                    <i class="bi bi-play-fill"></i>
                                </span>
                                <div>
                                    {{-- <h5 class="video-title mb-1"><?= html_escape($video_meta['title']) ?></h5>
                                            <p class="video-channel mb-0 text-muted"><?= html_escape($video_meta['author_name']) ?></p> --}}
                                    <h5 class="video-title mb-1">test</h5>
                                    <p class="video-channel mb-0 text-muted">test</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</section>
</main>
<x-footer></x-footer>
