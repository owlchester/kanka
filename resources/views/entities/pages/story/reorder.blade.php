<?php /**
 * @var \App\Models\Entity $entity
 * @var \App\Models\EntityNote[]|\Illuminate\Support\Collection $notes
 * @var \App\Models\EntityNote $first
 */
?>
@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => __('entities/story.reorder.title', ['name' => $entity->name]),
    'description' => '',
    'breadcrumbs' => false,
    'mainTitle' => false,
    'miscModel' => $entity->child,
    'bodyClass' => 'entity-story-reorder'
])
@inject('campaign', 'App\Services\CampaignService')


@section('content')
    @include('partials.errors')

    <div class="entity-grid">
        @include('entities.components.header_grid', [
            'model' => $entity->child,
            'entity' => $entity,
            'breadcrumb' => [
                ['url' => Breadcrumb::index($entity->pluralType()), 'label' => __($entity->pluralType() . '.index.title')],
                __('entities/story.reorder.panel_title')
            ]
        ])

        @include($entity->pluralType() . '._menu', [
            'active' => 'story',
            'model' => $entity->child,
            'name' => $entity->pluralType()
        ])

        <div class="entity-main-block">
            @include('entities.pages.story._reorder')
        </div>
    </div>
@endsection



@section('styles')
    @parent
    <link href="{{ mix('css/story.css') }}" rel="stylesheet">
@endsection

@section('scripts')
    @parent
    <script src="{{ mix('js/story.js') }}" defer></script>
@endsection
