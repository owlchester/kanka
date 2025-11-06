@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => __('entities/notes.create.title', ['name' => $entity->name]),
    'description' => '',
    'breadcrumbs' => [
        Breadcrumb::campaign($campaign)->entity($entity)->list(),
        Breadcrumb::show(),
        __('entities/notes.actions.add')
    ],
    'centered' => true,
    'entity' => null,
])

@section('content')
    @include('ads.top')
    <x-form
        :action="['entities.posts.store', $campaign, $entity->id]"
        :extra="['data-max-fields' => ini_get('max_input_vars'),]"
        unload
        class="entity-form post-form"
    >
        <x-grid type="1/1">
            @include('cruds.forms._errors')
            @include('entities.pages.posts._form')
        </x-grid>
    </x-form>
@endsection

@include('editors.editor', $entity->isCharacter() ? ['name' => 'characters'] : [])
