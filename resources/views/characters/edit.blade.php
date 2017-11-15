@extends('layouts.app', [
    'title' => trans('characters.edit.title', ['character' => $model->name]),
    'description' => trans('characters.edit.description'),
    'breadcrumbs' => [
        ['url' => route('characters.index'), 'label' => trans('characters.index.title')],
        ['url' => route('characters.show', $model->id), 'label' => $model->name],
        trans('crud.update'),
    ]
])

@section('content')
    <div class="row">
        <div class="col-md-12">
            @include('partials.errors')

            {!! Form::model($model, ['method' => 'PATCH', 'enctype' => 'multipart/form-data', 'route' => ['characters.update', $model->id]]) !!}
                @include('characters._form')
            {!! Form::close() !!}
        </div>

    </div>
@endsection
