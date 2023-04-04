@extends('layouts.login', ['title' => __('auth.login.title')])

@section('content')

    <h1 class="text-2xl leading-tight mb-3">{{ __('auth.tfa.title') }}</h1>

    <p class="text-gray-500 mb-3">
        {{ __('auth.tfa.helper') }}
    </p>

    {!! Form::open(['route' => 'auth.verify-2fa', 'method' => 'POST', 'class' => 'w-full']) !!}
        <div class="mb-3 {{ $errors->has('one_time_password') ? ' has-error' : '' }}">
            <input id="one_time_password" type="password" class="form-control" name="one_time_password" required autofocus>

            @if ($errors->has('password'))
                <span class="help-block text-red">
                    <strong>{{ __('auth.confirm.error') }}</strong>
                </span>
            @endif
        </div>

        <div class="mb-3 ">
            <button type="submit" class="rounded border border-blue-500 text-blue-500 uppercase px-6 py-2 transition-all bg-white hover:shadow-xs hover:bg-blue-500 hover:text-white">
                {{ __('auth.confirm.confirm') }}
            </button>
        </div>
    {!! Form::close() !!}

    <hr class="my-4 border" />

    {!! Form::open(['route' => 'auth.cancel-2fa', 'method' => 'POST', 'class' => 'w-full']) !!}
        <button type="submit" class="rounded border border-red-500 text-red-500 uppercase px-6 py-2 transition-all bg-white hover:shadow-xs hover:bg-red-500 hover:text-white">
            {{ __('crud.cancel') }}
        </button>
    {!! Form::close() !!}
@endsection








