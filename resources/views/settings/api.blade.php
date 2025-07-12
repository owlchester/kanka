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
                Personal Access Tokens
            </span>
            <a href="{{ route('settings.api.create') }}" class="btn2 btn-primary btn-outline btn-sm"
                data-toggle="dialog-ajax" data-target="primary-dialog" data-url="{{ route('settings.api.create') }}">
                <x-icon class="fa-solid fa-plus" />
                <span class="hidden lg:inline">Create New Token</span>
            </a>
        </div>

        @if (session('new_token'))
            <div class="bg-green-100 text-green-900 rounded p-4 mb-4">
                <p><strong>Your new personal access token:</strong></p>
                <pre class="bg-white border p-2 overflow-x-auto">{{ session('new_token') }}</pre>
                <p class="text-sm text-gray-600">This is the only time it will be shown. Copy it now!</p>
            </div>
        @endif

        @if (empty($tokens))
            <p>You have not created any personal access tokens.</p>
        @else
            <table class="table-auto w-full border-collapse">
                <thead>
                    <tr class="text-left border-b">
                        <th class="p-2">Name</th>
                        <th class="p-2 text-right">Actions</th>
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
        @endif
    </div>
    @if($applications->count() > 0)
        <div class="container mx-auto p-4 max-w-4xl">
            <div class="flex justify-between items-center mb-6">
                <span class="text-lg">
                    Authorized Applications
                </span>
            </div>

            <table class="table-auto w-full border-collapse">
                <thead>
                    <tr class="text-left border-b">
                        <th class="p-2">Name</th>
                        <th class="p-2">Scopes</th>
                        <th class="p-2 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($applications as $application)
                        <tr class="border-b">
                            <td class="p-2 align-middle">
                                {{ $application['name'] }}
                            </td>
                            <td class="p-2 align-middle">
                                {{implode(", ", $application['scopes'])}}
                            </td>
                            <td class="p-2 align-middle text-right">
                                <form action="{{ route('settings.api.revoke', ['token' => $application['id']]) }}" method="POST" class="inline">
                                    <x-buttons.confirm-delete :route="route('settings.api.revoke', ['token' => $application['id']])" />
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
                        OAuth Clients
                    </span>

                    <a href="{{ route('settings.client.create') }}" class="btn2 btn-primary btn-outline btn-sm"
                        data-toggle="dialog-ajax" data-target="primary-dialog" data-url="{{ route('settings.client.create') }}">
                        <x-icon class="fa-solid fa-plus" />
                        <span class="hidden lg:inline">Create New Client</span>
                    </a>
                </div>
            </div>

            @if ($clients->count() == 0)
                <p>You have not created any OAuth clients.</p>
            @else
                <table class="table-auto w-full border-collapse">
                    <thead>
                        <tr class="text-left border-b">
                            <th class="p-2">Client ID</th>
                            <th class="p-2">Name</th>
                            <th class="p-2">Secret</th>
                            <th class="p-2 text-right">Actions</th>
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
            @endif
        </div>
    @endif
@endsection
