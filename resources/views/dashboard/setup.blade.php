@extends('layouts.app', [
    'title' => __('dashboard.setup.title'),
    'breadcrumbs' => [
        __('dashboard.setup.title')
    ],
    'mainTitle' => '',
])

@php
$widgetClass = 'widget relative rounded text-xl text-center h-40 overflow-hidden shadow-xs hover:shadow-md cursor-pointer bg-box' ;
$overlayClass = 'bg-box opacity-80 rounded flex gap-3 p-2 flex-col justify-center h-full';
$newWidgetListClass = 'btn2 btn-full';
@endphp

@inject('campaignService', 'App\Services\CampaignService')
@section('content')
<div class="max-w-5xl">
    <div class="flex gap-2 mb-2 items-center">
        <h4 class="grow">
            @if ($dashboard)
                {!! $dashboard->name !!}
            @else
                {{ __('dashboard.dashboards.default.title') }}
            @endif
        </h4>
        <a href="{{ route('dashboard', isset($dashboard) ? ['dashboard' => $dashboard->id] : null) }}" class="btn2 btn-sm" title="{{ __('dashboard.setup.actions.back_to_dashboard') }}">
            <x-icon class="fa-solid fa-arrow-left" />
            {{ __('dashboard.setup.actions.back_to_dashboard') }}
        </a>
    </div>
    <x-box >

        @if ($dashboard)
            {!! __('dashboard.dashboards.custom.text', ['name' => $dashboard->name]) !!}
        @else
            {{ __('dashboard.dashboards.default.text') }}
        @endif

        @if ($campaignService->campaign()->boosted())
            <div class="mt-5 flex items-center gap-2">
                <a class="btn2 btn-primary btn-sm"
                     data-toggle="dialog-ajax"
                     data-target="edit-widget"
                     data-url="{{ route('campaign_dashboards.create') }}"
                   >
                    <x-icon class="plus"></x-icon>
                    <span class="hidden-xs">{{ __('dashboard.dashboards.actions.new') }}</span>
                </a>

                @if(!$dashboards->isEmpty() || !empty($dashboard))
                    <div class="dropdown">
                        <button type="button" class="btn2 btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                            <span class="hidden-xs">{{ __('dashboard.dashboards.actions.switch') }}</span>
                            <span class="visible-xs-inline">
                                <i class="fa-solid fa-exchange-alt" aria-hidden="true"></i>
                            </span> <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu" role="menu">
                            @if (!empty($dashboard))
                                <li>
                                    <a href="{{ route('dashboard.setup') }}">
                                        {{ __('dashboard.dashboards.default.title')}}
                                    </a>
                                </li>
                            @endif
                            @foreach ($dashboards as $dash)
                            <li>
                                <a href="{{ route('dashboard.setup', ['dashboard' => $dash->id]) }}">
                                    {!! $dash->name !!}
                                </a>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if($dashboard)
                    <div class="dropdown">
                        <button type="button" class="btn2 btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                            {{ __('crud.actions.actions') }} <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-right" role="menu">
                            <li>
                                <a href="{{ route('dashboard', ['dashboard' => $dashboard->id]) }}" target="_blank"
                                   >
                                    <i class="fa-solid fa-external-link-alt" aria-hidden="true"></i>
                                    {{ __('crud.view') }}
                                </a>
                            </li>
                            <li>
                                <a
                                    href="#"
                                    data-toggle="dialog-ajax"
                                    data-target="edit-widget"
                                    data-url="{{ route('campaign_dashboards.edit', $dashboard) }}"
                                >
                                    <i class="fa-solid fa-pencil-alt" aria-hidden="true"></i>
                                    {{ __('dashboard.dashboards.actions.edit') }}
                                </a>
                            </li>
                            <li>
                                <a
                                        href="#"
                                        data-toggle="dialog-ajax"
                                        data-target="edit-widget"
                                        data-url="{{ route('campaign_dashboards.create', ['source' => $dashboard]) }}"
                                >
                                    <i class="fa-solid fa-copy" aria-hidden="true"></i>
                                    {{ __('crud.actions.copy') }}
                                </a>
                            </li>
                            <li>
                                <a href="#" class="delete-confirm text-red" data-toggle="modal" data-name="{{ $dashboard->name }}"
                                   data-target="#delete-confirm" data-delete-target="delete-dashboard-{{ $dashboard->id }}"
                                   title="{{ __('crud.remove') }}">
                                    <x-icon class="trash"></x-icon>
                                    {{ __('crud.remove') }}
                                </a>
                                {!! Form::open(['method' => 'DELETE', 'route' => ['campaign_dashboards.destroy', $dashboard], 'style '=> 'display:inline', 'id' => 'delete-dashboard-' . $dashboard->id]) !!}
                                {!! Form::close() !!}
                            </li>
                        </ul>
                    </div>
                @endif
            </div>
        @endif
    </x-box>

    @include('partials.errors')

    <div class="campaign-dashboard-widgets">
        <div class="grid grid-cols-12 gap-2 md:gap-5" id="widgets" data-url="{{ route('dashboard.reorder') }}">
            @if (empty($dashboard))
            <div class="col-span-12">
                <div class="{{ $widgetClass }} border-dashboard widget-campaign cover-background h-auto" @if($campaignService->campaign()->header_image) style="background-image: url({{ Img::crop(1200, 400)->url($campaignService->campaign()->header_image) }})" @endif
                    data-toggle="dialog-ajax"
                     data-target="edit-widget"
                     data-url="{{ route('campaigns.dashboard-header.edit', $campaignService->campaign()) }}"
                >
                    <div class="{{ $overlayClass }}">
                        <span class="widget-type">{{ __('dashboard.setup.widgets.campaign') }}</span>
                    </div>
                </div>
            </div>
            @endif
            @foreach ($widgets as $widget)
                @includeWhen($widget->visible(), '.dashboard._widget')
            @endforeach

            <div class="col-span-4 {{ $widgetClass }} cursor-pointer shadow-xs hover:shadow-md" data-toggle="dialog" data-target="new-widget" id="btn-add-widget">
                <div class="{{ $overlayClass }} text-2xl">
                    <x-icon class="plus"></x-icon>
                    <span class="block">{{ __('dashboard.setup.actions.add') }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
    {{ csrf_field() }}

    @include('editors.editor', ['dialogsInBody' => true])
@endsection

@section('modals')
    <div class="col-span-1 col-span-2 col-span-3 col-span-4 col-span-5 col-span-6 col-span-6 col-span-7 col-span-8 col-span-9 col-span-10 col-span-11 col-span-12"></div>

    <x-dialog id="new-widget" :title="__('dashboard.setup.actions.add')">
        <div class="widget-list grid grid-cols-1 gap-2 mb-5" id="modal-content-buttons">
            <a href="#" class="{{ $newWidgetListClass }}" data-url="{{ route('campaign_dashboard_widgets.create', ['widget' => 'recent', 'dashboard' => $dashboard]) }}">
                <x-icon class="fa-solid fa-list"></x-icon>
                {{ __('dashboard.setup.widgets.recent') }}
            </a>
            <a href="#" class="{{ $newWidgetListClass }}" id="btn-widget-preview" data-url="{{ route('campaign_dashboard_widgets.create', ['widget' => 'preview', 'dashboard' => $dashboard]) }}">
                <x-icon class="fa-solid fa-align-justify"></x-icon>
                {{ __('dashboard.setup.widgets.preview') }}
            </a>
            <a  href="#" class="{{ $newWidgetListClass }}" id="btn-widget-calendar" data-url="{{ route('campaign_dashboard_widgets.create', ['widget' => 'calendar', 'dashboard' => $dashboard]) }}">
                <x-icon class="ra ra-moon-sun"></x-icon>
                {{ __('dashboard.setup.widgets.calendar') }}
            </a>

            <a href="#" class="{{ $newWidgetListClass }}" id="btn-widget-header" data-url="{{ route('campaign_dashboard_widgets.create', ['widget' => \App\Models\CampaignDashboardWidget::WIDGET_HEADER, 'dashboard' => $dashboard]) }}">
                <x-icon class="fa-solid faheading-"></x-icon>
                {{ __('dashboard.setup.widgets.header') }}
            </a>
            <a  href="#" class="{{ $newWidgetListClass }}" id="btn-widget-random" data-url="{{ route('campaign_dashboard_widgets.create', ['widget' => 'random', 'dashboard' => $dashboard]) }}">
                <x-icon class="fa-solid fa-dice-d20"></x-icon>
                {{ __('dashboard.setup.widgets.random') }}
            </a>
            <a  href="#" class="{{ $newWidgetListClass }}" id="btn-widget-welcome" data-url="{{ route('campaign_dashboard_widgets.create', ['widget' => 'welcome', 'dashboard' => $dashboard]) }}">
                <x-icon class="fa-solid fa-party-horn"></x-icon>
                {{ __('dashboard.setup.widgets.welcome') }}
            </a>
            @if(!empty($dashboard))
                <a  href="#" class="{{ $newWidgetListClass }}" id="btn-widget-campaign" data-url="{{ route('campaign_dashboard_widgets.create', ['widget' => 'campaign', 'dashboard' => $dashboard]) }}">
                    <x-icon class="fa-solid fa-th-list"></x-icon>
                    {{ __('dashboard.setup.widgets.campaign') }}
                </a>
            @endif
        </div>
        <div id="modal-content-spinner" style="display: none">
            <div class="text-center">
                <i class="fa-solid fa-spin fa-spinner fa-2x" aria-hidden="true"></i>
            </div>
        </div>

        <div id="modal-content-target"></div>
    </x-dialog>

    <!-- Modal edit widget -->

    <x-dialog id="edit-widget" :loading="true"></x-dialog>
    <div class="modal fade" id="edit-widget-old" role="dialog" aria-labelledby="deleteConfirmLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content bg-base-100 rounded-2xl">
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    @vite('resources/js/dashboard.js')
@endsection

@section('styles')
    @vite('resources/sass/dashboard.scss')
@endsection
