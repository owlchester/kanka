@extends('layouts.app', [
    'title' => trans('crud.notes.show.title', ['name' => $entityNote->name, 'entity' => $entity->name]),
    'description' => '',
    'breadcrumbs' => [
        ['url' => $entity->url('index'), 'label' => trans($entity->pluralType() . '.index.title')],
        ['url' => $entity->url('show'), 'label' => $entity->name]
    ]
])
@section('content')
    @include('partials.errors')
    @include('cruds.notes._show')
@endsection