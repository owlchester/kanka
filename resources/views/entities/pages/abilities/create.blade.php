@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => trans('entities/abilities.create.title', ['name' => $entity->name]),
    'description' => '',
    'breadcrumbs' => [
        ['url' => Breadcrumb::index($entity->pluralType()), 'label' => trans($entity->pluralType() . '.index.title')],
        ['url' => $entity->url('show'), 'label' => $entity->name],
        ['url' => route('entities.entity_abilities.index', $entity->id), 'label' => trans('crud.tabs.ability')],
    ]
])

@section('content')
    {!! Form::open([
        'route' => ['entities.entity_abilities.store', $entity],
        'method'=>'POST',
        'data-shortcut' => 1
    ]) !!}

    <div class="panel panel-default">
        @if (request()->ajax())
            <div class="panel-heading">
                <button type="button" class="close" data-dismiss="modal" aria-label="{{ trans('crud.delete_modal.close') }}"><span aria-hidden="true">&times;</span></button>
                <h4>
                    {{ __('entities/abilities.create.title', ['name' => $entity->name]) }}
                </h4>
        </div>
        @endif
        <div class="panel-body">
            @include('partials.errors')

            @include('entities.pages.abilities._form')
        </div>
        <div class="panel-footer">
            <button class="btn btn-success pull-right">{{ __('crud.save') }}</button>
            @include('partials.footer_cancel')
        </div>
    </div>
    {!! Form::close() !!}
@endsection
