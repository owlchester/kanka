@extends('layouts.app', [
    'title' => trans('campaigns.create.title'),
    'description' => trans('campaigns.create.description'),
    'breadcrumbs' => [
        ['url' => route('campaigns.index'), 'label' => trans('campaigns.index.title')],
        trans('crud.create')
    ]
])

@section('header-extra')
    {!! Form::open([
        'route' => ($start ? 'start' : 'campaigns.store'),
        'enctype' => 'multipart/form-data',
        'method' => 'POST',
        'data-shortcut' => '1'
    ]) !!}

    <div class="pull-right">
        @include('cruds.fields.save', ['onlySave' => 'true', 'disableCancel' => true, 'target' => 'entity-form'])
    </div>
@endsection

@section('content')
    @include('partials.errors')
    @include('campaigns.forms.' . ($start ? 'start' : 'standard'))
    {!! Form::close() !!}
@endsection

@include('editors.editor')
