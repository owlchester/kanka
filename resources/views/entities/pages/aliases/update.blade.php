<?php /** @var \App\Models\EntityAlias $entityAlias */?>
@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => __('entities/aliases.update.title', ['name' => $entity->name]),
    'description' => '',
    'breadcrumbs' => [
        ['url' => $entity->url('index'), 'label' => __($entity->pluralType() . '.index.title')],
        ['url' => $entity->url('show'), 'label' => $entity->name],
        ['url' => route('entities.entity_links.index', $entity->id), 'label' => __('crud.tabs.assets')],
    ]
])

@section('content')
    <div class="panel panel-default">
        @if (request()->ajax())
            <div class="panel-heading">
                <button type="button" class="close" data-dismiss="modal" aria-label="{{ __('crud.delete_modal.close') }}"><span aria-hidden="true">&times;</span></button>
                <h4>
                    {{ $entityAlias->name }}
                </h4>
            </div>
        @endif
        <div class="panel-body">
            @include('partials.errors')

            {!! Form::model($entityAlias, ['route' => ['entities.entity_aliases.update', $entity->id, $entityAlias], 'method' => 'PATCH', 'data-shortcut' => 1]) !!}
            @include('entities.pages.aliases._form')

            <button class="btn btn-success">{{ __('crud.save') }}</button>
            @includeWhen(!request()->ajax(), 'partials.or_cancel')

            <div class="pull-right">
                <a role="button" tabindex="0" class="btn btn-danger btn-dynamic-delete" data-toggle="popover"
                   title="{{ __('crud.delete_modal.title') }}"
                   data-content="<p>{{ __('crud.delete_modal.description_final', ['tag' => $entityAlias->name]) }}</p>
                       <a href='#' class='btn btn-danger btn-block' data-toggle='delete-form' data-target='#delete-form-alias-{{ $entityAlias->id}}'>{{ __('crud.remove') }}</a>">
                    <i class="fa fa-trash" aria-hidden="true"></i> {{ __('crud.remove') }}
                </a>
            </div>
        </div>

            {!! Form::close() !!}


        </div>
    </div>

    {!! Form::open(['method' => 'DELETE', 'route' => ['entities.entity_aliases.destroy', 'entity' => $entity, 'entity_alias' => $entityAlias], 'style' => 'display:inline', 'id' => 'delete-form-alias-' . $entityAlias->id]) !!}
    {!! Form::close() !!}
@endsection
