@extends('layouts.app', [
    'title' => trans($name . '.create.title', ['name' => $model->name]),
    'description' => trans($name . '.create.description'),
    'breadcrumbs' => [
        ['url' => route($parent . '.index'), 'label' => trans($parent . '.index.title')],
        ['url' => route($parent . '.show', $model->id), 'label' => $model->name]
    ]
])

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    @include('partials.errors')

                    {!! Form::open(array('route' => [$route . '.store', $model->id], 'method'=>'POST')) !!}
                    @include($name . '._form')
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
