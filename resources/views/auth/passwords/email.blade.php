@extends('layouts.login', ['title' => __('auth.reset.title')])

@section('content')
    <h1 class="text-2xl leading-tight mb-3">{{ __('auth.reset.title') }}</h1>

        @if (session('status'))
            <div class="p-4 rounded bg-blue-200 text-blue-800 mb-2">
                {{ session('status') }}
            </div>
        @endif

        <form class="w-full" method="POST" action="{{ route('password.email') }}">
            {{ csrf_field() }}

            <div class="mb-3 {{ $errors->has('email') ? ' has-error' : '' }}">
                <input id="email" type="email" class="rounded border p-2 w-full dark:bg-slate-800" name="email" value="{{ old('email') }}" required placeholder="{{ __('auth.reset.fields.email') }}">

                @if ($errors->has('email'))
                    <span class="text-red-500 text-sm">
                        {{ $errors->first('email') }}
                    </span>
                @endif
            </div>

            <button type="submit" class="rounded border border-blue-500 text-blue-500 uppercase px-6 py-2 transition-all bg-white hover:shadow-xs hover:bg-blue-500 hover:text-white dark:bg-slate-800">
                {{ __('auth.reset.send') }}
            </button>
        </form>
@endsection
