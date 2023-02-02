@extends('layouts.app', [
    'title' => __('dashboard.setup.title'),
    'description' => '',
    'breadcrumbs' => [
        __('dashboard.setup.title')
    ],

])

@php
$widgetClass = 'widget relative mb-5 rounded-md text-xl text-center h-40 overflow-hidden hover:drop-shadow cursor' ;
$overlayClass = 'widget-overlay rounded flex gap-3 flex-col justify-center h-full';
$newWidgetListClass = 'btn btn-block btn-default text-xl';
@endphp

@inject('campaignService', 'App\Services\CampaignService')
@section('content')

    <div class="box box-solid">
        <div class="box-header with-border">
            <h4 class="box-title">@if ($dashboard) {!! $dashboard->name !!} @else {{ __('dashboard.dashboards.default.title') }} @endif</h4>
            <div class="box-tools" style="margin-top: 1px;">
                <a href="{{ route('dashboard', isset($dashboard) ? ['dashboard' => $dashboard->id] : null) }}" class="btn btn-box-tool" title="{{ __('dashboard.setup.actions.back_to_dashboard') }}"><i class="fa-solid fa-arrow-left"></i> {{ __('dashboard.setup.actions.back_to_dashboard') }}</a>
            </div>
        </div>
        <div class="box-body">
            @if ($dashboard)
                {!! __('dashboard.dashboards.custom.text', ['name' => $dashboard->name]) !!}
            @else
                {{ __('dashboard.dashboards.default.text') }}
            @endif
        </div>
        @if (true || $campaignService->campaign()->boosted())
        <div class="box-footer">
            <a class="btn btn-primary mr-2"
                 data-toggle="ajax-modal"
                 data-target="#edit-widget"
                 data-url="{{ route('campaign_dashboards.create') }}"
               >
                <i class="fa-solid fa-plus"></i>
                <span class="hidden-xs">{{ __('dashboard.dashboards.actions.new') }}</span>
            </a>

            @if(!$dashboards->isEmpty() || !empty($dashboard))
                <div class="btn-group">
                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                        <span class="hidden-xs">{{ __('dashboard.dashboards.actions.switch') }}</span>
                        <span class="visible-xs-inline"><i class="fa-solid fa-exchange-alt"></i></span> <span class="caret"></span>
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
                <div class="btn-group pull-right">
                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                        {{ __('crud.actions.actions') }} <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu" role="menu">
                        <li>
                            <a href="{{ route('dashboard', ['dashboard' => $dashboard->id]) }}" target="_blank"
                               >
                                <i class="fa-solid fa-external-link-alt"></i>
                                {{ __('crud.view') }}
                            </a>
                        </li>
                        <li>
                            <a
                                    href="#"
                               data-toggle="ajax-modal"
                               data-target="#edit-widget"
                               data-url="{{ route('campaign_dashboards.edit', $dashboard) }}"
                            >
                                <i class="fa-solid fa-pencil-alt"></i>
                                {{ __('dashboard.dashboards.actions.edit') }}
                            </a>
                        </li>
                        <li>
                            <a
                                    href="#"
                                    data-toggle="ajax-modal"
                                    data-target="#edit-widget"
                                    data-url="{{ route('campaign_dashboards.create', ['source' => $dashboard]) }}"
                            >
                                <i class="fa-solid fa-copy"></i>
                                {{ __('crud.actions.copy') }}
                            </a>
                        </li>
                        <li>
                            <a href="#" class="delete-confirm text-red" data-toggle="modal" data-name="{{ $dashboard->name }}"
                               data-target="#delete-confirm" data-delete-target="delete-dashboard-{{ $dashboard->id }}"
                               title="{{ __('crud.remove') }}">
                                <i class="fa-solid fa-trash" aria-hidden="true"></i>
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
    </div>

    @include('partials.errors')

    <div class="campaign-dashboard-widgets">
        <div class="row" id="widgets" data-url="{{ route('dashboard.reorder') }}">
            @if (empty($dashboard))
            <div class="col-md-12">
                <div class="{{ $widgetClass }} border-dashboard widget-campaign cover-background" @if($campaignService->campaign()->header_image) style="background-image: url({{ Img::crop(1200, 400)->url($campaignService->campaign()->header_image) }})" @endif
                    data-toggle="ajax-modal"
                     data-target="#large-modal"
                     data-url="{{ route('campaigns.dashboard-header.edit', $campaignService->campaign()) }}"
                >
                    <div class="widget-overlay">
                        <span class="widget-type">{{ __('dashboard.setup.widgets.campaign') }}</span>
                    </div>
                </div>
            </div>
            @endif
            @foreach ($widgets as $widget)
                @includeWhen(empty($widget->entity) || !empty($widget->entity->child), '.dashboard._widget')
            @endforeach

            <div class="col-md-4">
                <div class="{{ $widgetClass }} cursor hover:shadow border-dashed border-2" data-toggle="modal" data-target="#new-widget" id="btn-add-widget">
                    <div class="{{ $overlayClass }} text-3xl">
                        <i class="fa-solid fa-plus" aria-hidden="true"></i>
                        <span class="block">{{ __('dashboard.setup.actions.add') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="new-widget" role="dialog" aria-labelledby="deleteConfirmLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content rounded-2xl">
                <div class="modal-body text-center" id="modal-content-buttons">
                    <button type="button" class="close" data-dismiss="modal" aria-label="{{ __('crud.delete_modal.close') }}" title="{{ __('crud.delete_modal.close') }}"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title mb-5" id="myModalLabel">
                        {{ __('dashboard.setup.actions.add') }}
                    </h4>

                    <div class="widget-list grid grid-cols-1 gap-2 mb-5">
                        <a href="#" class="{{ $newWidgetListClass }}" data-url="{{ route('campaign_dashboard_widgets.create', ['widget' => 'recent', 'dashboard' => $dashboard]) }}">
                            <i class="fa-solid fa-list" aria-hidden="true"></i> {{ __('dashboard.setup.widgets.recent') }}
                        </a>
                        <a href="#" class="{{ $newWidgetListClass }}" id="btn-widget-preview" data-url="{{ route('campaign_dashboard_widgets.create', ['widget' => 'preview', 'dashboard' => $dashboard]) }}">
                            <i class="fa-solid fa-align-justify" aria-hidden="true"></i>
                            {{ __('dashboard.setup.widgets.preview') }}
                        </a>
                        <a  href="#" class="{{ $newWidgetListClass }}" id="btn-widget-calendar" data-url="{{ route('campaign_dashboard_widgets.create', ['widget' => 'calendar', 'dashboard' => $dashboard]) }}">
                            <i class="ra ra-moon-sun" aria-hidden="true"></i> {{ __('dashboard.setup.widgets.calendar') }}
                        </a>

                        <a href="#" class="{{ $newWidgetListClass }}" id="btn-widget-header" data-url="{{ route('campaign_dashboard_widgets.create', ['widget' => \App\Models\CampaignDashboardWidget::WIDGET_HEADER, 'dashboard' => $dashboard]) }}">
                            <i class="fa-solid fa-heading" aria-hidden="true"></i> {{ __('dashboard.setup.widgets.header') }}
                        </a>
                        <a  href="#" class="{{ $newWidgetListClass }}" id="btn-widget-random" data-url="{{ route('campaign_dashboard_widgets.create', ['widget' => 'random', 'dashboard' => $dashboard]) }}">
                            <i class="fa-solid fa-dice-d20" aria-hidden="true"></i> {{ __('dashboard.setup.widgets.random') }}
                        </a>
                        <a  href="#" class="{{ $newWidgetListClass }}" id="btn-widget-welcome" data-url="{{ route('campaign_dashboard_widgets.create', ['widget' => 'welcome', 'dashboard' => $dashboard]) }}">
                            <i class="fa-solid fa-party-horn" aria-hidden="true"></i> {{ __('dashboard.setup.widgets.welcome') }}
                        </a>
                        @if(!empty($dashboard))
                            <a  href="#" class="{{ $newWidgetListClass }}" id="btn-widget-campaign" data-url="{{ route('campaign_dashboard_widgets.create', ['widget' => 'campaign', 'dashboard' => $dashboard]) }}">
                                <i class="fa-solid fa-th-list" aria-hidden="true"></i> {{ __('dashboard.setup.widgets.campaign') }}
                            </a>
                        @endif
                    </div>
                </div>

                <div class="modal-body" id="modal-content-spinner" style="display: none">
                    <div class="text-center">
                        <i class="fa-solid fa-spin fa-spinner fa-2x"></i>
                    </div>
                </div>

                <div id="modal-content-target"></div>
            </div>
        </div>
    </div>

    <!-- Modal edit widget -->
    <div class="modal fade" id="edit-widget" role="dialog" aria-labelledby="deleteConfirmLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content rounded-2xl">
            </div>
        </div>
    </div>

    {{ csrf_field() }}

    @include('editors.editor', ['dialogsInBody' => true])
@endsection

@section('scripts')
    <script src="{{ mix('js/dashboard.js') }}" defer></script>
@endsection

@section('styles')
    <link href="{{ mix('css/dashboard.css') }}" rel="stylesheet">
@endsection
