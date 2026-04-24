@php
    // Mengambil warna dari database, jika tidak ada pakai default biru (#0d6efd)
    $themeColor = $botSettings['chatbot_color'] ?? '#0d6efd';
@endphp

<style>
    /* 1. VARIABEL WARNA DINAMIS */
    :root {
        --bot-color: {{ $themeColor }};
        --bot-color-dark: {{ $themeColor }}dd;
        /* Memberi transparansi untuk efek hover */
    }

    /* 2. STRUKTUR UTAMA (TULANG) */
    #chatbot-wrapper {
        position: fixed;
        bottom: 25px;
        right: 25px;
        z-index: 1050;
        font-family: 'Inter', sans-serif;
    }

    /* Tombol Launcher */
    #chatbot-launcher {
        padding: 12px 24px;
        border-radius: 50px;
        background: var(--bot-color) !important;
        /* DINAMIS */
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        border: 2px solid white;
    }

    #chatbot-launcher:hover {
        transform: scale(1.05);
        background: var(--bot-color-dark) !important;
        /* DINAMIS */
    }

    #chatbot-launcher .launcher-text {
        font-weight: 600;
        margin-left: 10px;
        white-space: nowrap;
    }

    #chatbot-launcher.active {
        width: 60px;
        height: 60px;
        padding: 0;
        border-radius: 50%;
        background: #dc3545 !important;
        /* Tetap merah saat tutup */
    }

    /* Window Chat */
    #chatbot-window {
        width: 350px;
        max-width: 90vw;
        height: 500px;
        background: white;
        border-radius: 20px;
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
        display: none;
        flex-direction: column;
        overflow: hidden;
        position: absolute;
        bottom: 85px;
        right: 0;
        animation: slideIn 0.4s ease-out;
    }

    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateY(30px) scale(0.95);
        }

        to {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    }

    /* Header Chat */
    .chat-header {
        background: var(--bot-color) !important;
        /* DINAMIS */
        color: white;
        padding: 18px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    /* Area Pesan */
    .chat-body {
        flex: 1;
        padding: 20px;
        overflow-y: auto;
        background: #f0f2f5;
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .message {
        padding: 10px 15px;
        border-radius: 18px;
        max-width: 85%;
        font-size: 0.9rem;
        line-height: 1.5;
    }

    .message.bot {
        background: white;
        align-self: flex-start;
        color: #333;
        border-bottom-left-radius: 4px;
    }

    .message.user {
        background: var(--bot-color) !important;
        /* DINAMIS */
        color: white;
        align-self: flex-end;
        border-bottom-right-radius: 4px;
    }

    /* Footer & Input */
    .chat-footer {
        padding: 15px;
        background: white;
        border-top: 1px solid #eee;
    }

    .chat-input-group {
        display: flex;
        gap: 10px;
        background: #f8f9fa;
        padding: 5px;
        border-radius: 30px;
        border: 1px solid #ddd;
    }

    .chat-input-group input {
        border: none;
        background: transparent;
        padding: 8px 15px;
        flex: 1;
        outline: none;
    }

    .chat-input-group button {
        background: var(--bot-color) !important;
        /* DINAMIS */
        color: white;
        border: none;
        width: 38px;
        height: 38px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }
</style>
<x-header :title="$title" />
<main>
    <div id="chatbot-wrapper">
        <!-- Window Chat -->
        <div id="chatbot-window">
            <div class="chat-header">
                <div class="d-flex align-items-center">
                    <i class="bi bi-chat-square-dots-fill me-2 fs-5"></i>
                    <div>
                        <div class="fw-bold lh-1">{{ $botSettings['chatbot_name'] ?? 'Bantuan Kademangan' }}</div>
                        <small
                            style="font-size: 0.7rem; opacity: 0.8;">{{ $botSettings['chatbot_subtitle'] ?? 'Siap Melayani' }}</small>
                    </div>
                </div>
                <button type="button" class="btn-close btn-close-white" onclick="toggleChat()"></button>
            </div>

            <div class="chat-body" id="chat-messages">
                <!-- Pesan Pembuka -->
                <div class="message bot">
                    Selamat datang di layanan chatbot Kelurahan Kademangan! Ada yang bisa kami bantu hari ini?
                </div>
            </div>

            <div class="chat-footer">
                <form id="chat-form" onsubmit="sendMessage(event)">
                    <div class="chat-input-group">
                        <input type="text" id="user-input" placeholder="Tulis pertanyaan Anda..." autocomplete="off">
                        <button type="submit">
                            <i class="bi bi-send-fill"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Tombol Launcher (Sekarang berbentuk Pil) -->
        <div id="chatbot-launcher" onclick="toggleChat()">
            <i class="bi bi-chat-right-text-fill fs-5" id="launcher-icon"></i>
            <span class="launcher-text" id="launcher-label">Tanya Kami (AI)</span>
        </div>
    </div>
    <section id="home" class="py-5 d-flex align-items-center mb-5 mt-5">
        <div class="container-fluid px-lg-5">
            <div class="row align-items-center">
                <div class="col-lg-7">
                    <h1 class="display-5 fw-bold mb-3">Layanan Publik Kelurahan yang Mudah & Transparan</h1>
                    <p class="lead text-muted">Akses informasi, ajukan layanan, dan baca berita terbaru seputar
                        kelurahan
                        Anda dalam satu halaman.</p>
                    <a href="#" class="btn btn-primary btn-lg me-2" style="border-radius: 20px;">Ajukan
                        Layanan</a>
                    <a href="#Layanan" class="btn btn-outline-primary btn-lg" style="border-radius: 20px;">Layanan
                        kami</a>
                </div>
            </div>
        </div>
    </section>

    @if (isset($runningTexts) && $runningTexts->count() > 0)
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
                    @forelse ($layanan as $item)
                        <div class="slider-item col-10 col-sm-6 col-lg-3 p-0 flex-shrink-0"
                            style="scroll-snap-align:start;">

                            <div class="card service-card h-100 overflow-hidden">

                                <!-- GAMBAR -->
                                <div class="card-img-top bg-light d-flex align-items-center justify-content-center"
                                    style="height: 150px;">

                                    @if ($item->gambar)
                                        <img src="{{ asset('storage/' . $item->gambar) }}" alt="{{ $item->judul }}"
                                            style="height:100%; object-fit:cover; width:100%;">
                                    @else
                                        <i class="bi bi-file-earmark-text display-4 text-secondary"></i>
                                    @endif

                                </div>

                                <!-- CONTENT -->
                                <div class="card-body">
                                    <h5 class="card-title mb-1">{{ $item->judul }}</h5>

                                    <span class="title-underline"></span>

                                    <p class="card-text small text-muted mb-0">
                                        {{ \Illuminate\Support\Str::limit(strip_tags($item->deskripsi), 100) }}
                                    </p>
                                </div>

                            </div>
                        </div>

                    @empty

                        <div class="col-12 text-center">
                            <p class="text-muted">Belum ada layanan tersedia</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </section>

    <!-- ===== PENGUMUMAN ===== -->
    <section id="pengumuman" class="py-5 section-abstract">
        <div class="container-fluid px-lg-5">

            <div class="row mb-3">
                <div class="col-12 text-center">
                    <h2 class="section-title mb-1">Pengumuman</h2>
                    <p class="text-muted mb-0">Info penting/terbaru dari Kelurahan.</p>
                </div>
            </div>

            @if ($pengumuman->count())
                <div id="pengumumanSlider" class="flash-track d-flex flex-nowrap gap-4 pb-1"
                    style="scroll-snap-type:x mandatory; scroll-behavior:smooth;">

                    @foreach ($pengumuman as $p)
                        @php
                            $judul = trim($p->judul);
                            $isi = strip_tags($p->isi);
                            $ringkas = \Illuminate\Support\Str::limit($isi, 220);
                            $tglStr = $p->mulai_tayang
                                ? \Carbon\Carbon::parse($p->mulai_tayang)->format('d M Y, H:i')
                                : null;
                        @endphp

                        <article class="flash-item flash-col" style="scroll-snap-align:start;">
                            <div class="card flash-card h-100">

                                <div class="card-body d-flex flex-column">

                                    <div class="d-flex align-items-center gap-2 mb-2">
                                        <span class="flash-icon">
                                            <i class="bi bi-megaphone-fill"></i>
                                        </span>

                                        <span class="badge bg-warning text-dark fw-semibold">
                                            {{ $p->tipe ?? 'Info' }}
                                        </span>

                                        @if ($tglStr)
                                            <small class="text-muted ms-auto">
                                                {{ $tglStr }}
                                            </small>
                                        @endif
                                    </div>

                                    <h5 class="card-title mb-2 line-clamp-2">
                                        {{ $judul }}
                                    </h5>

                                    <p class="card-text text-muted mb-3 line-clamp-3">
                                        {{ $ringkas }}
                                    </p>

                                </div>
                            </div>
                        </article>
                    @endforeach

                </div>
            @else
                <div class="text-center text-muted py-4">
                    Belum ada pengumuman.
                </div>
            @endif

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
                                <div class="mx-auto mb-2"><i
                                        class="bi bi-{{ $s['icon'] }} display-6 text-primary"></i>
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

            <div id="carouselGaleri"
                class="carousel slide carousel-smooth force-motion shadow-sm rounded-4 overflow-hidden"
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
                        <img src="https://placehold.co/1200x500?text=Foto+Galeri+1" class="d-block w-100"
                            alt="Galeri 1">
                        <div class="carousel-caption d-none d-md-block text-start">
                            <h5>Judul Foto Galeri 1</h5>
                        </div>
                    </div>

                    {{-- Slide 2 --}}
                    <div class="carousel-item">
                        <img src="https://placehold.co/1200x500?text=Foto+Galeri+2" class="d-block w-100"
                            alt="Galeri 2">
                        <div class="carousel-caption d-none d-md-block text-start">
                            <h5>Judul Foto Galeri 2</h5>
                        </div>
                    </div>

                    {{-- Slide 3 --}}
                    <div class="carousel-item">
                        <img src="https://placehold.co/1200x500?text=Foto+Galeri+3" class="d-block w-100"
                            alt="Galeri 3">
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
                                    Ini adalah contoh teks ringkasan berita kelurahan. Warga diharapkan berpartisipasi
                                    dalam
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
            @if (!empty($video_id))
                <div class="row justify-content-center">
                    <div class="col-lg-10">
                        <div class="video-card brand-card shadow-sm rounded-4 overflow-hidden">
                            <div class="ratio ratio-16x9">
                                <iframe src="https://www.youtube.com/embed/{{ $video_id }}"
                                    title="{{ $video_meta['title'] }}" frameborder="0"
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                    allowfullscreen></iframe>
                            </div>

                            <div
                                class="video-info d-flex justify-content-between align-items-center px-4 py-3 bg-white">
                                <div class="d-flex align-items-center gap-3">
                                    <span class="yt-badge text-light" aria-hidden="true" style="font-size: 1.5rem;">
                                        <i class="bi bi-play-btn-fill"></i>
                                    </span>
                                    <div>
                                        <h5 class="video-title mb-1 fw-bold">{{ $video_meta['title'] }}</h5>
                                        <p class="video-channel mb-0 text-muted small">
                                            {{ $video_meta['author_name'] }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
    </section>
</main>
<x-footer></x-footer>
<script>
    // Fungsi untuk buka-tutup jendela chatbot
    function toggleChat() {
        const chatWindow = document.getElementById('chatbot-window');
        const launcher = document.getElementById('chatbot-launcher');
        const launcherIcon = document.getElementById('launcher-icon');
        const launcherLabel = document.getElementById('launcher-label');

        // Cek apakah window sedang tertutup
        if (chatWindow.style.display === 'none' || chatWindow.style.display === '') {
            // Membuka Chat
            chatWindow.style.display = 'flex';
            launcher.classList.add('active');
            launcherIcon.className = 'bi bi-x-lg fs-4'; // Berubah jadi ikon silang
            launcherLabel.style.display = 'none'; // Sembunyikan tulisan "Tanya Kami"
        } else {
            // Menutup Chat
            chatWindow.style.display = 'none';
            launcher.classList.remove('active');
            launcherIcon.className = 'bi bi-chat-right-text-fill fs-5'; // Berubah ke ikon awal
            launcherLabel.style.display = 'inline'; // Munculkan tulisan lagi
        }
    }

    async function sendMessage(event) {
        event.preventDefault();
        const input = document.getElementById('user-input');
        const messageContainer = document.getElementById('chat-messages');
        const text = input.value.trim();

        if (text === "") return;

        // 1. Tampilkan pesan user di layar
        appendMessage('user', text);
        input.value = '';

        // 2. Beri indikasi "sedang mengetik"
        const typingIndicator = document.createElement('div');
        typingIndicator.className = 'message bot italic';
        typingIndicator.id = 'typing';
        typingIndicator.textContent = 'Sedang mengetik...';
        messageContainer.appendChild(typingIndicator);
        messageContainer.scrollTop = messageContainer.scrollHeight;

        try {
            // 3. Kirim data ke Laravel menggunakan Fetch API
            const response = await fetch('/chatbot/send', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                        'content')
                },
                body: JSON.stringify({
                    message: text
                })
            });

            const data = await response.json();

            // Hapus indikator mengetik dan tampilkan jawaban AI
            document.getElementById('typing').remove();
            appendMessage('bot', data.reply);

        } catch (error) {
            document.getElementById('typing').remove();
            appendMessage('bot', "Maaf, server sedang sibuk.");
        }
    }

    function appendMessage(sender, text) {
        const messageContainer = document.getElementById('chat-messages');
        const div = document.createElement('div');
        div.className = `message ${sender}`;
        div.textContent = text;
        messageContainer.appendChild(div);
        messageContainer.scrollTop = messageContainer.scrollHeight;
    }
</script>
