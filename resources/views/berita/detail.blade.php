<x-header :title="$title" />

<section id="berita-detail" class="py-5">
    <div class="container">
        <a href="{{ route('berita.index') }}" class="back-icon mb-3 d-inline-flex" aria-label="Kembali">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 16 16" aria-hidden="true">
                <path fill-rule="evenodd" d="M15 8a.75.75 0 0 1-.75.75H3.56l3.22 3.22a.75.75 0 1 1-1.06 1.06l-4.5-4.5a.75.75 0 0 1 0-1.06l4.5-4.5a.75.75 0 1 1 1.06 1.06L3.56 7.25h10.69A.75.75 0 0 1 15 8z" />
            </svg>
            <span class="ms-2 fw-semibold">Kembali ke Daftar Berita</span>
        </a>

        <div class="row g-4">
            <div class="col-lg-8">
                <article class="card shadow-sm rounded-4 overflow-hidden">
                    @if (!empty($berita->gambar))
                        <img
                            src="{{ asset('storage/' . $berita->gambar) }}"
                            class="w-100"
                            alt="{{ $berita->judul_berita }}"
                            style="max-height:420px; object-fit:cover;">
                    @endif

                    <div class="card-body">
                        @php
                            $tgl = $berita->tgl_publish ?? $berita->created_at ?? now();
                            $penulis = $berita->user->nama_lengkap ?? $berita->penulis ?? 'Admin Kelurahan';
                        @endphp

                        <span class="badge bg-primary-subtle text-primary mb-2">
                            {{ $berita->kategori }}
                        </span>

                        <h1 class="h3">{{ $berita->judul_berita }}</h1>

                        <div class="text-muted small mb-4">
                            Dipublikasikan oleh
                            <span class="fw-semibold text-primary">{{ $penulis }}</span>
                            pada
                            <time datetime="{{ $tgl->format('Y-m-d') }}">
                                {{ $tgl->format('d M Y') }}
                            </time>
                        </div>

                        <div class="article-content">
                            {!! $berita->isi_berita !!}
                        </div>
                    </div>
                </article>
            </div>

            <div class="col-lg-4">
                <aside class="sticky-top" style="top: 90px;">
                    @if ($related->isNotEmpty())
                        <div class="card shadow-sm rounded-4 overflow-hidden mb-4">
                            <div class="card-body">
                                <h5 class="section-title mb-3">Berita Terkait</h5>
                                <ul class="list-unstyled m-0">
                                    @foreach ($related as $r)
                                        <li class="d-flex gap-3 align-items-start mb-3">
                                            <a href="{{ route('berita.detail', $r->slug_berita) }}" class="d-inline-block flex-shrink-0">
                                                <img
                                                    src="{{ $r->gambar ? asset('storage/' . $r->gambar) : asset('assets/img/noimage.jpg') }}"
                                                    alt="{{ $r->judul_berita }}"
                                                    class="rounded"
                                                    style="width:96px;height:72px;object-fit:cover;border:2px solid var(--accent);">
                                            </a>

                                            <div class="flex-grow-1">
                                                <a href="{{ route('berita.detail', $r->slug_berita) }}"
                                                   class="fw-semibold text-decoration-none d-block">
                                                    {{ Str::limit($r->judul_berita, 70) }}
                                                </a>

                                                <small class="text-muted d-block mt-1">
                                                    Dipublikasikan oleh
                                                    <span class="fw-semibold text-primary">
                                                        {{ $r->user->nama_lengkap ?? 'Admin Kelurahan' }}
                                                    </span>

                                                    @if ($r->tgl_publish)
                                                        • <time datetime="{{ $r->tgl_publish->format('Y-m-d') }}">
                                                            {{ $r->tgl_publish->format('d M Y') }}
                                                        </time>
                                                    @endif
                                                </small>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif

                    <div class="card shadow-sm rounded-4 overflow-hidden">
                        <div class="card-body">
                            <h5 class="section-title mb-3">Berita Lainnya</h5>
                            <ul class="list-unstyled m-0">
                                @forelse ($latest as $l)
                                    <li class="d-flex gap-3 align-items-start mb-3">
                                        <a href="{{ route('berita.detail', $l->slug_berita) }}" class="d-inline-block flex-shrink-0">
                                            <img
                                                src="{{ $l->gambar ? asset('storage/' . $l->gambar) : asset('assets/img/noimage.jpg') }}"
                                                alt="{{ $l->judul_berita }}"
                                                class="rounded"
                                                style="width:96px;height:72px;object-fit:cover;border:2px solid var(--accent);">
                                        </a>

                                        <div class="flex-grow-1">
                                            <a href="{{ route('berita.detail', $l->slug_berita) }}"
                                               class="fw-semibold text-decoration-none d-block">
                                                {{ Str::limit($l->judul_berita, 70) }}
                                            </a>

                                            <small class="text-muted d-block mt-1">
                                                Dipublikasikan oleh
                                                <span class="fw-semibold text-primary">
                                                    {{ $l->user->nama_lengkap ?? 'Admin Kelurahan' }}
                                                </span>

                                                @if ($l->tgl_publish)
                                                    • <time datetime="{{ $l->tgl_publish->format('Y-m-d') }}">
                                                        {{ $l->tgl_publish->format('d M Y') }}
                                                    </time>
                                                @endif
                                            </small>
                                        </div>
                                    </li>
                                @empty
                                    <li class="text-muted">Belum ada berita lain.</li>
                                @endforelse
                            </ul>
                        </div>
                    </div>
                </aside>
            </div>
        </div>
    </div>
</section>