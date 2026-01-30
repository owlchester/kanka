@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => __('entities/story.update.title', ['entity' => $entity->name]),
    'breadcrumbs' => [
        Breadcrumb::campaign($campaign)->entity($entity)->list(),
        Breadcrumb::show(),
        __('crud.tabs.story'),
        __('crud.edit')
    ],
    'mainTitle' => false,
    'entity' => null
])


@section('content')

    <x-form :action="['entities.entry.update', $campaign, $entity]" method="PATCH" class="entity-form entity-entry-form" unsaved>
        @include('partials.errors')
        <x-box>
            <x-forms.field field="entry">
                @include('cruds.fields.entry', ['model' => $entity])
            </x-forms.field>

            <div class="flex gap-2 items-center">
                <div class="grow">
                    @include('partials.footer_cancel')
                </div>
                <button class="btn2 btn-primary" id="form-submit-main">{{ __('crud.update') }}</button>
            </div>

        </x-box>
    </x-form>

    {{-- For bragi --}}
    @if ($entity->isCharacter())
        <input type="hidden" name="name" value="{{ $entity->name }}" />
    @endif
@endsection

@include('editors.editor', $entity->isCharacter() ? ['name' => 'characters'] : [])
