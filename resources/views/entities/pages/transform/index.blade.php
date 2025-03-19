@extends('layouts.app', [
    'title' => __('entities/transform.title', ['name' => $entity->name]),
    'breadcrumbs' => [
        Breadcrumb::entity($entity)->list(),
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
                <p class="text-neutral-content m-0">
                    {{ __('entities/transform.panel.description') }}
                </p>

                <a href="https://docs.kanka.io/en/latest/guides/transform.html" target="_blank" class="">
                    <i class="fa-solid fa-external-link" aria-hidden="true"></i>
                    {{ __('crud.helpers.learn_more', ['documentation' => __('footer.documentation')]) }}
                </a>

                <x-forms.field field="target" :label="__('entities/transform.fields.target')">
                    <x-forms.select name="target" :options="$entities" class="w-full" required />
                </x-forms.field>
            </x-grid>

            <x-dialog.footer>
                <button class="btn2 btn-primary">
                    <i class="fa-solid fa-exchange-alt" aria-hidden="true"></i>
                    {{ __('entities/transform.actions.transform') }}
                </button>
            </x-dialog.footer>
        </x-box>
    </x-form>
@endsection
