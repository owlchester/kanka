<?php /** @var \App\Models\Entity $entity */ ?>
@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => trans('entities/image.replace.title', ['name' => $entity->name]),
    'description' => '',
    'breadcrumbs' => [
        ['url' => $entity->url('index'), 'label' => __($entity->pluralType() . '.index.title')],
        ['url' => $entity->url('show'), 'label' => $entity->name],
        __('entities/image.replace.breadcrumb')
    ],
    'mainTitle' => false,
    'miscModel' => $model,
    'bodyClass' => 'entity-image-replace'
])
@inject('campaign', 'App\Services\CampaignService')


@section('content')
    @include('partials.errors')
    <div class="box box-solid">
        <div class="box-header with-border">
            <h3 class="box-title">
                {{ __('entities/image.replace.panel_title') }}
            </h3>
            @if(request()->ajax())
                <div class="box-tools">
                    <button type="button" class="close" data-dismiss="modal" aria-label="{{ __('crud.delete_modal.close') }}">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
        </div>
        <div class="box-body">
            {!! Form::open([
                'route' => ['entities.image.replace', $entity],
                'method' => 'POST',
                'enctype' => 'multipart/form-data',
            ]) !!}

            @include('cruds.fields.image', ['imageRequired' => false, 'model' => $model])

            @includeWhen($campaign->campaign()->boosted(), 'cruds.fields.entity_image')

            <input type="submit" class="btn btn-block btn-primary" value="{{ __('entities/image.actions.save-replace') }}" />

            {!! Form::close() !!}
        </div>
    </div>
@endsection
