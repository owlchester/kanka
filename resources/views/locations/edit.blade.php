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
                <div class="panel-heading">Edit {{ $location->name }}</div>

                <div class="panel-body">
                    @if (count($errors) > 0)
                        <div class="alert alert-danger">
                        <strong>Whoops!</strong> There were some problems with your input.<br>
                        <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                        </ul>
                    </div>
                    @endif

                    {!! Form::model($location, ['method' => 'PATCH', 'enctype' => 'multipart/form-data', 'route' => ['locations.update', $location->id]]) !!}
                        @include('locations._form')
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
