@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => trans('dashboard.dashboards.update.title', ['name' => $dashboard->name]),
    'description' => '',
    'breadcrumbs' => []
])

@section('content')
    {!! Form::model($dashboard, ['route' => ['campaign_dashboards.update', [$campaign, $dashboard]], 'method' => 'PATCH', 'data-shortcut' => 1]) !!}
    @include('partials.forms.form', [
        'title' => __('dashboard.dashboards.update.title', ['name' => $dashboard->name]),
        'content' => 'dashboard.dashboards._form',
    ])
    {!! Form::close() !!}
@endsection
