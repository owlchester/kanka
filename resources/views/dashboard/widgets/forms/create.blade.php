
@php $mode = 'create'; @endphp
<x-form :action="['campaign_dashboard_widgets.store', $campaign]">
    @include('partials.forms._dialog', [
        'title' => __('dashboard.widgets.create.title'),
        'subtitle' => __('dashboards/widgets/' . $widget . '.name'),
        'icon' => '<div class="w-10 h-10 flex items-center justify-center rounded-lg ' . $widgetClass->setupClass() . '"><i class="' . $widgetClass->widgetIcon() . ' text-lg" aria-hidden="true"></i></div>',
        'content' => 'dashboard.widgets.forms._' . $widget,
    ])

    <input type="hidden" name="widget" value="{{ $widget }}">
    @if(empty($dashboards) && !empty($dashboard))
        <input type="hidden" name="dashboard_id" value="{{ $dashboard->id }}">
    @endif
</x-form>
