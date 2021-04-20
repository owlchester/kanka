@include('partials.errors')
@inject('campaign', 'App\Services\CampaignService')

@if (!empty($model))
    {!! Form::model(
    $model,
    [
        'method' => 'PATCH',
        'route' => ['campaign_dashboard_widgets.update', $model],
        'data-shortcut' => '1'
    ]
) !!}
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span></button>
        <h4 class="modal-title" id="myModalLabel">
            {{ __('dashboard.setup.actions.edit') }}
        </h4>
    </div>
    <div class="modal-body">
@else
    {!! Form::open([
        'route' => ['campaign_dashboard_widgets.store'],
        'method'=>'POST',
        'data-shortcut' => '1'
    ]) !!}
@endif

    @include('dashboard.widgets.forms._' . $widget)
</div>
<div class="modal-footer">
    <div class="row">
        <div class="col-xs-6 text-left">
            <button class="btn btn-success">{{ __('crud.save') }}</button>

            <input type="hidden" name="widget" value="{{ $widget }}">
            @if(empty($dashboards) && !empty($dashboard))
                <input type="hidden" name="dashboard_id" value="{{ $dashboard->id }}">
            @endif
            {!! Form::close() !!}
        </div>
        <div class="col-xs-6 text-right">
            @if (!empty($model))
                {!! Form::open(['method' => 'DELETE','route' => ['campaign_dashboard_widgets.destroy', $model], 'class' => 'form-inline']) !!}
                <button class="btn btn-danger">
                    <i class="fa fa-trash" aria-hidden="true"></i> <span class="hidden-xs hidden-sm">{{ __('crud.remove') }}</span>
                </button>
                {!! Form::close() !!}

            @endif
        </div>
    </div>
</div>

