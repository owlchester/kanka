<?php /** @var \App\Models\Entity $entity
 * @var \App\Models\Inventory $item */?>
@extends('layouts.' . ($ajax ? 'ajax' : 'app'), [
    'title' => trans('relations.show.title', ['name' => $entity->name]),
    'breadcrumbs' => [
        ['url' => $entity->url('index'), 'label' => trans($entity->pluralType() . '.index.title')],
        ['url' => $entity->url('show'), 'label' => $entity->name],
        __('crud.tabs.relations')
    ]
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
                        {{ trans('crud.tabs.relations') }}
                    </h2>

                    <p class="help-block export-hidden">
                        @can('relation', [$entity->child, 'add'])
                            <a href="{{ route('entities.relations.create', [$entity]) }}" class="btn btn-primary btn-sm pull-right" data-toggle="ajax-modal" data-target="#entity-modal" data-url="{{ route('entities.relations.create', [$entity]) }}">
                                <i class="fa fa-plus"></i> <span class="hidden-xs hidden-sm">
                        {{ trans('crud.relations.actions.add') }}
                        </span></a>
                        @endcan
                        {{ __('relations.show.helper') }}
                    </p>

                    <table id="entity_relations" class="table table-hover {{ ($relations->count() === 0 ? 'export-hidden' : '') }}">
                        <thead>
                        <tr>
                            <th>
                                <a href="{{ route('entities.relations.index', [$entity, 'order' => 'relations/relation', '#relations']) }}">
                                    {{ trans('entities/relations.fields.relation') }}@if (request()->get('order') == 'relations/relation') <i class="fa fa-long-arrow-down"></i>@endif
                                </a>
                            </th>
                            <th>
                                <a href="{{ route('entities.relations.index', [$entity,  'order' => 'relations/attitude', '#relations']) }}">
                                    {{ trans('relations.fields.attitude') }}@if (request()->get('order') == 'relations/attitude') <i class="fa fa-long-arrow-down"></i>@endif
                                </a>
                            </th>
                            <th class="avatar"><br></th>
                            <th>
                                <a href="{{ route('entities.relations.index', [$entity,  'order' => 'relations/target.name', '#relations']) }}">
                                    {{ trans('crud.relations.fields.name') }}@if (request()->get('order') == 'relations/target.name') <i class="fa fa-long-arrow-down"></i>@endif
                                </a>
                            </th>
                            @if ($campaign->enabled('locations'))<th>{{ trans('crud.relations.fields.location') }}</th>@endif
                            @if (Auth::check())
                                <th>
                                    <a href="{{ route('entities.relations.index', [$entity,  'order' => 'relations/visibility', '#relations']) }}">
                                        {{ trans('crud.fields.visibility') }}@if (request()->get('order') == 'relations/visibility') <i class="fa fa-long-arrow-down"></i>@endif
                                    </a>
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
                                <td class="breakable">{{ $relation->relation }}</td>
                                <td class="breakable">{{ $relation->attitude }}</td>
                                <td>
                                    <a class="entity-image" style="background-image: url('{{ $relation->target->child->getImageUrl(true) }}');" title="{{ $relation->target->child->name }}" href="{{ $relation->target->url() }}"></a>
                                </td>
                                <td>
                                    {!! $relation->target->tooltipedLink() !!}
                                </td>
                                @if ($campaign->enabled('locations'))<td>
                                    @if ($relation->target->child->location)
                                        {!! $relation->target->child->location->tooltipedLink() !!}
                                    @endif
                                </td>
                                @endif
                                @if (Auth::check())
                                    <td>
                                        @include('cruds.partials.visibility', ['model' => $relation])
                                    </td>
                                @endif
                                <td class="text-right">
                                    @can('relation', [$entity->child, 'edit'])
                                        <a href="{{ route('entities.relations.edit', [$entity, 'relation' => $relation]) }}" class="btn btn-xs btn-primary"
                                           data-toggle="ajax-modal" data-target="#entity-modal" data-url="{{ route('entities.relations.edit', [$entity, 'relation' => $relation]) }}"
                                           title=" {{ trans('crud.edit') }}"
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
                                    <td colspan="{{ ($campaign->enabled('locations') ? 5 : 4) }}">{{ trans('crud.hidden') }}</td>
                                </tr>
                                @endviewentity
                                @endforeach
                        </tbody>
                    </table>

                    {{ $relations->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection