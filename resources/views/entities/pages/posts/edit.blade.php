@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => __('entities/notes.edit.title', ['name' => $entity->name]),
    'description' => '',
    'breadcrumbs' => [
        Breadcrumb::entity($entity)->list(),
        Breadcrumb::show(),
        __('crud.update'),
    ],
    'centered' => true,
    'entity' => null,
])

@section('content')

    <x-form
        method="PATCH"
        :action="['entities.posts.update', $campaign, $entity->id, $model->id]"
        :extra="['data-max-fields' => ini_get('max_input_vars'),]"
        unload
        class="entity-form post-form"
    >
    <x-grid type="1/1">
        @include('cruds.forms._errors')
        @include('entities.pages.posts._form')

        <div class="">
            <x-button.delete-confirm target="#delete-form-note-{{ $model->id}}" />
        </div>
    </x-grid>

    @if(!empty($model) && $campaign->hasEditingWarning())
        <input type="hidden" id="editing-keep-alive" data-url="{{ route('posts.keep-alive', [$campaign, 'post' => $model, 'entity' => $entity]) }}" />
    @endif

    @if(!empty($from))
        <input type="hidden" name="from" value="main" />
    @endif
    </x-form>
@endsection

@include('editors.editor', $entity->isCharacter() ? ['name' => 'characters'] : [])


@section('modals')
    @parent
    <x-form method="DELETE" :action="['entities.posts.destroy', $campaign, 'entity' => $entity, 'post' => $model]" id="delete-form-note-{{ $model->id }}" />

    @includeWhen(!empty($editingUsers) && !empty($model), 'cruds.forms.edit_warning', ['model' => $model, 'entity' => $entity])

@endsection
