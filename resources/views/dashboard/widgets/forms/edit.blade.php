@include('partials.errors')
@inject('campaignService', 'App\Services\CampaignService')

{!! Form::model(
    $model,
    [
        'method' => 'PATCH',
        'route' => ['campaign_dashboard_widgets.update', $model],
        'data-shortcut' => '1'
    ]
) !!}

@include('partials.forms.form', [
    'dialog' => true,
    'mode' => 'edit',
    'title' => __('dashboard.setup.widgets.' . $model->widget),
    'titleIcon' => $model->widgetIcon(),
    'content' => 'dashboard.widgets.forms._' . $widget,
    'deleteID' => '#delete-form-widget-' . $model->id,
    'dropdownParent' => '#edit-widget',
])
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

