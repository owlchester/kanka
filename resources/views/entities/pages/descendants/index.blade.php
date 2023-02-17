@extends('layouts.app', [
    'title' => __('entities/descendants.title', ['name' => $entity->name]),
    'breadcrumbs' => false,
    'canonical' => true,
    'mainTitle' => false,
    'miscModel' => $entity->child,
])


@section('content')
    @include('partials.errors')

    <div class="entity-grid">
        @include('entities.components.header', [
            'model' => $entity->child,
            'entity' => $entity,
            'breadcrumb' => [
                ['url' => Breadcrumb::index($entity->pluralType()), 'label' => __('entities.' . $entity->pluralType())],
                __('entities.' . $entity->pluralType())
            ]
        ])

        @include($entity->pluralType() . '._menu', [
            'active' => $entity->pluralType(),
            'model' => $entity->child,
            'name' => $entity->pluralType()
        ])

        <div class="entity-main-block">
            @include('entities.pages.descendants._descendants')
        </div>
    </div>
@endsection
