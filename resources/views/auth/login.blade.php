@extends('layouts.login', ['title' => __('auth.login.title')])

@section('content')
    <h1 class="text-2xl leading-tight mb-3 dark:text-slate-200">{{ __('auth.login.title') }}</h1>

    @if (session()->has('info'))
        <div class="p-4 rounded bg-blue-200 text-blue-800 mb-2">
            {!! session()->get('info')  !!}
        </div>
    @endif
    @include('partials.success')


    @if(config('auth.user_list'))
        <ul class="mb-2">
            @foreach (\App\Models\User::limit(5)->orderBy('last_login_at', 'desc')->get() as $user)
                <li>
                    <a href="{{ route('login-as-user', ['user' => $user]) }}" class="text-blue-500 hover:text-blue-900">
                        {!! $user->name !!} @if ($user->pledge) ({!! $user->pledge !!}) @endif
                    </a>
                </li>
            @endforeach
        </ul>

        <form method="GET" action="{{ route('login-as') }}" class="w-full">
            {{ csrf_field() }}
            <select id="user" name="user" class="rounded border p-2 w-full dark:bg-slate-800 dark:border-slate-500">
                @foreach (\App\Models\User::limit(30)->get() as $user)
                    <option value="{{ $user->id }}">{!! $user->name !!} @if ($user->pledge) ({!! $user->pledge !!}) @endif</option>
                @endforeach
            </select>

            <button type="submit" class="w-full rounded border border-blue-500 text-blue-500 uppercase px-6 py-2 transition-all bg-white hover:shadow-xs hover:bg-blue-500 hover:text-white dark:bg-slate-800">
                {{ __('auth.login.submit') }}
            </button>
        </form>
    @else
        <form method="POST" action="{{ route('login') }}" class="w-full flex flex-col gap-3">
            {{ csrf_field() }}
            <div class="{{ $errors->has('email') ? ' has-error' : '' }}">
                <input id="email" type="email" class="rounded border p-2 w-full dark:bg-slate-800 dark:border-slate-500" name="email" value="{{ old('email') }}" placeholder="{{ __('auth.login.fields.email') }}" required autofocus>

                @if ($errors->has('email'))
                    <span class="text-red-500">
                    {{ $errors->first('email') }}
                    </span>
                @endif
            </div>

            <div class="{{ $errors->has('password') ? ' has-error' : '' }}">
                <div class="flex items-stretch w-full">
                    <input id="password" type="password" class="border rounded w-full p-2 dark:bg-slate-800 dark:border-slate-500" name="password" required placeholder="{{ __('auth.login.fields.password') }}">
                    <a href="#" id="toggle-password" class="input-group-addon p-2" title="{{ __('auth.helpers.password') }}">
                        <i id="toggle-password-icon" class="fa-regular fa-eye" aria-hidden="true"></i>
                        <span class="sr-only">{{ __('auth.helpers.password') }}</span>
                    </a>
                </div>

                @if ($errors->has('password'))
                    <span class="text-red-500">
                        {{ $errors->first('password') }}
                    </span>
                @endif
            </div>

            <input type="hidden" name="remember" value="1" />

            <button type="submit" class="w-full rounded border border-blue-500 text-blue-500 uppercase px-6 py-2 transition-all bg-white hover:shadow-xs hover:bg-blue-500 hover:text-white dark:bg-slate-800">
                {{ __('auth.login.submit') }}
            </button>
        </form>
    @endif

    @if(config('auth.register_enabled'))
        <p class="text-center my-2 text-sm">
            {{ __('auth.login.no-account') }}
            <a class="text-blue-500 hover:text-blue-800 transition-all duration-150" href="{{ route('register') }}">
                {{ __('auth.login.sign-up') }}
            </a>
        </p>
    @endif

@if(config('auth.register_enabled'))
    <div class="social-auth-links text-center mb-3">
        <p class="mb-2 text-gray-500 dark:text-slate-200 m-3">- {{ __('auth.login.or') }} -</p>

        <div class="flex flex-col gap-2">
            @if(config('services.facebook.client_id'))
            <a href="{{ route('auth.provider', ['provider' => 'facebook']) }}" class="rounded border border-blue-500 text-blue-500 hover:text-white hover:bg-blue-500 px-6 py-2 transition-all duration-150 flex gap-3 items-center" title="{{ __('auth.continue.facebook') }}">
                <x-icon class="fa-brands fa-facebook-f" />
                {{ __('auth.continue.facebook') }}
            </a>
            @endif

            @if(config('services.google.client_id'))
            <a href="{{ route('auth.provider', ['provider' => 'google']) }}" class="rounded border border-red-400 text-red-400 hover:text-white hover:bg-red-400 px-6 py-2 transition-all duration-150 flex gap-3 items-center" title="{{ __('auth.continue.google') }}">
                <x-icon class="fa-brands fa-google" />
                {{ __('auth.continue.google') }}
            </a>
            @endif

            @if(config('services.twitter.client_id'))
            <a href="{{ route('auth.provider', ['provider' => 'twitter']) }}" class="rounded border border-blue-300 text-blue-300 hover:text-white hover:bg-blue-300 px-6 py-2 transition-all duration-150 flex gap-3 items-center" title="{{ __('auth.continue.x') }}">
                <x-icon class="fa-brands fa-x-twitter" />
                {{ __('auth.continue.x') }}
            </a>
            @endif
        </div>
    </div>
@endif
    <div class="grid grid-cols-2 gap-2 justify-center">
        <a class="text-blue-500 hover:text-blue-800 transition-all duration-150" href="{{ route('password.request') }}">
            {{ __('auth.login.password_forgotten') }}
        </a>
    </div>
@endsection
