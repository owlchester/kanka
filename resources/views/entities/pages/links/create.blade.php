@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => trans('entities/links.create.title', ['name' => $entity->name]),
    'description' => '',
    'breadcrumbs' => [
        ['url' => $entity->url('index'), 'label' => trans($entity->pluralType() . '.index.title')],
        ['url' => $entity->url('show'), 'label' => $entity->name],
        ['url' => route('entities.assets', $entity->id), 'label' => trans('crud.tabs.assets')],
    ]
])

@section('content')
    {!! Form::open(['route' => ['entities.entity_links.store', $entity], 'method'=>'POST', 'data-shortcut' => 1]) !!}

    <div class="panel panel-default">
        @if (request()->ajax())
            <div class="panel-heading">
                <button type="button" class="close" data-dismiss="modal" aria-label="{{ trans('crud.delete_modal.close') }}"><span aria-hidden="true">&times;</span></button>
                <h4>
                    {{ __('entities/links.create.title', ['name' => $entity->name]) }}
                </h4>
        </div>
        @endif
        <div class="panel-body">
            @include('partials.errors')

            @include('entities.pages.links._form')
        </div>
        <div class="panel-footer text-right">
            <button class="btn btn-success">{{ trans('crud.save') }}</button>
            @includeWhen(!request()->ajax(), 'partials.or_cancel')
        </div>
    </div>
    {!! Form::close() !!}
@endsection
