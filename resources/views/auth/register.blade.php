@extends('layouts.login', ['title' => trans('auth.register.title')])

@section('content')
    <h3>{{ trans('auth.register.title') }}</h3>

    @include('partials.errors')

    <form method="POST" action="{{ route('register') }}">
        {{ csrf_field() }}

        <div class="form-group has-feedback{{ $errors->has('name') ? ' has-error' : '' }}">
            <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" placeholder="{{ trans('auth.register.fields.name') }}" required autofocus>
            <span class="glyphicon glyphicon-user form-control-feedback"></span>

            @if ($errors->has('name'))
                <span class="help-block">
                    <strong>{{ $errors->first('name') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group has-feedback{{ $errors->has('email') ? ' has-error' : '' }}">
            <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="{{ trans('auth.register.fields.email') }}" required>
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>

            @if ($errors->has('email'))
                <span class="help-block">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group has-feedback{{ $errors->has('password') ? ' has-error' : '' }}">
            <input id="password" type="password" class="form-control" name="password" placeholder="{{ trans('auth.register.fields.password') }}" required>
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>

            @if ($errors->has('password'))
                <span class="help-block">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group has-feedback">
            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="{{ trans('auth.register.fields.password_confirmation') }}" required>
            <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
        </div>

        <div class="form-group text-right">
            <button type="submit" class="btn btn-primary">
                {{ trans('auth.register.submit') }}
            </button>
        </div>
    </form>

    <div class="row">
        <div class="col-md-12">
            <div class="social-auth-links text-center">
                <p>- {{ trans('auth.login.or') }} -</p>
                <a href="{{ route('auth.provider', ['provider' => 'facebook']) }}" class="btn btn-block btn-facebook">
                    <i class="fa fa-facebook"></i> {{ trans('auth.register.register_with_facebook') }}
                </a>
                <a href="{{ route('auth.provider', ['provider' => 'google']) }}" class="btn btn-block btn-google">
                    <i class="fa fa-google"></i> {{ trans('auth.register.register_with_google') }}
                </a>
                <a href="{{ route('auth.provider', ['provider' => 'twitter']) }}" class="btn btn-block btn-twitter">
                    <i class="fa fa-twitter"></i> {{ trans('auth.register.register_with_twitter') }}
                </a>
            </div>
            <a href="{{ route('login') }}">{{ trans('auth.register.already_account') }}</a>
        </div>
    </div>

</div>
@endsection
