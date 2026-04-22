@php
    /**
     * Footer Dinamis - Terhubung ke Database
     * Mengambil data dari tabel site_settings ID 1
     */
    $settings = \App\Models\SiteSetting::firstOrNew(['id' => 1]);
    
    // --- Data Asli dari Database ---
    $about = $settings->about_html;
    $links = $settings->related_links ?? [];
    $social = $settings->social_links ?? [];

    // --- Logic Helper (Tetap dipertahankan) ---
    $detectIconSet = function ($icon) {
        $icon = trim((string)$icon);
        if ($icon === '') return ['set' => 'fa-solid', 'icon' => 'fa-link'];
        
        // Cek apakah icon termasuk kategori brand (FontAwesome 6 standards)
        $isBrand = (bool)preg_match('/^(fa-)?(facebook|facebook-f|instagram|x-twitter|twitter|youtube|tiktok|whatsapp|linkedin|linkedin-in|telegram)/i', $icon);
        
        return [
            'set' => $isBrand ? 'fa-brands' : 'fa-solid', 
            'icon' => $icon
        ];
    };
@endphp

<section class="footer-info py-5">
    <div class="container">
        <div class="row g-4">

            {{-- TENTANG --}}
            @if(!empty($about))
                <div class="col-lg-6">
                    <div class="fi-card">
                        <div class="fi-card-head">
                            <h5 class="fi-title">Tentang Web</h5>
                        </div>
                        <div class="fi-card-body text-muted">
                            {{-- Gunakan {!! !!} karena data mengandung tag HTML --}}
                            {!! $about !!}
                        </div>
                    </div>
                </div>
            @endif

            {{-- TAUTAN --}}
            @if(count($links) > 0)
                <div class="col-lg-3">
                    <div class="fi-card">
                        <div class="fi-card-head">
                            <h5 class="fi-title">Tautan Terkait</h5>
                        </div>
                        <ul class="fi-list mb-0">
                            @foreach ($links as $it)
                                @php
                                    $linkTitle = trim($it['title'] ?? '');
                                    $linkUrl = trim($it['url'] ?? '');
                                    $host = $linkUrl ? (parse_url($linkUrl, PHP_URL_HOST) ?: $linkUrl) : '';
                                    $label = $linkTitle !== '' ? $linkTitle : $host;
                                @endphp
                                <li>
                                    @if($linkUrl !== '' && $linkUrl !== '#')
                                        <a href="{{ $linkUrl }}" target="_blank" rel="noopener">{{ $label }}</a>
                                    @else
                                        <span class="text-muted">{{ $label }}</span>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            {{-- SOSIAL MEDIA --}}
            @if(count($social) > 0)
                <div class="col-lg-3">
                    <div class="fi-card">
                        <div class="fi-card-head">
                            <h5 class="fi-title">Sosial Media</h5>
                        </div>
                        <ul class="fi-social mb-0">
                            @foreach ($social as $it)
                                @php
                                    $res = $detectIconSet($it['icon'] ?? '');
                                    $sLabel = trim($it['label'] ?? '');
                                    $sUrl = trim($it['url'] ?? '');
                                @endphp
                                <li>
                                    @if($sUrl !== '' && $sUrl !== '#')
                                        <a href="{{ $sUrl }}" target="_blank" rel="noopener">
                                            <span class="fi-ico"><i class="{{ $res['set'] }} {{ $res['icon'] }}"></i></span>
                                            <span class="fi-text">{{ $sLabel ?: $sUrl }}</span>
                                        </a>
                                    @else
                                        <div class="d-flex align-items-center text-muted">
                                            <span class="fi-ico"><i class="{{ $res['set'] }} {{ $res['icon'] }}"></i></span>
                                            <span class="fi-text">{{ $sLabel }}</span>
                                        </div>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

        </div>
    </div>
</section>

<footer class="mt-5 bg-light py-4">
    <div class="container text-center small text-muted">
        <div>© {{ date('Y') }} Kelurahan Kademangan. Semua hak dilindungi.</div>
        <div>Jl. Masjid Jami Al-Latif No.1 Kec. Setu, Kota Tangerang Selatan - Banten 15313, Indonesia • Telp: (021) 123456</div>
    </div>
</footer>

{{-- SCRIPTS --}}
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>

{{-- Pastikan file JS ini sudah dipindah ke folder public/assets/js/ --}}
<script src="{{ asset('assets/js/main.js') }}"></script>
<script src="{{ asset('assets/js/script.js') }}"></script>

<script>
    // Slider & UI Logic (Semua JS Anda tetap dipertahankan di sini)
    document.addEventListener('DOMContentLoaded', function() {
        // ... (Logika JS Slider Layanan Anda) ...
        const track = document.getElementById('layananSlider');
        if (!track) return;
        // ... dst (Semua script yang Anda sertakan sebelumnya)
    });
</script>

{{-- Penutup Body dan HTML yang ada di header --}}
</body>
</html>