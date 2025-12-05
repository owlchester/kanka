@extends('layouts.app', [
    'title' => __('settings.api.title'),
    'breadcrumbs' => false,
    'sidebar' => 'settings',
    'centered' => true,
])

@section('content')
    @include('partials.errors')
    <div class="container mx-auto p-4 max-w-4xl flex flex-col gap-4">
        <x-hero>
            <x-slot name="title">{{ __('settings.api.title') }}</x-slot>
            <x-slot name="subtitle">{{ __('settings.api.helper') }}</x-slot>
            <x-slot name="link">
                <a href="{{ route('larecipe.index') }}" class="">
                    <x-icon class="link" />
                    {{ __('front.features.api.link') }}
                </a>
            </x-slot>
        </x-hero>

        <div class="flex justify-between items-center">
            <span class="text-lg">
                {{ __('settings/api.tokens.title') }}
            </span>
            <a href="{{ route('settings.api.create') }}" class="btn2 btn-primary btn-outline btn-sm"
                data-toggle="dialog" data-url="{{ route('settings.api.create') }}">
                <x-icon class="fa-regular fa-plus" />
                <span class="hidden lg:inline"> {{ __('settings/api.tokens.new') }}</span>
            </a>
        </div>
        @if (session('new_token'))
            <x-box>
                <p><strong>{{ __('settings/api.new.title') }}</strong></p>
                <span class="cursor-pointer text-link break-all" data-clipboard="{{ session('new_token') }}" data-toast="{{ __('settings/api.new.copy') }}" data-toggle="tooltip" data-title="Click to copy to the clipboard">
                    {{ session('new_token') }}
                    <x-icon class="copy" />
                </span>
            </x-box>
        @endif
        @if (empty($tokens))
            <p>
                {{ __('settings/api.tokens.empty') }}
            </p>
        @else
            <div class="table-responsive">
                <table class="table table-default table-borderless table-hover">
                    <thead>
                        <tr class=" ">
                            <th >{{ __('crud.fields.name') }}</th>
                            <th class="text-right">{{ __('crud.actions.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($tokens as $token)
                            <tr class="">
                                <td class="align-middle">
                                    {{ $token['name'] }}
                                </td>
                                <td class="align-middle text-right">
                                    <form action="{{ route('settings.api.revoke', ['token' => $token['id']]) }}" method="POST" class="inline">
                                        <x-buttons.confirm-delete :route="route('settings.api.revoke', ['token' => $token['id']])" />
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
        @if ($tokens->hasPages())
            {!! $tokens->links() !!}
        @endif
    @if($applications->count() > 0)
        <div class="flex justify-between items-center ">
            <span class="text-lg">
                {{ __('settings/api.applications.title') }}
            </span>
        </div>

            <table class="table table-default table-borderless table-hover">
            <thead>
                <tr class=" ">
                    <th >{{ __('crud.fields.name') }}</th>
                    <th >{{ __('settings/api.fields.scopes') }}</th>
                    <th class="text-right">{{ __('crud.actions.actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($applications as $application)
                    <tr class="">
                        <td class="align-middle">
                            {{ $application->client['name'] }}
                        </td>
                        <td class="align-middle">
                            {{implode(", ", $application['scopes'])}}
                        </td>
                        <td class="align-middle text-right">
                            <form action="{{ route('settings.api.revoke', ['token' => $application['id']]) }}" method="POST" class="inline">
                                <x-buttons.confirm-delete :route="route('settings.api.revoke', ['token' => $application['id']])" confirm="settings/api.revoke-confirm" delete="settings/api.revoke"/>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
    @if (request()->has('clients'))
            <div class="flex justify-between items-center">
                <span class="text-lg">
                    {{ __('settings/api.clients.title') }}
                </span>

                <a href="{{ route('settings.client.create') }}" class="btn2 btn-primary btn-outline btn-sm"
                    data-toggle="dialog" data-url="{{ route('settings.client.create') }}">
                    <x-icon class="fa-regular fa-plus" />
                    <span class="hidden lg:inline">{{ __('settings/api.clients.new') }}</span>
                </a>
            </div>

            @if ($clients->count() == 0)
                <p>{{ __('settings/api.clients.empty') }}</p>
            @else
                <div class="table-responsive">
                    <table class="table table-default table-borderless table-hover">
                        <thead>
                            <tr class=" ">
                                <th >{{ __('settings/api.fields.client') }}</th>
                                <th >{{ __('crud.fields.name') }}</th>
                                <th >{{ __('settings/api.fields.secret') }}</th>
                                <th class="text-right">{{ __('crud.actions.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($clients as $client)
                                <tr class="">
                                    <td class="align-middle">
                                        {{ $client['id'] }}
                                    </td>
                                    <td class="align-middle">
                                        {{ $client['name'] }}
                                    </td>
                                    <td class="align-middle">
                                        <code>******</code>
                                    </td>
                                    <td class="align-middle text-right">
                                        <a href="{{ route('settings.client.edit', ['client' => $client['id']]) }}" class="btn2 btn-primary btn-outline btn-sm"
                                            data-toggle="dialog" data-url="{{ route('settings.client.edit', ['client' => $client['id']]) }}">
                                            <x-icon class="fa-regular fa-pencil" />
                                            <span class="hidden lg:inline">Edit</span>
                                        </a>
                                        <form action="{{ route('settings.client.revoke', ['client' => $client['id']]) }}" method="POST" class="inline">
                                            <x-buttons.confirm-delete :route="route('settings.client.revoke', ['client' => $client['id']])" />
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
            @endif
        @if ($clients->hasPages())
            {!! $clients->links() !!}
        @endif
    @endif
@endsection
