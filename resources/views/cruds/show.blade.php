<?php /** @var \App\Models\MiscModel $model */?>

@inject('campaign', 'App\Services\CampaignService')
@php
$headerImage = true;
@endphp

@extends('layouts.' . ($ajax ? 'ajax' : 'app'), [
    'title' => __($name . '.show.title', ['name' => $model->name]),
    'breadcrumbs' => [
        ['url' => Breadcrumb::index($name), 'label' => __($name . '.index.title')],
        $model->name,
    ],
    'miscModel' => $model,
    'canonical' => true,
    'mainTitle' => false,
])

@section('og')
    <meta property="og:description" content="{{ $model->tooltip() ?: trans($name . '.show.title', ['name' => $model->name]) }}" />
    @if ($model->image)<meta property="og:image" content="{{ $model->getImageUrl(0)  }}" />@endif

    <meta property="og:url" content="{{ $model->getLink()  }}" />
@endsection

@section('entity-header-actions')
    <div class="pull-right">
    <a href="{{ route('entities.entity_notes.create', $model->entity) }}" class="btn btn-primary">
        <i class="fa fa-plus"></i> {{ __('crud.actions.new_post') }}
    </a>
    </div>
@endsection

@include('entities.components.header', ['model' => $model])


@section('content')
    @include($name . '.show')
@endsection
