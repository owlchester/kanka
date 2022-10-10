@extends('layouts.login', ['title' => __('auth.login.title')])

@section('content')

    <h1>{{ __('auth.tfa.title') }}</h1>


    <p class="help-block">
        {{ __('auth.tfa.helper') }}
    </p>

    <div class="panel-body">

        {!! Form::open(['route' => 'auth.verify-2fa', 'method' => 'POST']) !!}
            <div class="form-group{{ $errors->has('one_time_password') ? ' has-error' : '' }}">
                <input id="one_time_password" type="password" class="form-control" name="one_time_password" required autofocus>

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
        {!! Form::close() !!}

        <hr />

        {!! Form::open(['route' => 'auth.cancel-2fa', 'method' => 'POST']) !!}
            <div class="form-group">
                <button type="submit" class="btn btn-block btn-danger">
                    {{ __('crud.cancel') }}
                </button>
            </div>
        {!! Form::close() !!}
    </div>
@endsection








