<?php /** @var \App\Models\EntityAsset $entityAsset */?>
@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => __('entities/files.update.title', ['entity' => $entity->name, 'file' => $entityAsset->name]),
    'description' => '',
    'breadcrumbs' => [
        ['url' => $entity->url('index'), 'label' => __('entities.' . $entity->pluralType())],
        ['url' => $entity->url('show'), 'label' => $entity->name],
        ['url' => route('entities.entity_assets.index', $entity->id), 'label' => __('crud.tabs.assets')],
    ]
])

@section('content')
    {!! Form::model($entityAsset, ['route' => ['entities.entity_assets.update', $entity->id, $entityAsset], 'method' => 'PATCH', 'data-shortcut' => 1]) !!}

    @if (request()->ajax())
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="{{ __('crud.delete_modal.close') }}"><span aria-hidden="true">&times;</span></button>
            <h4>
                {{ $entityAsset->name }}
            </h4>
        </div>
        <div class="modal-body">
            @include('partials.errors')
            @include('entities.pages.files._form')
        </div>
        <div class="modal-footer">
            <button class="btn btn-success">{{ __('crud.save') }}</button>
            <div class="pull-left">
                @include('partials.footer_cancel')
                <a role="button" tabindex="0" class="btn btn-danger btn-dynamic-delete" data-toggle="popover"
                   title="{{ __('crud.delete_modal.title') }}"
                   data-content="<p>{{ __('crud.delete_modal.permanent') }}</p>
                           <a href='#' class='btn btn-danger btn-block' data-toggle='delete-form' data-target='#delete-form-link-{{ $entityAsset->id}}'>{{ __('crud.remove') }}</a>">
                    <i class="fa-solid fa-trash" aria-hidden="true"></i> {{ __('crud.remove') }}
                </a>
            </div>
        </div>
    @else
        <div class="panel panel-default">
            <div class="panel-body">
                @include('partials.errors')
                @include('entities.pages.files._form')
            </div>
            <div class="panel-footer text-right">

                <button class="btn btn-success">{{ __('crud.save') }}</button>
                @includeWhen(!request()->ajax(), 'partials.or_cancel')

                <div class="pull-left">
                    <a role="button" tabindex="0" class="btn btn-danger btn-dynamic-delete" data-toggle="popover"
                       title="{{ __('crud.delete_modal.title') }}"
                       data-content="<p>{{ __('crud.delete_modal.permanent') }}</p>
                           <a href='#' class='btn btn-danger btn-block' data-toggle='delete-form' data-target='#delete-form-link-{{ $entityAsset->id}}'>{{ __('crud.remove') }}</a>">
                        <i class="fa-solid fa-trash" aria-hidden="true"></i> {{ __('crud.remove') }}
                    </a>
                </div>
            </div>

        </div>
    @endif
    {!! Form::close() !!}

    {!! Form::open(['method' => 'DELETE', 'route' => ['entities.entity_assets.destroy', 'entity' => $entity, 'entity_asset' => $entityAsset], 'style' => 'display:inline', 'id' => 'delete-form-link-' . $entityAsset->id]) !!}
    {!! Form::close() !!}
@endsection
