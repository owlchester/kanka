@include('partials.errors')
@inject('campaign', 'App\Services\CampaignService')

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
        @if ($model->widget != \App\Models\CampaignDashboardWidget::WIDGET_HEADER)
            <span class="widget-type">
             {!! $model->widgetIcon() !!}
                {{ __('dashboard.setup.widgets.' . $model->widget) }}
        </span>
        @else
        {{ __('dashboard.setup.actions.edit') }}
        @endif
    </h4>
</div>
<div class="modal-body">


    @include('dashboard.widgets.forms._' . $widget)
</div>
<div class="modal-footer">
    <button class="btn btn-success">{{ __('crud.save') }}</button>

    <div class="pull-left">
        <a role="button" tabindex="0" class="btn btn-dynamic-delete btn-danger" data-toggle="popover"
           title="{{ __('crud.delete_modal.title') }}"
           data-content="<p>{{ __('crud.delete_modal.description_final', ['tag' => __('dashboard.widgets.actions.delete-confirm')]) }}</p>
                   <a href='#' class='btn btn-danger btn-block' data-toggle='delete-form' data-target='#delete-form-widget-{{ $model->id}}'>{{ __('crud.remove') }}</a>">
            <i class="fa fa-trash" aria-hidden="true"></i> {{ __('crud.remove') }}
        </a>
    </div>
</div>

<input type="hidden" name="widget" value="{{ $widget }}">
@if(empty($dashboards) && !empty($dashboard))
    <input type="hidden" name="dashboard_id" value="{{ $dashboard->id }}">
@endif
{!! Form::close() !!}

{!! Form::open([
    'method' => 'DELETE',
    'route' => ['campaign_dashboard_widgets.destroy', $model],
    'id' => 'delete-form-widget-' . $model->id
]) !!}
{!! Form::close() !!}

