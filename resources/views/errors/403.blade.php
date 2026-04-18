<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>403 - Halaman Tidak Ditemukan</title>
    @vite('resources/css/app.css')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body class="bg-slate-50 flex items-center justify-center h-screen px-6">
    <div class="max-w-lg text-center">
        <!DOCTYPE html>
        <html lang="id">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>403 - Akses Dibatasi</title>
            @vite('resources/css/app.css')
        </head>

        <body class="bg-slate-50 flex items-center justify-center h-screen px-6">
            <div class="max-w-lg text-center">
                <div class="mb-8 flex justify-center">
                    <div class="relative">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-32 h-32 text-brand-yellow" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>
                </div>
                <h2 class="text-3xl font-bold text-slate-800 mb-4">Akses Dibatasi</h2>
                <p class="text-slate-600 mb-8 leading-relaxed">
                    Maaf, Anda tidak memiliki izin untuk mengakses area ini. Silakan kembali ke <span
                        class="font-semibold text-[#1F6FEB]">Halaman Utama</span> atau hubungi administrator jika Anda
                    merasa ini adalah kesalahan.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="javascript:history.back()"
                        class="bg-[#1F6FEB] hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-full transition-all duration-300 transform hover:scale-105 shadow-md">
                        Kembali
                    </a>
                    <a href="{{ route('home') }}"
                        class="bg-white border-2 border-[#F5B301] text-slate-700 hover:bg-[#F5B301] hover:text-white font-bold py-3 px-8 rounded-full transition-all duration-300 shadow-sm">
                        Kembali ke Home
                    </a>
                </div>
            </div>
        </body>

        </html>
