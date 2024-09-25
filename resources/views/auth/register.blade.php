@extends('layouts.login', [
    'title' => __('auth.register.title')
])

@php
    if (app()->isLocal() && config('auth.fast_registration')) {
        $name = 'Kanka' . rand(100, 9999999);
        $email = $name . '@kanka.io';
    }
@endphp

@section('content')
    <h1 class="text-2xl leading-tight mb-3 dark:text-slate-200">
        {{ __('auth.register.title') }}
    </h1>


    @if (session()->has('info'))
        <div class="p-4 rounded bg-blue-200 text-blue-800 mb-2">
            {!! session()->get('info') !!}
        </div>
    @endif
    @if (count($errors) > 0)
        <div class="p-4 rounded bg-red-200 text-red-800 mb-2">
            <strong>{{ trans('partials.errors.title') }}</strong>
            {{ trans('partials.errors.description') }}<br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('register') }}" class="submit-lock w-full" id="registration">
        {{ csrf_field() }}

        <div class="mb-3 has-feedback{{ $errors->has('name') ? ' has-error' : '' }}">
            <div class="flex items-stretch w-full">
                <input id="name" type="text" class="rounded border p-2 w-full dark:bg-slate-800 dark:border-slate-500" name="name" @if (app()->isLocal() && config('auth.fast_registration')) value="{{ $name }}" @else value="{!! old('name') !!}" @endif placeholder="{{ __('auth.register.fields.name') }}" required autofocus>
            </div>
            @if ($errors->has('name'))
                <span class="text-red-500">{{ $errors->first('name') }}</span>
            @endif
        </div>

        <div class="mb-3 has-feedback{{ $errors->has('email') ? ' has-error' : '' }}">
            <input id="email" type="email" class="rounded border p-2 w-full dark:bg-slate-800 dark:border-slate-500" name="email" @if (app()->isLocal() && config('auth.fast_registration')) value="{{ $email }}" @else value="{!! old('email') !!}" @endif placeholder="{{ __('auth.register.fields.email') }}" required>

            @if ($errors->has('email'))
                <span class="text-red-500">{{ $errors->first('email') }}</span>
            @endif
        </div>

        <div class="mb-3{{ $errors->has('password') ? ' has-error' : '' }}">
            <div class="flex items-stretch w-full">
                <input id="password" type="password" class="rounded border p-2 w-full dark:bg-slate-800 dark:border-slate-500" name="password" required @if (app()->isLocal() && config('auth.fast_registration')) value="{{ $name }}" @endif placeholder="{{ __('auth.register.fields.password') }}">
                <a href="#" id="toggle-password" class="p-2" tabindex="-1" title="{{ __('auth.helpers.password') }}">
                    <i id="toggle-password-icon" class="fa-solid fa-eye" aria-hidden="true"></i>
                    <span class="sr-only">{{ __('auth.helpers.password') }}</span>
                </a>
            </div>

            @if ($errors->has('password'))
                <span class="text-red-500">{{ $errors->first('password') }}</span>
            @endif
        </div>
        <div class="mb-3">
            <div class="text-gray-500 text-sm">
                <label for="newsletter" class="dark:text-slate-200">
                    <input id="newsletter" type="checkbox" name="newsletter" value="1" />
                    {!! __('front/newsletter.groups.all') !!}
                </label>
            </div>
        </div>
        <div class="flex gap-2">
            <div class="grow text-xs text-gray-500">
                {!! __('auth.register.tos', [
    'terms' => '<a href="https://kanka.io/terms-and-conditions" class="text-blue-500 hover:text-blue-800">' . __('footer.terms') . '</a>',
    'privacy' => '<a href="https://kanka.io/privacy-policy" class="text-blue-500 hover:text-blue-800">' . __('footer.privacy') . '</a>',
    ]) !!}
            </div>
            <div class="flex-none">
                <div id="btn-wait" class="rounded border border-gray-200 px-6 py-2 bg-gray-200 disabled" style="display: none;">
                    <x-icon class="load" />
                </div>

                <button id="btn-save" type="submit" class="@if (config('auth.recaptcha.enabled')) g-recaptcha @endif rounded border border-blue-500 text-blue-500 uppercase px-6 py-2 transition-all  hover:shadow-xs hover:bg-blue-500 hover:text-white"
                        @if (config('auth.recaptcha.enabled'))data-sitekey="{{ config('auth.recaptcha.key') }}" data-callback="tokenValidated" data-action="submit" @endif>
                    {{ __('auth.register.submit') }}
                </button>
            </div>
        </div>

    </form>

    <div class="social-auth-links text-center mb-3">
        <p class="mb-2 text-gray-500 dark:text-slate-200">- {{ __('auth.login.or') }} -</p>

        <div class="flex flex-col gap-2">
            @if(config('services.facebook.client_id'))
                <a href="{{ route('auth.provider', ['provider' => 'facebook']) }}" class="rounded border border-blue-500 text-blue-500 hover:text-white hover:bg-blue-500 px-6 py-2 uppercase transition-all duration-150" title="{{ __('auth.register.register_with_facebook') }}">
                    <x-icon class="fa-brands fa-facebook-f" />
                    Facebook
                </a>
            @endif

            @if(config('services.google.client_id'))
                <a href="{{ route('auth.provider', ['provider' => 'google']) }}" class="rounded border border-red-400 text-red-400 hover:text-white hover:bg-red-400 px-6 py-2 uppercase transition-all duration-150" title="{{ __('auth.register.register_with_google') }}">
                    <x-icon class="fa-brands fa-google" />
                    Google
                </a>
            @endif

            @if(config('services.twitter.client_id'))
                <a href="{{ route('auth.provider', ['provider' => 'twitter']) }}" class="rounded border border-blue-300 text-blue-300 hover:text-white hover:bg-blue-300 px-6 py-2 uppercase transition-all duration-150" title="{{ __('auth.register.register_with_x') }}">
                    <x-icon class="fa-brands fa-x-twitter" />
                    X
                </a>
            @endif
        </div>
    </div>

    <p class="text-sm text-gray-500 dark:text-slate-200">
        {!! __('auth.register.already', ['login' => '<a href="' . route('login') . '" class="text-blue-500" hover:text-blue-800">' . __('auth.register.log-in') . '</a>']) !!}
    </p>
</div>
@endsection

@section('scripts')
    @if (config('auth.recaptcha.enabled'))
    <script src="https://www.google.com/recaptcha/api.js"></script>
    <script>
        function tokenValidated(token) {
            document.getElementById("registration").requestSubmit();
        }
    </script>
    @endif
@endsection
