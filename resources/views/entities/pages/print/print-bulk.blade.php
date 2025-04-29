<?php /** @var \App\Models\MiscModel $model */?>

@php
    $headerImage = true;
@endphp

@extends('layouts.print', [
    'title' => __('Print'),
    'breadcrumbs' => false,
    'canonical' => true,
    'mainTitle' => false,
    'bodyClass' => 'entity-story'
])





@section('content')

    <button class="btn2 btn-lg btn-print fixed top-5 right-5" onclick="javascript:window.print();">
        <x-icon class="fa-regular fa-print" />
        {{ __('crud.actions.print') }}
    </button>

    @foreach ($entities as $model)
        @php
        if ($model instanceof \App\Models\Entity) {
            $entity = $model;
        } else {
            $entity = $model->entity;
        }
            $name = $entity->entityType->pluralCode()
        @endphp

        @if(view()->exists($entity->entityType->pluralCode() . '.show'))
            @include($entity->entityType->pluralCode() . '.show')
        @else
            @include('cruds.overview')
        @endif
        @includeIf('entities.pages.profile._' . $entity->entityType->code)
        @includeIf($entity->entityType->pluralCode() . '._print')
        @includeWhen($entity->abilities->count() > 0, 'entities.pages.print._abilities')
        @includeWhen($entity->inventories->count() > 0, 'entities.pages.print._inventory')
        @includeWhen($entity->relationships->count() > 0, 'entities.pages.print._relations')
        @includeWhen($entity->attributes->count() > 0 && !$entity->isAttributeTemplate(), 'entities.pages.print._attributes')
        <div class="pagebreak"></div>
    @endforeach



@endsection



@section('styles')
    @parent
@endsection
