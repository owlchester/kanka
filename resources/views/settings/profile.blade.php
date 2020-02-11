@extends('layouts.app', [
    'title' => trans('settings.profile.title'),
    'description' => trans('settings.profile.description'),
    'breadcrumbs' => false
])

@section('content')
    @include('partials.errors')
    <div class="row">
        <div class="col-lg-2 col-sm-4">
            @include('settings.menu')
        </div>
        <div class="col-lg-10 col-sm-8">
            {!! Form::model(auth()->user(), ['method' => 'PATCH', 'enctype' => 'multipart/form-data', 'route' => ['settings.profile']]) !!}
            <div class="box box-solid">
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h2 class="page-header with-border">
                                {{ trans('settings.profile.title') }}
                            </h2>

                            <div class="form-group required">
                                <label>{{ trans('profiles.fields.name') }}</label>
                                {!! Form::text('name', null, ['placeholder' => trans('profiles.placeholders.name'), 'class' => 'form-control']) !!}
                            </div>

                            <hr />

                            <div class="form-group checkbox">
                                <label>
                                    {!! Form::hidden('newsletter', 0) !!}
                                    {!! Form::checkbox('newsletter') !!}
                                    {{ trans('profiles.fields.newsletter') }}</label>
                            </div>

                            <div class="form-group checkbox">
                                <label>
                                    {!! Form::hidden('has_last_login_sharing', 0) !!}
                                    {!! Form::checkbox('has_last_login_sharing') !!}
                                    {{ trans('profiles.fields.last_login_share') }}</label>
                            </div>
                        </div>
                        <div class="col-md-4 col-md-offset-2">
                            <h2 class="page-header with-border">
                                {{ trans('settings.profile.avatar') }}
                            </h2>


                            {!! Form::file('avatar', ['class' => 'image form-group']) !!}
                            {!! Form::hidden('remove-avatar') !!}

                            @if (!empty(auth()->user()->avatar) && auth()->user()->avatar != 'users/default.png')
                                <div class="preview">
                                    <div class="image">
                                        <img src="{{ Storage::url(auth()->user()->avatar) }}"/>
                                        <a href="#" class="img-delete" data-target="remove-avatar" title="{{ trans('crud.remove') }}">
                                            <i class="fa fa-trash"></i> {{ trans('crud.remove') }}
                                        </a>
                                    </div>
                                    <br class="clear">
                                </div>
                            @endif

                        </div>
                    </div>

                    <button class="btn btn-primary">
                        {{ trans('settings.profile.actions.update_profile') }}
                    </button>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
@endsection
