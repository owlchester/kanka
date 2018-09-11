@extends('layouts.app', [
    'title' => trans('dashboard.settings.title'),
    'description' => trans('dashboard.settings.description'),
    'breadcrumbs' => [
        trans('dashboard.settings.title'),
        trans('crud.edit'),
    ]
])

@section('content')
    <div class="panel panel-default">
        <div class="panel-body">
            @include('partials.errors')

            {!! Form::model(Auth::user()->dashboardSetting, ['method' => 'PATCH', 'route' => ['dashboard.settings.update']]) !!}
            @include('dashboard.settings._form')
            {!! Form::close() !!}
        </div>
    </div>
@endsection
