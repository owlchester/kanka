<?php /** @var \App\Models\UserApp $discord */?>
@extends('layouts.app', [
    'title' => __('settings.apps.title'),
    'description' => '',
    'breadcrumbs' => false,
    'sidebar' => 'settings',
    'noads' => true,
])

@section('content')
    <div class="max-w-4xl">
        <h1 class="mb-3">
            {{ __('settings.apps.title') }}
        </h1>
        <p class="text-lg">
            {!! __('settings.apps.benefits') !!}
        </p>
        @include('partials.errors')
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div class="rounded shadow-sm bg-box p-5">

                <div class="flex gap-2 items-center mb-2">
                    <div class="flex-0">
                        <i class="fa-brands fa-discord fa-3x text-indigo-400" aria-hidden="true"></i>
                    </div>
                    <div class="grow text-lg font-extrabold truncate">
                        Discord
                    </div>
                    <div class="flex-0">
                        @if($discord = auth()->user()->apps()->app('discord')->first())
                            <x-buttons.confirm type="danger" target="remove-discord" outline="true">
                                <i class="fa-solid fa-link-slash" aria-hidden="true"></i>
                                <span>
                                    {{ __('settings.apps.actions.remove') }}
                                    @if (!empty($discord->settings)) {{ $discord->settings['username'] }}#{{ $discord->settings['discriminator'] }} @endif
                                </span>
                            </x-buttons.confirm>
                        @else
                            <a href="https://discord.com/api/oauth2/authorize?client_id={{ config('discord.client_id') }}&redirect_uri={{ url('/settings/discord-callback') }}&response_type=code&scope=identify+guilds+guilds.join" class="inline-block rounded px-6 py-2 border hover:shadow-xs bg-blue-600 text-white uppercase hover:bg-blue-800">
                                {{ __('settings.apps.actions.connect') }}
                            </a>
                        @endif
                    </div>
                </div>

                <p class="text-muted mb-0">
                    {{ __('settings.apps.discord.text') }}
                </p>
            </div>
        </div>
    </div>
@endsection

@section('modals')
    @parent

    <x-dialog id="remove-discord" :title="__('crud.delete_modal.title')">
        <p class="my-4">{{ __('settings.apps.discord.confirm') }}</p>

        <div class="grid grid-cols-2 gap-2 w-full">
            <x-buttons.confirm type="ghost" full="true" dismiss="dialog">
                {{ __('crud.cancel') }}
            </x-buttons.confirm>

            {!! Form::open([
                    'method' => 'DELETE',
                    'route' => [
                        'settings.discord.destroy'
                    ],
                    'style' => 'display:inline',
                    'id' => 'delete-form-discord'
                ]) !!}
                <x-buttons.confirm type="danger" outline="true" full="true">
                    {{ __('crud.click_modal.confirm') }}
                </x-buttons.confirm>
            {!! Form::close() !!}
        </div>
    </x-dialog>
@endsection
