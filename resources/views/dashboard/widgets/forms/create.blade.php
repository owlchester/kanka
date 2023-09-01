{!! Form::open([
    'route' => ['campaign_dashboard_widgets.store', $campaign],
    'method'=>'POST',
    'data-shortcut' => '1',
]) !!}

@php $mode = 'create'; @endphp
@include('partials.forms.form', [
    'dialog' => true,
    'title' => __('dashboard.setup.actions.add'),
    'content' => 'dashboard.widgets.forms._' . $widget,
])

<input type="hidden" name="widget" value="{{ $widget }}">
@if(empty($dashboards) && !empty($dashboard))
    <input type="hidden" name="dashboard_id" value="{{ $dashboard->id }}">
@endif
{!! Form::close() !!}
