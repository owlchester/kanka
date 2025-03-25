@extends('layouts.app', [
    'title' => __('settings.patreon.title'),
    'description' => __('settings.patreon.description'),
    'breadcrumbs' => false,
    'sidebar' => 'settings',
    'centered' => true,
])

@section('content')
    <x-hero>
        <x-slot name="title">{{ __('settings.patreon.title') }}</x-slot>
    </x-hero>
    <x-grid type="1/1">
        @include('partials.errors')

    @if(auth()->user()->isLegacyPatron())
        <x-box>
            <x-grid type="1/1">
                @includeIf('settings.tiers._' . strtolower(auth()->user()->pledge ?: 'kobold'))

                <div>
                    <x-buttons.confirm type="danger" outline="true" target="remove-patreon">
                        <x-icon class="fa-solid fa-link-slash" />
                        <span>
                            {{ __('settings.patreon.remove.button') }}
                        </span>
                    </x-buttons.confirm>
                </div>
            </x-grid>
        </x-box>
    @else
        <x-alert type="warning">
            <p>
                {!! __('settings.patreon.deprecated', ['subscription' => '<a href="' . route('settings.subscription') . '">' . __('settings.menu.subscription') . '</a>']) !!}
            </p>
        </x-alert>
    @endif
    </x-grid>
@endsection

@section('modals')
    <x-dialog id="remove-patreon" :title="__('settings.patreon.remove.title')">
        <p class="">
            {{ __('settings.patreon.remove.text') }}
        </p>

        <x-form method="DELETE" :action="['settings.patreon.unlink']" class="text-center">
            <x-buttons.confirm type="danger" outline="true" full="true">
                {{ __('crud.actions.confirm') }}
            </x-buttons.confirm>
        </x-form>
    </x-dialog>
@endsection
