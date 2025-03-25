@extends('layouts.app', [
    'title' => __('settings.layout.title'),
    'breadcrumbs' => false,
    'sidebar' => 'settings',
    'centered' => true,
])
@php
$boxClass = "rounded p-4 bg-box flex flex-col gap-2 hover:shadow-sm";
$highlightClass = 'shadow-sm border-primary border-solid border-2';
@endphp

@section('content')
    <x-hero>
        <x-slot name="title">{{ __('settings.menu.appearance') }}</x-slot>
        <x-slot name="subtitle">{{ __('settings/appearance.dismissible.main') }}</x-slot>
    </x-hero>
    <x-grid type="1/1">
        <x-form :action="['settings.appearance.update']" method="PATCH">
            <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-4 lg:gap-8">
                <div class="{{ $boxClass }} {{ $highlight === 'dark' ? $highlightClass : '' }}">
                    <div class="flex gap-2 justify-between">
                        <h2 class="text-base flex items-center gap-2">
                            <x-icon class="fa-regular fa-moon-over-sun" />
                            {{ __('settings/appearance.fields.theme') }}
                        </h2>
                        <a href="https://docs.kanka.io/en/latest/account/appearance.html#theme" target="_blank" class="" data-tooltip data-title="{{ __('settings/appearance.actions.learn-more') }}">
                            <x-icon class="fa-regular fa-arrow-up-right-from-square" /> {{ __('general.learn-more') }}
                        </a>
                    </div>
                    <p class="text-sm grow">
                        {{ __('settings/appearance.helpers.theme')}}
                        {{ __('settings/appearance.helpers.overridable')}}
                    </p>
                    <x-forms.select
                        name="theme"
                        :options="[
                            '' => __('profiles.theme.themes.default'),
                            'dark' => __('profiles.theme.themes.dark'),
                            'midnight' => __('profiles.theme.themes.midnight'),]"
                        radio
                        :selected="auth()->user()->theme" class="self-end w-full border rounded p-2" />
                </div>

                <div class="{{ $boxClass }} {{ $highlight === 'pagination' ? $highlightClass : '' }}">
                    <div class="flex gap-2 justify-between">
                        <h2 class="text-base flex items-center gap-2">
                            <x-icon class="fa-regular fa-list" />
                            {{ __('settings/appearance.fields.pagination') }}
                        </h2>
                        <a href="https://docs.kanka.io/en/latest/account/appearance.html#results-per-page" target="_blank" class="" data-tooltip data-title="{{ __('settings/appearance.actions.learn-more') }}">
                            <x-icon class="fa-regular fa-arrow-up-right-from-square" /> {{ __('general.learn-more') }}
                        </a>
                    </div>
                    <p class="text-sm grow">
                        {{ __('settings/appearance.helpers.pagination')}}
                    </p>
                    <x-forms.select name="pagination" :options="$paginationOptions" :selected="auth()->user()->pagination" class="self-end w-full border rounded p-2" :optionAttributes="$paginationDisabled" />
                </div>


                <div class="{{ $boxClass }}">
                    <div class="flex gap-2 justify-between">
                        <h2 class="text-base flex items-center gap-2">
                            <x-icon class="fa-regular fa-calendar" />
                            {{ __('settings/appearance.fields.date-format') }}
                        </h2>
                        <a href="https://docs.kanka.io/en/latest/account/appearance.html#date-formatting" target="_blank" class="" data-tooltip data-title="{{ __('settings/appearance.actions.learn-more') }}">
                            <x-icon class="fa-regular fa-arrow-up-right-from-square" /> {{ __('general.learn-more') }}
                        </a>
                    </div>

                    <p class="text-sm grow">
                        {{ __('settings/appearance.helpers.date-format')}}
                    </p>
                    <x-forms.select name="date_format" :options="[
                        null => 'Month d, Y',
                        'Y-m-d' => 'Y-m-d',
                        'd.m.Y' => 'd.m.Y',
                        'd-m-y' => 'd-m-y',
                        'm/d/Y' => 'm/d/Y',
                        ]" :selected="auth()->user()->date_format" class="self-end w-full border rounded p-2" />

                </div>

                <div class="{{ $boxClass }} {{ $highlight === 'campaign-switcher' ? $highlightClass : '' }}">
                    <div class="flex gap-2 justify-between">
                        <h2 class="text-base flex items-center gap-2">
                            <x-icon class="fa-regular fa-arrow-down-a-z" />
                            {{ __('settings/appearance.fields.campaign-order') }}
                        </h2>
                        <a href="https://docs.kanka.io/en/latest/account/appearance.html#campaign-order" target="_blank" class="" data-tooltip data-title="{{ __('settings/appearance.actions.learn-more') }}">
                            <x-icon class="fa-regular fa-arrow-up-right-from-square" /> {{ __('general.learn-more') }}
                        </a>
                    </div>

                    <p class="text-sm grow">
                        {{ __('settings/appearance.helpers.campaign-order')}}
                    </p>

                    <x-forms.select name="campaign_switcher_order_by" :options="[
                        null => __('settings/appearance.campaign-switcher.date_created'),
                        'r_date_created' => __('settings/appearance.campaign-switcher.r_date_created'),
                        'alphabetical' => __('settings/appearance.campaign-switcher.alphabetical'),
                        'r_alphabetical' => __('settings/appearance.campaign-switcher.r_alphabetical'),
                        'date_joined' => __('settings/appearance.campaign-switcher.date_joined'),
                        'r_date_joined' => __('settings/appearance.campaign-switcher.r_date_joined'),
                        ]" :selected="auth()->user()->campaignSwitcherOrderBy" class="self-end w-full border rounded p-2" />
                </div>

                @if ($textEditorSelect)
                    <div class="{{ $boxClass }}">
                        <div class="flex gap-2 justify-between">
                            <h2 class="text-base flex items-center gap-2">
                                <x-icon class="pencil" />
                                {{ __('settings/appearance.fields.editor') }}
                            </h2>
                            <a href="https://docs.kanka.io/en/latest/account/appearance.html#text-editor" target="_blank" class="" data-tooltip data-title="{{ __('settings/appearance.actions.learn-more') }}">
                                <x-icon class="fa-regular fa-arrow-up-right-from-square" /> {{ __('general.learn-more') }}
                            </a>
                        </div>
                        <p class="text-sm grow">{{ __('settings/appearance.helpers.editor') }}</p>
                        <x-forms.select name="editor" :options="[
                            '' => __('settings/appearance.editors.default', ['name' => 'Summernote']),
                            'legacy' => __('settings/appearance.editors.legacy', ['name' => 'TinyMCE 4']),
                        ]" :selected="auth()->user()->editor" class="self-end w-full border rounded p-2" />
                    </div>
                @endif

                <div class="{{ $boxClass }} {{ $highlight === 'explore' ? $highlightClass : '' }}">
                    <div class="flex gap-2 justify-between">
                        <h2 class="text-base flex items-center gap-2">
                            <x-icon class="fa-solid fa-grid" />
                            {{ __('settings/appearance.fields.entity-explore') }}
                        </h2>
                        <a href="https://docs.kanka.io/en/latest/account/appearance.html#entity-explore" target="_blank" class="" data-tooltip data-title="{{ __('settings/appearance.actions.learn-more') }}">
                            <x-icon class="fa-regular fa-arrow-up-right-from-square" /> {{ __('general.learn-more') }}
                        </a>
                    </div>
                    <p class="text-sm grow">
                        {{ __('settings/appearance.helpers.entity-explore') }}
                    </p>

                    <x-forms.select name="entity_explore" radio :options="[
                            0 => '<i class=\'fa-solid fa-grid\' aria-hidden=\'true\'></i> ' . __('settings/appearance.explore.grid'),
                            1 => '<i class=\'fa-solid fa-list-ul\' aria-hidden=\'true\'></i> ' . __('settings/appearance.explore.table'),
                        ]" :selected="auth()->user()->entity_explore" class="self-end w-full border rounded p-2" />
                </div>

                <div class="{{ $boxClass }}">
                    <div class="flex gap-2 justify-between">
                        <h2 class="text-base flex items-center gap-2">
                            <x-icon class="fa-regular fa-at" />
                            {{ __('settings/appearance.fields.mentions') }}
                        </h2>
                        <a href="https://docs.kanka.io/en/latest/account/appearance.html#mentions" target="_blank" class="" data-tooltip data-title="{{ __('settings/appearance.actions.learn-more') }}">
                            <x-icon class="fa-regular fa-arrow-up-right-from-square" /> {{ __('general.learn-more') }}
                        </a>
                    </div>
                    <p class="text-sm grow">
                        {!! __('settings/appearance.helpers.advanced-mentions') !!}
                    </p>
                    <div class="note-editing-area">
                    <x-forms.select name="advanced_mentions" radio :options="[
                            0 => __('settings/appearance.mentions.default', ['mention' => '<span class=\'mention\'>Entity</span>']),
                            1 => __('settings/appearance.mentions.advanced', ['code' => '<code>[entity:123]</code>']),
                        ]" :selected="auth()->user()->alwaysAdvancedMentions()" class="self-end w-full border rounded p-2"/>
                    </div>
                </div>

            </div>

            <div class="text-center py-4">
                <x-buttons.confirm type="primary" >
                    <x-icon class="save" />
                    <span>{{ __('settings/appearance.actions.save') }}</span>
                </x-buttons.confirm>
            </div>
            @if (!empty($from))
                <input type="hidden" name="from" value="{{ $from }}" />
            @endif
        </x-form>
    </x-grid>
@endsection
