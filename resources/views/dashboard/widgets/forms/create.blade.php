
@php $mode = 'create'; @endphp
<x-form :action="['campaign_dashboard_widgets.store', $campaign]">
    @include('partials.forms.form', [
        'dialog' => true,
        'title' => __('dashboard.widgets.create.title'),
        'content' => 'dashboard.widgets.forms._' . $widget,
    ])

    <input type="hidden" name="widget" value="{{ $widget }}">
    @if(empty($dashboards) && !empty($dashboard))
        <input type="hidden" name="dashboard_id" value="{{ $dashboard->id }}">
    @endif
</x-form>
