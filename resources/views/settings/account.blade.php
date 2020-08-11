@extends('layouts.app', [
    'title' => trans('settings.account.title'),
    'breadcrumbs' => false,
    'sidebar' => 'settings',
])

@section('content')
    @include('partials.errors')
    <div class="box box-solid">
        <div class="box-body">

            <h2 class="page-header with-border">
                {{ trans('settings.account.email') }}
            </h2>
            {!! Form::model(auth()->user(), ['method' => 'PATCH', 'route' => ['settings.account.email']]) !!}
            <div class="form-group required">
                <label>{{ trans('profiles.fields.email') }}</label>
                {!! Form::text('email', null, ['placeholder' => trans('profiles.placeholders.email'), 'class' => 'form-control']) !!}
            </div>

            @if (empty(auth()->user()->provider))
                <div class="form-group">
                    <label>{{ trans('profiles.fields.password') }}</label>
                    {!! Form::password('password', ['placeholder' => trans('profiles.placeholders.password'), 'class' => 'form-control']) !!}
                </div>
            @endif

            <button class="btn btn-primary margin-bottom">
                {{ trans('settings.account.actions.update_email') }}
            </button>
            {!! Form::close() !!}

            @if (empty(auth()->user()->provider))
            <h2 class="page-header with-border">
                {{ trans('settings.account.password') }}
            </h2>

            {!! Form::model(auth()->user(), ['method' => 'PATCH', 'route' => ['settings.account.password']]) !!}
            <div class="form-group">
                <label>{{ trans('profiles.fields.password') }}</label>
                {!! Form::password('password', ['placeholder' => trans('profiles.placeholders.password'), 'class' => 'form-control']) !!}
            </div>
            <div class="form-group">
                <label>{{ trans('profiles.fields.new_password') }}</label>
                {!! Form::password('password_new', ['placeholder' => trans('profiles.placeholders.new_password'), 'class' => 'form-control']) !!}
            </div>
            <div class="form-group">
                <label>{{ trans('profiles.fields.new_password_confirmation') }}</label>
                {!! Form::password('password_new_confirmation', ['placeholder' => trans('profiles.placeholders.new_password_confirmation'), 'class' => 'form-control']) !!}
            </div>
            <button class="btn btn-primary">
                {{ trans('settings.account.actions.update_password') }}
            </button>
            {!! Form::close() !!}

            @else
                <h2 class="page-header with-border">
                    {{ trans('settings.account.social.title') }}
                </h2>

                <p class="help">{{ __('settings.account.social.helper', ['provider' => ucfirst(auth()->user()->provider)]) }}</p>
                {!! Form::model(auth()->user(), ['method' => 'PATCH', 'route' => ['settings.account.social']]) !!}
                <div class="form-group">
                    <label>{{ trans('profiles.fields.new_password') }}</label>
                    {!! Form::password('password_new', ['placeholder' => trans('profiles.placeholders.new_password'), 'class' => 'form-control']) !!}
                </div>
                <button class="btn btn-primary margin-bottom">
                    {{ trans('settings.account.actions.social') }}
                </button>
                {!! Form::close() !!}
            @endif


            <p><br /></p>
            <h2 class="page-header with-border text-red">
                {{ trans('profiles.sections.delete.title') }}
            </h2>
            {!! Form::model(auth()->user(), ['method' => 'PATCH', 'id' => 'delete-confirm-form', 'route' => ['settings.account.destroy']]) !!}

            @if (empty(auth()->user()->provider))
            <div class="form-group">
                <label>{{ trans('profiles.fields.password') }}</label>
                {!! Form::password('password', ['placeholder' => trans('profiles.placeholders.password'), 'class' => 'form-control']) !!}
            </div>
            @endif
            {!! Form::close() !!}
            <div class="form-group">
                <button class="btn btn-danger delete-confirm" data-text="{{ trans('profiles.sections.delete.warning') }}" data-toggle="modal" data-target="#delete-confirm">
                    <i class="fa fa-trash" aria-hidden="true"></i> {{ trans('profiles.sections.delete.delete') }}
                </button>
            </div>
        </div>
    </div>
@endsection
