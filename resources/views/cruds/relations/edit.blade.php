@extends('layouts.app', [
    'title' => trans($name . '.create.title', ['name' => $model->name]),
    'description' => trans($name . '.create.description'),
    'breadcrumbs' => [
        ['url' => route($parent . '.index'), 'label' => trans($parent . '.index.title')],
        ['url' => route($parent . '.show', $model->id), 'label' => $model->name],
        trans('crud.update'),
    ]
])
@section('content')
    <div class="row">
        <div class="col-md-12 col-md-offset">
            <div class="panel panel-default">
                <div class="panel-body">
                    @include('partials.errors')

                    {!! Form::model($relation, ['method' => 'PATCH', 'route' => [$route . '.update', $model->id, $relation->id]]) !!}
                    @include($name . '._form')
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
