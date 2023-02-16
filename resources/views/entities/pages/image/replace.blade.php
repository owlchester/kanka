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



@section('content')
    @include('partials.errors')
        <div class="modal-header">
            @if(request()->ajax())
            <button type="button" class="close" data-dismiss="modal" aria-label="{{ __('crud.click_modal.close') }}"><span aria-hidden="true">&times;</span></button>
            @endif

            <h3 class="modal-title">
                {{ __('entities/image.replace.panel_title') }}
            </h3>
        </div>
        <div class="modal-body">
            {!! Form::open([
                'route' => ['entities.image.replace', [$campaign, $entity]],
                'method' => 'POST',
                'enctype' => 'multipart/form-data',
            ]) !!}

            @include('cruds.fields.image', ['imageRequired' => false, 'model' => $model])

            @includeWhen($campaign->boosted(), 'cruds.fields.entity_image')

        </div>
        <div class="modal-footer">
            <input type="submit" class="btn btn-block btn-primary" value="{{ __('entities/image.actions.save-replace') }}" />
        </div>
    {!! Form::close() !!}
@endsection
