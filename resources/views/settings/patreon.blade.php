@extends('layouts.app', [
    'title' => __('settings.patreon.title'),
    'description' => __('settings.patreon.description'),
    'breadcrumbs' => false,
    'sidebar' => 'settings',
    'noads' => true,
])

@section('content')
    <h1 class="mb-3">
        {{ __('settings.patreon.title') }}
    </h1>
    @include('partials.errors')

    @if(auth()->user()->isLegacyPatron())
        <x-box>
            @includeIf('settings.tiers._' . strtolower(auth()->user()->pledge ?: 'kobold'))

            <x-buttons.confirm type="danger" outline="true" target="remove-patreon">
                <i class="fa-solid fa-link-slash" aria-hidden="true"></i>
                <span>
                    {{ __('settings.patreon.remove.button') }}
                </span>
            </x-buttons.confirm>
        </x-box>
    @else
        <x-alert type="warning">
            <p>
                {!! __('settings.patreon.deprecated', ['subscription' => link_to_route('settings.subscription', __('settings.menu.subscription'))]) !!}
            </p>
        </div>
    @endif
@endsection

@section('modals')
    <x-dialog id="remove-patreon" :title="__('settings.patreon.remove.title')">
        <p class="mb-2">
            {{ __('settings.patreon.remove.text') }}
        </p>
        {!! Form::model(auth()->user(), ['method' => 'DELETE', 'route' => ['settings.patreon.unlink'], 'class' => 'text-center mb-5 w-full']) !!}
        <x-buttons.confirm type="danger" outline="true" full="true">
            {{ __('crud.click_modal.confirm') }}
        </x-buttons.confirm>
        {!! Form::close() !!}
    </x-dialog>
@endsection
