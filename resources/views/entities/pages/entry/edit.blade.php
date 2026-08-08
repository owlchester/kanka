@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => __('entities/story.update.title', ['entity' => $entity->name]),
    'breadcrumbs' => [
        Breadcrumb::campaign($campaign)->entity($entity)->list(),
        Breadcrumb::show(),
        __('fields.description.label'),
        __('crud.edit')
    ],
    'mainTitle' => false,
    'entity' => null
])


@section('content')

    <x-form :action="['entities.entry.update', $campaign, $entity]" method="PATCH" class="entity-form entity-entry-form" unsaved>
        @include('partials.errors')
        <div class="flex gap-2 items-center mb-4">
            <div class="grow">
                @include('partials.footer_cancel')
            </div>
            <div class="join">
                <button class="btn2 btn-primary join-item" id="form-submit-main">{{ __('crud.update') }}</button>
                <div class="dropdown">
                    <button type="button" class="btn2 btn-primary join-item" data-dropdown aria-expanded="false">
                        <x-icon class="fa-regular fa-caret-down" />
                        <span class="sr-only">{{ __('crud.actions.actions') }}</span>
                    </button>
                    <div class="dropdown-menu hidden" role="menu">
                        @include('cruds.fields._stealth-edit')
                    </div>
                </div>
            </div>
        </div>

            <x-forms.field field="entry">
                @include('cruds.fields.entry', ['model' => $entity ?? null])
            </x-forms.field>


    </x-form>

    {{-- For bragi --}}
    @if ($entity->isCharacter())
        <input type="hidden" name="name" value="{{ $entity->name }}" />
    @endif
@endsection

@include('editors.editor', $entity->isCharacter() ? ['name' => 'characters'] : [])
