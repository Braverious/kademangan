@props(['title', 'breadcrumbs' => []])

<div class="page-header">
    <h4 class="page-title">{{ $title }}</h4>
    <ul class="breadcrumbs">
        <li class="nav-home">
            {{-- Arahkan ke dashboard utama admin --}}
            <a href="{{ route('admin.dashboard') }}">
                <i class="flaticon-home"></i>
            </a>
        </li>
        
        @foreach ($breadcrumbs as $item)
            <li class="separator">
                <i class="flaticon-right-arrow"></i>
            </li>
            <li class="nav-item">
                @if (!empty($item['url']))
                    <a href="{{ $item['url'] }}">{{ $item['label'] }}</a>
                @else
                    <a href="javascript:void(0)">{{ $item['label'] }}</a>
                @endif
            </li>
        @endforeach
    </ul>
</div>