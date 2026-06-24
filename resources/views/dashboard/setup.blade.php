@extends('layouts.app', [
    'title' => __('dashboard.setup.title'),
    'breadcrumbs' => [
        __('dashboard.setup.title')
    ],
    'mainTitle' => '',
    'centered' => true,
])

@php
$widgetClass = 'widget rounded-xl shadow-xs hover:shadow-md bg-box' ;
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

            @if (config('limits.campaigns.premium'))
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
                        <x-dropdowns.item link="#" css="text-error-content hover:bg-error" :dialog="$data" icon="trash">
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
            @endif
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
                    <div class="{{ $widgetClass }} widget-campaign cover-background handle cursor-grab rounded-xl"
                         data-toggle="dialog"
                         data-url="{{ route('campaigns.dashboard-header.edit', ['campaign' => $campaign]) }}"
                    >
                        <div class="rounded-xl bg-box flex items-center gap-3 justify-between p-4">
                            <div class="flex-none text-neutral-content" data-toggle="tooltip" data-title="{{ __('dashboard.setup.reorder.helper') }}">
                                <x-icon class="fa-solid fa-grip-vertical" />
                            </div>
                            <div class="flex-none">
                                <div class="rounded-lg flex items-center justify-center w-10 h-10 text-lg bg-red-100 text-red-700" tooltip title="{{ __('dashboards/widgets/campaign.name') }}">
                                    <x-icon class="fa-regular fa-th-list" />
                                </div>
                            </div>
                            <div class="flex flex-col gap-1 grow">
                                <div class="flex gap-2 items-center w-full">
                                    <div class="truncate font-medium">
                                        {{ __('dashboards/widgets/campaign.name') }}
                                    </div>
                                    <div class="rounded px-2 py-0.5 bg-red-100 text-red-700 text-2xs font-medium uppercase">
                                        {{ __('dashboards/widgets/campaign.tag') }}
                                    </div>
                                </div>
                                <p class="text-neutral-content text-xs italic">
                                    {{ __('dashboards/widgets/campaign.tagline') }}
                                </p>
                            </div>
                            <div class="rounded bg-base-200 px-2 py-0.5 text-neutral-content text-2xs">
                                {{ __('dashboard.widgets.widths.12') }}
                            </div>
                        </div>
                    </div>
                </div>
                @endif
                @foreach ($widgets as $widget)
                    @includeWhen($widget->visible(), '.dashboard._widget')
                @endforeach

                <div class="col-span-12 widget rounded-xl text-neutral-content border-base-300 hover:border-primary focus:border-primary hover:text-primary focus:text-primary transition-colors duration-150 cursor-pointer border-dashed border-2 py-4 font-medium text-center" data-toggle="dialog" data-url="{{ route('campaign_dashboard_widgets.index', [$campaign, 'dashboard' => $dashboard]) }}" data-tooltip data-title="{{ __('dashboards/setup.tooltips.add') }}">
                        <x-icon class="plus" />
                        {{ __('dashboards/setup.actions.add') }}
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
