<?php /** @var \App\Models\EntityLink $entityLink */?>
@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => __('entities/links.update.title', ['name' => $entity->name]),
    'description' => '',
    'breadcrumbs' => [
        ['url' => $entity->url('index'), 'label' => __($entity->pluralType() . '.index.title')],
        ['url' => $entity->url('show'), 'label' => $entity->name],
        ['url' => route('entities.entity_links.index', $entity->id), 'label' => __('crud.tabs.assets')],
    ]
])

@section('content')
    {!! Form::model($entityLink, ['route' => ['entities.entity_links.update', $entity->id, $entityLink], 'method' => 'PATCH', 'data-shortcut' => 1]) !!}

    <div class="panel panel-default">
        @if (request()->ajax())
            <div class="panel-heading">
                <button type="button" class="close" data-dismiss="modal" aria-label="{{ __('crud.delete_modal.close') }}"><span aria-hidden="true">&times;</span></button>
                <h4>
                    {{ $entityLink->name }}
                </h4>
            </div>
        @endif
        <div class="panel-body">
            @include('partials.errors')

            @include('entities.pages.links._form')
        </div>
        <div class="panel-footer text-right">

            <button class="btn btn-success">{{ __('crud.save') }}</button>
            @includeWhen(!request()->ajax(), 'partials.or_cancel')

            <div class="pull-left">
                <a role="button" tabindex="0" class="btn btn-danger btn-dynamic-delete" data-toggle="popover"
                   title="{{ __('crud.delete_modal.title') }}"
                   data-content="<p>{{ __('crud.delete_modal.description_final', ['tag' => $entityLink->name]) }}</p>
                       <a href='#' class='btn btn-danger btn-block' data-toggle='delete-form' data-target='#delete-form-link-{{ $entityLink->id}}'>{{ __('crud.remove') }}</a>">
                    <i class="fa-solid fa-trash" aria-hidden="true"></i> {{ __('crud.remove') }}
                </a>
            </div>
        </div>
    </div>

    {!! Form::close() !!}

    {!! Form::open(['method' => 'DELETE', 'route' => ['entities.entity_links.destroy', 'entity' => $entity, 'entity_link' => $entityLink], 'style' => 'display:inline', 'id' => 'delete-form-link-' . $entityLink->id]) !!}
    {!! Form::close() !!}
@endsection
