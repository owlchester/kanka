@extends('layouts.app', [
    'title' => __('entities/transform.title', ['name' => $entity->name]),
    'breadcrumbs' => [
        Breadcrumb::campaign($campaign)->entity($entity)->list(),
        Breadcrumb::show(),
        __('crud.actions.transform'),
    ],
    'centered' => true,
    'entity' => null,
])

@section('content')
    @include('partials.errors')

    <x-form :action="['entities.transform-process', $campaign, $entity->id]">
        <x-box>
            <x-grid type="1/1">
                <x-helper>
                    <p>{{ __('entities/transform.panel.description') }}</p>
                    <x-slot name="docs">guides/transform.html</x-slot>
                </x-helper>


                <x-forms.field field="target" :label="__('entities/transform.fields.target')">
                    <x-forms.select name="target" :options="$entities" class="w-full" required />
                </x-forms.field>
            </x-grid>

            <x-dialog.footer>
                <button class="btn2 btn-primary">
                    <x-icon class="fa-regular fa-exchange-alt" />
                    {{ __('entities/transform.actions.transform') }}
                </button>
            </x-dialog.footer>
        </x-box>
    </x-form>
@endsection
