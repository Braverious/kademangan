<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @php
        // Mengambil data setting ID 1 langsung di component
        $siteSettings = \App\Models\SiteSetting::find(1);
    @endphp

    @if ($siteSettings && $siteSettings->favicon)
        {{-- Tambahkan ?v=time() agar browser tidak melakukan caching pada favicon lama --}}
        <link rel="icon" href="{{ asset('storage/' . $siteSettings->favicon) }}?v={{ time() }}"
            type="image/x-icon">
    @endif
    <title>Login - Admin Kelurahan</title>
    {{-- <link rel="icon" href="{{ asset('assets/img/icon.ico') }}" type="image/x-icon" /> --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/login_custom.css') }}">
</head>

<body class="login">
    <div class="container-login">
        <h3>Login Administrator</h3>

        {{-- Menampilkan Error dari Session (Validation) --}}
        @if ($errors->any())
            <div class="alert-danger" role="alert" style="color: red; margin-bottom: 15px;">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form action="{{ url('auth/process') }}" method="POST">
            @csrf {{-- WAJIB DI LARAVEL --}}

            <div class="form-group">
                <label for="username">Username</label>
                <input id="username" name="username" type="text" class="form-control" value="{{ old('username') }}"
                    required autofocus>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input id="password" name="password" type="password" class="form-control" required>
            </div>

            <div class="form-action">
                <button type="submit" class="btn-primary">Login</button>
            </div>
        </form>
    </div>
</body>

</html>
