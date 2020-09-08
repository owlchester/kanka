<?php /** @var \App\Models\Entity $entity
 * @var \App\Models\Inventory $item */?>
@extends('layouts.' . ($ajax ? 'ajax' : 'app'), [
    'title' => __('entities/relations.show.title', ['name' => $entity->name]),
    'breadcrumbs' => [
        ['url' => $entity->url('index'), 'label' => __($entity->pluralType() . '.index.title')],
        ['url' => $entity->url('show'), 'label' => $entity->name],
        __('crud.tabs.relations')
    ],
    'canonical' => true,
    'mainTitle' => false,
    'miscModel' => $entity->child,
])
@inject('campaign', 'App\Services\CampaignService')

@section('content')
    @include('partials.errors')
    <div class="row">
        <div class="col-md-3">
            @include($entity->pluralType() . '._menu', ['active' => 'relations', 'model' => $entity->child, 'name' => $entity->pluralType()])
        </div>
        <div class="col-md-9">
            <div class="box box-solid">
                <div class="box-body">
                    <h2 class="page-header with-border">
                        {{ __('crud.tabs.relations') }}
                    </h2>

                    <p class="help-block export-hidden">
                        {{ __('entities/relations.helper') }}
                    </p>

                    <div class="row">
                        <div class="col-md-6">
                            @include('cruds.datagrids.sorters.simple-sorter')
                        </div>
                        <div class="col-md-6 text-right">
                            @can('relation', [$entity->child, 'add'])
                                <a href="{{ route('entities.relations.create', [$entity]) }}" class="btn btn-primary btn-sm" data-toggle="ajax-modal" data-target="#entity-modal" data-url="{{ route('entities.relations.create', [$entity]) }}">
                                    <i class="fa fa-plus"></i> <span class="hidden-xs hidden-sm">
                        {{ __('crud.relations.actions.add') }}
                        </span></a>
                            @endcan
                        </div>
                    </div>

                    <table id="entity_relations" class="table table-hover {{ ($relations->count() === 0 ? 'export-hidden' : '') }}">
                        <thead>
                        <tr>
                            <th>
                                {{ __('entities/relations.fields.relation') }}
                            </th>
                            <th class="avatar"><br></th>
                            <th>
                                {{ __('crud.relations.fields.name') }}
                            </th>
                            <th>
                                {{ __('entities/relations.fields.attitude') }}
                            </th>
                            @if (Auth::check())
                                <th>
                                    {{ __('crud.fields.visibility') }}
                                </th>
                            @endif
                            <th class="text-right">
                                <br />
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($relations as $relation)
                            @viewentity($relation->target)
                            <tr>
                                <td class="breakable">
                                    {{ $relation->relation }}
                                </td>
                                <td>
                                    <a class="entity-image" style="background-image: url('{{ $relation->target->child->getImageUrl(40) }}');" title="{{ $relation->target->child->name }}" href="{{ $relation->target->url() }}"></a>
                                </td>
                                <td>
                                    {!! $relation->target->tooltipedLink() !!}
                                </td>
                                <td class="breakable">
                                    @if (!empty($relation->colour))
                                        <div class="label-tag-bubble" style="background-color: {{ $relation->colour }}"></div>
                                    @endif
                                    {{ $relation->attitude }}
                                </td>
                                @if (Auth::check())
                                    <td>
                                        @include('cruds.partials.visibility', ['model' => $relation])
                                    </td>
                                @endif
                                <td class="text-right">
                                    @can('relation', [$entity->child, 'edit'])
                                        <a href="{{ route('entities.relations.edit', [$entity, 'relation' => $relation]) }}" class="btn btn-xs btn-primary"
                                           data-toggle="ajax-modal" data-target="#entity-modal" data-url="{{ route('entities.relations.edit', [$entity, 'relation' => $relation]) }}"
                                           title=" {{ __('crud.edit') }}"
                                        >
                                            <i class="fa fa-edit"></i>
                                        </a>
                                    @endcan
                                    @can('relation', [$entity->child, 'delete'])
                                        <button class="btn btn-xs btn-danger delete-confirm" data-toggle="modal" data-name="{{ $relation->target->name }}"
                                                data-target="#delete-confirm" data-delete-target="delete-form-{{ $relation->id }}"
                                                data-mirrored="{{ $relation->mirrored() }}"
                                                title="{{ __('crud.remove') }}">
                                            <i class="fa fa-trash" aria-hidden="true"></i>
                                        </button>
                                        {!! Form::open(['method' => 'DELETE', 'route' => ['entities.relations.destroy', $entity, 'relation' => $relation], 'style' => 'display:inline', 'id' => 'delete-form-' . $relation->id]) !!}
                                        {!! Form::hidden('remove_mirrored', 0) !!}
                                        {!! Form::close() !!}
                                    @endcan
                                </td>
                            </tr>
                            @else
                                <tr class="entity-hidden">
                                    <td colspan="{{ ($campaign->enabled('locations') ? 5 : 4) }}">{{ __('crud.hidden') }}</td>
                                </tr>
                                @endviewentity
                                @endforeach
                        </tbody>
                    </table>

                    {{ $relations->links() }}
                </div>
            </div>

            <div class="box box-solid">
                <div class="box-body">
                    @if($campaign->campaign()->boosted())
                    <div class="loading text-center" id="spinner">
                        <i class="fa fa-spinner fa-spin fa-4x"></i>
                    </div>
                    <div id="cy" class="cy" style="display: none;" data-url="{{ route('entities.relations_map', $entity) }}"></div>

                    @else

                        <div class="visu-teaser text-center">
                            <a href="{{ route('front.features', '#boost') }}" target="_blank">
                                {!! __('entities/relations.teaser') !!}
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection


@if($campaign->campaign()->boosted())

@section('scripts')
    <script src="/vendor/spectrum/spectrum.js" defer></script>
    <script src="{{ mix('js/relations.js') }}" defer></script>
@endsection

@section('styles')
    <link href="/vendor/spectrum/spectrum.css" rel="stylesheet">
    <link href="{{ mix('css/relations.css') }}" rel="stylesheet">
@endsection

@endif
