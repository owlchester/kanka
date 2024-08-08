<?php /** @var \App\Models\UserApp $discord */?>
@extends('layouts.app', [
    'title' => __('settings.apps.title'),
    'description' => '',
    'breadcrumbs' => false,
    'sidebar' => 'settings',
    'centered' => true,
])

@section('content')
    <x-grid type="1/1">
        <h1>
            {{ __('settings.apps.title') }}
        </h1>
        <p class="text-lg">
            {!! __('settings.apps.benefits') !!}
        </p>
        @include('partials.errors')
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <x-box>
                <x-grid type="1/1">
                    <div class="flex gap-2 items-center ">
                        <div class="flex-0">
                            <x-icon class="fa-brands fa-discord fa-3x text-indigo-400" />
                        </div>
                        <div class="grow text-lg font-extrabold truncate">
                            Discord
                        </div>
                        <div class="flex-0">
                            @if($discord = auth()->user()->apps()->app('discord')->first())
                                <x-buttons.confirm type="danger" target="remove-discord" outline="true" size="sm">
                                    <x-icon class="fa-solid fa-link-slash" />
                                    <span>
                                        {{ __('settings.apps.actions.remove') }}
                                        @if (!empty($discord->settings)) {{ $discord->settings['username'] }}
                                        @if (!empty($discord->settings['discriminator']))#{{ $discord->settings['discriminator'] }} @endif
                                        @endif
                                    </span>
                                </x-buttons.confirm>
                            @else
                                <a href="https://discord.com/api/oauth2/authorize?client_id={{ config('discord.client_id') }}&redirect_uri={{ url('/settings/discord-callback') }}&response_type=code&scope=identify+guilds+guilds.join" class="btn2 btn-primary btn-outline btn-sm">
                                    {{ __('settings.apps.actions.connect') }}
                                </a>
                            @endif
                        </div>
                    </div>

                    <p class="text-neutral-content">
                        {{ __('settings.apps.discord.text') }}
                    </p>
                </x-grid>
            </x-box>
        </div>
    </x-grid>
@endsection

@section('modals')
    @parent

    <x-dialog id="remove-discord" :title="__('crud.delete_modal.title')">
        <p class="my-4">{{ __('settings.apps.discord.confirm') }}</p>

        <div class="grid grid-cols-2 gap-2 w-full">
            <x-buttons.confirm type="ghost" full="true" dismiss="dialog">
                {{ __('crud.cancel') }}
            </x-buttons.confirm>

            <x-form method="DELETE" :action="['settings.discord.destroy']" id="delete-form-discord">
                <x-buttons.confirm type="danger" outline="true" full="true">
                    {{ __('crud.click_modal.confirm') }}
                </x-buttons.confirm>
            </x-form>
        </div>
    </x-dialog>
@endsection
