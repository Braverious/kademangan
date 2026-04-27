<x-header :title="$data['title'] ?? 'Pengajuan Berhasil'" />

<main>
    <section class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-md-8 mx-auto text-center">
                    <div class="display-1 text-success mb-3">
                        <i class="bi bi-check-circle-fill"></i>
                    </div>

                    <h1 class="display-5 fw-bold">Pengajuan Terkirim!</h1>

                    <p class="lead text-muted">
                        {{ session('success') }}
                    </p>

                    <p>
                        Silakan tunggu informasi selanjutnya dari pihak kelurahan.
                        Anda akan dihubungi jika data sudah selesai diproses.
                    </p>

                    <a href="{{ route('home') }}" class="btn btn-primary mt-3">
                        Kembali ke Halaman Utama
                    </a>
                </div>
            </div>
        </div>
    </section>
</main>

<x-footer />