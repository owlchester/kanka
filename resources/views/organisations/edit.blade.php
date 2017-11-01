@extends('layouts.app', [
    'title' => trans('organisations.show.title', ['organisation' => $organisation->name]),
    'description' => trans('organisations.show.description'),
    'breadcrumbs' => [
        ['url' => route('organisations.index'), 'label' => trans('organisations.index.title')],
        ['url' => route('organisations.show', $organisation->id), 'label' => $organisation->name],
        trans('crud.update'),
    ]
])
@section('content')
    <div class="row">
        <div class="col-md-12 col-md-offset">
            <div class="panel panel-default">
                <div class="panel-heading">Edit {{ $organisation->name }}</div>

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

                    {!! Form::model($organisation, ['method' => 'PATCH', 'enctype' => 'multipart/form-data', 'route' => ['organisations.update', $organisation->id]]) !!}
                        @include('organisations._form')
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
