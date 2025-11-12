<?php /** @var \App\Models\MiscModel $model */?>


@php
$headerImage = true;
@endphp

@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => $entity->name . ' - ' . $entity->entityType->plural(),
    'breadcrumbs' => false,
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

    @if(view()->exists($entity->entityType->pluralCode() . '.show'))
        @include($entity->entityType->pluralCode() . '.show')
    @else
        @include('cruds.overview')
    @endif
@endsection
