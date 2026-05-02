<x-header :title="$title" />

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-white py-3 d-flex align-items-center justify-content-between">
                    <h5 class="fw-bold mb-0 text-primary">
                        <i class="fas fa-user-circle me-2"></i>Profil Lengkap Warga
                    </h5>
                    <a href="{{ route('home') }}" class="btn btn-sm btn-outline-primary">
                        <i class="fas fa-angle-left me-1"></i> Kembali
                    </a>
                </div>
                <div class="card-body p-4">
                    <div class="alert alert-info border-0 rounded-3 mt-2">
                        <small><i class="fas fa-info-circle me-1"></i> Jika terdapat ketidaksesuaian data, silakan
                            hubungi operator Kelurahan Kademangan.</small>
                    </div>
                    <div class="row" style="margin-bottom:-20px;">
                        <!-- BAGIAN A: IDENTITAS UTAMA -->
                        <div class="col-md-6 mb-4">
                            <h6 class="fw-bold text-dark border-bottom pb-2"><i
                                    class="fas fa-id-card me-2"></i>Identitas Pribadi</h6>
                            <table class="table table-borderless sm-table">
                                <tr>
                                    <th width="40%">NIK</th>
                                    <td>: {{ $user->username }}</td>
                                </tr>
                                <tr>
                                    <th>Nama Lengkap</th>
                                    <td>: {{ $user->citizenDetail->full_name }}</td>
                                </tr>
                                <tr>
                                    <th>Tempat Lahir</th>
                                    <td>: {{ $user->citizenDetail->birth_place }}</td>
                                </tr>
                                <tr>
                                    <th>Tanggal Lahir</th>
                                    <td>: {{ \Carbon\Carbon::parse($user->citizenDetail->birth_date)->format('d F Y') }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>Agama</th>
                                    <td>: {{ $user->citizenDetail->religion }}</td>
                                </tr>
                                <tr>
                                    <th>Status Nikah</th>
                                    <td>: {{ $user->citizenDetail->marital_status }}</td>
                                </tr>
                                <tr>
                                    <th>Pekerjaan</th>
                                    <td>: {{ $user->citizenDetail->occupation }}</td>
                                </tr>
                                <tr>
                                    <th>Kewarganegaraan</th>
                                    <td>: {{ $user->citizenDetail->nationality }}</td>
                                </tr>
                                <tr>
                                    <th>Berlaku KTP</th>
                                    <td>: {{ $user->citizenDetail->ktp_expiry }}</td>
                                </tr>
                            </table>
                        </div>
                        <!-- BAGIAN B: KELUARGA & DOMISILI -->
                        <div class="col-md-6 mb-4">
                            <h6 class="fw-bold text-dark border-bottom pb-2"><i class="fas fa-users me-2"></i>Data
                                Keluarga & Domisili</h6>
                            <table class="table table-borderless sm-table">
                                <tr>
                                    <th width="40%">Nomor KK</th>
                                    <td>: {{ $user->citizenDetail->no_kk }}</td>
                                </tr>
                                <tr>
                                    <th>Kepala Keluarga</th>
                                    <td>: {{ $user->citizenDetail->family_head_name }}</td>
                                </tr>
                                <tr>
                                    <th>Alamat</th>
                                    <td>: {{ $user->citizenDetail->address }}</td>
                                </tr>
                                <tr>
                                    <th>RT / RW</th>
                                    <td>: {{ $user->citizenDetail->rt }} / {{ $user->citizenDetail->rw }}</td>
                                </tr>
                                <tr>
                                    <th>Kelurahan</th>
                                    <td>: {{ $user->citizenDetail->village }}</td>
                                </tr>
                                <tr>
                                    <th>Kecamatan</th>
                                    <td>: {{ $user->citizenDetail->district }}</td>
                                </tr>
                                <tr>
                                    <th>Kota</th>
                                    <td>: {{ $user->citizenDetail->city }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                        <div class="card-body p-0">
                            <div class="d-flex flex-column flex-md-row">
                                <div class="bg-primary text-white p-4 d-flex align-items-center justify-content-center"
                                    style="min-width: 100px;">
                                    <i class="fas fa-university fa-3x"></i>
                                </div>
                                <div class="p-4">
                                    <h6 class="fw-bold text-dark mb-2">Informasi Pembaruan Data Kependudukan</h6>
                                    <p class="text-muted small mb-2" style="line-height: 1.6;">
                                        Data yang Anda lihat di atas <strong>tidak</strong> disinkronkan dengan basis
                                        data
                                        kependudukan nasional.
                                        Perlu diketahui bahwa sistem di tingkat Kelurahan hanya bersifat
                                        <strong>pemanfaat data</strong>.
                                        Apabila terdapat ketidaksesuaian informasi atau Anda ingin melakukan perubahan
                                        (seperti status pernikahan, gelar, atau alamat), kami mohon kesediaannya
                                        untuk melakukan pembaruan secara resmi melalui:
                                    </p>
                                    <div class="d-flex flex-wrap gap-2 mb-3">
                                        <span
                                            class="badge bg-light text-primary border border-primary-subtle px-3 py-2 rounded-pill">
                                            <i class="fas fa-building me-1"></i> Kantor Disdukcapil Kota Tangerang
                                            Selatan
                                        </span>
                                        <span
                                            class="badge bg-light text-primary border border-primary-subtle px-3 py-2 rounded-pill">
                                            <i class="fas fa-mobile-alt me-1"></i> Aplikasi/Layanan Online Dukcapil
                                        </span>
                                    </div>
                                    <p class="text-muted small mb-0 italic" style="font-style: italic;">
                                        <i class="fas fa-lightbulb text-warning me-1"></i>
                                        <strong>Perhatian:</strong> Jika sudah melakukan perubahan di Dukcapil, hubungi
                                        operator Kelurahan Kademangan untuk perubahan data. <br>Data yang valid akan
                                        mempermudah akses Anda terhadap berbagai layanan
                                        publik pemerintah lainnya, seperti BPJS, Bantuan Sosial, hingga urusan
                                        perbankan.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<x-footer />
