<x-admin.header :title="$title" />
<x-admin.sidebar />

<div class="page-inner">
    <x-admin.breadcrumbs :title="$title" :breadcrumbs="$breadcrumbs" />
    <div class="row">
        <div class="col-md-12">
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Form Edit Berita</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.berita.update', $berita->id_berita) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label>Judul Berita</label>
                            <input type="text" name="judul_berita" class="form-control"
                                value="{{ old('judul_berita', $berita->judul_berita) }}" required>
                        </div>

                        <div class="form-group">
                            <label>Kategori</label>
                            <select name="kategori" class="form-control" required>
                                @foreach ($kategoriOptions as $kategori)
                                    <option value="{{ $kategori }}"
                                        {{ old('kategori', $berita->kategori) === $kategori ? 'selected' : '' }}>
                                        {{ $kategori }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Gambar Saat Ini</label><br>
                            @if ($berita->gambar)
                                <img src="{{ asset('storage/' . $berita->gambar) }}" alt="{{ $berita->judul_berita }}"
                                    style="max-width:220px;border:1px solid #eee;border-radius:6px;">
                            @else
                                <em>Belum ada gambar</em>
                            @endif
                        </div>

                        <div class="form-group">
                            <label>Ganti Gambar Sampul (opsional)</label>
                            <input type="file" name="gambar" class="form-control"
                                accept=".jpg,.jpeg,.png,.gif,.webp">
                            <small class="text-muted">Kosongkan jika tidak ingin mengganti.</small>
                        </div>

                        <div class="form-group">
                            <label>Isi Berita</label>
                            <textarea name="isi_berita" id="isi_berita" class="form-control" rows="10"
                                data-upload-url="{{ route('admin.berita.upload-gambar') }}">{{ old('isi_berita', $berita->isi_berita) }}</textarea>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                            <a href="{{ route('admin.berita.index') }}" class="btn btn-secondary">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<x-admin.footer />
