<?php /** @var \App\Models\Relation $relation */?>
@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => __('entities/relations.update.title', ['name' => $entity->name]),
    'description' => '',
    'breadcrumbs' => [
        ['url' => $entity->url('index'), 'label' => __($entity->pluralType() . '.index.title')],
        ['url' => $entity->url('show'), 'label' => $entity->name],
        ['url' => route('entities.relations.index', $entity->id), 'label' => __('crud.tabs.relations')],
    ]
])

@section('content')
    {!! Form::model($relation, ['route' => ['entities.relations.update', $entity->id, $relation], 'method' => 'PATCH', 'data-shortcut' => 1]) !!}

    @if (request()->ajax())
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="{{ __('crud.delete_modal.close') }}">
                <span aria-hidden="true">&times;</span>
            </button>
            <h4 class="modal-title">
                {{ __('entities/relations.update.title', ['name' => $entity->name]) }}
            </h4>
        </div>
        <div class="modal-body">
    @else
        <div class="panel panel-default">
    @endif
            <div class="@if(!request()->ajax()) panel-body @endif">
                @include('partials.errors')

                @include('entities.pages.relations._form')
            </div>

    @if(request()->ajax())
        </div>
        <div class="modal-footer">
            <a href="#" type="button" class="mr-1" data-dismiss="modal" aria-label="{{ __('crud.delete_modal.close') }}">
                {{ __('crud.cancel') }}
            </a>
            <button class="btn btn-success">
                <i class="fa-solid fa-save" aria-hidden="true"></i>
                {{ __('crud.save') }}
            </button>

            <div class="pull-left">
                <a role="button" tabindex="-1" class="btn btn-dynamic-delete btn-danger" data-toggle="popover"
                   title="{{ __('crud.delete_modal.title') }}"
                   data-content="<p>{{ __($relation->isMirrored() ? 'entities/relations.destroy.mirrored' : 'crud.delete_modal.permanent') }}</p>
                   <a href='#' class='btn btn-danger btn-block' data-toggle='delete-form' data-target='#delete-relation-{{ $relation->id}}'>{{ __('crud.remove') }}</a>">
                    <i class="fa-solid fa-trash" aria-hidden="true"></i> {{ __('crud.remove') }}
                </a>
            </div>
        </div>
     @else
            <div class="panel-footer">
                <div class="pull-right">
                    <button class="btn btn-success">{{ __('crud.save') }}</button>
                </div>

                @include('partials.footer_cancel')
            </div>
        </div>
    @endif



    @if(!empty($from))
        <input type="hidden" name="from" value="{{ $from }}" />
    @endif
    {!! Form::hidden('owner_id', $entity->id) !!}
    {!! Form::hidden('option', request()->get('option')) !!}
    {!! Form::hidden('mode', request()->get('mode')) !!}

    {!! Form::close() !!}
    {!! Form::open([
        'method' => 'DELETE',
        'route' => ['entities.relations.destroy', 'entity' => $entity->id, 'relation' => $relation->id, 'mode' => request()->mode, 'option' => request()->option],
        'id' => 'delete-relation-' . $relation->id]) 
        !!}
    @if ($relation->isMirrored())<input type="hidden" name="remove_mirrored" value="1" />@endif
    {!! Form::close() !!}
@endsection
