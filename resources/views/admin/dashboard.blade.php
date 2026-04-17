<x-admin.header :title="$title" />
<x-admin.sidebar />

<style>
    :root {
        --blue-900: #0a2a66;
        --blue-700: #0f3a8a;
        --blue-600: #1147a7;
        --blue-100: #eaf2ff;
        --paper: #fff;
        --ink: #0b1220;
        --yellow-500: #ffc107
    }
    .page-header { display: flex; align-items: center; flex-wrap: wrap; gap: 10px 24px; }
    #jsPeriodChips { display: flex; align-items: center; gap: 16px; padding: 6px 10px; border-radius: 14px; background: #fff; box-shadow: 0 2px 10px rgba(24, 28, 33, .06); }
    #jsPeriodChips .chip { padding: 10px 16px; border-radius: 999px; }
    #jsPeriodChips .chip:focus-visible { outline: 3px solid rgba(17, 71, 167, .18); outline-offset: 2px; }
    @media (max-width: 576px) { #jsPeriodChips { gap: 12px; } }
    .section-sep { height: 3px; background: var(--yellow-500); border: 0; margin: .5rem 0 1rem }
    .toolbar { display: flex; gap: .75rem; align-items: center; flex-wrap: wrap; background: #fff; border: 1px solid #e8ebf2; border-radius: 12px; padding: .6rem .8rem }
    .chip { border: 1px solid #e6e8ef; background: #fff; border-radius: 999px; padding: .45rem .9rem; display: inline-flex; gap: .5rem; align-items: center; font-weight: 600 }
    .chip i { opacity: .85 }
    .chip.active { border-color: var(--blue-600); box-shadow: 0 0 0 3px rgba(17, 71, 167, .12) }
    .toolbar .dates { display: flex; gap: .5rem; align-items: center; margin-left: auto }
    .toolbar input[type="date"] { border: 1px solid #e6e8ef; border-radius: 10px; padding: .35rem .55rem }
    .toolbar .btn-apply { border-radius: 10px }
    .stat-grid .stat-card { border: 1px solid rgba(17, 71, 167, .08); border-radius: 16px; background: linear-gradient(180deg, #fff 0%, #f7f8fc 100%); box-shadow: 0 6px 18px rgba(24, 28, 33, .06); transition: transform .18s, box-shadow .18s, border-color .18s }
    .stat-grid .stat-card:hover { transform: translateY(-2px); box-shadow: 0 10px 28px rgba(24, 28, 33, .1); border-color: rgba(17, 71, 167, .18) }
    .stat-body { padding: 16px; display: flex; gap: 14px; align-items: center }
    .stat-icon { width: 50px; height: 50px; flex: 0 0 50px; border-radius: 12px; background: var(--blue-100); color: var(--blue-600); display: flex; align-items: center; justify-content: center; box-shadow: inset 0 0 0 1px rgba(17, 71, 167, .10) }
    .stat-icon i { font-size: 18px }
    .stat-meta { min-width: 0; flex: 1 }
    .stat-title { margin: 0; font-size: .95rem; font-weight: 700; color: #1f2a44; white-space: normal; overflow: visible }
    .stat-sub { margin-top: 2px; color: #64748b; font-size: .825rem }
    .stat-value { font-weight: 800; font-size: 1.35rem; color: var(--blue-700); font-variant-numeric: tabular-nums }
    .card-modern { border: 0; border-radius: 14px; box-shadow: 0 6px 18px rgba(24, 28, 33, .06) }
    .card-modern .card-header { border: 0; padding: 14px 18px; box-shadow: inset 0 -3px 0 0 var(--yellow-500) }
    .card-modern .card-title { margin: 0; font-weight: 700; font-size: 1.05rem; color: var(--blue-700) }
    .wx-chips { display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: .75rem; }
    .wx-chip { width: auto; display: flex; align-items: center; gap: .6rem; border: 1px solid #e6e8ef; border-radius: 12px; background: #fff; padding: .6rem .7rem; }
    .wx-chip i { width: 36px; height: 36px; border-radius: 10px; display: flex; align-items: center; justify-content: center; background: var(--blue-100); color: var(--blue-600); }
    @media (min-width: 992px) { .wx-chips { grid-template-columns: repeat(4, minmax(220px, 1fr)); } }
</style>

<div class="container mt-4 page-inner">
    <div class="page-header">
        <h4 class="page-title mb-2">Dashboard</h4>
        <div class="toolbar">
            <div class="chip-group" id="jsPeriodChips">
                <button type="button" class="chip js-chip active"><i class="fas fa-calendar-alt"></i> Bulan ini</button>
                <button type="button" class="chip js-chip"><i class="fas fa-sun"></i> Hari ini</button>
                <button type="button" class="chip js-chip"><i class="fas fa-sliders-h"></i> Rentang</button>
            </div>
        </div>
    </div>

    <hr class="section-sep">

    <div class="mb-2">
        <small class="text-muted">Periode: <span id="jsPeriodLabel">Bulan ini</span></small>
    </div>

    <div class="row g-3 stat-grid mb-3">
        <div class="col-12 col-md-4">
            <a class="stat-link text-decoration-none" href="#">
                <div class="card stat-card h-100">
                    <div class="stat-body">
                        <div class="stat-icon"><i class="fas fa-coins"></i></div>
                        <div class="stat-meta">
                            <p class="stat-title">Surat Keterangan Penghasilan</p>
                            <div class="stat-sub">Total: 45</div>
                        </div>
                        <div class="stat-value">45</div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-12 col-md-4">
            <a class="stat-link text-decoration-none" href="#">
                <div class="card stat-card h-100">
                    <div class="stat-body">
                        <div class="stat-icon"><i class="fas fa-user"></i></div>
                        <div class="stat-meta">
                            <p class="stat-title">Surat Keterangan Belum Bekerja</p>
                            <div class="stat-sub">Total: 120</div>
                        </div>
                        <div class="stat-value">120</div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-12 col-md-4">
            <a class="stat-link text-decoration-none" href="#">
                <div class="card stat-card h-100">
                    <div class="stat-body">
                        <div class="stat-icon"><i class="fas fa-shield-alt"></i></div>
                        <div class="stat-meta">
                            <p class="stat-title">Surat Keterangan Tidak Mampu (SKTM)</p>
                            <div class="stat-sub">Total: 85</div>
                        </div>
                        <div class="stat-value">85</div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-12 col-md-4">
            <a class="stat-link text-decoration-none" href="#">
                <div class="card stat-card h-100">
                    <div class="stat-body">
                        <div class="stat-icon"><i class="fas fa-university"></i></div>
                        <div class="stat-meta">
                            <p class="stat-title">Surat Keterangan Domisili Yayasan</p>
                            <div class="stat-sub">Total: 12</div>
                        </div>
                        <div class="stat-value">12</div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-12 col-md-4">
            <a class="stat-link text-decoration-none" href="#">
                <div class="card stat-card h-100">
                    <div class="stat-body">
                        <div class="stat-icon"><i class="fas fa-home"></i></div>
                        <div class="stat-meta">
                            <p class="stat-title">Surat Keterangan Belum Memiliki Rumah</p>
                            <div class="stat-sub">Total: 30</div>
                        </div>
                        <div class="stat-value">30</div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-12 col-md-4">
            <a class="stat-link text-decoration-none" href="#">
                <div class="card stat-card h-100">
                    <div class="stat-body">
                        <div class="stat-icon"><i class="fas fa-crosshairs"></i></div>
                        <div class="stat-meta">
                            <p class="stat-title">Surat Keterangan Kematian (Dukcapil)</p>
                            <div class="stat-sub">Total: 18</div>
                        </div>
                        <div class="stat-value">18</div>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-12">
            <div class="card card-modern">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title mb-0"><i class="fas fa-cloud-sun me-2"></i>Cuaca & Waktu</h4>
                    <span class="text-muted">Terakhir diperbarui: 12:00 WIB</span>
                </div>
                <div class="card-body">
                    <div class="wx-sub">
                        <strong>Kademangan, Setu, Tangerang Selatan</strong> • <span>17 April 2024</span> • <span>12:00:00</span>
                        <span class="badge bg-warning text-dark ms-2">Asia/Jakarta</span>
                    </div>
                    <div class="d-grid d-md-grid mt-3" style="grid-template-columns:repeat(4,minmax(160px,1fr));gap:.6rem">
                        <div class="wx-chip"><i class="fas fa-thermometer-half"></i>
                            <div><div class="wx-val">32.0°C (35.0°C)</div><div class="wx-sub">Suhu (Feels)</div></div>
                        </div>
                        <div class="wx-chip"><i class="fas fa-cloud"></i>
                            <div><div class="wx-val">Cerah Berawan</div><div class="wx-sub">Kondisi</div></div>
                        </div>
                        <div class="wx-chip"><i class="fas fa-wind"></i>
                            <div><div class="wx-val">15 km/j • Barat Laut</div><div class="wx-sub">Angin</div></div>
                        </div>
                        <div class="wx-chip"><i class="fas fa-tint"></i>
                            <div><div class="wx-val">65%</div><div class="wx-sub">Kelembapan</div></div>
                        </div>
                    </div>
                    <div class="mt-2 wx-sub">Sunrise/Sunset: 05:50 / 17:55</div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6 mb-3">
            <div class="card card-modern h-100">
                <div class="card-header">
                    <h4 class="card-title mb-0"><i class="fas fa-chart-bar me-2"></i>Jangkauan Layanan</h4>
                </div>
                <div class="card-body"><canvas id="coverageChart" height="180"></canvas></div>
            </div>
        </div>
        <div class="col-lg-6 mb-3">
            <div class="card card-modern h-100">
                <div class="card-header">
                    <h4 class="card-title mb-0"><i class="fas fa-chart-line me-2"></i>Pengajuan Surat (12 bulan)</h4>
                </div>
                <div class="card-body"><canvas id="suratChart" height="180"></canvas></div>
            </div>
        </div>
    </div>

    <div class="card card-modern">
        <div class="card-header d-flex align-items-center justify-content-between flex-wrap gap-2">
            <h4 class="card-title mb-0">Aktivitas Pengajuan Surat</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover w-100 align-middle">
                    <thead>
                        <tr>
                            <th style="min-width:170px;">Tanggal Masuk</th>
                            <th style="min-width:220px;">Jenis Surat</th>
                            <th>Nama Pemohon/Yayasan</th>
                            <th>Petugas</th>
                            <th style="min-width:120px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>17 Apr 2024, 09:30</td>
                            <td><span class="badge bg-primary">SKTM</span></td>
                            <td>Budi Santoso</td>
                            <td>Admin Utama</td>
                            <td><button class="btn btn-info btn-sm text-white">Lihat Detail</button></td>
                        </tr>
                        <tr>
                            <td>16 Apr 2024, 14:15</td>
                            <td><span class="badge bg-primary">Belum Bekerja</span></td>
                            <td>Siti Aminah</td>
                            <td>Admin Utama</td>
                            <td><button class="btn btn-info btn-sm text-white">Lihat Detail</button></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    window.addEventListener('load', function() {
        const elCov = document.getElementById('coverageChart');
        if (elCov) {
            new Chart(elCov, {
                type: 'bar',
                data: {
                    labels: ['Jumlah KK', 'Penduduk', 'RW', 'RT'],
                    datasets: [{
                        label: 'Jumlah',
                        data: [7884, 25724, 12, 48],
                        backgroundColor: '#1147a7'
                    }]
                },
                options: { responsive: true, plugins: { legend: { display: false } } }
            });
        }

        const elSurat = document.getElementById('suratChart');
        if (elSurat) {
            new Chart(elSurat, {
                type: 'bar',
                data: {
                    labels: ['Nov', 'Des', 'Jan', 'Feb', 'Mar', 'Apr'],
                    datasets: [{
                        label: 'Pengajuan',
                        data: [50, 80, 45, 90, 110, 60],
                        backgroundColor: '#ffc107'
                    }]
                },
                options: { responsive: true }
            });
        }
    });
</script>
<x-admin.footer />