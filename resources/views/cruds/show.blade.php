<?php /** @var \App\Models\MiscModel $model */?>

@inject('campaign', 'App\Services\CampaignService')
@php
$headerImage = true;
@endphp

@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
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
                <i class="fa-solid fa-grip-lines"></i>
            </div>
            <div class="btn btn-default btn-sm btn-post-expand" title="{{ __('entities/story.actions.expand_all') }}" data-toggle="tooltip">
                <i class="fa-solid fa-bars"></i>
            </div>
        </div>
        @can('update', $model)
            <a href="{{ $model->getLink('edit') }}" class="btn btn-primary btn-sm ">
                <i class="fa-solid fa-pencil"></i> {{ __('crud.edit') }}
            </a>
        @endcan
        @can('entity-note', [$model, 'add'])
        <a href="{{ route('entities.entity_notes.create', $model->entity) }}" class="btn btn-warning btn-sm"
           data-toggle="tooltip" title="{{ __('crud.tooltips.new_post') }}">
            <i class="fa-solid fa-plus"></i> {{ __('crud.actions.new_post') }}
        </a>
        @endcan
    </div>
@endsection



@section('content')

    @include('partials.ads.top')
    @if(view()->exists($name . '.show'))
        @include($name . '.show')
    @else
        @include('cruds.overview')
    @endif
@endsection
