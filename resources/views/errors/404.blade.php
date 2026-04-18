<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Halaman Tidak Ditemukan</title>
    @vite('resources/css/app.css')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 flex items-center justify-center h-screen px-6">
    <div class="max-w-lg text-center">
        <div class="mb-8 flex justify-center">
            <div class="relative">
                <h1 class="text-9xl font-bold text-slate-200 select-none">404</h1>
                <div class="absolute inset-0 flex items-center justify-center">
                    <span class="text-4xl font-bold bg-[#F5B301] text-white px-4 py-1 rounded shadow-lg">Waduh!</span>
                </div>
            </div>
        </div>

        <h2 class="text-3xl font-bold text-slate-800 mb-4">Halaman Tidak Ditemukan</h2>
        <p class="text-slate-600 mb-8 leading-relaxed">
            Maaf, sepertinya halaman yang Anda cari di <span class="font-semibold text-[#1F6FEB]">Kelurahan Kademangan</span> sudah pindah atau tidak pernah ada.
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