<?php /** @var \App\Models\Entity $entity
 * @var \App\Models\Ability $ability */?>
@extends('layouts.app', [
    'title' => __('entities/abilities.show.title', ['name' => $entity->name]),
    'breadcrumbs' => false,
    'mainTitle' => false,
    'bodyClass' => 'entity-abilities'
])

@section('content')
    @include('entities.pages.subpage', [
        'active' => 'abilities',
        'view' => 'entities.pages.abilities.reorder._reorder',
        'entity' => $entity,
    ])
@endsection
