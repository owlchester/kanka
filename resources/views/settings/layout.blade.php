@extends('layouts.app', [
    'title' => trans('settings.layout.title'),
    'breadcrumbs' => false,
    'sidebar' => 'settings',
])

@inject('pagination', App\Services\PaginationService)

@section('content')
    @include('partials.errors')
    {!! Form::model(auth()->user(), ['method' => 'PATCH', 'route' => ['settings.layout']]) !!}
    <div class="box box-solid">
        <div class="box-body">
            <h2 class="page-header with-border">
                {{ trans('settings.layout.title') }}
            </h2>

            <div class="form-group">
                <label>{{ trans('profiles.fields.theme') }}</label>
                {!! Form::select('theme', [
                    '' => trans('profiles.theme.themes.default'),
                    'dark' => trans('profiles.theme.themes.dark'),
                    'future' => trans('profiles.theme.themes.future'),
                    'midnight' => trans('profiles.theme.themes.midnight')
                ], null, ['class' => 'form-control']) !!}
            </div>

            <div class="form-group">
                <label>{{ trans('profiles.settings.fields.pagination') }}</label>
                {!! Form::select('default_pagination', $pagination->options(), null, ['class' => 'form-control']) !!}
            </div>

            <div class="form-group">
                <label>{{ trans('profiles.settings.fields.date_format') }}</label>
                {!! Form::select('date_format', [
                    'Y-m-d' => 'Y-m-d',
                    'd.m.Y' => 'd.m.Y',
                    'd-m-y' => 'd-m-y',
                    'm/d/Y' => 'm/d/Y'

                ], null, ['class' => 'form-control']) !!}
            </div>

            <div class="form-group">
                <div class="form-group">
                {!! Form::hidden('default_nested', 0) !!}
                <label>
                    {!! Form::checkbox('default_nested', 1, auth()->user()->defaultNested) !!}
                    {{ trans('profiles.settings.fields.default_nested') }}
                </label>
                <p class="help-block">{{ trans('profiles.settings.hints.default_nested') }}</p>
            </div>

            <div class="form-group">
                <div class="form-group">
                {!! Form::hidden('advanced_mentions', 0) !!}
                <label>
                    {!! Form::checkbox('advanced_mentions', 1, auth()->user()->advancedMentions) !!}
                    {{ trans('profiles.settings.fields.advanced_mentions') }}
                </label>
                <p class="help-block">{{ trans('profiles.settings.hints.advanced_mentions') }}</p>
            </div>

            <button class="btn btn-primary">
                {{ trans('crud.save') }}
            </button>
        </div>
    </div>
    {!! Form::close() !!}
@endsection
