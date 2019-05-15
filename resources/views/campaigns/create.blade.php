@extends('layouts.app', [
    'title' => trans('campaigns.create.title'),
    'description' => trans('campaigns.create.description'),
    'breadcrumbs' => [
        ['url' => route('campaigns.index'), 'label' => trans('campaigns.index.title')],
        trans('crud.create')
    ]
])

@section('fullpage-form')
    {!! Form::open([
        'route' => ($start ? 'start' : 'campaigns.store'),
        'enctype' => 'multipart/form-data',
        'method' => 'POST',
        'data-shortcut' => '1'
    ]) !!}
@endsection

@section('header-extra')
    @if (!$start)
    <div class="pull-right">
        @include('cruds.fields.save', ['onlySave' => 'true', 'disableCancel' => true, 'target' => 'entity-form'])
    </div>
    @endif
@endsection

@section('content')
    @include('partials.errors')
    @include('campaigns.forms.' . ($start ? 'start' : 'standard'))
@endsection

@section('fullpage-form-end')
    {!! Form::close() !!}
@endsection

@include('editors.editor')
