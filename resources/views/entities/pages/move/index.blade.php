@extends('layouts.app', [
    'title' => __('entities/move.title', ['name' => $entity->name]),
    'breadcrumbs' => [
        Breadcrumb::campaign($campaign)->entity($entity)->list(),
        Breadcrumb::show(),
        __('crud.actions.move'),
    ],
    'centered' => true,
    'entity' => null,
])

@section('content')
    @include('partials.errors')
    <x-form :action="['entities.move-process', $campaign, $entity]">
    <x-box>
        <x-grid type="1/1">
            <x-helper>
                <p>{{ __('entities/move.panel.description') }}</p>
            </x-helper>

            <x-forms.field field="campaign" :label="__('entities/move.fields.campaign')">
                <x-forms.select name="campaign" :options="$campaigns" class="w-full" />
            </x-forms.field>

            @can('update', $entity)
                <x-forms.field field="copy" css="form-check" :label="__('entities/move.fields.copy')">
                    <x-checkbox :text="__('entities/move.helpers.copy')">
                        <input type="checkbox" name="copy" value="1" @if (old('copy', true)) checked="checked" @endif />
                    </x-checkbox>
                </x-forms.field>
            @else
                <input type="hidden" name="copy" value="1" />
            @endcan

            @if ($entity->entityType->isCustom())
                <x-alert type="warning">
                    {!! __('entities/move.warnings.custom', ['module' => $entity->entityType->plural()]) !!}
                </x-alert>
            @endif

            @includeIf($entity->entityType->pluralCode() . '.bulk.modals._copy_to_campaign')
        </x-grid>

        <x-dialog.footer>
            <button class="btn2 btn-primary">
                <x-icon class="copy" />
                @can('update', $entity) {{ __('entities/move.actions.move') }} @else  {{ __('entities/move.actions.copy') }} @endcan
            </button>
        </x-dialog.footer>
    </x-box>

    </x-form>
@endsection
