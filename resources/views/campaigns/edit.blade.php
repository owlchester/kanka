@extends('layouts.app', [
    'title' => trans('campaigns.edit.title', ['campaign' => $model->name]),
    'breadcrumbs' => [
        ['url' => route('campaign'), 'label' => __('entities.campaign')],
        trans('crud.edit')
    ],
    'canonical' => true,
])

@inject('campaignService', 'App\Services\CampaignService')

@section('fullpage-form')
    {!! Form::model($model, [
        'method' => 'PATCH',
        'enctype' => 'multipart/form-data',
        'route' => ['campaigns.update'],
        'data-shortcut' => '1',
        'class' => 'entity-form',
        'data-unload' => 1,
    ]) !!}
@endsection

@section('content')
    @include('partials.errors')
    @include('campaigns.forms.' . ($start ? 'start' : 'standard'))

    @if(!empty($model) && $campaignService->campaign()->hasEditingWarning())
        <input type="hidden" id="editing-keep-alive" data-url="{{ route('campaigns.keep-alive', $model->id) }}" />
    @endif
@endsection


@section('fullpage-form-end')
    {!! Form::close() !!}
@endsection

@inject('campaignService', 'App\Services\CampaignService')
@include('editors.editor')

@section('modals')
    @parent
    @includeWhen(!empty($editingUsers) && !empty($model), 'cruds.forms.edit_warning', ['model' => $model])
@endsection
