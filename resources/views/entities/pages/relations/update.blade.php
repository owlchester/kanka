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
            <button class="btn btn-success">{{ __('crud.save') }} @include('partials.koinks', ['cost' => 2])</button>

            <div class="pull-left">
                @include('partials.footer_cancel')
            </div>
        </div>
    @else
            <div class="panel-footer">
                <div class="pull-right">
                    <button class="btn btn-success">{{ __('crud.save') }} @include('partials.koinks', ['cost' => 2])</button>
                </div>

                @include('partials.footer_cancel')
            </div>
        </div>
    @endif



    @if(!empty($from))
        <input type="hidden" name="from" value="{{ $from }}" />
    @endif

    {!! Form::hidden('owner_id', $entity->id) !!}
    {!! Form::close() !!}
@endsection
