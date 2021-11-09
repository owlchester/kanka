<?php /** @var \App\Models\MiscModel $model */?>

@inject('campaign', 'App\Services\CampaignService')
@php
$headerImage = true;
@endphp

@extends('layouts.' . ($ajax ? 'ajax' : 'app'), [
    'title' => $model->name . ' - ' . __('entities.' . $name),
    'breadcrumbs' => false,
    'miscModel' => $model,
    'canonical' => true,
    'mainTitle' => false,
    'bodyClass' => 'entity-story',
])

@section('og')
    <meta property="og:description" content="{{ $model->tooltip() ?: trans($name . '.show.title', ['name' => $model->name]) }}" />
    @if ($model->image)<meta property="og:image" content="{{ $model->getImageUrl(0)  }}" />@endif

    <meta property="og:url" content="{{ $model->getLink()  }}" />
@endsection


@section('entity-header-actions')
    <div class="header-buttons">
        <div class="btn-group">
            <div class="btn btn-default btn-sm btn-post-collapse" title="{{ __('entities/story.actions.collapse_all') }}" data-toggle="tooltip">
                <i class="fas fa-grip-lines"></i>
            </div>
            <div class="btn btn-default btn-sm btn-post-expand" title="{{ __('entities/story.actions.expand_all') }}" data-toggle="tooltip">
                <i class="fas fa-bars"></i>
            </div>
        </div>
        @can('update', $model)
            <a href="{{ $model->getLink('edit') }}" class="btn btn-primary btn-sm ">
                <i class="fa fa-pencil"></i> {{ __('crud.edit') }}
            </a>
        @endcan
        @can('entity-note', [$model, 'add'])
        <a href="{{ route('entities.entity_notes.create', $model->entity) }}" class="btn btn-warning btn-sm ">
            <i class="fa fa-plus"></i> {{ __('crud.actions.new_post') }}
        </a>
        @endcan
    </div>
@endsection



@section('content')
    @if(view()->exists($name . '.show'))
        @include($name . '.show')
    @else
        <div class="entity-grid">

            @include('entities.components.header_grid', [
                'model' => $model,
                'breadcrumb' => [
                    ['url' => Breadcrumb::index($name), 'label' => __($name . '.index.title')],
                    null
                ]
            ])

            @include($name . '._menu', ['active' => 'story'])

            <div class="entity-story-block">

                @include('entities.components.notes', ['withEntry' => true])

                @include('cruds.partials.mentions')
                @include('cruds.boxes.history')
            </div>

            <div class="entity-sidebar">
                @include('entities.components.pins')
            </div>
        </div>

    @endif
@endsection
