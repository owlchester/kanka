@php
    $translations = json_encode([
    'title' => __('dashboards/onboarding.title'),
    'intro' => __('dashboards/onboarding.intro'),
    'name' => __('dashboards/onboarding.fields.name'),
    'placeholder' => __('dashboards/onboarding.placeholders.name'),
    'type-title' => __('dashboards/onboarding.selection.title'),
    'type-intro' => __('dashboards/onboarding.selection.intro'),
    'type-helper' => __('dashboards/onboarding.selection.helper'),
    'skip' => __('dashboards/onboarding.actions.skip'),
    'continue' => __('dashboards/onboarding.actions.continue'),
    'worldbuilding' => __('dashboards/onboarding.selection.worldbuilding'),
    'worldbuilding-description' => __('dashboards/onboarding.selection.worldbuilding-description'),
    'campaign' => __('dashboards/onboarding.selection.campaign'),
    'campaign-description' => __('dashboards/onboarding.selection.campaign-description'),
    'story' => __('dashboards/onboarding.selection.story'),
    'story-description' => __('dashboards/onboarding.selection.story-description'),
    ]);
@endphp
<div id="onboarding">
    <onboarding
        api="{{ route('campaign.onboarding.initial', $campaign) }}"
        skip="{{ route('campaign.onboarding.initial-skip', $campaign) }}"
        i18n="{{ $translations }}"
        campaign="{{ $campaign->name }}"
    ></onboarding>
</div>
