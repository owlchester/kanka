@extends('layouts.login', ['title' => __('auth.login.title')])

@section('content')

    <h1>{{ __('auth.login.2fa') }}</h1>
    <!-- 2fagoogle -->

<form method="POST" action="{{ route('verify2fa') }}">
  @csrf
  <div class="row">
    <div class="form-group">
      <input type="password" class="form-control" name="one_time_password" id="one_time_password" placeholder="{{ __('auth.login.fields.2fa') }}" required>
    </div>
  </div>
  <div class="row-mb-5">

  <div class="col">
    <div class="form-group">
      <button type="submit" class="btn pull-right btn-primary" name="button">
        {{ __('auth.login.submit') }}
      </button>
    </div>
  </div>
</form>

<form method="POST" action="{{ route('cancel-2fa') }}">
  @csrf
  <div class="col">
    <div class="form-group">
      <button type="submit" class="btn btn-danger pull-left btn-primary">
        {{ __('auth.login.cancel') }}
      </button>
      </div>
    </div>
  </div>
</form>

<div class="form-group">
  <div class="row">
  </div>
</div>
@endsection








