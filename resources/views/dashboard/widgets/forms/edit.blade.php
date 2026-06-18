@include('partials.errors')

<x-form :action="['campaign_dashboard_widgets.update', $campaign, $model]" method="PATCH">
    @include('partials.forms._dialog', [
        'mode' => 'edit',
        'title' => __('dashboard.widgets.edit.title'),
        'subtitle' => __('dashboards/widgets/' . $model->widget->value . '.name'),
        'icon' => '<div class="w-10 h-10 flex items-center justify-center rounded-lg ' . $model->setupClass() . '"><i class="' . $model->widgetIcon() . ' text-lg" aria-hidden="true"></i></div>',
        'content' => 'dashboard.widgets.forms._' . $widget,
        'deleteID' => '#delete-form-widget-' . $model->id,
    ])
    <input type="hidden" name="widget" value="{{ $widget }}">
    @if(empty($dashboards) && !empty($dashboard))
        <input type="hidden" name="dashboard_id" value="{{ $dashboard->id }}">
    @endif
</x-form>

<x-form method="DELETE" :action="['campaign_dashboard_widgets.destroy', $campaign, $model]"
        id="delete-form-widget-{{ $model->id }}"/>


