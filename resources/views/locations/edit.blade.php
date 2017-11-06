@extends('layouts.app', [
    'title' => trans('locations.show.title', ['location' => $location->name]),
    'description' => trans('locations.show.description'),
    'breadcrumbs' => [
        ['url' => route('locations.index'), 'label' => trans('locations.index.title')],
        ['url' => route('locations.show', $location->id), 'label' => $location->name],
        trans('crud.update'),
    ]
])
@section('content')
    <div class="row">
        <div class="col-md-12 col-md-offset">
            <div class="panel panel-default">
                <div class="panel-body">
                    @include('partials.errors')

                    {!! Form::model($location, ['method' => 'PATCH', 'enctype' => 'multipart/form-data', 'route' => ['locations.update', $location->id]]) !!}
                        @include('locations._form')
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
