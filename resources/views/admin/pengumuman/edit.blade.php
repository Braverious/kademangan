<x-admin.header :title="$title" />
<x-admin.sidebar />

<div class="page-inner">
    <div class="page-header">
        <h4 class="page-title">{{ $title }}</h4>
        <ul class="breadcrumbs">
            <li class="nav-home">
                <a href="#"><i class="flaticon-home"></i></a>
            </li>
            <li class="separator"><i class="flaticon-right-arrow"></i></li>
            <li class="nav-item">
                <a href="{{ route('admin.pengumuman.index') }}">Pengumuman</a>
            </li>
            <li class="separator"><i class="flaticon-right-arrow"></i></li>
            <li class="nav-item">
                <a href="#">Edit</a>
            </li>
        </ul>
    </div>

    <div class="row">
        <div class="col-md-12">

            {{-- FLASH ERROR --}}
            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            {{-- VALIDATION ERROR --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Form Edit Pengumuman</h4>
                </div>

                <div class="card-body">

                    <form action="{{ route('admin.pengumuman.update', $row->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        {{-- JUDUL --}}
                        <div class="form-group">
                            <label>Judul</label>
                            <input type="text"
                                name="judul"
                                class="form-control"
                                value="{{ old('judul', $row->judul) }}"
                                required>
                        </div>

                        {{-- ISI --}}
                        <div class="form-group">
                            <label>Isi</label>
                            <textarea name="isi"
                                    class="form-control"
                                    rows="6"
                                    required>{{ old('isi', $row->isi) }}</textarea>
                        </div>

                        <div class="form-row">

                            {{-- TIPE --}}
                            <div class="form-group col-md-4">
                                <label>Tipe</label>
                                <select name="tipe" class="form-control">
                                    @foreach (['info','peringatan','penting'] as $t)
                                        <option value="{{ $t }}"
                                            {{ old('tipe', $row->tipe) == $t ? 'selected' : '' }}>
                                            {{ ucfirst($t) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- STATUS --}}
                            <div class="form-group col-md-4">
                                <label>Status</label>
                                <select name="status" class="form-control">
                                    <option value="publish" {{ old('status', $row->status) == 'publish' ? 'selected' : '' }}>
                                        Publish
                                    </option>
                                    <option value="draft" {{ old('status', $row->status) == 'draft' ? 'selected' : '' }}>
                                        Draft
                                    </option>
                                </select>
                            </div>

                        </div>

                        <div class="form-row">

                            {{-- MULAI --}}
                            <div class="form-group col-md-6">
                                <label>Mulai Tayang</label>
                                <input type="datetime-local"
                                    name="mulai_tayang"
                                    class="form-control"
                                    value="{{ old('mulai_tayang', $row->mulai_tayang ? \Carbon\Carbon::parse($row->mulai_tayang)->format('Y-m-d\TH:i') : '') }}">
                            </div>

                            {{-- BERAKHIR --}}
                            <div class="form-group col-md-6">
                                <label>Berakhir Tayang (kosongkan = +24 jam)</label>
                                <input type="datetime-local"
                                    name="berakhir_tayang"
                                    class="form-control"
                                    value="{{ old('berakhir_tayang', $row->berakhir_tayang ? \Carbon\Carbon::parse($row->berakhir_tayang)->format('Y-m-d\TH:i') : '') }}">
                            </div>

                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                Simpan Perubahan
                            </button>

                            <a href="{{ route('admin.pengumuman.index') }}"
                            class="btn btn-secondary">
                                Batal
                            </a>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>
</div>

<x-admin.footer />