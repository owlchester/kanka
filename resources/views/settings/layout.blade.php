@extends('layouts.app', [
    'title' => __('settings.layout.title'),
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
                {{ __('settings.layout.title') }}
            </h2>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>{{ __('profiles.fields.theme') }}</label>
                        {!! Form::select('theme', [
                            '' => __('profiles.theme.themes.default'),
                            'dark' => __('profiles.theme.themes.dark'),
                            'future' => __('profiles.theme.themes.future'),
                            'midnight' => __('profiles.theme.themes.midnight')
                        ], null, ['class' => 'form-control']) !!}
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>{{ __('profiles.settings.fields.pagination') }}</label>
                        {!! Form::select('default_pagination', $pagination->options(), null, ['class' => 'form-control']) !!}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>{{ __('profiles.settings.fields.date_format') }}</label>
                        {!! Form::select('date_format', [
                            'Y-m-d' => 'Y-m-d',
                            'd.m.Y' => 'd.m.Y',
                            'd-m-y' => 'd-m-y',
                            'm/d/Y' => 'm/d/Y'

                        ], null, ['class' => 'form-control']) !!}
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>{{ __('profiles.settings.fields.new_entity_workflow') }}</label>
                            {!! Form::select('new_entity_workflow', [
                                    '' => __('profiles.workflows.default'),
                                    'created' => __('profiles.workflows.created'),
                                ], null, ['class' => 'form-control']) !!}

                        <p class="help-block">{{ __('profiles.settings.hints.new_entity_workflow') }}</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>{{ __('profiles.settings.fields.editor') }}</label>
                        {!! Form::select('editor', [
                            '' => __('profiles.editors.default'),
                            'summernote' => __('profiles.editors.summernote'),
                        ], null, ['class' => 'form-control']) !!}
                    </div>

                    <p class="help-block">{{ __('profiles.settings.helpers.editor') }}</p>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::hidden('default_nested', 0) !!}
                        <label>
                            {!! Form::checkbox('default_nested', 1, auth()->user()->defaultNested) !!}
                            {{ __('profiles.settings.fields.default_nested') }}
                        </label>
                        <p class="help-block">{{ __('profiles.settings.hints.default_nested') }}</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::hidden('advanced_mentions', 0) !!}
                        <label>
                            {!! Form::checkbox('advanced_mentions', 1, auth()->user()->advancedMentions) !!}
                            {{ __('profiles.settings.fields.advanced_mentions') }}
                        </label>
                        <p class="help-block">{{ __('profiles.settings.hints.advanced_mentions') }}</p>
                    </div>
                </div>
            </div>

            <button class="btn btn-primary">
                {{ __('crud.save') }}
            </button>
        </div>
    </div>
    {!! Form::close() !!}
@endsection
