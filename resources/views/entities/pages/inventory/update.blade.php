@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => __('entities/inventories.update.title', ['name' => $entity->name]),
    'description' => '',
    'breadcrumbs' => [
        ['url' => $entity->url('index'), 'label' => __('entities.' . $entity->pluralType())],
        ['url' => $entity->url('show'), 'label' => $entity->name],
        ['url' => route('entities.inventory', $entity->id), 'label' => __('crud.tabs.inventory')],
    ]
])

@section('content')
    {!! Form::model($inventory, ['route' => ['entities.inventories.update', $entity->id, $inventory], 'method' => 'PATCH', 'data-shortcut' => 1]) !!}

    @if (request()->ajax())
        @include('modals.modal', [
            'title' => __('entities/inventories.update.title', ['name' => $entity->name]),
            'content' => 'entities.pages.inventory._form',
        ])
    @else
        <div class="box box-solid">
            <div class="box-body">
                @include('partials.errors')
                @include('entities.pages.inventory._form')
            </div>
            <div class="box-footer">
                <button class="btn btn-success">{{ __('crud.save') }}</button>
                @includeWhen(!request()->ajax(), 'partials.or_cancel')
            </div>
        </div>
    @endif

    {!! Form::hidden('entity_id', $entity->id) !!}
    {!! Form::close() !!}
@endsection
