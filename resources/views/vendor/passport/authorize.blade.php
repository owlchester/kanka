@extends('layouts.login', [
    'title' => 'Kanka oAuth Authorization',
])

@section('content')
    <h1 class="text-2xl leading-tight dark:text-slate-200">
        {{ __('Authorization Request') }}
    </h1>

    <p>The application <strong>{{ $client->name }}</strong> is requesting permission to access your Kanka account.</p>

    <!-- Scope List -->
    @if (count($scopes) > 0)
        <div class="scopes">
            <p><strong>This application will be able to:</strong></p>

            <ul>
                @foreach ($scopes as $scope)
                    <li>{{ $scope->description }}</li>
                @endforeach
            </ul>
        </div>
    @else
        <p class="text-orange-500 dark:text-orange-300">
            <x-icon class="fa-regular fa-exclamation-triangle" />
           This application will have full access to your account and campaigns.
        </p>
    @endif

    <div class="flex flex-col md:grid grid-cols-2 gap-4">
        <!-- Authorize Button -->
        <form method="post" action="{{ route('passport.authorizations.approve') }}">
            @csrf

            <input type="hidden" name="state" value="{{ $request->state }}">
            <input type="hidden" name="client_id" value="{{ $client->id }}">
            <input type="hidden" name="auth_token" value="{{ $authToken }}">
            <button type="submit" class="w-full rounded border border-blue-500 text-blue-500 uppercase px-6 py-2 transition-all bg-white hover:shadow-xs hover:bg-blue-500 hover:text-white dark:bg-slate-800">
                <x-icon class="check" />
                Authorize
            </button>
        </form>

        <!-- Cancel Button -->
        <form method="post" action="{{ route('passport.authorizations.deny') }}">
            @csrf
            @method('DELETE')

            <input type="hidden" name="state" value="{{ $request->state }}">
            <input type="hidden" name="client_id" value="{{ $client->id }}">
            <input type="hidden" name="auth_token" value="{{ $authToken }}">
            <button class="w-full rounded border border-red-500 text-red-500 uppercase px-6 py-2 transition-all bg-white hover:shadow-xs hover:bg-red-500 hover:text-white dark:bg-slate-800">
                <x-icon class="fa-regular fa-ban" />
                Deny
            </button>
        </form>
    </div>

    <hr class="border-gray-800 dark:border-gray-700" />
    <p class="text-sm">If you are unsure why you are seeing this, contact us at <a class="text-blue-500 hover:text-blue-800 transition-all duration-150" href="mailto:{{ config('app.email') }}">{{ config('app.email') }}</a> or reach out directly on <a href="https://kanka.io/go/discord" class="text-blue-500 hover:text-blue-800 transition-all duration-150">Discord</a>.</p>

@endsection
