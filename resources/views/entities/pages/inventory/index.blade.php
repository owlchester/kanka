<?php /** @var \App\Models\Entity $entity
 * @var \App\Models\Inventory $item */?>
@extends('layouts.' . ($ajax ? 'ajax' : 'app'), [
    'title' => trans('entities/inventories.show.title', ['name' => $entity->name]),
    'description' => '',
    'breadcrumbs' => [
        ['url' => $entity->url('index'), 'label' => trans($entity->pluralType() . '.index.title')],
        ['url' => $entity->url('show'), 'label' => $entity->name],
        __('crud.tabs.inventory')
    ]
])
@inject('campaign', 'App\Services\CampaignService')

@section('content')
    @include('partials.errors')
    <div class="row">
        <div class="col-md-3">
            @include($entity->pluralType() . '._menu', ['active' => 'inventory', 'model' => $entity->child, 'name' => $entity->pluralType()])
        </div>
        <div class="col-md-9">
            <div class="box box-flat">
                <div class="box-body">
                    <h2 class="page-header with-border">
                        {{ trans('crud.tabs.inventory') }}
                    </h2>

                    <p class="help-block">{{ __('entities/inventories.show.helper') }}</p>
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th class="avatar"></th>
                            <th>{{ __('crud.fields.item') }}</th>
                            <th>{{ __('entities/inventories.fields.position') }}</th>
                            <th>{{ __('entities/inventories.fields.amount') }}</th>
                            <th>{{ __('entities/inventories.fields.description') }}</th>
                            @if (Auth::check())
                            <th>{{ __('crud.fields.visibility') }}</th>
                                @can('update', $entity->child)
                                    <th class="text-right">
                                        <a href="{{ route('entities.inventories.create', ['entity' => $entity]) }}" class="btn btn-primary btn-sm"
                                           data-toggle="ajax-modal" data-target="#entity-modal"
                                           data-url="{{ route('entities.inventories.create', ['entity' => $entity]) }}"
                                        >
                                            <i class="fa fa-plus"></i> <span class="visible-lg-inline">{{ __('entities/inventories.actions.add') }}</span>
                                        </a>
                                    </th>
                                @endcan
                            @endif
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($inventory as $item)
                            <tr>
                                <td>
                                    <a class="entity-image" style="background-image: url('{{ $item->item->getImageUrl(true) }}');" title="{{ $item->item->name }}" href="{{ $item->item->getLink() }}"></a>
                                </td>
                                <td>
                                    <a href="{{ $item->item->getLink() }}" data-toggle="tooltip" data-html="true" title="{{ $item->item->tooltipWithName() }}">
                                        {{ $item->item->name }}
                                    </a>
                                </td>
                                <td>
                                    {{ $item->position }}
                                </td>
                                <td>
                                    {{ $item->amount }}
                                </td>
                                <td>
                                    {{ $item->description }}
                                </td>
                                @if (Auth::check())
                                    <td>
                                        @include('cruds.partials.visibility', ['model' => $item])
                                    </td>
                                    @can('update', $entity->child)
                                    <td class="text-right">
                                        <a href="{{ route('entities.inventories.edit', ['entity' => $entity, 'inventory' => $item->id]) }}"
                                           data-toggle="ajax-modal" data-target="#entity-modal"
                                           data-url="{{ route('entities.inventories.edit', ['entity' => $entity, 'inventory' => $item->id]) }}"
                                           title="{{ __('crud.edit') }}" class="btn btn-primary btn-xs">
                                            <i class="fa fa-edit"></i>
                                        </a>

                                        <button class="btn btn-xs btn-danger delete-confirm" data-toggle="modal" data-name="{{ $item->item->name }}"
                                                data-target="#delete-confirm" data-delete-target="delete-form-{{ $item->id }}" title="{{ __('crud.remove') }}">
                                            <i class="fa fa-trash" aria-hidden="true"></i>
                                        </button>
                                        {!! Form::open(['method' => 'DELETE', 'route' => ['entities.inventories.destroy', 'entity' => $entity, 'inventory' => $item], 'style' => 'display:inline', 'id' => 'delete-form-' . $item->id]) !!}
                                        {!! Form::close() !!}
                                    </td>
                                    @endcan
                                @endif
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {{ $inventory->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection