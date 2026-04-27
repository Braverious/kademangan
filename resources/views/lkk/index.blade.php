<x-header :title="$data['title']" />

<main>
    <section class="pelayanan-section py-5">
        <div class="container">

            <div class="d-flex justify-content-between align-items-center mb-4">
                <div></div>

                <a href="{{ route('home') }}" class="back-icon" aria-label="Kembali">
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
                    <h1 class="h3 mb-1">Lembaga Kemasyarakatan Kelurahan</h1>
                    <p class="text-muted mb-0">
                        Pilih informasi lembaga kemasyarakatan yang tersedia di Kelurahan Kademangan.
                    </p>
                </div>
            </div>

            <div class="row g-4">
                @foreach ($data['cards'] as $card)
                    <div class="col-md-4">
                        <div class="card h-100 shadow-sm service-card">
                            <div class="card-body d-flex flex-column">
                                <div class="d-flex align-items-center mb-3">
                                    <i class="{{ $card['icon'] }} fs-3 text-primary me-2"></i>
                                    <h5 class="card-title mb-0">{{ $card['title'] }}</h5>
                                </div>

                                <p class="card-text text-muted small flex-grow-1">
                                    {{ $card['desc'] }}
                                </p>

                                @if ($card['url'] === '#')
                                    <a href="#"
                                        class="btn btn-primary mt-auto disabled"
                                        aria-disabled="true">
                                        Belum Tersedia
                                    </a>
                                @else
                                    <a href="{{ $card['url'] }}"
                                        class="btn btn-primary mt-auto"
                                        @if ($card['external']) target="_blank" rel="noopener" @endif>
                                        Lihat Informasi
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

        </div>
    </section>
</main>

<x-footer />