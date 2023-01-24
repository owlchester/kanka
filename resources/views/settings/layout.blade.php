@extends('layouts.app', [
    'title' => __('settings.layout.title'),
    'breadcrumbs' => false,
    'sidebar' => 'settings',
    'noads' => true,
])

@section('content')
    @include('partials.errors')
    @if (auth()->check() && !auth()->user()->settings()->get('tutorial_appearance'))
        <div class="alert alert-info tutorial">
            <button type="button" class="close banner-notification-dismiss" data-dismiss="alert" aria-hidden="true" data-url="{{ route('settings.banner', ['code' => 'appearance', 'type' => 'tutorial']) }}">×</button>

            <p>{{ __('settings/appearance.dismissible.main') }}</p>

            <p>{!!  __('settings/appearance.dismissible.lean-more', ['documentation' => link_to('https://docs.kanka.io/en/latest/profile/appearance.html', '<i class="fa-solid fa-external-link" aria-hidden="true"></i> ' . __('front.menu.documentation'), ['target' => '_blank'], null, false)])!!}</p>
        </div>
    @endif

    {!! Form::model(auth()->user(), ['method' => 'PATCH', 'route' => ['settings.appearance.update'], 'data-shortcut' => 1]) !!}
    <div class="box box-solid">
        <div class="box-header with-border">
            <h3 class="box-title">
                {{ __('settings.menu.appearance') }}
            </h3>
            <div class="box-tools">
                <a href="https://docs.kanka.io/en/latest/profile/appearance.html" target="_blank" class="btn btn-box-tool">
                    <i class="fa-solid fa-question-circle" aria-hidden="true"></i>
                    {{ __('front.menu.documentation') }}
                </a>
            </div>
        </div>
        <div class="box-body">
            <div class="grid grid-cols-2 gap-4 lg:grid-cols-3">
                <div class="form-group">
                    <label>{{ __('settings/appearance.fields.theme') }}
                    </label>
                    {!! Form::select('theme', [
                        '' => __('profiles.theme.themes.default'),
                        'dark' => __('profiles.theme.themes.dark'),
                        'midnight' => __('profiles.theme.themes.midnight')
                    ], null, ['class' => 'form-control']) !!}
                    <p class="help-block">
                        {{ __('settings/appearance.helpers.theme')}}
                    </p>
                </div>

                <div class="form-group">
                    <label>
                        {{ __('settings/appearance.fields.pagination') }}
                    </label>
                    {!! Form::select('pagination', $paginationOptions, null, ['class' => 'form-control'], $paginationDisabled) !!}
                    <p class="help-block">
                        {{ __('settings/appearance.helpers.pagination')}}
                    </p>
                </div>

                <div class="form-group">
                    <label>
                        {{ __('settings/appearance.fields.date-format') }}
                    </label>
                    {!! Form::select('date_format', [
                        null => 'Month d, Y',
                        'Y-m-d' => 'Y-m-d',
                        'd.m.Y' => 'd.m.Y',
                        'd-m-y' => 'd-m-y',
                        'm/d/Y' => 'm/d/Y',

                    ], null, ['class' => 'form-control']) !!}

                    <p class="help-block">
                        {{ __('settings/appearance.helpers.date-format')}}
                    </p>
                </div>

                <div class="form-group {{ $highlight === 'campaign-switcher' ? 'alert alert-info' : '' }}">
                    <label>
                        {{ __('settings/appearance.fields.campaign-order') }}
                    {!! Form::select('campaign_switcher_order_by', [
                        null => __('settings/appearance.campaign-switcher.date_created'),
                        'r_date_created' => __('settings/appearance.campaign-switcher.r_date_created'),
                        'alphabetical' => __('settings/appearance.campaign-switcher.alphabetical'),
                        'r_alphabetical' => __('settings/appearance.campaign-switcher.r_alphabetical'),
                        'date_joined' => __('settings/appearance.campaign-switcher.date_joined'),
                        'r_date_joined' => __('settings/appearance.campaign-switcher.r_date_joined'),
                    ], auth()->user()->campaignSwitcherOrderBy, ['class' => 'form-control']) !!}

                    <p class="help-block">
                        {{ __('settings/appearance.helpers.campaign-order')}}
                    </p>
                </div>

                <div class="form-group">
                    <label>
                        {{ __('settings/appearance.fields.new-entity-workflow') }}
                    </label>
                    {!! Form::select('new_entity_workflow', [
                            '' => __('profiles.workflows.default'),
                            'created' => __('profiles.workflows.created'),
                        ], null, ['class' => 'form-control']) !!}

                    <p class="help-block">{{ __('settings/appearance.helpers.new-entity-workflow') }}</p>
                </div>

                @if ($textEditorSelect)
                    <div class="form-group">
                        <label>
                            {{ __('settings/appearance.fields.editor') }}
                        </label>
                        {!! Form::select('editor', [
                            '' => __('settings/appearance.editors.default', ['name' => 'Summernote']),
                            'legacy' => __('settings/appearance.editors.legacy', ['name' => 'TinyMCE 4']),
                        ], null, ['class' => 'form-control']) !!}

                        <p class="help-block">{{ __('settings/appearance.helpers.editor') }}</p>
                    </div>
                @endif
            </div>


            <div class="form-group">
                {!! Form::hidden('default_nested', 0) !!}
                <label>
                    {!! Form::checkbox('default_nested', 1, auth()->user()->defaultNested) !!}
                    {{ __('settings/appearance.fields.default-nested') }}
                </label>
                <p class="help-block">{{ __('settings/appearance.helpers.default-nested') }}</p>
            </div>

            <div class="form-group">
                {!! Form::hidden('advanced_mentions', 0) !!}
                <label>
                    {!! Form::checkbox('advanced_mentions', 1, auth()->user()->alwaysAdvancedMentions()) !!}
                    {{ __('settings/appearance.fields.advanced-mentions') }}
                </label>
                <p class="help-block">{!! __('settings/appearance.helpers.advanced-mentions', ['mention' => '<code>[entity:123]</code>']) !!}</p>
            </div>
        </div>

        <div class="box-footer text-right">
            <button class="btn btn-primary">
                <i class="fa-solid fa-save" aria-hidden="true"></i>
                {{ __('settings/appearance.actions.save') }}
            </button>
        </div>
    </div>
    {!! Form::close() !!}
@endsection
