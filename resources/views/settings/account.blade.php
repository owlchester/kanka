@extends('layouts.app', [
    'title' => __('settings.account.title'),
    'breadcrumbs' => false,
    'sidebar' => 'settings',
    'noads' => true,
])

@section('content')
    @include('partials.errors')
    <div class="row">
        <div class="col-md-6">
            {!! Form::model(auth()->user(), ['method' => 'PATCH', 'route' => ['settings.account.email']]) !!}
            <div class="box box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        {{ __('settings.account.email') }}
                    </h3>
                </div>
                <div class="box-body">
                    <div class="form-group required">
                        <label>{{ __('profiles.fields.email') }}</label>
                        {!! Form::text('email', null, ['placeholder' => __('profiles.placeholders.email'), 'class' => 'form-control']) !!}
                    </div>

                    @if (empty(auth()->user()->provider))
                        <div class="form-group">
                            <label>{{ __('profiles.fields.password') }}</label>
                            {!! Form::password('password', ['placeholder' => __('profiles.placeholders.password'), 'class' => 'form-control']) !!}
                        </div>
                    @endif
                </div>
                <div class="box-footer">

                    <button class="btn btn-primary">
                        {{ __('settings.account.actions.update_email') }}
                    </button>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
        <div class="col-md-6">
            <div class="box box-solid">
                @if (empty(auth()->user()->provider))
                <div class="box-header with-border">
                    <h3 class="box-title">
                        {{ __('settings.account.password') }}
                    </h3>
                </div>
                {!! Form::model(auth()->user(), ['method' => 'PATCH', 'route' => ['settings.account.password']]) !!}
                <div class="box-body">
                    <div class="form-group">
                        <label>{{ __('profiles.fields.password') }}</label>
                        {!! Form::password('password', ['placeholder' => __('profiles.placeholders.password'), 'class' => 'form-control']) !!}
                    </div>
                    <div class="form-group">
                        <label>{{ __('profiles.fields.new_password') }}</label>
                        {!! Form::password('password_new', ['placeholder' => __('profiles.placeholders.new_password'), 'class' => 'form-control']) !!}
                    </div>
                    <div class="form-group">
                        <label>{{ __('profiles.fields.new_password_confirmation') }}</label>
                        {!! Form::password('password_new_confirmation', ['placeholder' => __('profiles.placeholders.new_password_confirmation'), 'class' => 'form-control']) !!}
                    </div>
                </div>
                <div class="box-footer">
                    <button class="btn btn-primary">
                        {{ __('settings.account.actions.update_password') }}
                    </button>
                </div>
                {!! Form::close() !!}
                @else
                <div class="box-header with-border">
                    <h3 class="box-title">
                        {{ __('settings.account.social.title') }}
                    </h3>
                </div>
                {!! Form::model(auth()->user(), ['method' => 'PATCH', 'route' => ['settings.account.social']]) !!}

                <div class="box-body">

                    <p class="help">{{ __('settings.account.social.helper', ['provider' => ucfirst(auth()->user()->provider)]) }}</p>
                    <div class="form-group">
                        <label>{{ __('profiles.fields.new_password') }}</label>
                        {!! Form::password('password_new', ['placeholder' => __('profiles.placeholders.new_password'), 'class' => 'form-control']) !!}
                    </div>
                </div>
                <div class="box-footer">
                    <button class="btn btn-primary">
                        {{ __('settings.account.actions.social') }}
                    </button>
                </div>
                {!! Form::close() !!}
                @endif
            </div>
        </div>
    </div>

    <div class="box box-solid">
        <div class="box-header with-border">
            <h3 class="box-title text-red">
                {{ __('profiles.sections.delete.title') }}
            </h3>
        </div>
        <div class="box-body">
            <p class="alert alert-danger">{{ __('profiles.sections.delete.helper') }}</p>
            {!! Form::model(auth()->user(), ['method' => 'PATCH', 'id' => 'delete-confirm-form', 'route' => ['settings.account.destroy']]) !!}

            @if (empty(auth()->user()->provider))
                <div class="form-group">
                    <label>{{ __('profiles.fields.password') }}</label>
                    {!! Form::password('password', ['placeholder' => __('profiles.placeholders.password'), 'class' => 'form-control']) !!}
                </div>
            @endif
            {!! Form::close() !!}
        </div>
        <div class="box-footer">
            <button class="btn btn-danger delete-confirm" data-text="{{ __('profiles.sections.delete.warning') }}" data-toggle="modal" data-target="#delete-confirm">
                <i class="fa fa-trash" aria-hidden="true"></i> {{ __('profiles.sections.delete.delete') }}
            </button>
        </div>
    </div>
@endsection
