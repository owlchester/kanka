@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => __('entities/links.create.title', ['name' => $entity->name]),
    'description' => '',
    'breadcrumbs' => [
        ['url' => $entity->url('index'), 'label' => __('entities.' . $entity->pluralType())],
        ['url' => $entity->url('show'), 'label' => $entity->name],
        ['url' => route('entities.entity_assets.index', [$campaign, $entity]), 'label' => trans('crud.tabs.assets')],
    ]
])

@section('content')
    {!! Form::open(['route' => ['entities.entity_assets.store', [$campaign, $entity]], 'method'=>'POST', 'data-shortcut' => 1]) !!}

    @include('partials.forms.form', [
            'title' => __('entities/links.create.title', ['name' => $entity->name]),
            'content' => 'entities.pages.links._form',
        ])
    {!! Form::close() !!}
@endsection
