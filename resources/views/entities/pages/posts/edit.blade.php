@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => __('entities/notes.edit.title', ['name' => $entity->name]),
    'description' => '',
    'breadcrumbs' => [
        Breadcrumb::entity($entity)->list(),
        Breadcrumb::show(),
        __('crud.update'),
    ],
    'centered' => true,
])

@section('fullpage-form')
    {!! Form::model($model, [
        'method' => 'PATCH',
        'route' => ['entities.posts.update', $campaign, $entity->id, $model->id],
        'data-shortcut' => '1',
        'class' => 'entity-note-form post-form entity-form',
        'id' => 'entity-form',
        'data-maintenance' => 1,
        'data-unload' => 1,
    ]) !!}
@endsection

@section('content')

    <x-grid type="1/1">
    @include('entities.pages.posts._form')

    <div class="">
        <x-button.delete-confirm target="#delete-form-note-{{ $model->id}}" />
    </div>
    </x-grid>

    @if(!empty($model) && $campaign->hasEditingWarning())
        <input type="hidden" id="editing-keep-alive" data-url="{{ route('posts.keep-alive', [$campaign, 'post' => $model, 'entity' => $entity]) }}" />
    @endif
@endsection

@include('editors.editor', $entity->isCharacter() ? ['name' => 'characters'] : [])

@section('fullpage-form-end')
    @if(!empty($from))
        <input type="hidden" name="from" value="main" />
    @endif
    {!! Form::close() !!}
@endsection

@section('modals')
    @parent
    {!! Form::open(['method' => 'DELETE', 'route' => ['entities.posts.destroy', $campaign, 'entity' => $entity, 'post' => $model], 'style' => 'display:inline', 'id' => 'delete-form-note-' . $model->id]) !!}
    {!! Form::close() !!}

    @includeWhen(!empty($editingUsers) && !empty($model), 'cruds.forms.edit_warning', ['model' => $model, 'entity' => $entity])

@endsection
