<?php /** @var \App\Models\Entity $entity
 * @var \App\Models\EntityFile $asset */
$assetCount = 0; ?>
@extends('layouts.app', [
    'title' => __('entities/assets.show.title', ['name' => $entity->name]),
    'breadcrumbs' => [
        ['url' => $entity->url('index'), 'label' => __($entity->pluralType() . '.index.title')],
        ['url' => $entity->url('show'), 'label' => $entity->name],
        __('crud.tabs.assets')
    ],
    'mainTitle' => false,
    'miscModel' => $entity->child,
])
@inject('campaign', 'App\Services\CampaignService')

@section('content')
    @include('partials.errors')
    <div class="row">
        <div class="col-md-3">
            @include($entity->pluralType() . '._menu', ['active' => 'assets', 'model' => $entity->child, 'name' => $entity->pluralType()])
        </div>
        <div class="col-md-9">
        @can('update', $entity->child)
            <div class="text-right">
                <a href="#" class="btn btn-warning" data-toggle="ajax-modal" data-target="#entity-modal" data-url="{{ route('entities.entity_files.create', [$entity]) }}">
                    <i class="fas fa-plus"></i> {{ __('entities/assets.actions.file') }}
                </a>
                <a href="#" class="btn btn-warning" data-toggle="ajax-modal" data-target="#entity-modal" data-url="{{ route('entities.entity_links.create', [$entity]) }}">
                    <i class="fas fa-plus"></i> {{ __('entities/assets.actions.link') }}
                </a>
            </div>
        @endcan
            <div class="entity-assets">
                <div class="row">
                @foreach ($entity->assets() as $asset)
                    @if($assetCount % 3 == 0)
                </div><div class="row">
                    @endif
                    @includeWhen($asset->isFile(), 'entities.pages.assets._file')
                    @includeWhen($asset->isLink(), 'entities.pages.assets._link')

                    @php $assetCount++ @endphp
                @endforeach
                </div>
            </div>
        </div>
    </div>

@endsection


@section('styles')
    @parent
    <link href="{{ mix('css/assets.css') }}" rel="stylesheet">
@endsection
