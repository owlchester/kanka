@include('partials.errors')

<x-form :action="['campaign_dashboard_widgets.update', $campaign, $model]" method="PATCH">
    @include('partials.forms._dialog', [
        'mode' => 'edit',
        'title' => __('dashboard.setup.widgets.' . $model->widget->value),
        'titleIcon' => '<i class="' . $model->widgetIcon() . '" aria-hidden="true"></i>',
        'content' => 'dashboard.widgets.forms._' . $widget,
        'deleteID' => '#delete-form-widget-' . $model->id,
    ])
    <input type="hidden" name="widget" value="{{ $widget }}">
    @if(empty($dashboards) && !empty($dashboard))
        <input type="hidden" name="dashboard_id" value="{{ $dashboard->id }}">
    @endif
</x-form>

<x-form method="DELETE" :action="['campaign_dashboard_widgets.destroy', $campaign, $model]" id="delete-form-widget-{{ $model->id }}" />


