<?php /** @var \App\Models\Entity $entity
 * @var \App\Models\Inventory $item */?>
@extends('layouts.widget', [
    'title' => __('entities/attributes.show.title', ['name' => $entity->name]),
    'description' => '',
    'breadcrumbs' => false,
    'mainTitle' => false,
    'bodyClass' => 'entity-attributes'
])



@section('content')
    <div class="entity-main-block flex flex-col gap-4">
        @include('entities.pages.attributes.render')
    </div>
@endsection


@section('scripts')
    @parent
    @vite('resources/js/attributes.js')
@endsection

@section('styles')
    @parent
    <style>
        dl { display: flex; flex-wrap: wrap; width: 100%; gap: 0.25rem; }
        dt { flex: 25% 0; text-align: right; font-weight: 900; overflow: hidden; margin-right: 2%;
            text-overflow: ellipsis;
            white-space: nowrap; }
        dd { flex: 0 70% }
        @media (min-width: 768px) {
            dl { display: unset;}
        }
    </style>
@endsection

