@props(['title' => 'Dashboard Admin'])

<!DOCTYPE html>
<html lang="id">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>{{ $title }} - Admin Kelurahan</title>
    <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    {{-- <link rel="icon" href="{{ asset('assets/img/icon.ico') }}" type="image/x-icon" /> --}}
    @php
        // Mengambil data setting ID 1 langsung di component
        $siteSettings = \App\Models\SiteSetting::find(1);
    @endphp

    @if ($siteSettings && $siteSettings->favicon)
        {{-- Tambahkan ?v=time() agar browser tidak melakukan caching pada favicon lama --}}
        <link rel="icon" href="{{ asset('storage/' . $siteSettings->favicon) }}?v={{ time() }}"
            type="image/x-icon">
    @endif
    <script src="{{ asset('assets/js/plugin/webfont/webfont.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/head.js?v=2') }}"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/simple-line-icons/2.5.5/css/simple-line-icons.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

    <link rel="stylesheet" href="{{ asset('assets/admin/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/css/atlantis.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/css/style.css?v=2') }}">
</head>

<body>
    <div class="wrapper">
        <div class="main-header">
            <div class="logo-header" data-background-color="blue">
                <a href="{{ route('admin.dashboard') }}" class="logo">
                    <img src="{{ asset('assets/img/logo.svg') }}" alt="navbar brand" class="admin-logo-image">
                </a>
                <button class="navbar-toggler sidenav-toggler ml-auto" type="button" data-toggle="collapse"
                    data-target="collapse" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon">
                        <i class="icon-menu"></i>
                    </span>
                </button>
                <button class="topbar-toggler more"><i class="icon-options-vertical"></i></button>
                <div class="nav-toggle">
                    <button class="btn btn-toggle toggle-sidebar">
                        <i class="icon-menu"></i>
                    </button>
                </div>
            </div>
            <nav class="navbar navbar-header navbar-expand-lg" data-background-color="blue2">
                <div class="container-fluid">
                    <ul class="navbar-nav topbar-nav ml-md-auto align-items-center">
                        <li class="nav-item dropdown hidden-caret">
                            <a class="dropdown-toggle profile-pic" data-toggle="dropdown" href="#"
                                aria-expanded="false">
                                <div class="avatar-sm">
                                    <img src="{{ asset('uploads/profil/' . (Auth::user()->foto ?? 'default.jpg')) }}"
                                        alt="Profile" class="avatar-img rounded-circle">
                                </div>
                            </a>
                            <ul class="dropdown-menu dropdown-user animated fadeIn">
                                <div class="dropdown-user-scroll scrollbar-outer">
                                    <li>
                                        <div class="user-box">
                                            <div class="avatar-lg">
                                                <img src="{{ asset('uploads/profil/' . (Auth::user()->foto ?? 'default.jpg')) }}"
                                                    alt="Profile" class="avatar-img rounded">
                                            </div>
                                            <div class="u-text">
                                                <h4>{{ Auth::user()->nama_lengkap ?? 'Administrator' }}</h4>
                                                <p class="text-muted">
                                                    {{ Auth::user()->id_level == 1 ? 'Superadmin' : 'Admin/Staff' }}
                                                </p>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="dropdown-divider"></div>

                                        {{-- MENU BARU: KEMBALI KE HOME --}}
                                        <a class="dropdown-item" href="{{ route('home') }}" target="_blank">
                                            Kembali
                                        </a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" href="{{ route('admin.profile') }}">Profil Saya</a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" href="{{ route('logout') }}">Logout</a>
                                    </li>
                                </div>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
