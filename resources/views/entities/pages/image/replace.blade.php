<?php /** @var \App\Models\Entity $entity */ ?>
@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => trans('entities/image.replace.title', ['name' => $entity->name]),
    'description' => '',
    'breadcrumbs' => [
        ['url' => $entity->url('index'), 'label' => __('entities.' . $entity->pluralType())],
        ['url' => $entity->url('show'), 'label' => $entity->name],
        __('entities/image.replace.breadcrumb')
    ],
    'mainTitle' => false,
    'miscModel' => $model,
    'bodyClass' => 'entity-image-replace'
])
@inject('campaignService', 'App\Services\CampaignService')


@section('content')
    <div class="modal-header">
        <x-dialog.close />
        <h4 class="modal-title" id="myModalLabel">
            {{ __('entities/image.replace.panel_title') }}
        </h4>
    </div>
    <div class="modal-header">

        {!! Form::open([
            'route' => ['entities.image.replace', $entity],
            'method' => 'POST',
            'enctype' => 'multipart/form-data',
        ]) !!}

        @include('cruds.fields.image', ['imageRequired' => false, 'model' => $model])

        @includeWhen($campaignService->campaign()->boosted(), 'cruds.fields.entity_image')

        <input type="submit" class="btn btn-block btn-primary" value="{{ __('entities/image.actions.save-replace') }}" />

        {!! Form::close() !!}
    </div>
@endsection
