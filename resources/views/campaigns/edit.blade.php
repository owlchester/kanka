@extends('layouts.app', [
    'title' => trans('campaigns.edit.title', ['campaign' => $model->name]),
    'description' => trans('campaigns.edit.description'),
    'breadcrumbs' => [
        ['url' => route('campaigns.index'), 'label' => trans('campaigns.index.title')],
        ['url' => route('campaigns.show', $model->id), 'label' => $model->name],
        trans('crud.create')
    ]
])


@section('header-extra')
    {!! Form::model($model, [
        'method' => 'PATCH',
        'enctype' => 'multipart/form-data',
        'route' => ['campaigns.update', $model->id],
        'data-shortcut' => '1'
    ]) !!}

    <div class="pull-right">
        @include('cruds.fields.save', ['onlySave' => true, 'disableCancel' => true, 'target' => 'entity-form'])
    </div>
@endsection

@section('content')
    @include('partials.errors')
    @include('campaigns.forms.' . ($start ? 'start' : 'standard'))
    {!! Form::close() !!}
@endsection

@include('editors.editor')