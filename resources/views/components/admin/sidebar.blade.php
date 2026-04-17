<div class="sidebar sidebar-style-2">
    <div class="sidebar-wrapper scrollbar scrollbar-inner">
        <div class="sidebar-content">

            @php
                //==== Segments untuk active menu di Laravel =====//
                $seg2 = request()->segment(2); // menangkap 'dashboard' dari 'admin/dashboard'
                $seg3 = request()->segment(3);
            @endphp

            <div class="user">
                <div class="avatar-sm float-left mr-2">
                    <img src="{{ asset('uploads/profil/' . (Auth::user()->foto ?? 'default.jpg')) }}" alt="Profile"
                        class="avatar-img rounded-circle">
                </div>
                <div class="info">
                    <a data-toggle="collapse" href="#collapseExample" aria-expanded="true">
                        <span>
                            {{-- STATIS: Nama dan Level Sidebar --}}
                            Administrator
                            <span class="user-level">Superadmin</span>
                        </span>
                    </a>
                    <div class="clearfix"></div>
                </div>
            </div>

            <ul class="nav nav-primary">

                <li class="nav-item {{ $seg2 === 'dashboard' ? 'active' : '' }}">
                    <a href="{{ route('admin.dashboard') }}">
                        <i class="fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <li class="nav-section">
                    <span class="sidebar-mini-icon"><i class="fas fa-ellipsis-h"></i></span>
                    <h4 class="text-section">LAYANAN</h4>
                </li>

                @php
                    // Daftar layanan surat
                    $services = [
                        [
                            'slug' => 'surat_sktm',
                            'url' => 'admin/surat_sktm',
                            'label' => 'Surat Keterangan Tidak Mampu (SKTM)',
                        ],
                        [
                            'slug' => 'surat_belum_bekerja',
                            'url' => 'admin/surat_belum_bekerja',
                            'label' => 'Surat Keterangan Belum Bekerja',
                        ],
                        [
                            'slug' => 'surat_penghasilan',
                            'url' => 'admin/surat_penghasilan',
                            'label' => 'Surat Keterangan Penghasilan',
                        ],
                        [
                            'slug' => 'surat_domisili_yayasan',
                            'url' => 'admin/surat_domisili_yayasan',
                            'label' => 'Surat Keterangan Domisili Yayasan',
                        ],
                        [
                            'slug' => 'surat_belum_memiliki_rumah',
                            'url' => 'admin/surat_belum_memiliki_rumah',
                            'label' => 'Surat Keterangan Belum Punya Rumah',
                        ],
                        [
                            'slug' => 'surat_kematian',
                            'url' => 'admin/surat_kematian',
                            'label' => 'Surat Keterangan Kematian (Dukcapil)',
                        ],
                        [
                            'slug' => 'surat_kematian_nondukcapil',
                            'url' => 'admin/surat_kematian_nondukcapil',
                            'label' => 'Surat Keterangan Kematian (Non-Dukcapil)',
                        ],
                        [
                            'slug' => 'surat_suami_istri',
                            'url' => 'admin/surat_suami_istri',
                            'label' => 'Surat Keterangan Suami Istri',
                        ],
                        [
                            'slug' => 'surat_pengantar_nikah',
                            'url' => 'admin/surat_pengantar_nikah',
                            'label' => 'Surat Pengantar Nikah',
                        ],
                    ];
                    $isServiceMenuActive = in_array($seg2, array_column($services, 'slug'), true);
                @endphp

                <li class="nav-item {{ $isServiceMenuActive ? 'active sub-menu' : '' }}">
                    <a data-toggle="collapse" href="#menuLayanan" class="collapsed"
                        aria-expanded="{{ $isServiceMenuActive ? 'true' : 'false' }}">
                        <i class="fas fa-briefcase"></i>
                        <p>Pelayanan</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse {{ $isServiceMenuActive ? 'show' : '' }}" id="menuLayanan">
                        <ul class="nav nav-collapse">
                            @foreach ($services as $svc)
                                <li class="{{ $seg2 === $svc['slug'] ? 'active' : '' }}">
                                    <a href="{{ url($svc['url']) }}">
                                        <span class="sub-item">{{ $svc['label'] }}</span>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </li>

                @php
                    $kontenItems = [
                        [
                            'slug' => 'berita',
                            'url' => 'admin/berita',
                            'icon' => 'fas fa-newspaper',
                            'label' => 'Berita',
                        ],
                        ['slug' => 'galeri', 'url' => 'admin/galeri', 'icon' => 'far fa-images', 'label' => 'Galeri'],
                        [
                            'slug' => 'pengumuman',
                            'url' => 'admin/pengumuman',
                            'icon' => 'fas fa-bullhorn',
                            'label' => 'Pengumuman',
                        ],
                    ];
                    $kontenSlugs = array_column($kontenItems, 'slug');
                    $isKontenActive = in_array($seg2, $kontenSlugs, true);
                @endphp

                <li class="nav-section">
                    <span class="sidebar-mini-icon"><i class="fas fa-ellipsis-h"></i></span>
                    <h4 class="text-section">KONTEN</h4>
                </li>

                @foreach ($kontenItems as $it)
                    <li class="nav-item {{ $seg2 === $it['slug'] ? 'active' : '' }}">
                        <a href="{{ url($it['url']) }}">
                            <i class="{{ $it['icon'] }}"></i>
                            <p>{{ $it['label'] }}</p>
                        </a>
                    </li>
                @endforeach

                {{-- STATIS: Logic if id_level == 1 (Superadmin) dibypass jadi true dulu --}}
                @if (true)
                    <li class="nav-section">
                        <span class="sidebar-mini-icon"><i class="fas fa-ellipsis-h"></i></span>
                        <h4 class="text-section">ADMINISTRATOR</h4>
                    </li>

                    @php
                        $settingsItems = [
                            ['slug' => 'pejabat', 'url' => 'admin/pejabat', 'label' => 'Pejabat'],
                            ['slug' => 'layanan', 'url' => 'admin/layanan', 'label' => 'Layanan'],
                            ['slug' => 'uploadvideo', 'url' => 'admin/uploadvideo', 'label' => 'Pengaturan Video'],
                            ['slug' => 'coverage', 'url' => 'admin/coverage', 'label' => 'Jangkauan Layanan'],
                            ['slug' => 'runningtext', 'url' => 'admin/runningtext', 'label' => 'Running Text'],
                            ['slug' => 'users', 'url' => 'admin/users', 'label' => 'Manajemen User'],
                            [
                                'slug' => 'settings',
                                'route' => 'admin.settings.footer', // Menggunakan nama route
                                'label' => 'Footer',
                                'seg3' => 'footer',
                            ],
                        ];

                        $isSettingsMenuActive = false;
                        foreach ($settingsItems as $it) {
                            $matchPlain = $seg2 === $it['slug'] && empty($it['seg3']);
                            $matchSeg3 = !empty($it['seg3']) && $seg2 === $it['slug'] && $seg3 === $it['seg3'];
                            if ($matchPlain || $matchSeg3) {
                                $isSettingsMenuActive = true;
                                break;
                            }
                        }
                    @endphp

                    <li class="nav-item {{ $isSettingsMenuActive ? 'active sub-menu' : '' }}">
                        <a data-toggle="collapse" href="#menuPengaturan" class="collapsed"
                            aria-expanded="{{ $isSettingsMenuActive ? 'true' : 'false' }}">
                            <i class="fas fa-cog"></i>
                            <p>Pengaturan</p>
                            <span class="caret"></span>
                        </a>
                        <div class="collapse {{ $isSettingsMenuActive ? 'show' : '' }}" id="menuPengaturan">
                            <ul class="nav nav-collapse">
                                @foreach ($settingsItems as $it)
                                    @php
                                        $active =
                                            ($seg2 === $it['slug'] && empty($it['seg3'])) ||
                                            (!empty($it['seg3']) && $seg2 === $it['slug'] && $seg3 === $it['seg3']);
                                    @endphp
                                    <li class="{{ $active ? 'active' : '' }}">
                                        @php
                                            // Logika cerdas: Jika ada 'route', pakai route(). Jika ada 'url', pakai url().
                                            $linkTarget = isset($it['route'])
                                                ? route($it['route'])
                                                : url($it['url'] ?? '#');
                                        @endphp

                                        <a href="{{ $linkTarget }}">
                                            <span class="sub-item">{{ $it['label'] }}</span>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </li>
                @endif

            </ul>
        </div>
    </div>
</div>

<div class="main-panel">
    <div class="content">
