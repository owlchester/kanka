<?php /** @var \App\Models\Entity $entity
 * @var \App\Models\Inventory $inventory */?>
@extends('layouts.' . ($ajax ? 'ajax' : 'app'), [
    'title' => trans('entities/inventories.show.title', ['name' => $entity->name]),
    'description' => '',
    'breadcrumbs' => [
        ['url' => $entity->url('index'), 'label' => trans($entity->pluralType() . '.index.title')],
        ['url' => $entity->url('show'), 'label' => $entity->name]
    ]
])
@section('content')

    <div class="pagination-ajax-body">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="loading text-center" style="display: none">
                    <i class="fa fa-spinner fa-spin fa-4x"></i>
                </div>
                <div class="pagination-ajax-content">
                    <p class="help-block">{{ __('entities/inventories.show.helper') }}</p>
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th class="avatar"></th>
                            <th>{{ __('crud.fields.item') }}</th>
                            <th>{{ __('entities/inventories.fields.amount') }}</th>
                            <th>{{ __('entities/inventories.fields.position') }}</th>
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
                                    <a href="{{ $item->item->getLink() }}" data-toggle="tooltip" title="{{ $item->item->tooltip() }}">
                                        {{ $item->item->name }}
                                    </a>
                                </td>
                                <td>
                                    <?=$item->amount?>
                                </td>
                                <td>
                                    <?=$item->position?>
                                </td>
                                @if (Auth::check())
                                    <td>
                                        @include('cruds.partials.visibility', ['model' => $item])
                                    </td>
                                    @can('update', $entity->child)
                                    <td class="text-right">
                                        <a href="{{ route('entities.inventories.edit', ['entity' => $entity, 'inventory' => $item]) }}"
                                           data-toggle="ajax-modal" data-target="#entity-modal"
                                           data-url="{{ route('entities.inventories.edit', ['entity' => $entity, 'inventory' => $item]) }}"
                                           title="{{ __('crud.edit') }}" class="btn btn-primary btn-xs">
                                            <i class="fa fa-edit"></i>
                                        </a>

                                        <button class="btn btn-xs btn-danger delete-confirm" data-toggle="modal" data-name="{{ $item->item->name }}"
                                                data-target="#delete-confirm" data-delete-target="delete-form-{{ $item->id }}" title="{{ trans('crud.remove') }}">
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