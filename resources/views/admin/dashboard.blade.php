<x-header title="Dashboard Admin" />

<div class="container mt-5 py-5">
    <div class="card shadow rounded-4 border-0">
        <div class="card-body text-center p-5">
            <i class="bi bi-check-circle-fill text-success display-1"></i>
            <h1 class="fw-bold mt-4">Berhasil Login!</h1>
            <p class="lead text-muted">Selamat datang, <strong>{{ Auth::user()->nama_lengkap }}</strong>.</p>
            <hr class="my-4">
            <p>Anda sekarang berada di halaman Dashboard Admin (Laravel 11).</p>
            <a href="{{ route('logout') }}" class="btn btn-danger px-4">Logout</a>
        </div>
    </div>
</div>

{{-- Footer static atau component footer nanti --}}
</body>
</html>