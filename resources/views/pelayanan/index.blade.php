<x-header :title="$data['title']" />

<main>
    <section class="pelayanan-section py-5">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div></div>

                <a href="{{ route('home') }}#Layanan" class="back-icon" aria-label="Kembali">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                        viewBox="0 0 16 16" aria-hidden="true">
                        <path fill-rule="evenodd"
                            d="M15 8a.75.75 0 0 1-.75.75H3.56l3.22 3.22a.75.75 0 1 1-1.06 1.06l-4.5-4.5a.75.75 0 0 1 0-1.06l4.5-4.5a.75.75 0 1 1 1.06 1.06L3.56 7.25h10.69A.75.75 0 0 1 15 8z" />
                    </svg>

                    <span class="ms-2 fw-semibold">Kembali</span>
                </a>
            </div>

            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h3 mb-1">Pelayanan Kelurahan</h1>
                    <p class="text-muted mb-0">Pilih jenis pelayanan untuk mulai pengajuan.</p>
                </div>
            </div>

            <div class="row g-4">
                @forelse ($data['cards'] as $card)
                    <div class="col-md-4">
                        <div class="card h-100 shadow-sm service-card">
                            @if ($card->gambar)
                                <img src="{{ asset('storage/' . $card->gambar) }}" class="card-img-top"
                                    alt="{{ $card->judul }}" style="height: 180px; object-fit: cover;">
                            @endif

                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title mb-2">
                                    {{ $card->judul }}
                                </h5>

                                <p class="card-text text-muted small flex-grow-1">
                                    {{ $card->deskripsi }}
                                </p>

                                @if ($card->is_active)
                                    <a href="{{ route('pelayanan.show', $card->slug) }}"
                                        class="btn btn-primary mt-auto">
                                        Ajukan Sekarang
                                    </a>
                                @else
                                    <button type="button" class="btn btn-secondary mt-auto" disabled>
                                        Pelayanan Sedang Tutup
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center">
                        <p class="text-muted mb-0">Belum ada pelayanan tersedia.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>
</main>
<x-footer />
