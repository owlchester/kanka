@extends('layouts.login', ['title' => trans('auth.login.title')])

@section('content')
<h3>{{ trans('auth.login.title') }}</h3>

    @if (session()->has('info'))
        <div class="alert alert-info alert-dismissable">
            {{ session()->get('info') }}
        </div>
    @endif
    @include('partials.errors')

    <form method="POST" action="{{ route('login') }}">
        {{ csrf_field() }}

        <div class="form-group has-feedback{{ $errors->has('email') ? ' has-error' : '' }}">
            <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="{{ trans('auth.login.fields.email') }}" required autofocus>
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>

            @if ($errors->has('email'))
                <span class="help-block">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
            <div class="input-group">
                <input id="password" type="password" class="form-control" name="password" required placeholder="{{ trans('auth.login.fields.password') }}">
                <a href="#" class="toggle-password input-group-addon" title="{{ trans('auth.helpers.password') }}">
                    <i class="toggle-password-icon fa fa-eye"></i>
                </a>
            </div>

            @if ($errors->has('password'))
                <span class="help-block">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
            @endif
        </div>

        <div class="row">
            <div class="col-xs-8">
                <div class="checkbox">
                    <label>
                        <input type="checkbox" class="minimal" name="remember" {{ old('remember') ? 'checked' : '' }}>
                        {{ trans('auth.login.remember_me') }}
                    </label>
                </div>
            </div>
            <div class="col-xs-4">
                <button type="submit" class="btn pull-right btn-primary">
                    {{ trans('auth.login.submit') }}
                </button>
            </div>
        </div>

        <div class="form-group">
            <div class="col-md-8 col-md-offset-4">

            </div>
        </div>
    </form>

@if(config('auth.register_enabled'))
    <div class="row">
        <div class="col-md-12">
            <div class="social-auth-links text-center">
                <p>- {{ trans('auth.login.or') }} -</p>
                <a href="{{ route('auth.provider', ['provider' => 'facebook']) }}" class="btn btn-app btn-facebook" title="{{ trans('auth.login.login_with_facebook') }}">
                    <i class="fab fa-facebook-f"></i>
                    Facebook
                </a>
                <a href="{{ route('auth.provider', ['provider' => 'google']) }}" class="btn btn-app btn-google" title="{{ trans('auth.login.login_with_google') }}">
                    <i class="fab fa-google"></i>
                    Google
                </a>
                <a href="{{ route('auth.provider', ['provider' => 'twitter']) }}" class="btn btn-app btn-twitter" title="{{ trans('auth.login.login_with_twitter') }}">
                    <i class="fab fa-twitter"></i>
                    Twitter
                </a>
            </div>
        </div>
    </div>
@endif
    <div class="row">
        <div class="hidden-xs hidden-sm">
            <div class="col-md-6">
                <a class="btn btn-link" href="{{ route('password.request') }}">
                    {{ trans('auth.login.password_forgotten') }}
                </a>
            </div>@if(config('auth.register_enabled'))
            <div class="col-md-6 text-right">
                <a class="btn btn-link" href="{{ route('register') }}">
                    {{ trans('auth.login.new_account') }}
                </a>
            </div>@endif
        </div>
        <div class="visible-xs visible-sm">

            <div class="col-md-12 text-center">
                <a class="btn btn-link" href="{{ route('password.request') }}">
                    {{ trans('auth.login.password_forgotten') }}
                </a>
            </div>@if(config('auth.register_enabled'))
            <div class="col-md-12 text-center">
                <a class="btn btn-link" href="{{ route('register') }}">
                    {{ trans('auth.login.new_account') }}
                </a>
            </div>@endif
        </div>
    </div>
@endsection
