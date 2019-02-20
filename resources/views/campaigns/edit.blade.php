@extends('layouts.app', [
    'title' => trans('campaigns.edit.title', ['campaign' => $model->name]),
    'description' => trans('campaigns.edit.description'),
    'breadcrumbs' => [
        ['url' => route('campaigns.index'), 'label' => trans('campaigns.index.title')],
        ['url' => route('campaigns.show', $model->id), 'label' => $model->name],
        trans('crud.create')
    ]
])

@section('content')
    @include('partials.errors')

    {!! Form::model($model, [
        'method' => 'PATCH',
        'enctype' => 'multipart/form-data',
        'route' => ['campaigns.update', $model->id],
        'data-shortcut' => '1'
    ]) !!}
        @include('campaigns._form')
    {!! Form::close() !!}
@endsection

@include('editors.editor')