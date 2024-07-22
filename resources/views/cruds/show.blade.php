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

@include('entities.components.og')

@section('entity-header-actions')
    <div class="header-buttons flex flex-wrap gap-2 items-center justify-end">
        @include('entities.headers.toggle')
        @can('post', [$model, 'add'])
            <a href="{{ route('entities.posts.create', [$campaign, $entity]) }}" class="btn2 btn-sm btn-new-post"
               data-entity-type="post" data-toggle="tooltip" data-title="{{ __('crud.tooltips.new_post') }}">
                <x-icon class="plus"></x-icon> {{ __('crud.actions.new_post') }}
            </a>
        @endcan
        @can('update', $model)
            <a href="{{ $model->getLink('edit') }}" class="btn2 btn-primary btn-sm ">
                <x-icon class="pencil"></x-icon> {{ __('crud.edit') }}
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
