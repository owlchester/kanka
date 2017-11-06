@extends('layouts.app', [
    'title' => trans('profiles.title'),
    'description' => trans('profiles.description'),
    'breadcrumbs' => [
        trans('profiles.title'),
        trans('crud.edit'),
    ]
])

@section('content')
    <div class="row">
        <div class="col-md-12 col-md-offset">
            <div class="panel panel-default">
                <div class="panel-body">
                    @include('partials.errors')

                    {!! Form::model($user, ['method' => 'PATCH', 'enctype' => 'multipart/form-data', 'route' => ['profile.update']]) !!}
                        @include('profiles._form')
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
