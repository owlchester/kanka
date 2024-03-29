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
    @include('entities.pages.subpage', [
        'active' => 'abilities',
        'breadcrumb' => __('entities.abilities'),
        'view' => 'entities.pages.abilities.reorder._reorder',
        'entity' => $entity,
        'model' => $entity->child,
    ])
@endsection
