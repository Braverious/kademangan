@props(['title' => 'Kelurahan'])

<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
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

            <a class="navbar-brand fw-bold navbar-brand-center brand-kademangan" href="{{ route('home') }}">
                <span class="brand-line-1">KADEMANGAN</span>
                <span class="brand-line-2">Solutif &middot; Kolaboratif &middot; Inklusif</span>
            </a>

            <div class="d-none d-lg-block ms-auto">
                @auth
                    @if (Auth::user()->level_id == 3)
                        {{-- Tombol untuk Warga (Level 3) --}}
                        <a href="{{ route('logout') }}" class="btn btn-outline-danger px-3">
                            <i class="fa fa-sign-out-alt mr-1"></i> Logout
                        </a>
                    @else
                        {{-- Tombol untuk Staff/Admin (Level 1 & 2) --}}
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-primary px-3">
                            <i class="fa fa-tachometer-alt mr-1"></i> Dashboard
                        </a>
                    @endif
                @endauth

                @guest
                    {{-- Tombol untuk Pengunjung yang belum login --}}
                    <a href="{{ route('login') }}" class="btn btn-outline-primary px-3">
                        <i class="fa fa-user mr-1"></i> Login
                    </a>
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
                                    href="{{ route('home') }}">
                                    <i class="fa-solid fa-house" aria-hidden="true"></i>
                                    <span>Home</span>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ route('pelayanan.index') }}"
                                    class="nav-link d-flex align-items-center gap-2 px-3 {{ request()->is('pelayanan*') ? 'active' : '' }}">
                                    <i class="fa-solid fa-file-signature" aria-hidden="true"></i>
                                    <span>Pelayanan</span>
                                </a>
                            </li>

                            <li class="nav-item dropdown">
                                <a href="{{ route('lkk.index') }}"
                                    class="nav-link d-flex align-items-center gap-2 px-3 {{ request()->is('lkk*') ? 'active' : '' }}">
                                    <i class="fa-solid fa-people-group" aria-hidden="true"></i>
                                    <span>LKK</span>
                                </a>
                                <ul class="dropdown-menu shadow rounded-3 border-0 p-2">
                                    <li>
                                        <h6 class="dropdown-header fw-bold text-primary">
                                            <i class="fas fa-sitemap me-2"></i>Lembaga Kemasyarakatan Kelurahan
                                        </h6>
                                    </li>
                                    <li><a class="dropdown-item" href="#"><i class="fas fa-users me-2"></i>RT dan
                                            RW</a></li>
                                    <li><a class="dropdown-item" href="#"><i
                                                class="fas fa-hand-holding-heart me-2"></i>PKK</a></li>
                                    <li><a class="dropdown-item"
                                            href="https://www.instagram.com/karangtarunakademangan?igsh=MWZzd2VlcGgxaGM5NQ=="
                                            target="_blank" rel="noopener">
                                            <i class="fas fa-hands-helping me-2"></i>Karang Taruna</a></li>
                                    <li><a class="dropdown-item" href="#"><i
                                                class="fas fa-clinic-medical me-2"></i>Posyandu</a></li>
                                    <li><a class="dropdown-item" href="#"><i
                                                class="fas fa-project-diagram me-2"></i>LPM</a></li>
                                    <li><a class="dropdown-item" href="#"><i class="fas fa-mosque me-2"></i>MUI
                                            Kelurahan</a></li>
                                    <li><a class="dropdown-item" href="#"><i class="fas fa-mosque me-2"></i>DMI
                                            Kelurahan</a></li>
                                    <li><a class="dropdown-item" href="#"><i class="fas fa-quran me-2"></i>LPTQ
                                            Kelurahan</a></li>
                                    <li><a class="dropdown-item" href="#"><i
                                                class="fas fa-book-open me-2"></i>Pengajian Al Hidayah</a></li>
                                    <li><a class="dropdown-item" href="#"><i
                                                class="fas fa-recycle me-2"></i>TPS3R dan Bank Sampah</a></li>
                                    <li><a class="dropdown-item" href="#"><i
                                                class="fas fa-seedling me-2"></i>KWT dan Poktan</a></li>
                                    <li><a class="dropdown-item"
                                            href="https://www.instagram.com/kkmp_kademangan?igsh=MWxsOXNhNXEzaGlsYg=="
                                            target="_blank" rel="noopener">
                                            <i class="fa-solid fa-coins"></i> Koperasi Merah Putih</a></li>
                                </ul>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link px-3 d-flex align-items-center gap-2 {{ request()->is('berita*') ? 'active' : '' }}"
                                    href="{{ route('berita.index') }}">
                                    <i class="fa-regular fa-newspaper" aria-hidden="true"></i>
                                    <span>Berita</span>
                                </a>
                            </li>
                            @auth
                                @if (Auth::user()->level_id == 3)
                                    <li class="nav-item">
                                        <a class="nav-link px-3 d-flex align-items-center gap-2 {{ request()->is('warga/profil*') ? 'active' : '' }}"
                                            href="{{ route('warga.profil') }}">
                                            <i class="fa-solid fa-user-circle" aria-hidden="true"></i>
                                            <span>Profil</span>
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a class="nav-link px-3 d-flex align-items-center gap-2 {{ request()->is('warga/riwayat*') ? 'active' : '' }}"
                                            href="#">
                                            <i class="fa-solid fa-clock-rotate-left" aria-hidden="true"></i>
                                            <span>Riwayat</span>
                                        </a>
                                    </li>
                                @endif
                            @endauth

                            <li class="nav-item d-lg-none mt-2">
                                <a href="#" class="btn btn-outline-primary w-100">Login</a>
                            </li>

                        </ul>
                    </div>
                </div>
            </div>
        </nav>
    </header>
