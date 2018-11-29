@extends('layouts.app', [
    'title' => trans('campaigns.dashboard.title'),
    'description' => '',
    'breadcrumbs' => [
        trans('campaigns.dashboard.title')
    ]
])

@section('content')

    @include('partials.errors')

    <div class="campaign-dashboard-widgets">
        <div class="row" id="widgets">

            @foreach ($widgets as $widget)
                <?php /** @var \App\Models\CampaignDashboardWidget $widget */ ?>
                <div class="col-md-{{ $widget->colSize() }}">
                    <div class="widget widget-{{ $widget->widget }}" data-toggle="ajax-modal" data-target="#edit-widget" data-url="{{ route('campaign_dashboard_widgets.edit', $widget) }}">
                        {{ $widget->widget }}
                    </div>
                </div>
            @endforeach

            <div class="col-md-4">
                <div class="widget add" data-toggle="modal" data-target="#new-widget" id="btn-add-widget">
                    <i class="fa fa-plus"></i> {{ __('dashboard.setup.actions.add') }}
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
                <div class="modal-body">
                    <div id="modal-content-buttons">
                        <div class="btn btn-block btn-default btn-lg" id="btn-widget-preview" data-url="{{ route('campaign_dashboard_widgets.create', ['widget' => 'preview']) }}">
                            <i class="fa fa-align-justify"></i> {{ __('dashboard.setup.widgets.preview') }}
                        </div>
                        <div class="btn btn-block btn-default btn-lg" id="btn-widget-calendar" data-url="{{ route('campaign_dashboard_widgets.create', ['widget' => 'calendar']) }}">
                            <i class="ra ra-moon-sun"></i> {{ __('dashboard.setup.widgets.calendar') }}
                        </div>
                        <div class="btn btn-block btn-default btn-lg" id="btn-widget-recent">
                            <i class="fa fa-history"></i> {{ __('dashboard.setup.widgets.recent') }}
                        </div>
                    </div>

                    <div id="modal-content-target">
                        <div class="text-center" id="modal-content-spinner" style="display: none;">
                            <h1><i class="fa fa-spin fa-spinner"></i></h1>
                        </div>
                    </div>
                </div>
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
@endsection

@section('scripts')
    <script src="{{ mix('js/dashboard.js') }}" defer></script>
@endsection

@section('styles')
    <link href="{{ mix('css/dashboard.css') }}" rel="stylesheet">
@endsection