@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => __('entities/relations.create.title', ['name' => $entity->name]),
    'description' => '',
    'breadcrumbs' => [
        ['url' => $entity->url('index'), 'label' => __($entity->pluralType() . '.index.title')],
        ['url' => $entity->url('show'), 'label' => $entity->name],
        ['url' => route('entities.relations.index', $entity->id), 'label' => __('crud.tabs.relations')],
        __('crud.actions.new')
    ]
])

@section('content')
    {!! Form::open(['route' => ['entities.relations.store', $entity->id], 'method' => 'POST', 'data-shortcut' => 1]) !!}

    @if (request()->ajax())
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="{{ __('crud.delete_modal.close') }}">
            <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title">
            {{ __('entities/relations.create.title', ['name' => $entity->name]) }}
        </h4>
    </div>
    <div class="modal-body">
    @else
    <div class="panel panel-default">
    @endif

        <div class="@if(!request()->ajax()) panel-body @endif">
            @include('partials.errors')

            @include('entities.pages.relations._form')

            {!! Form::hidden('entity_id', $entity->id) !!}
            {!! Form::hidden('owner_id', $entity->id) !!}
        </div>

    @if(request()->ajax())
    </div>
    <div class="modal-footer">
        <button class="btn btn-success">{{ __('crud.save') }}</button>

        <div class="pull-left">
            @include('partials.footer_cancel')
        </div>
    </div>
    @else
        <div class="panel-footer">
            <div class="pull-right">
                    <button class="btn btn-success">{{ __('crud.save') }}</button>
            </div>
            @include('partials.footer_cancel')
        </div>
    @endif


    {!! Form::close() !!}
@endsection

@section('scripts')
    <script src="{{ mix('js/relations.js') }}" defer></script>
@endsection

@section('styles')
    <link href="{{ mix('css/relations.css') }}" rel="stylesheet">
@endsection
