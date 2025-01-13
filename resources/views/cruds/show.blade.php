<?php /** @var \App\Models\MiscModel $model */?>


@php
$headerImage = true;
@endphp

@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => $entity->name . ' - ' . $entity->entityType->plural(),
    'breadcrumbs' => false,
    'miscModel' => $entity->entityType->isSpecial() ? $entity : $entity->child,
    'canonical' => true,
    'mainTitle' => false,
    'bodyClass' => 'entity-story',
])

@include('entities.components.og')

@section('entity-header-actions')
    <div class="header-buttons flex flex-wrap gap-2 items-center justify-end">
        @include('entities.headers.toggle')
        @include('entities.headers.actions')
    </div>
@endsection



@section('content')

    @include('ads.top')
    @if(view()->exists($name . '.show'))
        @include($name . '.show')
    @else
        @include('cruds.overview')
    @endif
@endsection
