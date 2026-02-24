<?php /**
 * @var \App\Models\Campaign $model
 */ ?>
@extends('layouts.app', [
    'title' => __('campaigns/applications.title') . ' - ' . $campaign->name,
    'breadcrumbs' => [
        __('campaigns/applications.title')
    ],
    'mainTitle' => false,
    'sidebar' => 'campaign',
    'centered' => true,
])
@section('content')
    @include('ads.top')

    <div class="flex gap-2 items-center justify-between">
        <h1 class="text-2xl">
            {{ __('campaigns/applications.setup.title') }}
        </h1>
        <x-learn-more url="features/campaigns/applications.html" />
    </div>


    @include('partials.errors')
    <x-form
        method="POST"
        :action="['campaign-applications.setup.save', $campaign]"
        unload
        class="entity-form"
    >
        <x-box class="flex flex-col gap-4">

            <p>{!! __('campaigns/applications.setup.tutorial') !!}</p>

            <x-forms.field
                field="intro"
                required
                :label="__('campaigns/applications.fields.intro')">
                <textarea
                    name="intro"
                    id="intro"
                    class="w-full"
                    required
                    placeholder="{{ __('campaigns/applications.placeholders.intro') }}"
                >{{ old('intro', $campaign->getFilter(\App\Enums\CampaignFilterType::Intro)) }}</textarea>
            </x-forms.field>

            @include('campaigns.forms.panes._discovery', ['model' => $campaign])

            <x-forms.field
                field="tags"
                :label="__('campaigns/applications.fields.playstyle_tags')">
                <input type="hidden" name="playstyle_tags" value="1">
                @include('components.form.playstyles', ['options' => [
                    'model' => $campaign ?? null,
                    'quickCreator' => false
                ]])
            </x-forms.field>

            <h4 class="m-0 text-lg">{{ __('campaigns/applications.timezone') }}</h4>

            <x-forms.field
                field="timezone"
                :label="__('campaigns/applications.fields.timezone')">

                <x-forms.select
                    name="timezone"
                    :options="$timezones"
                    :selected="old('timezone', $campaign->getFilter(\App\Enums\CampaignFilterType::Timezone) ?? 'UTC +00:00')"
                />
            </x-forms.field>

            <x-forms.field
                field="schedule"
                :label="__('campaigns/applications.fields.schedule')">
                <input
                    type="text"
                    name="schedule"
                    value="{{ old('schedule', $campaign->getFilter(\App\Enums\CampaignFilterType::Schedule)) }}"
                    maxlength="45"
                    class="w-full"
                    placeholder="{{ __('campaigns/applications.fields.schedule-placeholder') }}"
                />
            </x-forms.field>

            <x-forms.field
                field="players"
                :label="__('campaigns/applications.fields.player_count')">
                <input
                    type="text"
                    name="players"
                    value="{{ old('players', $campaign->getFilter(\App\Enums\CampaignFilterType::PlayerCount)) }}"
                    maxlength="45"
                    class="w-full"
                    placeholder="{{ __('campaigns/applications.placeholders.player_count') }}"
                />
            </x-forms.field>

            <div class="flex flex-col gap-2">
                <h4 class="m-0 text-lg">{{ __('campaigns/applications.setup.prioritise') }}</h4>

                @if (!$isElemental)
                    <label class="flex items-start gap-3 opacity-50 cursor-not-allowed select-none">
                        <input type="checkbox" disabled class="mt-1 shrink-0" />
                        <span class="flex flex-col gap-1">
                            <span class="font-medium">{{ __('campaigns/applications.setup.prioritise') }}</span>
                            <span class="text-sm text-base-content/70">{{ __('campaigns/applications.setup.prioritise_help') }}</span>
                            <span class="text-sm">
                                {!! __('campaigns/applications.setup.prioritise_upgrade', [
                                    'link' => '<a href="' . route('settings.subscription') . '" class="text-link">Elemental</a>',
                                ]) !!}
                            </span>
                        </span>
                    </label>
                @elseif ($prioritisedCampaign)
                    <label class="flex items-start gap-3 opacity-50 cursor-not-allowed select-none">
                        <input type="checkbox" disabled class="mt-1 shrink-0" />
                        <span class="flex flex-col gap-1">
                            <span class="font-medium">{{ __('campaigns/applications.setup.prioritise') }}</span>
                            <span class="text-sm text-base-content/70">{{ __('campaigns/applications.setup.prioritise_help') }}</span>
                            <span class="text-sm">
                                {!! __('campaigns/applications.setup.prioritise_conflict', [
                                    'campaign' => '<a href="' . route('campaign-applications.setup', $prioritisedCampaign) . '" class="text-link">' . e($prioritisedCampaign->name) . '</a>',
                                ]) !!}
                            </span>
                        </span>
                    </label>
                @else
                    <label class="flex items-start gap-3 cursor-pointer">
                        <input
                            type="checkbox"
                            name="is_prioritised"
                            value="1"
                            class="mt-1 shrink-0"
                            {{ old('is_prioritised', $campaign->is_prioritised) ? 'checked' : '' }}
                        />
                        <span class="flex flex-col gap-1">
                            <span class="font-medium">{{ __('campaigns/applications.setup.prioritise') }}</span>
                            <span class="text-sm text-base-content/70">{{ __('campaigns/applications.setup.prioritise_help') }}</span>
                        </span>
                    </label>
                @endif
            </div>

            <div class="sticky bottom-4 ml-auto z-50">
                <button type="submit" class="btn2 btn-primary">
                    <x-icon class="save" />
                    {{ __('crud.save') }}
                </button>
            </div>
        </x-box>
    </x-form>
@endsection
