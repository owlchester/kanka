@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => trans('entities/inventories.create.title', ['name' => $entity->name]),
    'description' => '',
    'breadcrumbs' => [
        ['url' => $entity->url('index'), 'label' => trans($entity->pluralType() . '.index.title')],
        ['url' => $entity->url('show'), 'label' => $entity->name],
        ['url' => route('entities.inventory', $entity->id), 'label' => trans('crud.tabs.inventory')],
    ]
])

@section('content')
    {!! Form::open(['route' => ['entities.inventories.store', $entity->id], 'method'=>'POST', 'data-shortcut' => 1]) !!}
    <div class="box box-solid">
        @if ($ajax)
            <div class="box-header with-border">
                <h3 class="box-title">
                    {{ __('entities/inventories.create.title', ['name' => $entity->name]) }}
                </h3>

                <div class="box-tools">
                    <button type="button" class="close" data-dismiss="modal" aria-label="{{ trans('crud.delete_modal.close') }}"><span aria-hidden="true">&times;</span></button>
                </div>
        </div>
        @endif
        <div class="box-body">
            @include('partials.errors')
            @include('entities.pages.inventory._form')
        </div>
        <div class="box-footer @if($ajax) text-right @endif">
            <button class="btn btn-success">{{ __('entities/inventories.actions.add') }}</button>
            @includeWhen(!request()->ajax(), 'partials.or_cancel')
        </div>
    </div>

    {!! Form::hidden('entity_id', $entity->id) !!}
    {!! Form::close() !!}
@endsection
