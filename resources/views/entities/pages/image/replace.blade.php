<?php /** @var \App\Models\Entity $entity */ ?>
@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => trans('entities/image.replace.title', ['name' => $entity->name]),
    'description' => '',
    'breadcrumbs' => [
        Breadcrumb::entity($entity)->list(),
        Breadcrumb::show(),
        __('entities/image.replace.breadcrumb')
    ],
    'mainTitle' => false,
    'miscModel' => $model,
    'bodyClass' => 'entity-image-replace'
])


@section('content')
    <div class="modal-header">
        <x-dialog.close :modal="true" />
        <h4 class="modal-title" id="myModalLabel">
            {{ __('entities/image.replace.panel_title') }}
        </h4>
    </div>
    <div class="modal-header">

        {!! Form::open([
            'route' => ['entities.image.replace', $campaign, $entity],
            'method' => 'POST',
            'enctype' => 'multipart/form-data',
        ]) !!}

        @include('cruds.fields.image', ['imageRequired' => false, 'model' => $model])

        @includeWhen($campaign->boosted(), 'cruds.fields.entity_image')

        <x-dialog.footer :modal="true">
            <button type="submit" class="btn2 btn-primary">
                {{ __('entities/image.actions.save-replace') }}
            </button>
        </x-dialog.footer>

        {!! Form::close() !!}
    </div>
@endsection
