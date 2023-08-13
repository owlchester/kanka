@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => __('entities/relations.create.title', ['name' => $entity->name]),
    'description' => '',
    'breadcrumbs' => [
        Breadcrumb::entity($entity)->list(),
        Breadcrumb::show(),
        ['url' => route('entities.relations.index', [$campaign, $entity->id]), 'label' => __('crud.tabs.relations')],
        __('crud.actions.new')
    ]
])

@section('content')
    {!! Form::open(['route' => ['entities.relations.store', $campaign, $entity->id], 'method' => 'POST', 'data-shortcut' => 1]) !!}

    @include('partials.forms.form', [
            'title' => __('entities/relations.create.title', ['name' => $entity->name]),
            'content' => 'entities.pages.relations._form',
        ])

    {!! Form::hidden('entity_id', $entity->id) !!}
    {!! Form::hidden('owner_id', $entity->id) !!}
    {!! Form::close() !!}
@endsection

@section('scripts')
    @vite('resources/js/relations.js')
@endsection

@section('styles')
    @vite('resources/sass/relations.scss')
@endsection
