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
        <div class="rounded shadow-sm bg-box p-5">

            <div class="flex gap-2 items-center">
                <div class="flex-0">
                    <i class="fa-brands fa-discord fa-3x text-indigo-400" aria-hidden="true"></i>
                </div>
                <div class="grow">
                    <strong>Discord</strong>
                    <p class="text-muted mb-0">
                        {{ __('settings.apps.discord.text') }}
                    </p>
                </div>
                <div class="flex-0">
                    @if(!$discord = auth()->user()->apps()->app('discord')->first())
                        <button class="rounded px-6 py-2 border text-red-500 border-red-500 hover:bg-red-500 hover:text-white hover:shadow-xs" data-toggle="dialog" data-target="remove-discord"
                                title="{{ __('settings.apps.actions.remove') }}">
                            {{ __('settings.apps.actions.remove') }} @if (!empty($discord->settings)) {{ $discord->settings['username'] }}#{{ $discord->settings['discriminator'] }} @endif
                        </button>
                    @else

                        <a href="https://discord.com/api/oauth2/authorize?client_id={{ config('discord.client_id') }}&redirect_uri={{ url('/settings/discord-callback') }}&response_type=code&scope=identify+guilds+guilds.join" class="inline-block rounded px-6 py-2 border hover:shadow-xs bg-blue-600 text-white uppercase hover:bg-blue-800">
                            {{ __('settings.apps.actions.connect') }}
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@section('modals')
    @parent
    <dialog class="dialog rounded-2xl " id="remove-discord" aria-modal="true" aria-labelledby="helpModalLabelremove-discord">
        <header>
            <h4 id="helpModalLabelremove-discord">
                {!! __('crud.delete_modal.title') !!}
            </h4>
            <button type="button" class="rounded-full" onclick="this.closest('dialog').close('close')">
                <i class="fa-solid fa-times" aria-hidden="true"></i>
                <span class="sr-only">{{ __('crud.delete_modal.close') }}</span>
            </button>
        </header>
        <article>
            {!! Form::open([
                'method' => 'DELETE',
                'route' => [
                    'settings.discord.destroy'
                ],
                'style' => 'display:inline',
                'id' => 'delete-form-discord'
            ]) !!}
            <p class="my-4">{{ __('settings.apps.discord.confirm') }}</p>

            <button class="rounded w-full px-6 py-2 border text-red-500 border-red-500 hover:bg-red-500 hover:text-white hover:shadow-xs">
                {{ __('crud.click_modal.confirm') }}
            </button>
            {!! Form::close() !!}
        </article>
    </dialog>

@endsection
