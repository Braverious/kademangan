<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>405 - Metode Tidak Diizinkan</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-slate-50 flex items-center justify-center h-screen px-6">
    <div class="max-w-lg text-center">
        <div class="mb-8 flex justify-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-32 h-32 text-brand-yellow" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
            </svg>
        </div>

        <h1 class="text-3xl font-bold text-slate-800 mb-4">Cara Akses Salah!</h1>
        <p class="text-slate-600 mb-8 leading-relaxed">
            Halaman ini tidak bisa diakses secara langsung melalui address bar. Silakan gunakan tombol dan formulir yang
            tersedia di halaman <span class="text-brand-blue font-bold">Kelurahan Kademangan</span>.
        </p>
        <a href="{{ url('/') }}"
            class="bg-white border-2 border-[#F5B301] text-slate-700 hover:bg-[#F5B301] hover:text-white font-bold py-3 px-8 rounded-full transition-all duration-300 shadow-sm">
            Kembali ke Home
        </a>
    </div>
</body>

</html>
