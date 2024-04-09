@extends('layouts.app', [
    'title' => __('settings.layout.title'),
    'breadcrumbs' => false,
    'sidebar' => 'settings',
    'noads' => true,
    'centered' => true,
])
@php
$boxClass = "rounded p-4 bg-box flex flex-col gap-2";
$highlightClass = 'shadow-xs border-accent border-solid border-2 border-blue-500';
@endphp

@section('content')
    <x-grid type="1/1">
        <h1 class="">{{ __('settings.menu.appearance') }}</h1>
        <p class="text-lg">
            {{ __('settings/appearance.dismissible.main') }}
        </p>


        {!! Form::model(auth()->user(), ['method' => 'PATCH', 'route' => ['settings.appearance.update'], 'data-shortcut' => 1]) !!}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">

            <div class="{{ $boxClass }}">
                <div class="flex gap-2">
                    <h2 class="text-base grow">
                        <x-icon class="fa-regular fa-moon-over-sun"></x-icon>
                        {{ __('settings/appearance.fields.theme') }}
                    </h2>
                    <a href="https://docs.kanka.io/en/latest/account/appearance.html#theme" target="_blank" class="flex-0" title="{{ __('settings/appearance.actions.learn-more') }}">
                        <x-icon class="question"></x-icon>
                        <span class="sr-only">{{ __('settings/appearance.actions.learn-more') }}</span>
                    </a>
                </div>
                <p class="text-sm grow">
                    {{ __('settings/appearance.helpers.theme')}}
                    {{ __('settings/appearance.helpers.overridable')}}
                </p>
                {!! Form::select('theme', [
                    '' => __('profiles.theme.themes.default'),
                    'dark' => __('profiles.theme.themes.dark'),
                    'midnight' => __('profiles.theme.themes.midnight')
                ], null, ['class' => ' self-end w-full border rounded p-2']) !!}
            </div>

            <div class="{{ $boxClass }} {{ $highlight === 'pagination' ? $highlightClass : '' }}">
                <div class="flex gap-2">
                    <h2 class="text-base grow">
                        <x-icon class="fa-solid fa-list"></x-icon>
                        {{ __('settings/appearance.fields.pagination') }}
                    </h2>
                    <a href="https://docs.kanka.io/en/latest/account/appearance.html#results-per-page" target="_blank" class="flex-0" title="{{ __('settings/appearance.actions.learn-more') }}">
                        <x-icon class="question"></x-icon>
                        <span class="sr-only">{{ __('settings/appearance.actions.learn-more') }}</span>
                    </a>
                </div>
                <p class="text-sm grow">
                    {{ __('settings/appearance.helpers.pagination')}}
                </p>
                {!! Form::select('pagination', $paginationOptions, null, ['class' => ' flex self-end w-full border rounded p-2'], $paginationDisabled) !!}
            </div>


            <div class="{{ $boxClass }}">
                <div class="flex gap-2">
                    <h2 class="text-base grow">
                        <x-icon class="fa-solid fa-calendar"></x-icon>
                        {{ __('settings/appearance.fields.date-format') }}
                    </h2>
                    <a href="https://docs.kanka.io/en/latest/account/appearance.html#date-formatting" target="_blank" class="flex-0" title="{{ __('settings/appearance.actions.learn-more') }}">
                        <x-icon class="question"></x-icon>
                        <span class="sr-only">{{ __('settings/appearance.actions.learn-more') }}</span>
                    </a>
                </div>

                <p class="text-sm grow">
                    {{ __('settings/appearance.helpers.date-format')}}
                </p>
                {!! Form::select('date_format', [
                    null => 'Month d, Y',
                    'Y-m-d' => 'Y-m-d',
                    'd.m.Y' => 'd.m.Y',
                    'd-m-y' => 'd-m-y',
                    'm/d/Y' => 'm/d/Y',

                ], null, ['class' => ' flex self-end w-full border rounded p-2']) !!}

            </div>

            <div class="{{ $boxClass }} {{ $highlight === 'campaign-switcher' ? $highlightClass : '' }}">
                <div class="flex gap-2">
                    <h2 class="text-base grow">
                        <x-icon class="fa-solid fa-arrow-down-a-z"></x-icon>
                        {{ __('settings/appearance.fields.campaign-order') }}
                    </h2>
                    <a href="https://docs.kanka.io/en/latest/account/appearance.html#campaign-order" target="_blank" class="flex-0" title="{{ __('settings/appearance.actions.learn-more') }}">
                        <x-icon class="question"></x-icon>
                        <span class="sr-only">{{ __('settings/appearance.actions.learn-more') }}</span>
                    </a>
                </div>

                <p class="text-sm grow">
                    {{ __('settings/appearance.helpers.campaign-order')}}
                </p>
                {!! Form::select('campaign_switcher_order_by', [
                    null => __('settings/appearance.campaign-switcher.date_created'),
                    'r_date_created' => __('settings/appearance.campaign-switcher.r_date_created'),
                    'alphabetical' => __('settings/appearance.campaign-switcher.alphabetical'),
                    'r_alphabetical' => __('settings/appearance.campaign-switcher.r_alphabetical'),
                    'date_joined' => __('settings/appearance.campaign-switcher.date_joined'),
                    'r_date_joined' => __('settings/appearance.campaign-switcher.r_date_joined'),
                ], auth()->user()->campaignSwitcherOrderBy, ['class' => ' flex self-end w-full border rounded p-2']) !!}
            </div>

            @if ($textEditorSelect)
                <div class="{{ $boxClass }}">
                    <div class="flex gap-2">
                        <h2 class="text-base grow">
                            <x-icon class="pencil"></x-icon>
                            {{ __('settings/appearance.fields.editor') }}
                        </h2>
                        <a href="https://docs.kanka.io/en/latest/account/appearance.html#text-editor" target="_blank" class="flex-0" title="{{ __('settings/appearance.actions.learn-more') }}">
                            <x-icon class="question"></x-icon>
                            <span class="sr-only">{{ __('settings/appearance.actions.learn-more') }}</span>
                        </a>
                    </div>
                    <p class="text-sm grow">{{ __('settings/appearance.helpers.editor') }}</p>
                    {!! Form::select('editor', [
                        '' => __('settings/appearance.editors.default', ['name' => 'Summernote']),
                        'legacy' => __('settings/appearance.editors.legacy', ['name' => 'TinyMCE 4']),
                    ], null, ['class' => ' flex self-end w-full border rounded p-2']) !!}

                </div>
            @endif

            <div class="{{ $boxClass }} {{ $highlight === 'explore' ? $highlightClass : '' }}">
                <div class="flex gap-2">
                    <h2 class="text-base grow">
                        <x-icon class="fa-solid fa-grid"></x-icon>
                        {{ __('settings/appearance.fields.entity-explore') }}
                    </h2>
                    <a href="https://docs.kanka.io/en/latest/account/appearance.html#entity-explore" target="_blank" class="flex-0" title="{{ __('settings/appearance.actions.learn-more') }}">
                        <x-icon class="question"></x-icon>
                        <span class="sr-only">{{ __('settings/appearance.actions.learn-more') }}</span>
                    </a>
                </div>
                <p class="text-sm grow">
                    {{ __('settings/appearance.helpers.entity-explore') }}
                </p>
                {!! Form::select('entity_explore', [
                        0 => __('settings/appearance.explore.grid'),
                        1 => __('settings/appearance.explore.table'),
                    ], null, ['class' => ' flex self-end w-full border rounded p-2']) !!}
            </div>

            <div class="{{ $boxClass }}">
                <div class="flex gap-2">
                    <h2 class="text-base grow">
                        <x-icon class="fa-solid fa-at"></x-icon>
                        {{ __('settings/appearance.fields.mentions') }}
                    </h2>
                    <a href="https://docs.kanka.io/en/latest/account/appearance.html#mentions" target="_blank" class="flex-0" title="{{ __('settings/appearance.actions.learn-more') }}">
                        <x-icon class="question"></x-icon>
                        <span class="sr-only">{{ __('settings/appearance.actions.learn-more') }}</span>
                    </a>
                </div>
                <p class="text-sm grow">
                    {!! __('settings/appearance.helpers.advanced-mentions') !!}
                </p>
                {!! Form::select('advanced_mentions', [
                        0 => __('settings/appearance.mentions.default'),
                        1 => __('settings/appearance.mentions.advanced', ['code' => '[entity:123]']),
                    ], auth()->user()->alwaysAdvancedMentions(), ['class' => ' self-end w-full border rounded p-2']) !!}
            </div>

            <x-buttons.confirm type="primary" full="true">
                <x-icon class="save"></x-icon>
                <span>{{ __('settings/appearance.actions.save') }}</span>
            </x-buttons.confirm>
        @if (!empty($from))
            <input type="hidden" name="from" value="{{ $from }}" />
        @endif
        {!! Form::close() !!}
    </x-grid>
@endsection
