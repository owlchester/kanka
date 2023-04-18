@extends('layouts.login', ['title' => __('auth.reset.title')])


@section('content')
   <h1 class="text-2xl leading-tight mb-3">{{ __('auth.reset.title') }}</h1>

    <form class="w-full" method="POST" action="{{ route('password.request') }}">
        {{ csrf_field() }}

        <input type="hidden" name="token" value="{{ $token }}">

        <div class="mb-3 {{ $errors->has('email') ? ' has-error' : '' }}">
            <label for="email" class="">{{ __('auth.reset.fields.email') }}</label>

            <input id="email" type="email" class="rounded border p-2 w-full" name="email" value="{{ $email ?? old('email') }}" required autofocus>

            @if ($errors->has('email'))
                <span class="text-red-500 text-sm">
                    {{ $errors->first('email') }}
                </span>
            @endif
        </div>

        <div class="mb-3 {{ $errors->has('password') ? ' has-error' : '' }}">
            <label for="password" class="">{{ __('auth.reset.fields.password') }}</label>

            <input id="password" type="password" class="rounded border p-2 w-full" name="password" required>

            @if ($errors->has('password'))
                <span class="text-red-500 text-sm">
                    {{ $errors->first('password') }}
                </span>
            @endif
        </div>

        <div class="mb-3 {{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
            <label for="password-confirm" class="">{{ __('auth.reset.fields.password_confirmation') }}</label>
            <input id="password-confirm" type="password" class="rounded border p-2 w-full" name="password_confirmation" required>

            @if ($errors->has('password_confirmation'))
                <span class="text-red-500 text-sm">
                    {{ $errors->first('password_confirmation') }}
                </span>
            @endif
        </div>


        <button type="submit" class="rounded border border-blue-500 text-blue-500 uppercase px-6 py-2 transition-all bg-white hover:shadow-xs hover:bg-blue-500 hover:text-white">
            {{ __('auth.reset.submit') }}
        </button>
    </form>
@endsection
