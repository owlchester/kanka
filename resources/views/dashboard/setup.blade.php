@extends('layouts.app', [
    'title' => __('dashboard.setup.title'),
    'breadcrumbs' => [
        __('dashboard.setup.title')
    ],
    'mainTitle' => '',
    'centered' => true,
])

@php
$widgetClass = 'widget rounded-xl h-28 shadow-xs hover:shadow-md cursor-pointer bg-box' ;
$overlayClass = 'rounded-xl flex gap-2 flex-col p-2 items-center h-full';

$hasDashboards = !$dashboards->isEmpty() || !empty($dashboard);
@endphp

@section('content')
    <x-grid type="1/1">
        <div class="flex gap-2 items-center justify-between">
            @if ($hasDashboards)
                <div class="flex gap-1 items-center dropdown" role="button" data-dropdown aria-expanded="false">
                    <h4 class="text-lg group cursor-pointer" data-tooltip data-title="{{ __('dashboards/setup.tooltips.switch') }}">
                        @if ($dashboard)
                            {!! $dashboard->name !!}
                        @else
                            {{ __('dashboard.dashboards.default.title') }}
                        @endif

                        <x-icon class="fa-regular fa-caret-down group-hover:text-primary duration-150 transition-colors" />
                    </h4>

                    <div class="dropdown-menu hidden" role="menu">
                        <x-dropdowns.section>
                            {{ __('dashboards/setup.sections.switch') }}
                        </x-dropdowns.section>
                        @if (!empty($dashboard))
                            <x-dropdowns.item :link="route('dashboard.setup', $campaign)" icon="cog">
                                {{ __('dashboard.dashboards.default.title')}}
                            </x-dropdowns.item>
                        @endif
                        @foreach ($dashboards as $dash)
                            <x-dropdowns.item :link="route('dashboard.setup', [$campaign, 'dashboard' => $dash->id])" icon="cog">
                                {!! $dash->name !!}
                            </x-dropdowns.item>
                        @endforeach
                    </div>
                </div>
            @else
                <h4 class="text-lg">
                @if ($dashboard)
                    {!! $dashboard->name !!}
                @else
                    {{ __('dashboard.dashboards.default.title') }}
                @endif
                </h4>
            @endif
            <div class="flex items-center gap-2">
                <div class="inline-block">
                    <a href="{{ route('dashboard', isset($dashboard) ? [$campaign, 'dashboard' => $dashboard->id] : [$campaign]) }}" class="btn2 btn-sm" title="{{ __('dashboard.setup.actions.back_to_dashboard') }}">
                        <x-icon class="fa-regular fa-arrow-left" />
                        <span class="hidden sm:inline">{{ __('dashboard.setup.actions.back_to_dashboard') }}</span>
                    </a>
                </div>



                @if($dashboard)
                <div class="dropdown">
                    <button type="button" class="btn2 btn-sm" data-dropdown aria-expanded="false">
                        <span class="hidden sm:inline">{{ __('crud.actions.actions') }}</span>
                        <x-icon class="fa-regular fa-caret-down" />
                    </button>
                    <div class="dropdown-menu hidden" role="menu">

                        @php $url = route('campaign_dashboards.edit', [$campaign, $dashboard]); @endphp
                        <x-dropdowns.item link="#" :dialog="$url" icon="edit">
                            {{ __('dashboard.dashboards.actions.edit') }}
                        </x-dropdowns.item>

                        @php $url = route('campaign_dashboards.create', [$campaign, 'source' => $dashboard]); @endphp
                        <x-dropdowns.item link="#" :dialog="$url" icon="copy">
                            {{ __('crud.actions.copy') }}
                        </x-dropdowns.item>

                        @php $data = route('confirm-delete', [$campaign, 'route' => route('campaign_dashboards.destroy', [$campaign, $dashboard]), 'name' => $dashboard->name, 'permanent' => true]); @endphp
                        <x-dropdowns.divider />
                        <x-dropdowns.item link="#" css="text-error hover:bg-error hover:text-error-content" :dialog="$data" icon="trash">
                            {{ __('crud.remove') }}
                        </x-dropdowns.item>
                    </div>
                </div>
                @endif
                <a class="btn2 btn-primary btn-sm"
                   data-toggle="dialog"
                   data-url="{{ route('campaign_dashboards.create', $campaign) }}"
                >
                    <x-icon class="plus" />
                    <span class="hidden sm:inline">{{ __('dashboard.dashboards.actions.new') }}</span>
                </a>
            </div>
        </div>

        @empty($dashboard)
        <x-helper>
            <p>{!! __('dashboard.dashboards.default.text', ['campaign' => $campaign->name]) !!}</p>
        </x-helper>
        @endif

        @include('partials.errors')

        <x-tutorial code="dashboard_setup">
            <p>
                {!! __('dashboard.setup.tutorial.text', [
'blog' => '<a href="https://blog.kanka.io/2020/09/20/how-to-style-your-kanka-campaign-dashboard/" class="text-link">' . __('dashboard.setup.tutorial.blog') . '</a>',
]) !!}
            </p>
        </x-tutorial>

        <div class="campaign-dashboard-widgets">
            <div class="grid grid-cols-12 gap-2 md:gap-5" id="widgets" data-url="{{ route('dashboard.reorder', $campaign) }}">
                @if (empty($dashboard))
                <div class="col-span-12">
                    <div class="{{ $widgetClass }} border-dashboard widget-campaign cover-background h-auto p-4 " @if($campaign->header_image) style="background-image: url({{ Img::crop(1200, 400)->url($campaign->header_image) }})" @endif
                        data-toggle="dialog"
                         data-url="{{ route('campaigns.dashboard-header.edit', $campaign) }}"
                    >
                        <div class="{{ $overlayClass }} backdrop-blur-sm bg-box opacity-60">
                            <span class="widget-type">{{ __('dashboards/widgets/campaign.name') }}</span>
                        </div>
                    </div>
                </div>
                @endif
                @foreach ($widgets as $widget)
                    @includeWhen($widget->visible(), '.dashboard._widget')
                @endforeach

                <div class="col-span-4 widget rounded-xl h-28 hover:border-primary text-primary transition-all duration-150 cursor-pointer border-dashed border-2 py-6" data-toggle="dialog" data-url="{{ route('campaign_dashboard_widgets.index', [$campaign, 'dashboard' => $dashboard]) }}" data-tooltip data-title="{{ __('dashboards/setup.tooltips.add') }}">
                    <div class="text-lg flex gap-2 items-center justify-center p-2 align-middle h-full">
                        <x-icon class="plus" />
                        <span class="uppercase">{{ __('dashboards/setup.actions.add') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </x-grid>

    @include('editors.editor', ['dialogsInBody' => true])
@endsection

@section('scripts')
    @vite('resources/js/dashboard.js')
@endsection

@section('styles')
    @vite('resources/css/dashboard.css')
@endsection
