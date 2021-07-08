@include('partials.errors')
@inject('campaign', 'App\Services\CampaignService')


{!! Form::open([
    'route' => ['campaign_dashboard_widgets.store'],
    'method'=>'POST',
    'data-shortcut' => '1'
]) !!}

<div class="modal-body modal-widget-subform">
@include('dashboard.widgets.forms._' . $widget)
</div>

<div class="modal-footer">
    <a href="#" class="pull-left" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">{{ __('crud.cancel') }}</span>
    </a>
    <button class="btn btn-success">{{ __('crud.create') }}</button>
</div>

<input type="hidden" name="widget" value="{{ $widget }}">
@if(empty($dashboards) && !empty($dashboard))
    <input type="hidden" name="dashboard_id" value="{{ $dashboard->id }}">
@endif
{!! Form::close() !!}
