<x-admin.header :title="$title" />
<x-admin.sidebar />

<div class="page-inner">
    <div class="row">
        <div class="col-md-12">

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
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
                    <div class="d-flex align-items-center">
                        <h4 class="card-title">Running Text</h4>
                        <button form="form-runningtext" class="btn btn-primary btn-round ml-auto">
                            <i class="fa fa-save mr-2"></i> Simpan
                        </button>
                    </div>
                </div>

                <form action="{{ route('admin.settings.runningtext.update') }}" method="POST" id="form-runningtext">
                    @csrf
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead class="thead-light">
                                    <tr>
                                        <th style="width:120px">Posisi</th>
                                        <th style="width:140px">Arah</th>
                                        <th style="width:130px">Speed</th>
                                        <th>Teks</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- BARIS TOP --}}
                                    <tr>
                                        <td><span class="badge badge-info px-3 py-2" style="text-transform:lowercase">top</span></td>
                                        <td>
                                            <select class="form-control" name="top_direction" required>
                                                <option value="left" {{ old('top_direction', $top->direction) == 'left' ? 'selected' : '' }}>left</option>
                                                <option value="right" {{ old('top_direction', $top->direction) == 'right' ? 'selected' : '' }}>right</option>
                                            </select>
                                        </td>
                                        <td>
                                            <input type="number" min="1" max="10" class="form-control" name="top_speed" value="{{ old('top_speed', $top->speed) }}" required>
                                        </td>
                                        <td>
                                            <textarea class="form-control" name="top_content" rows="2" maxlength="255" required>{{ old('top_content', $top->content) }}</textarea>
                                            <small class="text-muted d-block mt-1">
                                                Preview:
                                                <marquee behavior="scroll" direction="{{ $top->direction }}" scrollamount="{{ $top->speed }}">
                                                    {{ $top->content }}
                                                </marquee>
                                            </small>
                                        </td>
                                    </tr>

                                    {{-- BARIS BOTTOM --}}
                                    <tr>
                                        <td><span class="badge badge-info px-3 py-2" style="text-transform:lowercase">bottom</span></td>
                                        <td>
                                            <select class="form-control" name="bottom_direction" required>
                                                <option value="left" {{ old('bottom_direction', $bottom->direction) == 'left' ? 'selected' : '' }}>left</option>
                                                <option value="right" {{ old('bottom_direction', $bottom->direction) == 'right' ? 'selected' : '' }}>right</option>
                                            </select>
                                        </td>
                                        <td>
                                            <input type="number" min="1" max="10" class="form-control" name="bottom_speed" value="{{ old('bottom_speed', $bottom->speed) }}" required>
                                        </td>
                                        <td>
                                            <textarea class="form-control" name="bottom_content" rows="2" maxlength="255" required>{{ old('bottom_content', $bottom->content) }}</textarea>
                                            <small class="text-muted d-block mt-1">
                                                Preview:
                                                <marquee behavior="scroll" direction="{{ $bottom->direction }}" scrollamount="{{ $bottom->speed }}">
                                                    {{ $bottom->content }}
                                                </marquee>
                                            </small>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Update live preview saat ngetik (opsional agar interaktif)
        const updatePreview = (pos) => {
            document.querySelector(`textarea[name="${pos}_content"]`).addEventListener('input', function(e) {
                document.querySelector(`marquee[direction="${document.querySelector(`select[name="${pos}_direction"]`).value}"]`).innerText = e.target.value;
            });
        };
        updatePreview('top');
        updatePreview('bottom');
    });
</script>
<x-admin.footer />