<x-admin.header :title="$title" />
<x-admin.sidebar />

<div class="page-inner">
    <x-admin.breadcrumbs :title="$title" :breadcrumbs="$breadcrumbs" />
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center flex-wrap gap-2">
                        <h4 class="card-title">Daftar Berita</h4>
                        <div class="ml-auto d-flex">
                            <button type="button" id="btnBulkDelete" class="btn btn-danger btn-round mr-2 d-none">
                                <i class="fa fa-trash mr-1"></i> Hapus Terpilih
                            </button>
                            <a href="{{ route('admin.berita.create') }}" class="btn btn-primary btn-round">
                                <i class="fa fa-plus mr-1"></i> Tambah Berita
                            </a>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    {{-- Alert Handling --}}
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    {{-- Form Pencarian & Filter --}}
                    <form action="{{ route('admin.berita.index') }}" method="GET" class="row mb-4" id="filterForm">
                        <div class="col-md-8 mb-2">
                            <label class="small font-weight-bold">Pencarian Cepat</label>
                            <div class="input-group">
                                {{-- Tambahkan id="jsSearchInput" --}}
                                <input type="text" id="jsSearchInput" class="form-control"
                                    placeholder="Cari judul, penulis, atau slug...">
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="fa fa-search"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-2">
                            <label class="small font-weight-bold">Filter Kategori</label>
                            {{-- Tambahkan id="jsKategoriFilter" --}}
                            <select id="jsKategoriFilter" class="form-control">
                                <option value="">-- Semua Kategori --</option>
                                @foreach (['Kegiatan', 'Pengumuman', 'Layanan', 'Umum'] as $opt)
                                    <option value="{{ $opt }}">{{ $opt }}</option>
                                @endforeach
                            </select>
                        </div>
                    </form>

                    <div class="table-responsive">
                        <form id="formBulkDelete" action="{{ route('admin.berita.bulkDestroy') }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <table class="table table-striped table-hover w-100">
                                <thead>
                                    <tr>
                                        <th style="width: 40px">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="checkAll">
                                                <label class="custom-control-label" for="checkAll"></label>
                                            </div>
                                        </th>
                                        <th>Gambar</th>
                                        <th>Judul Berita</th>
                                        <th>Kategori</th>
                                        <th>Penulis</th>
                                        <th>Publish</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($berita_list as $item)
                                        <tr class="clickable-row"
                                            data-href="{{ route('admin.berita.edit', $item->id_berita) }}"
                                            style="cursor: pointer;">
                                            <td class="noclick">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" name="ids[]" value="{{ $item->id_berita }}"
                                                        class="custom-control-input checkbox-item"
                                                        id="check-{{ $item->id_berita }}">
                                                    <label class="custom-control-label"
                                                        for="check-{{ $item->id_berita }}"></label>
                                                </div>
                                            </td>
                                            <td>
                                                <img src="{{ asset('storage/' . $item->gambar) }}" width="80"
                                                    class="rounded shadow-sm">
                                            </td>
                                            <td>
                                                <div class="font-weight-bold">{{ $item->judul_berita }}</div>
                                                <small class="text-muted">{{ $item->slug_berita }}</small>
                                            </td>
                                            <td><span class="badge badge-info">{{ $item->kategori }}</span></td>
                                            <td>{{ $item->user->nama_lengkap ?? '-' }}</td>
                                            <td>{{ $item->tgl_publish ? $item->tgl_publish->format('d/m/Y') : '-' }}
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center py-4 text-muted">Data tidak ditemukan.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<x-admin.footer />
<script>
    $(document).ready(function() {

        // --- 1. LOGIKA FILTERING JAVASCRIPT ---
        function filterTable() {
            const searchText = $('#jsSearchInput').val().toLowerCase();
            const category = $('#jsKategoriFilter').val();

            $('#formBulkDelete tbody tr').each(function() {
                const row = $(this);
                const title = row.find('td:nth-child(3)').text().toLowerCase();
                const rowCategory = row.find('td:nth-child(4)').text().trim();
                const author = row.find('td:nth-child(5)').text().toLowerCase();

                const matchSearch = title.includes(searchText) || author.includes(searchText);
                const matchCategory = (category === "") || (rowCategory === category);

                if (matchSearch && matchCategory) {
                    row.show();
                } else {
                    row.hide();
                }
            });

            // Reset status checkbox saat filter berubah agar tidak ada data "gaib" yang terhapus
            $('#checkAll').prop('checked', false);
            $('.checkbox-item').prop('checked', false);
            updateBulkDeleteButton();
        }

        $('#jsSearchInput').on('keyup', filterTable);
        $('#jsKategoriFilter').on('change', filterTable);


        // --- 2. LOGIKA INTERAKSI TABEL ---

        // Klik Baris (Edit) - td:not(.noclick) agar checkbox tidak memicu redirect
        $('.clickable-row td:not(.noclick)').on('click', function() {
            window.location = $(this).closest('tr').data('href');
        });

        // Check All - Menggunakan filter tr yang tidak hidden (display != none)
        $('#checkAll').on('click', function() {
            // Kita cari TR yang sedang tampil, lalu cari checkbox di dalamnya
            var targetCheckboxes = $('#formBulkDelete tbody tr').filter(function() {
                return $(this).css('display') !== 'none';
            }).find('.checkbox-item');

            targetCheckboxes.prop('checked', this.checked);
            updateBulkDeleteButton();
        });

        // Update Button Bulk Delete (Hitung jumlah yang diceklis)
        function updateBulkDeleteButton() {
            const checkedCount = $('.checkbox-item:checked').length;
            if (checkedCount > 0) {
                $('#btnBulkDelete').removeClass('d-none').html(
                    `<i class="fa fa-trash mr-1"></i> Hapus (${checkedCount})`);
            } else {
                $('#btnBulkDelete').addClass('d-none');
            }
        }

        // Pantau setiap perubahan pada checkbox item
        $(document).on('change', '.checkbox-item', function() {
            updateBulkDeleteButton();
        });


        // --- 3. LOGIKA SWEETALERT UNTUK HAPUS MASSAL ---
        $('#btnBulkDelete').on('click', function() {
            const total = $('.checkbox-item:checked').length;

            swal({
                title: "Hapus Masal?",
                text: "Anda akan menghapus " + total +
                    " berita sekaligus, data tidak bisa dikembalikan!",
                icon: "warning",
                buttons: {
                    cancel: {
                        text: 'Batal',
                        visible: true,
                        className: 'btn btn-warning'
                    },
                    confirm: {
                        text: 'Ya, Hapus',
                        visible: true,
                        className: 'btn btn-danger'
                    }
                },
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {
                    // Beri feedback loading pada tombol
                    $(this).html('<i class="fa fa-spinner fa-spin"></i> Menghapus...');
                    $(this).prop('disabled', true);

                    // Submit form bulk delete
                    $('#formBulkDelete').submit();
                }
            });
        });
    });
</script>
