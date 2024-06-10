@extends('layouts.login', ['title' => __('auth.login.title')])

@section('content')

    <h1 class="text-2xl leading-tight mb-3">{{ __('auth.tfa.title') }}</h1>

    <p class="text-gray-500 mb-3">
        {{ __('auth.tfa.helper') }}
    </p>

    <x-form method="POST" action="auth.verify-2fa">
        <div class="mb-3 {{ $errors->has('one_time_password') ? ' has-error' : '' }}">
            <input id="one_time_password" type="password" class="rounded border p-4 w-full dark:bg-slate-800" name="one_time_password" required autofocus>

            @if ($errors->has('password'))
                <span class="text-sm text-red-500">
                    <strong>{{ __('auth.confirm.error') }}</strong>
                </span>
            @endif
        </div>

        <div class="mb-3 ">
            <button type="submit" class="rounded border border-blue-500 text-blue-500 uppercase px-6 py-2 transition-all bg-white hover:shadow-xs hover:bg-blue-500 hover:text-white dark:bg-slate-800">
                {{ __('auth.confirm.confirm') }}
            </button>
        </div>
    </x-form>

    <hr class="my-5" />

    <x-form action="auth.cancel-2fa">
        <button type="submit" class="rounded border border-red-500 text-red-500 uppercase px-6 py-2 transition-all bg-white hover:shadow-xs hover:bg-red-500 hover:text-white dark:bg-slate-800">
            {{ __('crud.cancel') }}
        </button>
    </x-form>
@endsection








