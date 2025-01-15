@extends('layouts.app', [
    'title' => __('entities/move.title', ['name' => $post->name]),
    'breadcrumbs' => [
        Breadcrumb::entity($entity)->list(),
        Breadcrumb::show(),
        __('crud.actions.move'),
    ],
    'entity' => null,
])

@section('content')
    @include('partials.errors')
    <x-form :action="['posts.move', $campaign, $entity->id, $post->id]">
    <x-box>
        <x-grid type="1/1">
            <x-forms.field field="entity" :label="__('entities/notes.move.entity')">
                <select name="entity" class=" select2" data-url="{{ route('search.entities-with-relations', $campaign) }}" data-allow-clear="false" data-allow-new="false" data-placeholder="{{ __('entities/notes.move.description') }}"></select>
            </x-forms.field>

            <x-forms.field field="copy" css="form-check" :label="__('entities/notes.move.copy_title')">
                <x-checkbox :text="__('entities/notes.move.copy')">
                    <input type="checkbox" name="copy" value="1" @if (old('copy', true)) checked="checked" @endif />
                </x-checkbox>
            </x-forms.field>
        </x-grid>

        <x-dialog.footer>
            <button class="btn2 btn-primary">@can('update', $entity) {{ __('entities/move.actions.move') }} @else  {{ __('entities/move.actions.copy') }} @endcan</button>
        </x-dialog.footer>
    </x-box>

    </x-form>
@endsection
