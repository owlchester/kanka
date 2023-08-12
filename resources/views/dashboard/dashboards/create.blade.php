@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => trans('dashboard.dashboards.create.title'),
    'description' => '',
    'breadcrumbs' => []
])

@section('content')

    {!! Form::open(['route' => ['campaign_dashboards.store', $campaign], 'method' => 'POST', 'data-shortcut' => 1]) !!}
    @include('partials.forms.form', [
        'dialog' => true,
        'title' => __('dashboard.dashboards.create.title'),
        'content' => 'dashboard.dashboards._form',
    ])
    {!! Form::close() !!}
@endsection
