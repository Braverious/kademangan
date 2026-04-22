@props(['title' => 'Kelurahan'])

<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Menggunakan variabel $title dari Route, default ke 'Kelurahan' --}}
    <title>{{ $title ?? 'Kelurahan' }}</title>
    @php
        // Mengambil data setting ID 1 langsung di component
        $siteSettings = \App\Models\SiteSetting::find(1);
    @endphp

    @if ($siteSettings && $siteSettings->favicon)
        {{-- Tambahkan ?v=time() agar browser tidak melakukan caching pada favicon lama --}}
        <link rel="icon" href="{{ asset('storage/' . $siteSettings->favicon) }}?v={{ time() }}"
            type="image/x-icon">
    @endif
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet" />

    {{-- Menggunakan helper asset() untuk memanggil file di folder public --}}
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/informasi_custom.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/berita_custom.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/pelayanan_custom.css') }}">
</head>

<body class="is-home has-abstract-bg">

    <nav class="navbar navbar-light bg-white shadow-sm nav-topbar sticky-top">
        <div class="container align-items-center position-relative">
            <button class="navbar-toggler d-lg-none me-2" type="button" data-bs-toggle="collapse"
                data-bs-target="#mainNav" aria-controls="mainNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <a class="navbar-brand fw-bold navbar-brand-center brand-kademangan" href="#">
                <span class="brand-line-1">Kademangan</span>
                <span class="brand-line-2">Solutif &middot; Kolaboratif &middot; Inklusif</span>
            </a>

            <div class="d-none d-lg-block ms-auto">
                @auth
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-primary px-3">Dashboard</a>
                @endauth

                @guest
                    <a href="{{ route('login') }}" class="btn btn-outline-primary px-3">Login</a>
                @endguest
            </div>
        </div>
    </nav>
    <header class="sticky-top bg-transparent">
        <nav class="navbar navbar-expand-lg nav-menubar">
            <div class="container container-menu">
                <div class="menubar-floating">
                    <div class="collapse navbar-collapse justify-content-center" id="mainNav">
                        <ul class="navbar-nav nav-justified gap-lg-1">

                            <li class="nav-item">
                                {{-- Menggunakan request()->is() untuk deteksi menu aktif --}}
                                <a class="nav-link px-3 d-flex align-items-center gap-2 {{ request()->is('/') || request()->is('home') ? 'active' : '' }}"
                                    href="#">
                                    <i class="fa-solid fa-house" aria-hidden="true"></i>
                                    <span>Home</span>
                                </a>
                            </li>

                            <li class="nav-item dropdown">
                                <a href="#"
                                    class="nav-link d-none d-lg-flex align-items-center gap-2 px-3 {{ request()->is('pelayanan*') ? 'active' : '' }}">
                                    <i class="fa-solid fa-file-signature" aria-hidden="true"></i>
                                    <span>Pelayanan</span>
                                </a>

                                <a href="#"
                                    class="nav-link dropdown-toggle d-lg-none d-flex align-items-center gap-2 px-3"
                                    data-bs-toggle="dropdown" role="button" aria-expanded="false">
                                    <i class="fa-solid fa-file-signature" aria-hidden="true"></i>
                                    <span>Pelayanan</span>
                                </a>

                                <ul class="dropdown-menu shadow rounded-3 border-0 p-2">
                                    <li>
                                        <h6 class="dropdown-header fw-bold text-primary">
                                            <i class="fas fa-envelope-open-text me-2"></i>Pilih Jenis Surat
                                        </h6>
                                    </li>
                                    <li><a class="dropdown-item d-flex align-items-center gap-2" href="#"><i
                                                class="fas fa-shield-alt me-2"></i>SKTM</a></li>
                                    <li><a class="dropdown-item d-flex align-items-center gap-2" href="#"><i
                                                class="fas fa-user me-2"></i>Ket. Belum Bekerja</a></li>
                                    <li><a class="dropdown-item d-flex align-items-center gap-2" href="#"><i
                                                class="fas fa-university me-2"></i>Domisili Yayasan</a></li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li><a class="dropdown-item text-center fw-semibold text-primary" href="#">
                                            <i class="fas fa-ellipsis-h me-1"></i>Layanan Lainnya
                                        </a></li>
                                </ul>
                            </li>

                            <li class="nav-item dropdown">
                                <a href="#" class="nav-link dropdown-toggle d-flex align-items-center gap-2 px-3"
                                    data-bs-toggle="dropdown" role="button" aria-expanded="false">
                                    <i class="fa-solid fa-people-group" aria-hidden="true"></i>
                                    <span>LKK</span>
                                </a>
                                <ul class="dropdown-menu shadow rounded-3 border-0 p-2">
                                    <li><a class="dropdown-item" href="#"><i class="fas fa-users me-2"></i>RT
                                            dan
                                            RW</a></li>
                                    <li><a class="dropdown-item" href="#"><i
                                                class="fas fa-hand-holding-heart me-2"></i>PKK</a></li>
                                    <li><a class="dropdown-item" href="#"><i
                                                class="fas fa-hands-helping me-2"></i>Karang Taruna</a></li>
                                </ul>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link px-3 d-flex align-items-center gap-2 {{ request()->is('berita*') ? 'active' : '' }}"
                                    href="#">
                                    <i class="fa-regular fa-newspaper" aria-hidden="true"></i>
                                    <span>Berita</span>
                                </a>
                            </li>

                            <li class="nav-item d-lg-none mt-2">
                                <a href="#" class="btn btn-outline-primary w-100">Login</a>
                            </li>

                        </ul>
                    </div>
                </div>
            </div>
        </nav>
    </header>
