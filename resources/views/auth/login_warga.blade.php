<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @php $siteSettings = \App\Models\SiteSetting::find(1); @endphp
    @if ($siteSettings && $siteSettings->favicon)
        <link rel="icon" href="{{ asset('storage/' . $siteSettings->favicon) }}?v={{ time() }}"
            type="image/x-icon">
    @endif
    <title>{{ $title }}</title>
    <link rel="stylesheet" href="{{ asset('assets/css/login_custom.css') }}">

    <!-- 1. Tambahkan Script reCAPTCHA -->
    {!! htmlScriptTagJsApi() !!}
</head>

<body class="login">
    <div class="container-login">
        <h3>Login Warga</h3>
        <p style="text-align: center; color: #666; margin-top: -10px;">Silakan masukkan NIK dan Password</p>

        @if ($errors->any())
            <div class="alert-danger" style="color: red; margin-bottom: 15px; text-align: center;">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form action="{{ route('login.process') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="username">NIK</label>
                <input id="username" name="username" type="text" class="form-control" value="{{ old('username') }}"
                    required autofocus placeholder="Masukkan 16 digit NIK">
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input id="password" name="password" type="password" class="form-control" required
                    placeholder="******">
            </div>

            <!-- 2. Tambahkan Widget Captcha di sini -->
            <div class="form-group" style="margin-bottom: 15px; display: flex; justify-content: center;">
                {!! htmlFormSnippet() !!}
            </div>
            @php
                $throttleKey = \Illuminate\Support\Str::lower(old('username')) . '|' . request()->ip();
                $isThrottled = \Illuminate\Support\Facades\RateLimiter::tooManyAttempts($throttleKey, 3);
            @endphp
            <div class="form-action">
                <button type="submit" class="btn-primary" style="width: 100%;" @disabled($isThrottled)>
                    {{ $isThrottled ? 'Akun Terkunci (Tunggu 5 Menit)' : 'Masuk ke Layanan' }}
                </button>
            </div>
        </form>

        <div class="login-footer" style="margin-top: 20px; text-align: center; font-size: 0.9em;">
            <p>Belum punya akun? <a href="{{ route('auth.register') }}"
                    style="color: #1a73e8; font-weight: bold;">Daftar Sekarang</a></p>
            <hr style="border: 0; border-top: 1px solid #eee; margin: 15px 0;">
            <a href="{{ route('login.staff') }}" style="color: #888; text-decoration: none;">Login sebagai
                Staff/Admin</a>
            <hr style="border: 0; border-top: 1px solid #eee; margin: 15px 0;">
            <a href="{{ route('home') }}" style="color: #888; text-decoration: none;">Kembali ke Beranda</a>
        </div>
    </div>
</body>

</html>
@if ($isThrottled)
    @php
        $seconds = \Illuminate\Support\Facades\RateLimiter::availableIn($throttleKey);
    @endphp
    <script>
        let seconds = {{ $seconds }};
        const button = document.querySelector('.btn-primary');

        const timer = setInterval(() => {
            seconds--;
            if (seconds <= 0) {
                clearInterval(timer);
                button.disabled = false;
                button.innerText = 'Masuk ke Layanan';
                button.style.backgroundColor = ""; // Kembali ke warna asal
            } else {
                let mins = Math.ceil(seconds / 60);
                button.innerText = `Tunggu ${mins} Menit lagi...`;
            }
        }, 1000);
    </script>
@endif
