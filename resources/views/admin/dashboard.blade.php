<x-admin.header :title="$title" />
<x-admin.sidebar />
<div class="container mt-4 page-inner admin-dashboard">
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
                    <div class="d-grid d-md-grid mt-3 dashboard-weather-grid">
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
                            <th class="dashboard-col-date">Tanggal Masuk</th>
                            <th class="dashboard-col-jenis">Jenis Surat</th>
                            <th>Nama Pemohon/Yayasan</th>
                            <th>Petugas</th>
                            <th class="dashboard-col-aksi">Aksi</th>
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

<x-admin.footer />
