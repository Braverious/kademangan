<x-admin.header :title="$title" />
<x-admin.sidebar />
<div class="page-inner">
    <x-admin.breadcrumbs :title="$title" :breadcrumbs="$breadcrumbs" />
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title"><i class="fa fa-history mr-2"></i> Audit Trail & Riwayat Login</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.settings.login_logs') }}" method="GET" class="mb-4">
                        <div class="row align-items-end">
                            <div class="col-md-3">
                                <div class="form-group p-0">
                                    <label class="small fw-bold">Tanggal</label>
                                    <input type="date" name="date" class="form-control" value="{{ request('date') }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group p-0">
                                    <label class="small fw-bold">Perangkat</label>
                                    <select name="device" class="form-control">
                                        <option value="">Semua Perangkat</option>
                                        <option value="Laptop/PC" {{ request('device') == 'Laptop/PC' ? 'selected' : '' }}>Laptop/PC</option>
                                        <option value="Smartphone" {{ request('device') == 'Smartphone' ? 'selected' : '' }}>Smartphone</option>
                                        <option value="Tablet" {{ request('device') == 'Tablet' ? 'selected' : '' }}>Tablet</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group p-0">
                                    <label class="small fw-bold">Pencarian NIK/Username</label>
                                    <input type="text" name="q" class="form-control" placeholder="Ketik NIK..." value="{{ request('q') }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group p-0 d-flex gap-2">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> Filter</button>
                                    <a href="{{ route('admin.settings.login_logs') }}" class="btn btn-secondary border"><i class="fa fa-sync"></i></a>
                                    
                                    <button type="submit" name="export" value="csv" class="btn btn-success ml-auto" title="Export CSV"><i class="fa fa-file-csv"></i></button>
                                    <button type="submit" name="export" value="pdf" class="btn btn-danger" title="Export PDF"><i class="fa fa-file-pdf"></i></button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <hr>

                    <div class="table-responsive">
                        <table class="table table-striped table-hover w-100">
                            <thead>
                                <tr>
                                    <th>Waktu</th>
                                    <th>User / NIK</th>
                                    <th>Status</th>
                                    <th>IP & Lokasi</th>
                                    <th>Perangkat & Browser</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($logs as $log)
                                    <tr>
                                        <td>
                                            <strong>{{ $log->created_at->format('d M Y') }}</strong><br>
                                            <small class="text-muted">{{ $log->created_at->format('H:i:s') }} WIB</small>
                                        </td>
                                        <td>
                                            @if($log->user)
                                                <strong>{{ $log->user->citizenDetail->full_name ?? ($log->user->staffDetail->full_name ?? 'Admin') }}</strong><br>
                                            @else
                                                <strong class="text-danger">Tidak Ditemukan</strong><br>
                                            @endif
                                            <span class="badge badge-light border">{{ $log->username }}</span>
                                        </td>
                                        <td>
                                            @if($log->status == 'SUCCESS')
                                                <span class="badge badge-success"><i class="fa fa-check"></i> Sukses</span>
                                            @else
                                                <span class="badge badge-danger"><i class="fa fa-times"></i> Gagal</span>
                                            @endif
                                        </td>
                                        <td>
                                            <strong>{{ $log->ip_address }}</strong><br>
                                            <small class="text-muted"><i class="fa fa-map-marker-alt"></i> {{ $log->location ?? 'Unknown' }}</small>
                                        </td>
                                        <td>
                                            <i class="fa {{ $log->device == 'Smartphone' ? 'fa-mobile-alt' : 'fa-laptop' }} mr-1"></i> {{ $log->device }}<br>
                                            <small class="text-primary"><i class="fab fa-chrome mr-1"></i> {{ $log->browser }}</small>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">Belum ada riwayat login.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-3">
                        {{ $logs->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<x-admin.footer />