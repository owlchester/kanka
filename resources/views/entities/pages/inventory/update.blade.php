@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => __('entities/inventories.update.title', ['name' => $entity->name]),
    'description' => '',
    'breadcrumbs' => [
        ['url' => $entity->url('index'), 'label' => __($entity->pluralType() . '.index.title')],
        ['url' => $entity->url('show'), 'label' => $entity->name],
        ['url' => route('entities.inventory', $entity->id), 'label' => __('crud.tabs.inventory')],
    ]
])

@section('content')
    {!! Form::model($inventory, ['route' => ['entities.inventories.update', $entity->id, $inventory], 'method' => 'PATCH', 'data-shortcut' => 1]) !!}

    <div class="box box-solid">
        @if ($ajax)
            <div class="box-header with-border">
                <h3 class="box-title with-border">
                    {{ __('entities/inventories.update.title', ['name' => $entity->name]) }}
                </h3>
                <div class="box-tools pull-right">

                    <button type="button" class="close" data-dismiss="modal" aria-label="{{ __('crud.delete_modal.close') }}"><span aria-hidden="true">&times;</span></button>
                </div>
            </div>
        @endif
        <div class="box-body">
            @include('partials.errors')
            @include('entities.pages.inventory._form')
        </div>
        <div class="box-footer @if($ajax) text-right @endif">
            <button class="btn btn-success">{{ __('crud.save') }}</button>
            @includeWhen(!request()->ajax(), 'partials.or_cancel')
        </div>
    </div>

    {!! Form::hidden('entity_id', $entity->id) !!}
    {!! Form::close() !!}
@endsection
