<?php
/**
 * @var \App\Models\Entity $entity
 * @var \App\Models\TimelineElement $element
 */?>
@extends('layouts.' . ($ajax ? 'ajax' : 'app'), [
    'title' => __('entities/map-points.title', ['name' => $entity->name]),
    'description' => '',
    'breadcrumbs' => [
        ['url' => $entity->url('index'), 'label' => __($entity->pluralType() . '.index.title')],
        ['url' => $entity->url('show'), 'label' => $entity->name],
        __('crud.tabs.timelines')
    ],
    'mainTitle' => false,
    'canonical' => true,
    'miscModel' => $entity->child,
])
@inject('campaign', 'App\Services\CampaignService')


@include('entities.components.header', ['model' => $entity->child, 'entity' => $entity])

@section('content')
    @include('partials.errors')
    <div class="row">
        <div class="col-md-2">
            @include($entity->pluralType() . '._menu', ['active' => 'map-points', 'model' => $entity->child, 'name' => $entity->pluralType()])
        </div>
        <div class="col-md-10">
            <div class="box box-solid">
                <div class="box-body">
                    <h2 class="page-header with-border">
                        {{ __('entities/map-points.title', ['name' => $entity->name]) }}
                    </h2>

                    <p class="help-block">{{ __('entities/map-points.helper') }}</p>

                    <table id="entity-map-points" class="table table-hover {{ $data->count() === 0 ? 'export-hidden' : '' }}">
                        <tbody><tr>
                            <th>{{ __('locations.fields.name') }}</th>
                            <th>{{ __('locations.fields.map') }}</th>
                        </tr>
                        @foreach ($markers as $marker)
                            <tr>
                                <td>
                                    {!! $marker->map->tooltipedLink() !!}
                                </td>
                                <td>
                                    <a href="{{ route('maps.explore', [$marker->map_id, 'lat' => $marker->latitude, 'lng' => $marker->longitude]) }}" target="_blank">
                                        <i class="fa fa-map"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        @foreach ($data as $location)
                            <tr>
                                <td>
                                    {!! $location->location->tooltipedLink() !!}
                                </td>
                                <td>
                                    @if (!empty($location->location->map) && (!$location->location->is_map_private || (auth()->check() && auth()->user()->can('map', $location->location))))
                                        <a href="{{ route('locations.map', $location->location_id) }}"><i class="fa fa-map"></i></a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                    {{ $markers->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
