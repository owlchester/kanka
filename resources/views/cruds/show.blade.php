<?php /** @var \App\Models\MiscModel $model */?>

@php
$headerImage = true;
@endphp

@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => $model->name . ' - ' . \App\Facades\Module::plural($model->entityTypeId(), __('entities.' . $name)),
    'breadcrumbs' => false,
    'miscModel' => $model,
    'canonical' => true,
    'mainTitle' => false,
    'bodyClass' => 'entity-story',
])

@section('og')
@if ($tooltip = $model->entity->mappedPreview())<meta property="og:description" content="{{ $tooltip }}" />@endif
@if ($model->image)<meta property="og:image" content="{{ $model->thumbnail(200)  }}" />@endif
    <meta property="og:url" content="{{ $model->getLink()  }}" />
    <meta name="twitter:card" content="summary_large_image" />
@endsection


@section('entity-header-actions')
    <div class="header-buttons inline-block flex flex-wrap gap-2 items-center justify-end">
        @include('entities.headers.toggle')
        @can('update', $model)
            <a href="{{ $model->getLink('edit') }}" class="btn2 btn-primary btn-sm ">
                <x-icon class="pencil"></x-icon> {{ __('crud.edit') }}
            </a>
        @endcan
        @can('post', [$model, 'add'])
        <a href="{{ route('entities.posts.create', [$campaign, $model->entity]) }}" class="btn2 btn-accent btn-sm btn-new-post"
           data-entity-type="post" data-toggle="tooltip" title="{{ __('crud.tooltips.new_post') }}">
            <x-icon class="plus"></x-icon> {{ __('crud.actions.new_post') }}
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
