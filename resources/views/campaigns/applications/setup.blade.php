<?php /**
 * @var \App\Models\Campaign $model
 * @var \App\Services\LanguageService $languages
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
@inject('languages', 'App\Services\LanguageService')
@section('content')
    @include('ads.top')
    @include('partials.errors')
    <x-form
        method="POST"
        :action="['campaign-applications.setup.save', $campaign]"
        unload
        class="entity-form"
    >
    <div class="bg-base-100 p-4 rounded-xl flex flex-col gap-6">
        <div class="flex gap-2 items-center justify-between">
            <h1 class="text-2xl">
                {{ __('campaigns/applications.setup.title') }}
            </h1>
            <x-learn-more url="features/campaigns/applications.html" />
        </div>

        <p>{!! __('campaigns/applications.setup.tutorial') !!}</p>

        <x-forms.field
            field="intro"
            :label="__('campaigns/applications.fields.intro')">
            <textarea 
                name="intro" 
                id="intro" 
                class="w-full" 
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

        <div class="sticky bottom-4 ml-auto z-50">
            <button type="submit" class="btn2 btn-primary">
                <x-icon class="save" />
                {{ __('crud.save') }}
            </button>
        </div>
    </div>
    </x-form>
@endsection
