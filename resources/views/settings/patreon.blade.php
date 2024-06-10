@extends('layouts.app', [
    'title' => __('settings.patreon.title'),
    'description' => __('settings.patreon.description'),
    'breadcrumbs' => false,
    'sidebar' => 'settings',
    'centered' => true,
])

@section('content')
    <x-grid type="1/1">
        <h1 class="">
            {{ __('settings.patreon.title') }}
        </h1>
        @include('partials.errors')

    @if(auth()->user()->isLegacyPatron())
        <x-box>
            <x-grid type="1/1">
                @includeIf('settings.tiers._' . strtolower(auth()->user()->pledge ?: 'kobold'))

                <div>
                    <x-buttons.confirm type="danger" outline="true" target="remove-patreon">
                        <i class="fa-solid fa-link-slash" aria-hidden="true"></i>
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
                {{ __('crud.click_modal.confirm') }}
            </x-buttons.confirm>
        </x-form>
    </x-dialog>
@endsection
