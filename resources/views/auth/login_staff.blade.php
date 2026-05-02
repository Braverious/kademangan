<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @php $siteSettings = \App\Models\SiteSetting::find(1); @endphp
    @if ($siteSettings && $siteSettings->favicon)
        <link rel="icon" href="{{ asset('storage/' . $siteSettings->favicon) }}?v={{ time() }}" type="image/x-icon">
    @endif
    <title>{{ $title }}</title>
    <link rel="stylesheet" href="{{ asset('assets/css/login_custom.css') }}">

    <!-- 1. Script reCAPTCHA -->
    {!! htmlScriptTagJsApi() !!}

    <!-- Style tambahan untuk tombol disabled -->
    <style>
        .btn-primary:disabled {
            background-color: #cccccc !important;
            color: #666666 !important;
            cursor: not-allowed;
            border: 1px solid #999999;
        }
    </style>
</head>

<body class="login" style="background-color: #f4f7f6;">
    <div class="container-login">
        <h3 style="color: #1a73e8;">Login Administrator</h3>
        <p style="text-align: center; color: #666; margin-top: -10px;">Portal Khusus Staff Kelurahan</p>

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
                <label for="username">Username</label>
                <input id="username" name="username" type="text" class="form-control" value="{{ old('username') }}" required autofocus>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input id="password" name="password" type="password" class="form-control" required>
            </div>

            <!-- 2. Widget Captcha -->
            <div class="form-group" style="margin-bottom: 15px; display: flex; flex-direction: column; align-items: center;">
                {!! htmlFormSnippet() !!}
            </div>

            <!-- 3. Logic Rate Limiting Blade -->
            @php
                $throttleKey = \Illuminate\Support\Str::lower(old('username')) . '|' . request()->ip();
                $isThrottled = \Illuminate\Support\Facades\RateLimiter::tooManyAttempts($throttleKey, 3);
            @endphp

            <div class="form-action">
                <button type="submit" class="btn-primary" style="width: 100%; {{ !$isThrottled ? 'background-color: #1a73e8;' : '' }}" @disabled($isThrottled)>
                    {{ $isThrottled ? 'Akun Terkunci (Tunggu 5 Menit)' : 'Masuk ke Dashboard' }}
                </button>
            </div>
        </form>

        <div class="login-footer" style="margin-top: 20px; text-align: center; font-size: 0.9em;">
            <a href="{{ route('login') }}" style="color: #888; text-decoration: none;">&larr; Kembali ke Login Warga</a>
        </div>
    </div>

    <!-- 4. Script Timer jika terkena limit -->
    @if ($isThrottled)
        @php
            $seconds = \Illuminate\Support\Facades\RateLimiter::availableIn($throttleKey);
        @endphp
        <script>
            let seconds = {{ $seconds ?? 0 }};
            const button = document.querySelector('.btn-primary');

            const timer = setInterval(() => {
                seconds--;
                if (seconds <= 0) {
                    clearInterval(timer);
                    button.disabled = false;
                    button.innerText = 'Masuk ke Dashboard';
                    button.style.backgroundColor = "#1a73e8"; // Kembalikan ke warna biru staff
                } else {
                    let mins = Math.ceil(seconds / 60);
                    button.innerText = `Tunggu ${mins} Menit lagi...`;
                }
            }, 1000);
        </script>
    @endif
</body>
</html>