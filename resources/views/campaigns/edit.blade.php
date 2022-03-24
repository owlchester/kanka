@extends('layouts.app', [
    'title' => trans('campaigns.edit.title', ['campaign' => $model->name]),
    'description' => '',
    'breadcrumbs' => [
        ['url' => route('campaigns.index'), 'label' => trans('campaigns.index.title')],
        trans('crud.edit')
    ],
    'canonical' => true,
])

@section('fullpage-form')
    {!! Form::model($model, [
        'method' => 'PATCH',
        'enctype' => 'multipart/form-data',
        'route' => ['campaigns.update', $model->id],
        'data-shortcut' => '1',
        'class' => 'entity-form',
    ]) !!}
@endsection

@section('content')
    @include('partials.errors')
    @include('campaigns.forms.' . ($start ? 'start' : 'standard'))
@endsection


@section('fullpage-form-end')
    {!! Form::close() !!}
@endsection

@inject('campaign', 'App\Services\CampaignService')
@include('editors.editor')

