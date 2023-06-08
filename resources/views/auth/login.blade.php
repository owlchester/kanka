@extends('layouts.login', ['title' => __('auth.login.title')])

@section('content')
    <h1 class="text-2xl leading-tight mb-3">{{ __('auth.login.title') }}</h1>

    @if (session()->has('info'))
        <div class="p-4 rounded bg-blue-200 text-blue-800 mb-2">
            {{ session()->get('info') }}
        </div>
    @endif
    @include('partials.success')


    @if(config('auth.user_list'))
        <ul class="mb-2">
            @foreach (\App\User::limit(5)->orderBy('last_login_at', 'desc')->get() as $user)
                <li>
                    <a href="{{ route('login-as-user', ['user' => $user]) }}" class="text-blue-500 hover:text-blue-900">
                        {!! $user->name !!}
                    </a>
                </li>
            @endforeach
        </ul>
    @endif


    <form method="POST" action="{{ route('login') }}" class="w-full">
        {{ csrf_field() }}
        <div class="mb-3 {{ $errors->has('email') ? ' has-error' : '' }}">
            @if(config('auth.user_list'))
                <select id="email" name="email" class="rounded border p-2 w-full">
                    @foreach (\App\User::limit(30)->get() as $user)
                        <option value="{{ $user->email}}">{!! $user->name !!}</option>
                    @endforeach
                </select>
            @else
                <input id="email" type="email" class="rounded border p-2 w-full" name="email" value="{{ old('email') }}" placeholder="{{ __('auth.login.fields.email') }}" required autofocus>
            @endif
            <span class="fa-solid fa-envelope form-control-feedback"></span>

            @if ($errors->has('email'))
                <span class="text-red-500">
                   {{ $errors->first('email') }}
                </span>
            @endif
        </div>

        <div class="mb-3 {{ $errors->has('password') ? ' has-error' : '' }}">
            <div class="flex items-stretch w-full">
                <input id="password" type="password" class="border rounded w-full p-2" name="password" required placeholder="{{ __('auth.login.fields.password') }}">
                <a href="#" id="toggle-password" class="input-group-addon p-2" title="{{ __('auth.helpers.password') }}">
                    <i id="toggle-password-icon" class="fa-solid fa-eye" aria-hidden="true"></i>
                    <span class="sr-only">{{ __('auth.helpers.password') }}</span>
                </a>
            </div>

            @if ($errors->has('password'))
                <span class="text-red-500">
                    {{ $errors->first('password') }}
                </span>
            @endif
        </div>

        <div class="flex gap-2 items-center">
            <div class="grow">
                <label>
                    <input type="checkbox" class="minimal" name="remember" {{ old('remember') ? 'checked' : '' }}>
                    {{ __('auth.login.remember_me') }}
                </label>
            </div>
            <div class="self-end">
                <button type="submit" class="rounded border border-blue-500 text-blue-500 uppercase px-6 py-2 transition-all bg-white hover:shadow-xs hover:bg-blue-500 hover:text-white">
                    {{ __('auth.login.submit') }}
                </button>
            </div>
        </div>
    </form>

@if(config('auth.register_enabled'))
    <div class="social-auth-links text-center mb-3">
        <p class="mb-2 text-gray-500">- {{ __('auth.login.or') }} -</p>

        <div class="flex flex-col gap-2">
            @if(config('services.facebook.client_id'))
            <a href="{{ route('auth.provider', ['provider' => 'facebook']) }}" class="rounded border border-blue-500 text-blue-500 hover:text-white hover:bg-blue-500 px-6 py-2 uppercase transition-all duration-150" title="{{ __('auth.login.login_with_facebook') }}">
                <i class="fa-brands fa-facebook-f" aria-hidden="true"></i>
                Facebook
            </a>
            @endif

            @if(config('services.google.client_id'))
            <a href="{{ route('auth.provider', ['provider' => 'google']) }}" class="rounded border border-red-400 text-red-400 hover:text-white hover:bg-red-400 px-6 py-2 uppercase transition-all duration-150" title="{{ __('auth.login.login_with_google') }}">
                <i class="fa-brands fa-google" aria-hidden="true"></i>
                Google
            </a>
            @endif

            @if(config('services.twitter.client_id'))
            <a href="{{ route('auth.provider', ['provider' => 'twitter']) }}" class="rounded border border-blue-300 text-blue-300 hover:text-white hover:bg-blue-300 px-6 py-2 uppercase transition-all duration-150" title="{{ __('auth.login.login_with_twitter') }}">
                <i class="fa-brands fa-twitter" aria-hidden="true"></i>
                Twitter
            </a>
            @endif
        </div>
    </div>
@endif
    <div class="grid grid-cols-2 gap-2">
        <div class="text-center">
            <a class="text-blue-500 hover:text-blue-800 transition-all duration-150" href="{{ route('password.request') }}">
                {{ __('auth.login.password_forgotten') }}
            </a>
        </div>@if(config('auth.register_enabled'))
        <div class="text-center">
            <a class="text-blue-500 hover:text-blue-800 transition-all duration-150" href="{{ route('register') }}">
                {{ __('auth.login.new_account') }}
            </a>
        </div>@endif
    </div>
@endsection
