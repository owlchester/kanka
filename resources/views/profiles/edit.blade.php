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
                <div class="panel-heading">Edit your profile</div>

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

                    {!! Form::model($user, ['method' => 'PATCH', 'enctype' => 'multipart/form-data', 'route' => ['profile.update']]) !!}
                        @include('profiles._form')
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
