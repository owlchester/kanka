@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => __('entities/story.update.title', ['entity' => $entity->name]),
    'description' => '',
    'breadcrumbs' => [
        Breadcrumb::entity($entity)->list(),
        Breadcrumb::show(),
        __('crud.tabs.story'),
        __('crud.edit')
    ],
    'mainTitle' => false,
])


@section('content')

    {!! Form::model($entity->child, ['route' => ['entities.entry.update', $campaign, $entity], 'method' => 'PATCH', 'data-shortcut' => 1, 'class' => 'entity-form entity-entry-form', 'data-maintenance' => 1, 'data-unload' => 1,]) !!}

        @include('partials.errors')

        <x-forms.field field="entry">
            {!! Form::textarea('entryForEdition', null, ['class' => ' html-editor', 'id' => 'entry', 'name' => 'entry']) !!}
        </x-forms.field>

        <div class="flex gap-2 items-center">
            <div class="grow">
                @include('partials.footer_cancel')
            </div>
            <button class="btn2 btn-primary" id="form-submit-main">{{ __('crud.update') }}</button>
        </div>

    {!! Form::close() !!}

    {{-- For bragi --}}
    @if ($entity->isCharacter())
        <input type="hidden" name="name" value="{{ $entity->name }}" />
    @endif
@endsection

@include('editors.editor', $entity->isCharacter() ? ['name' => 'characters'] : [])
