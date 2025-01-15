<?php /**
 * @var \App\Models\Entity $entity
 */?>

@php
    $headerImage = true;
@endphp

@extends('layouts.print', [
    'title' => $entity->name . ' - ' . $entity->entityType->plural(),
    'breadcrumbs' => false,
    'canonical' => true,
    'mainTitle' => false,
    'bodyClass' => 'entity-story'
])

@section('content')

    <button class="btn2 btn-lg btn-print fixed top-5 right-5" onclick="javascript:window.print();">
        <i class="fa-solid fa-print" aria-hidden="true"></i>
        {{ __('crud.actions.print') }}
    </button>

    @if(view()->exists($name . '.show'))
        @include($name . '.show')
    @else
        @include('cruds.overview')
    @endif
    @includeIf('entities.pages.profile._' . $entity->entityType->code)
    @includeIf($name . '._print')
    @includeWhen($entity->abilities->count() > 0, 'entities.pages.print._abilities')
    @includeWhen($entity->inventories->count() > 0, 'entities.pages.print._inventory')
    @includeWhen($entity->relationships->count() > 0, 'entities.pages.print._relations')
    @includeWhen($entity->attributes->count() > 0 && !$entity->isAttributeTemplate(), 'entities.pages.print._attributes')

@endsection



@section('styles')
    @parent
@endsection
