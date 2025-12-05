@extends('layouts.app', [
    'title' => __('dashboard.setup.title'),
    'breadcrumbs' => [
        __('dashboard.setup.title')
    ],
    'mainTitle' => '',
    'centered' => true,
])

@php
$widgetClass = 'widget rounded-xl h-28 shadow-xs hover:shadow cursor-pointer bg-box' ;
$overlayClass = 'rounded-xl flex gap-2 flex-col p-2 items-center h-full';
@endphp

@section('content')
    <x-grid type="1/1">
        <div class="flex gap-2 items-center justify-between">
            <h4 class="text-lg">
                @if ($dashboard)
                    {!! $dashboard->name !!}
                @else
                    {{ __('dashboard.dashboards.default.title') }}
                @endif
            </h4>
            <div class="flex items-center gap-2">
                <div class="hidden lg:inline-block">
                    <a href="{{ route('dashboard', isset($dashboard) ? [$campaign, 'dashboard' => $dashboard->id] : [$campaign]) }}" class="btn2 btn-sm" title="{{ __('dashboard.setup.actions.back_to_dashboard') }}">
                        <x-icon class="fa-solid fa-arrow-left" />
                        <span class="hidden sm:inline">{{ __('dashboard.setup.actions.back_to_dashboard') }}</span>
                    </a>
                </div>

                <a class="btn2 btn-primary btn-sm"
                   data-toggle="dialog"
                   data-target="primary-dialog"
                   data-url="{{ route('campaign_dashboards.create', $campaign) }}"
                >
                    <x-icon class="plus" />
                    <span class="hidden sm:inline">{{ __('dashboard.dashboards.actions.new') }}</span>
                </a>

                <div class="dropdown">
                    <button type="button" class="btn2 btn-sm" data-dropdown aria-expanded="false">
                        <span class="hidden sm:inline">{{ __('crud.actions.actions') }}</span>
                        <x-icon class="fa-solid fa-caret-down" />
                    </button>
                    <div class="dropdown-menu hidden" role="menu">
                        @if($dashboard)
                            <x-dropdowns.item :link="route('dashboard', [$campaign, 'dashboard' => $dashboard->id])" icon="fa-solid fa-arrow-left">
                                {{ __('dashboard.setup.actions.back_to_dashboard') }}
                            </x-dropdowns.item>
                        @else
                            <x-dropdowns.item :link="route('dashboard', [$campaign])" icon="fa-solid fa-arrow-left">
                                {{ __('dashboard.setup.actions.back_to_dashboard') }}
                            </x-dropdowns.item>
                        @endif

                        @if($dashboard)
                            @php $url = route('campaign_dashboards.edit', [$campaign, $dashboard]); @endphp
                            <x-dropdowns.item link="#" :dialog="$url" icon="edit">
                                {{ __('dashboard.dashboards.actions.edit') }}
                            </x-dropdowns.item>

                            @php $url = route('campaign_dashboards.create', [$campaign, 'source' => $dashboard]); @endphp
                            <x-dropdowns.item link="#" :dialog="$url" icon="copy">
                                {{ __('crud.actions.copy') }}
                            </x-dropdowns.item>

                            @php $data = route('confirm-delete', [$campaign, 'route' => route('campaign_dashboards.destroy', [$campaign, $dashboard]), 'name' => $dashboard->name, 'permanent' => true]); @endphp
                            <x-dropdowns.item link="#" css="text-error hover:bg-error hover:text-error-content" :dialog="$data" icon="trash">
                                {{ __('crud.remove') }}
                            </x-dropdowns.item>
                        @endif
                        @if(!$dashboards->isEmpty() || !empty($dashboard))
                            <x-dropdowns.section>
                                {{ __('dashboard.dashboards.actions.switch') }}
                            </x-dropdowns.section>
                            <span class="" ></span>
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
                        @endif
                    </div>
                </div>
            </div>
        </div>

        @empty($dashboard)
        <x-helper>
            <p>{!! __('dashboard.dashboards.default.text', ['campaign' => $campaign->name]) !!}</p>
        </x-helper>
        @endif

        @include('partials.errors')

        <x-tutorial code="dashboard-setup">
            <p>
                {!! __('dashboard.setup.tutorial.text', [
'blog' => '<a href="https://blog.kanka.io/2020/09/20/how-to-style-your-kanka-campaign-dashboard/" target="_blank">' . __('dashboard.setup.tutorial.blog') . '</a>',
]) !!}
            </p>
        </x-tutorial>

        <div class="campaign-dashboard-widgets">
            <div class="grid grid-cols-12 gap-2 md:gap-5" id="widgets" data-url="{{ route('dashboard.reorder', $campaign) }}">
                @if (empty($dashboard))
                <div class="col-span-12">
                    <div class="{{ $widgetClass }} border-dashboard widget-campaign cover-background h-auto p-4 " @if($campaign->header_image) style="background-image: url({{ Img::crop(1200, 400)->url($campaign->header_image) }})" @endif
                        data-toggle="dialog"
                         data-target="primary-dialog"
                         data-url="{{ route('campaigns.dashboard-header.edit', $campaign) }}"
                    >
                        <div class="{{ $overlayClass }} backdrop-blur bg-box opacity-60">
                            <span class="widget-type">{{ __('dashboards/widgets/campaign.name') }}</span>
                        </div>
                    </div>
                </div>
                @endif
                @foreach ($widgets as $widget)
                    @includeWhen($widget->visible(), '.dashboard._widget')
                @endforeach

                <div class="col-span-4 widget rounded-xl h-28 hover:border-primary text-primary transition-all duration-150 cursor-pointer border-dashed border-2 py-6" data-toggle="dialog" data-target="primary-dialog" data-url="{{ route('campaign_dashboard_widgets.index', [$campaign, 'dashboard' => $dashboard]) }}">
                    <div class="text-lg flex gap-2 items-center justify-center p-2 align-middle h-full">
                        <x-icon class="plus" />
                        <span class="uppercase">{{ __('crud.add') }}</span>
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
