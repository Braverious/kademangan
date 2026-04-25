<a href="{{ route('admin.penghasilan.edit', $surat->id) }}" class="btn btn-warning">
    Edit
</a>

@if ($bisaCetak)
    <form action="{{ route('admin.penghasilan.cetak', $surat->id) }}" method="GET" target="_blank">
        <select name="ttd" required>
            @foreach ($signers as $s)
                <option value="{{ $s->id }}" {{ $defaultSignerId == $s->id ? 'selected' : '' }}>
                    {{ $s->jabatan_nama }} - {{ $s->nama }}
                </option>
            @endforeach
        </select>

        <button class="btn btn-success">Cetak PDF</button>
    </form>
@endif
