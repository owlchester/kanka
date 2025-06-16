@extends('layouts.app', [
    'title' => $title,
    'breadcrumbs' => [
        ['url' => Breadcrumb::campaign($campaign)->index($name), 'label' => $plural],
        __('crud.create'),
    ],
    'mainTitle' => false,
    'centered' => true,
])

@section('content')
    <x-form
        :action="['bookmarks.store', $campaign]"
        files
        unsaved
        class="entity-form"
        id="entity-form"
        :extra="['data-max-fields' => ini_get('max_input_vars')]">

        <x-grid type="1/1" class="">
            @include('cruds.forms._errors')

            <h1 class="text-lg md:text-4xl">{{ __('bookmarks.create.title') }}</h1>

            @include('bookmarks.forms._entry')

            <div class="flex items-center justify-end ">
                @include('cruds.fields.save', ['disableCancel' => true, 'target' => 'entity-form', 'disableCopy' => true])
            </div>
        </x-grid>
    </x-form>
@endsection

@include('editors.editor')


@includeIf($name . '.forms._tutorial')
