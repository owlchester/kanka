@extends('layouts.login', ['title' => trans('auth.reset.title')])

@section('content')
    <h3>{{ trans('auth.reset.title') }}</h3>

    <div class="panel-body">
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif

        <form class="form-horizontal" method="POST" action="{{ route('password.email') }}">
            {{ csrf_field() }}

            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required placeholder="{{ trans('auth.reset.fields.email') }}">

                    @if ($errors->has('email'))
                        <span class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
            </div>

            <div class="form-group">
                    <button type="submit" class="btn btn-block btn-primary">
                        {{ trans('auth.reset.send') }}
                    </button>
            </div>
        </form>
    </div>
@endsection
