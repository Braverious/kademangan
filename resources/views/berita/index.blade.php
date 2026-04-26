<x-header :title="$title" />

<section id="berita" class="berita-section list py-5">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-1">Berita Kelurahan</h1>
                <p class="text-muted mb-0">Kabar dan kegiatan terbaru seputar kelurahan Anda.</p>
            </div>

            <a href="{{ route('home') }}" class="back-icon" aria-label="Kembali">
                <span class="ms-2 fw-semibold">Kembali ke Halaman Utama</span>
            </a>
        </div>

        <div class="row g-4">
            @forelse ($berita_list as $berita)
                <div class="col-md-4">
                    <div class="card news-card h-100 overflow-hidden rounded-4 shadow-sm">
                        <img
                            src="{{ asset('storage/' . $berita->gambar) }}"
                            class="card-img-top news-img"
                            alt="{{ $berita->judul_berita }}"
                            style="height:200px; object-fit:cover;">

                        <div class="card-body d-flex flex-column">
                            <span class="badge bg-primary-subtle text-primary align-self-start mb-2">
                                {{ $berita->kategori }}
                            </span>

                            <div class="text-muted small mb-1">
                                Dipublikasikan oleh
                                <span class="fw-semibold text-primary">
                                    {{ $berita->user->nama_lengkap ?? 'Admin Kelurahan' }}
                                </span>

                                @if ($berita->tgl_publish)
                                    • <time datetime="{{ $berita->tgl_publish->format('Y-m-d') }}">
                                        {{ $berita->tgl_publish->format('d M Y') }}
                                    </time>
                                @endif
                            </div>

                            <h5 class="card-title mb-2">
                                {{ $berita->judul_berita }}
                            </h5>

                            <div class="card-text small text-muted mb-3 flex-grow-1 article-content article-excerpt">
                                {{ Str::limit(strip_tags(html_entity_decode($berita->isi_berita)), 160) }}
                            </div>

                            <a href="{{ route('berita.detail', $berita->slug_berita) }}"
                               class="btn btn-outline-primary btn-sm mt-auto">
                                Baca Selengkapnya
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center">
                    <p>Belum ada berita yang dipublikasikan saat ini.</p>
                </div>
            @endforelse
        </div>

        <div class="row mt-5">
            <div class="col-12 d-flex justify-content-center">
                {{ $berita_list->links() }}
            </div>
        </div>
    </div>
</section>