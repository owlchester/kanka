<ol class="breadcrumb block m-0 mb-2 p-0 text-xs">
    @if (!isset($breadcrumbsDashboard) || $breadcrumbsDashboard === true)
        @if ($campaign)
            <li>
                <a href="{{ route('dashboard') }}">
                    <i class="fa-solid fa-globe" aria-hidden="true"></i>
                    <span class="hidden-xs hidden-sm">
                        {!! $campaign->name !!}
                    </span>
                </a>
            </li>
        @else
            <li>
                <a href="{{ route('home') }}">
                    <i class="fa-solid fa-dashboard" aria-hidden="true"></i>
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
                            {!! \Illuminate\Support\Str::limit(e($breadcrumb['label']), 20) !!}
                        @else
                            {!! e($breadcrumb['label']) !!}
                        @endif
                    </a>
                @else
                    @if (strlen($breadcrumb) > 22)
                        <span title="{{ $breadcrumb }}">{!! \Illuminate\Support\Str::limit(e($breadcrumb), 20) !!}</span>
                    @else
                        {!! e($breadcrumb) !!}
                    @endif
                @endif
            </li>
        @endforeach
    @endif
</ol>
