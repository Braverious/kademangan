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
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-32 h-32 text-brand-blue animate-spin-slow"
                        style="animation: spin 10s linear infinite;" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </div>
                <h2 class="text-3xl font-bold text-slate-800 mb-4">Ups! Server Lagi Lelah</h2>
                <p class="text-slate-600 mb-8 leading-relaxed">
                    Terjadi kesalahan internal pada sistem kami. Tim IT Kelurahan Kademangan sedang berusaha
                    memperbaikinya sesegera mungkin.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ url('/') }}"
                        class="bg-[#1F6FEB] hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-full transition-all duration-300 transform hover:scale-105 shadow-md">
                        Kembali ke Home
                    </a>
                    <a href="https://wa.me/your-number"
                        class="bg-white border-2 border-[#F5B301] text-slate-700 hover:bg-[#F5B301] hover:text-white font-bold py-3 px-8 rounded-full transition-all duration-300 shadow-sm">
                        Lapor Admin
                    </a>
                </div>
            </div>
        </body>

        </html>
