<ol class="breadcrumb text-xs list-none flex items-center ">
    @if (!isset($breadcrumbsDashboard) || $breadcrumbsDashboard === true)
        @if ($campaign)
            <li class="flex items-center">
                <a href="{{ route('dashboard', $campaign) }}" class="text-base-content">
                    <x-icon class="fa-regular fa-globe" />
                    <span class="hidden md:inline">
                        {!! $campaign->name !!}
                    </span>
                </a>
            </li>
        @else
            <li class="flex items-center">
                <a href="{{ route('home') }}" class="text-base-content">
                    <x-icon class="fa-regular fa-dashboard" />
                    <span class="hidden md:inline">
                        {{ __('dashboard.title') }}
                    </span>
                </a>
            </li>
        @endif
    @endif
    @if (isset($breadcrumbs))
        @foreach ($breadcrumbs as $breadcrumb)
            <li class="flex items-center">
                @if (!empty($breadcrumb['url']))
                    <a href="{{ $breadcrumb['url'] }}" title="{{ $breadcrumb['label'] }}" class="text-base-content">
                        @if (strlen($breadcrumb['label']) > 22)
                            {!! \Illuminate\Support\Str::limit(e($breadcrumb['label']), 20) !!}
                        @else
                            {!! $breadcrumb['label'] !!}
                        @endif
                    </a>
                @else
                    @if (strlen($breadcrumb) > 22)
                        <span title="{{ $breadcrumb }}" class="text-base-content" style="--tw-text-opacity: .7">{!! \Illuminate\Support\Str::limit(e($breadcrumb), 20) !!}</span>
                    @else
                        <span class="text-base-content" style="--tw-text-opacity: .7">{!! e($breadcrumb) !!}</span>
                    @endif
                @endif
            </li>
        @endforeach
    @endif
</ol>
