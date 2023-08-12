<?php /** @var \App\Models\Entity $entity
 * @var \App\Models\Ability $ability */?>
@extends('layouts.app', [
    'title' => __('entities/abilities.show.title', ['name' => $entity->name]),
    'breadcrumbs' => false,
    'mainTitle' => false,
    'miscModel' => $entity->child,
    'bodyClass' => 'entity-abilities'
])


@section('content')
    @include('partials.errors')
    @include('partials.ads.top')
    <div class="entity-grid">
        @include('entities.components.header', [
            'model' => $entity->child,
            'entity' => $entity,
            'breadcrumb' => [
                ['url' => Breadcrumb::index($entity->pluralType()), 'label' => __('entities.' . $entity->pluralType())],
                __('crud.tabs.abilities'),
                __('entities/abilities.show.reorder')
            ]
        ])

        @include('entities.components.menu_v2', [
            'active' => 'abilities',
            'model' => $entity->child,
        ])

        <div class="entity-main-block">
            @includeWhen(!empty($parents), 'entities.pages.abilities.reorder._reorder')
        </div>
    </div>
@endsection
