@extends('layouts.app', [
    'title' => __('settings.api.title'),
    'breadcrumbs' => false,
    'sidebar' => 'settings',
    'centered' => true,
])

@section('content')
    @include('partials.errors')
    <div class="container mx-auto p-4 max-w-4xl">
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

        <div class="flex justify-between items-center mb-6">
            <span class="text-lg">
                {{ __('settings/api.tokens.title') }}
            </span>
            <a href="{{ route('settings.api.create') }}" class="btn2 btn-primary btn-outline btn-sm"
                data-toggle="dialog-ajax" data-target="primary-dialog" data-url="{{ route('settings.api.create') }}">
                <x-icon class="fa-solid fa-plus" />
                <span class="hidden lg:inline"> {{ __('settings/api.tokens.new') }}</span>
            </a>
        </div>

        @if (session('new_token'))
            <div class="bg-green-100 text-green-900 rounded p-4 mb-4">
                <p><strong>{{ __('settings/api.new.title') }}</strong></p>
                <pre class="bg-white border p-2 overflow-x-auto" >
                    <a href="#" data-clipboard="{{ session('new_token') }}" data-toast="{{ __('settings/api.new.copy') }}">
                        {{ session('new_token') }}
                    </a>
                </pre>
                <p class="text-sm text-gray-600">{{ __('settings/api.new.helper') }}</p>
            </div>
        @endif
        @if (empty($tokens))
            <p>
                {{ __('settings/api.tokens.empty') }}
            </p>
        @else
            <div class="table-responsive">
                <table class="table table-hover table-auto w-full border-collapse">
                    <thead>
                        <tr class="text-left border-b">
                            <th class="p-2">{{ __('crud.fields.name') }}</th>
                            <th class="p-2 text-right">{{ __('crud.actions.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($tokens as $token)
                            <tr class="border-b">
                                <td class="p-2 align-middle">
                                    {{ $token['name'] }}
                                </td>
                                <td class="p-2 align-middle text-right">
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
    </div>
    @if($applications->count() > 0)
        <div class="container mx-auto p-4 max-w-4xl">
            <div class="flex justify-between items-center mb-6">
                <span class="text-lg">
                    {{ __('settings/api.applications.title') }}
                </span>
            </div>

            <table class="table-auto w-full border-collapse">
                <thead>
                    <tr class="text-left border-b">
                        <th class="p-2">{{ __('crud.fields.name') }}</th>
                        <th class="p-2">{{ __('settings/api.fields.scopes') }}</th>
                        <th class="p-2 text-right">{{ __('crud.actions.actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($applications as $application)
                        <tr class="border-b">
                            <td class="p-2 align-middle">
                                {{ $application->client['name'] }}
                            </td>
                            <td class="p-2 align-middle">
                                {{implode(", ", $application['scopes'])}}
                            </td>
                            <td class="p-2 align-middle text-right">
                                <form action="{{ route('settings.api.revoke', ['token' => $application['id']]) }}" method="POST" class="inline">
                                    <x-buttons.confirm-delete :route="route('settings.api.revoke', ['token' => $application['id']])" confirm="settings/api.revoke-confirm" delete="settings/api.revoke"/>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
    @if (request()->has('clients'))
        <div class="container mx-auto p-4 max-w-4xl">
            <div class="card-header">
                <div class="flex justify-between items-center">
                    <span class="text-lg">
                        {{ __('settings/api.clients.title') }}
                    </span>

                    <a href="{{ route('settings.client.create') }}" class="btn2 btn-primary btn-outline btn-sm"
                        data-toggle="dialog-ajax" data-target="primary-dialog" data-url="{{ route('settings.client.create') }}">
                        <x-icon class="fa-solid fa-plus" />
                        <span class="hidden lg:inline">{{ __('settings/api.clients.new') }}</span>
                    </a>
                </div>
            </div>

            @if ($clients->count() == 0)
                <p>{{ __('settings/api.clients.empty') }}</p>
            @else
                <div class="table-responsive">
                    <table class="table-auto w-full border-collapse">
                        <thead>
                            <tr class="text-left border-b">
                                <th class="p-2">{{ __('settings/api.fields.client') }}</th>
                                <th class="p-2">{{ __('crud.fields.name') }}</th>
                                <th class="p-2">{{ __('settings/api.fields.secret') }}</th>
                                <th class="p-2 text-right">{{ __('crud.actions.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($clients as $client)
                                <tr class="border-b">
                                    <td class="p-2 align-middle">
                                        {{ $client['id'] }}
                                    </td>
                                    <td class="p-2 align-middle">
                                        {{ $client['name'] }}
                                    </td>                                
                                    <td class="p-2 align-middle">
                                        <code>******</code>
                                    </td>
                                    <td class="p-2 align-middle text-right">
                                        <a href="{{ route('settings.client.edit', ['client' => $client['id']]) }}" class="btn2 btn-primary btn-outline btn-sm"
                                            data-toggle="dialog-ajax" data-target="primary-dialog" data-url="{{ route('settings.client.edit', ['client' => $client['id']]) }}">
                                            <x-icon class="fa-solid fa-pencil" />
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
                </div>
            @endif
        </div>
        @if ($clients->hasPages())
            {!! $clients->links() !!}
        @endif
    @endif
@endsection
