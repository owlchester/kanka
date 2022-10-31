@extends('layouts.app', [
    'title' => trans('campaigns.edit.title', ['campaign' => $model->name]),
    'breadcrumbs' => [
        ['url' => route('campaigns.index'), 'label' => __('entities.campaign')],
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

@inject('campaignService', 'App\Services\CampaignService')
@include('editors.editor')

