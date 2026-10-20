{{-- Usage: @include('admin.partials.page-header', ['title' => 'Orders', 'subtitle' => '…',
     'crumbs' => ['Content' => null, 'Pages' => route(...)], 'actions' => '<a …>…</a>']) --}}
<div class="adm-page-header">
    <div>
        @if(!empty($crumbs))
            <nav class="adm-breadcrumb" aria-label="Breadcrumb">
                <a href="{{ route('admin.home') }}">Dashboard</a>
                @foreach($crumbs as $label => $url)
                    <span aria-hidden="true">/</span>
                    @if($url)<a href="{{ $url }}">{{ $label }}</a>@else<span>{{ $label }}</span>@endif
                @endforeach
            </nav>
        @endif
        <h1>{{ $title }}</h1>
        @if(!empty($subtitle))<div class="adm-subtitle">{!! $subtitle !!}</div>@endif
    </div>
    @if(!empty($actions))
        <div class="adm-actions">{!! $actions !!}</div>
    @endif
</div>
