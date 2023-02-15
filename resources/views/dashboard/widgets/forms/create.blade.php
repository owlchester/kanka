@include('partials.errors')



{!! Form::open([
    'route' => ['campaign_dashboard_widgets.store', [$campaign]],
    'method'=>'POST',
    'data-shortcut' => '1'
]) !!}

@include('partials.forms.form', [
    'title' => __('dashboard.setup.actions.new', ['type' => __('dashboard.setup.widgets.' . $widget)]),
    'content' => 'dashboard.widgets.forms._' . $widget,
    'submit' =>  __('crud.add')
])
<input type="hidden" name="widget" value="{{ $widget }}">
@if(empty($dashboards) && !empty($dashboard))
    <input type="hidden" name="dashboard_id" value="{{ $dashboard->id }}">
@endif
{!! Form::close() !!}
