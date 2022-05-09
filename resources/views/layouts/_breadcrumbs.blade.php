<ol class="breadcrumb">
    @if (!isset($breadcrumbsDashboard) || $breadcrumbsDashboard === true)
        @if ($campaign)
            <li>
                <a href="{{ route('dashboard') }}">
                    <i class="fa-solid fa-globe"></i>
                    <span class="hidden-xs hidden-sm">
                        {!! $campaign->name !!}
                    </span>
                </a>
            </li>
        @else
            <li>
                <a href="{{ route('home') }}">
                    <i class="fa-solid fa-dashboard"></i>
                    <span class="hidden-xs hidden-sm">
                        {{ __('dashboard.title') }}
                    </span>
                </a>
            </li>
        @endif
    @endif
    @if (isset($breadcrumbs))
        @foreach ($breadcrumbs as $breadcrumb)
            <li>
                @if (!empty($breadcrumb['url']))
                    <a href="{{ $breadcrumb['url'] }}" title="{{ $breadcrumb['label'] }}">
                        @if (strlen($breadcrumb['label']) > 22)
                            {!! substr($breadcrumb['label'], 0, 20) . '...' !!}
                        @else
                            {!! $breadcrumb['label'] !!}
                        @endif
                    </a>
                @else
                    @if (strlen($breadcrumb) > 22)
                        <span title="{{ $breadcrumb }}">{!! substr($breadcrumb, 0, 20) . '...' !!}</span>
                    @else
                        {!! $breadcrumb !!}
                    @endif
                @endif
            </li>
        @endforeach
    @endif
</ol>
