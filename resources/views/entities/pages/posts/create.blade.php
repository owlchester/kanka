@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => __('entities/notes.create.title', ['name' => $entity->name]),
    'description' => '',
    'breadcrumbs' => [
        Breadcrumb::entity($entity)->list(),
        Breadcrumb::show(),
        __('entities/notes.actions.add')
    ],
    'centered' => true,
])

@section('fullpage-form')
    {!! Form::open([
        'route' => ['entities.posts.store', $campaign, $entity->id],
        'method'=>'POST',
        'data-shortcut' => '1',
        'id' => 'entity-form',
        'class' => 'entity-form post-form entity-note-form',
        'data-maintenance' => 1,
        'data-unload' => 1,
    ]) !!}
@endsection

@section('content')
    @include('entities.pages.posts._form')
@endsection

@include('editors.editor', $entity->isCharacter() ? ['name' => 'characters'] : [])

@section('fullpage-form-end')
    {!! Form::close() !!}
@endsection
