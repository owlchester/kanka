@extends('layouts.app', [
    'title' => __('dashboard.setup.title'),
    'description' => '',
    'breadcrumbs' => [
        __('dashboard.setup.title')
    ],

])

@inject('campaign', 'App\Services\CampaignService')
@section('content')

    <div class="box box-solid">
        <div class="box-header with-border">
            <h4 class="box-title">@if ($dashboard) {!! $dashboard->name !!} @else {{ __('dashboard.dashboards.default.title') }} @endif</h4>
            <div class="box-tools" style="margin-top: 1px;">
                <a href="{{ route('dashboard', isset($dashboard) ? ['dashboard' => $dashboard->id] : null) }}" class="btn btn-box-tool" title="{{ __('dashboard.setup.actions.back_to_dashboard') }}"><i class="fa fa-arrow-left"></i> {{ __('dashboard.setup.actions.back_to_dashboard') }}</a>
            </div>
        </div>
        <div class="box-body">
            @if ($dashboard)
                {!! __('dashboard.dashboards.custom.text', ['name' => $dashboard->name]) !!}
            @else
                {{ __('dashboard.dashboards.default.text') }}
            @endif

            @if (!$campaign->campaign()->boosted())
                {!! __('dashboard.dashboards.boosted', ['boosted_campaigns' => link_to_route('front.pricing', __('crud.boosted_campaigns'), '#boost')])!!}
           @endif
        </div>
        @if ($campaign->campaign()->boosted())
        <div class="box-footer">
            <a class="btn btn-primary margin-r-5"
                 data-toggle="ajax-modal"
                 data-target="#edit-widget"
                 data-url="{{ route('campaign_dashboards.create') }}"
               >
                <i class="fas fa-plus"></i>
                <span class="hidden-xs">{{ __('dashboard.dashboards.actions.new') }}</span>
            </a>

            @if(!$dashboards->isEmpty() || !empty($dashboard))
                <div class="btn-group">
                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                        <span class="hidden-xs">{{ __('dashboard.dashboards.actions.switch') }}</span>
                        <span class="visible-xs-inline"><i class="fas fa-exchange-alt"></i></span> <span class="caret"></span>
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
                                <i class="fas fa-external-link-alt"></i>
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
                                <i class="fas fa-pencil-alt"></i>
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
                                <i class="fas fa-copy"></i>
                                {{ __('crud.actions.copy') }}
                            </a>
                        </li>
                        <li>
                            <a href="#" class="delete-confirm text-red" data-toggle="modal" data-name="{{ $dashboard->name }}"
                               data-target="#delete-confirm" data-delete-target="delete-dashboard-{{ $dashboard->id }}"
                               title="{{ __('crud.remove') }}">
                                <i class="fa fa-trash" aria-hidden="true"></i>
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
                <div class="widget widget-campaign cover-background" @if($campaign->campaign()->header_image) style="background-image: url({{ Img::crop(1200, 400)->url($campaign->campaign()->header_image) }})" @endif
                    data-toggle="ajax-modal"
                     data-target="#large-modal"
                     data-url="{{ route('campaigns.dashboard-header.edit', $campaign->campaign()) }}"
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
                <div class="widget add" data-toggle="modal" data-target="#new-widget" id="btn-add-widget">
                    <div class="widget-overlay">
                    <i class="fa fa-plus"></i> {{ __('dashboard.setup.actions.add') }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="new-widget" role="dialog" aria-labelledby="deleteConfirmLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="{{ trans('crud.delete_modal.close') }}" title="{{ trans('crud.delete_modal.close') }}"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">
                        {{ trans('dashboard.setup.actions.add') }}
                    </h4>
                </div>
                <div class="modal-body" id="modal-content-buttons">
                    <div class="btn btn-block btn-default btn-lg" id="btn-widget-preview" data-url="{{ route('campaign_dashboard_widgets.create', ['widget' => 'preview', 'dashboard' => $dashboard]) }}">
                        <i class="fa fa-align-justify"></i> {{ __('dashboard.setup.widgets.preview') }}
                    </div>
                    <div class="btn btn-block btn-default btn-lg" id="btn-widget-calendar" data-url="{{ route('campaign_dashboard_widgets.create', ['widget' => 'calendar', 'dashboard' => $dashboard]) }}">
                        <i class="ra ra-moon-sun"></i> {{ __('dashboard.setup.widgets.calendar') }}
                    </div>
                    <div class="btn btn-block btn-default btn-lg" id="btn-widget-recent" data-url="{{ route('campaign_dashboard_widgets.create', ['widget' => 'recent', 'dashboard' => $dashboard]) }}">
                        <i class="fa fa-history"></i> {{ __('dashboard.setup.widgets.recent') }}
                    </div>
                    <div class="btn btn-block btn-default btn-lg" id="btn-widget-header" data-url="{{ route('campaign_dashboard_widgets.create', ['widget' => \App\Models\CampaignDashboardWidget::WIDGET_HEADER, 'dashboard' => $dashboard]) }}">
                        <i class="fas fa-heading"></i> {{ __('dashboard.setup.widgets.header') }}
                    </div>
                    <div class="btn btn-block btn-default btn-lg" id="btn-widget-unmentioned" data-url="{{ route('campaign_dashboard_widgets.create', ['widget' => 'unmentioned', 'dashboard' => $dashboard]) }}">
                        <i class="fa fa-question"></i> {{ __('dashboard.setup.widgets.unmentioned') }}
                    </div>
                    <div class="btn btn-block btn-default btn-lg" id="btn-widget-random" data-url="{{ route('campaign_dashboard_widgets.create', ['widget' => 'random', 'dashboard' => $dashboard]) }}">
                        <i class="fas fa-dice-d20"></i> {{ __('dashboard.setup.widgets.random') }}
                    </div>
                    @if(!empty($dashboard))

                        <div class="btn btn-block btn-default btn-lg" id="btn-widget-campaign" data-url="{{ route('campaign_dashboard_widgets.create', ['widget' => 'campaign', 'dashboard' => $dashboard]) }}">
                            <i class="fas fa-th-list"></i> {{ __('dashboard.setup.widgets.campaign') }}
                        </div>
                    @endif
                </div>

                <div class="modal-body" id="modal-content-spinner">
                    <div class="text-center">
                        <h1><i class="fa fa-spin fa-spinner"></i></h1>
                    </div>
                </div>

                <div id="modal-content-target"></div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="edit-widget" role="dialog" aria-labelledby="deleteConfirmLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">

            </div>
        </div>
    </div>

    {{ csrf_field() }}

    @include('editors.editor')
@endsection

@section('scripts')
    <script src="{{ mix('js/dashboard.js') }}" defer></script>
@endsection

@section('styles')
    <link href="{{ mix('css/dashboard.css') }}" rel="stylesheet">
@endsection
