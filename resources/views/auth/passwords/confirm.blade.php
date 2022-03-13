@extends('layouts.login', ['title' => __('auth.confirm.title')])

@section('content')
    <h3>{{ __('auth.confirm.title') }}</h3>

    <p class="help-block">
        {{ __('auth.confirm.helper') }}
    </p>

    <div class="panel-body">
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif

        <form class="form-horizontal" method="POST" action="{{ route('password.confirm') }}">
            {{ csrf_field() }}

            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                <input id="password" type="password" class="form-control" name="password" required>

                @if ($errors->has('password'))
                    <span class="help-block text-red">
                        <strong>{{ __('auth.confirm.error') }}</strong>
                    </span>
                @endif
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-block btn-primary">
                    {{ __('auth.confirm.confirm') }}
                </button>
            </div>
        </form>
    </div>
@endsection
