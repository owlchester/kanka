@extends('layouts.login', [
    'title' => __('auth.register.title')
])

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

        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
            <div class="input-group">
                <input id="password" type="password" class="form-control" name="password" required placeholder="{{ trans('auth.register.fields.password') }}">
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
        <div class="form-group has-feedback{{ $errors->has('tos') ? ' has-error' : '' }}">
            <div class="checkbox">
                <label for="tos">
                    <input id="tos" type="checkbox" name="tos" value="1" required>
                    {!! trans('auth.register.fields.tos', ['privacyUrl' => route('front.privacy')]) !!}
                </label>

                @if ($errors->has('tos'))
                    <span class="help-block">
                        <strong>{{ $errors->first('tos') }}</strong>
                    </span>
                @endif


                <button type="submit" class="btn btn-primary pull-right">
                    {{ trans('auth.register.submit') }}
                </button>
            </div>
        </div>

        <div class="form-group text-right">
        </div>
    </form>

    <div class="row">
        <div class="col-md-12">
            <div class="social-auth-links text-center">
                <p>- {{ trans('auth.login.or') }} -</p>
                <a href="{{ route('auth.provider', ['provider' => 'facebook']) }}" class="btn btn-app btn-facebook" title="{{ trans('auth.register.register_with_facebook') }}">
                    <i class="fab fa-facebook-f"></i> Facebook
                </a>
                <a href="{{ route('auth.provider', ['provider' => 'google']) }}" class="btn btn-app btn-google" title="{{ trans('auth.register.register_with_google') }}">
                    <i class="fab fa-google"></i> Google
                </a>
                <a href="{{ route('auth.provider', ['provider' => 'twitter']) }}" class="btn btn-app btn-twitter" title="{{ trans('auth.register.register_with_twitter') }}">
                    <i class="fab fa-twitter"></i> Twitter
                </a>
            </div>
            <a href="{{ route('login') }}">{{ trans('auth.register.already_account') }}</a>
        </div>
    </div>

</div>
@endsection
