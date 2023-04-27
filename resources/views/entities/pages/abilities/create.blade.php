@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => trans('entities/abilities.create.title', ['name' => $entity->name]),
    'description' => '',
    'breadcrumbs' => [
        ['url' => Breadcrumb::index($entity->pluralType()), 'label' => \App\Facades\Module::plural($entity->typeId(), __('entities.' . $entity->pluralType()))],
        ['url' => $entity->url(), 'label' => $entity->name],
        ['url' => route('entities.entity_abilities.index', $entity->id), 'label' => trans('crud.tabs.ability')],
    ]
])

@section('content')
    {!! Form::open([
        'route' => ['entities.entity_abilities.store', $entity],
        'method'=>'POST',
        'data-shortcut' => 1
    ]) !!}

    @include('partials.forms.form', [
        'title' => __('entities/abilities.create.title', ['name' => $entity->name]),
        'content' => 'entities.pages.abilities._form',
    ])

    {!! Form::close() !!}
@endsection
