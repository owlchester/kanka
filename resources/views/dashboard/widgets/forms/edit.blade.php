@include('partials.errors')

{!! Form::model(
    $model,
    [
        'method' => 'PATCH',
        'route' => ['campaign_dashboard_widgets.update', $campaign, $model],
        'data-shortcut' => '1'
    ]
) !!}

@include('partials.forms.form', [
    'dialog' => true,
    'mode' => 'edit',
    'title' => __('dashboard.setup.widgets.' . $model->widget->value),
    'titleIcon' => $model->widgetIcon(),
    'content' => 'dashboard.widgets.forms._' . $widget,
    'deleteID' => '#delete-form-widget-' . $model->id,
])
<input type="hidden" name="widget" value="{{ $widget }}">
@if(empty($dashboards) && !empty($dashboard))
    <input type="hidden" name="dashboard_id" value="{{ $dashboard->id }}">
@endif
{!! Form::close() !!}

{!! Form::open([
    'method' => 'DELETE',
    'route' => ['campaign_dashboard_widgets.destroy', $campaign, $model],
    'id' => 'delete-form-widget-' . $model->id
]) !!}
{!! Form::close() !!}

