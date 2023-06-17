@extends('layouts.login', ['title' => __('auth.confirm.title')])

@section('content')
    <h1 class="text-2xl leading-tight mb-3">{{ __('auth.confirm.title') }}</h1>

    <p class="text-gray-500 mb-2">
        {{ __('auth.confirm.helper') }}
    </p>

    @if (session('status'))
        <x-alert type="success">
            {{ session('status') }}
        </x-alert>
    @endif

    <form class="form-horizontal" method="POST" action="{{ route('password.confirm') }}" class="w-full">
        {{ csrf_field() }}

        <div class="mb-2">
            <input id="password" type="password" class="rounded p-2 w-full border" name="password" required autofocus>

            @if ($errors->has('password'))
                <span class="text-red-500">
                    {{ __('auth.confirm.error') }}
                </span>
            @endif
        </div>

        <div class="mb-2">
            <button type="submit" class="w-full rounded px-6 py-2 uppercase text-blue-500 border border-blue-500 hover:shadow-xs hover:text-white hover:bg-blue-500 ">
                {{ __('auth.confirm.confirm') }}
            </button>
        </div>
    </form>
@endsection
