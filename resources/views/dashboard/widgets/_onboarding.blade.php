@php
    $i18n = json_encode([
        'title' => __('dashboards/widgets/onboarding_widget.title'),
        'dismiss' => __('dashboards/widgets/onboarding_widget.dismiss'),
        'go_to' => __('dashboards/widgets/onboarding_widget.go_to'),
        'step1.heading' => __('dashboards/widgets/onboarding_widget.step1.heading'),
        'step1.saving' => __('dashboards/widgets/onboarding_widget.step1.saving'),
        'step1.campaign' => __('dashboards/widgets/onboarding_widget.step1.campaign'),
        'step1.campaign_description' => __('dashboards/widgets/onboarding_widget.step1.campaign_description'),
        'step1.worldbuilding' => __('dashboards/widgets/onboarding_widget.step1.worldbuilding'),
        'step1.worldbuilding_description' => __('dashboards/widgets/onboarding_widget.step1.worldbuilding_description'),
        'step1.story' => __('dashboards/widgets/onboarding_widget.step1.story'),
        'step1.story_description' => __('dashboards/widgets/onboarding_widget.step1.story_description'),
        'step2.campaign_heading' => __('dashboards/widgets/onboarding_widget.step2.campaign_heading'),
        'step2.campaign_placeholder' => __('dashboards/widgets/onboarding_widget.step2.campaign_placeholder'),
        'step2.worldbuilding_heading' => __('dashboards/widgets/onboarding_widget.step2.worldbuilding_heading'),
        'step2.worldbuilding_placeholder' => __('dashboards/widgets/onboarding_widget.step2.worldbuilding_placeholder'),
        'step2.story_heading' => __('dashboards/widgets/onboarding_widget.step2.story_heading'),
        'step2.story_placeholder' => __('dashboards/widgets/onboarding_widget.step2.story_placeholder'),
        'step2.button' => __('dashboards/widgets/onboarding_widget.step2.button'),
        'step2.creating' => __('dashboards/widgets/onboarding_widget.step2.creating'),
        'step3.campaign_heading' => __('dashboards/widgets/onboarding_widget.step3.campaign_heading'),
        'step3.campaign_placeholder' => __('dashboards/widgets/onboarding_widget.step3.campaign_placeholder'),
        'step3.worldbuilding_heading' => __('dashboards/widgets/onboarding_widget.step3.worldbuilding_heading'),
        'step3.worldbuilding_placeholder' => __('dashboards/widgets/onboarding_widget.step3.worldbuilding_placeholder'),
        'step3.story_heading' => __('dashboards/widgets/onboarding_widget.step3.story_heading'),
        'step3.story_placeholder' => __('dashboards/widgets/onboarding_widget.step3.story_placeholder'),
        'step3.button' => __('dashboards/widgets/onboarding_widget.step3.button'),
        'step3.creating' => __('dashboards/widgets/onboarding_widget.step3.creating'),
        'step4.heading' => __('dashboards/widgets/onboarding_widget.step4.heading'),
        'step4.body' => __('dashboards/widgets/onboarding_widget.step4.body'),
        'step4.cta' => __('dashboards/widgets/onboarding_widget.step4.cta'),
        'step4.skip' => __('dashboards/widgets/onboarding_widget.step4.skip'),
        'step5.campaign_heading' => __('dashboards/widgets/onboarding_widget.step5.campaign_heading'),
        'step5.campaign_body' => __('dashboards/widgets/onboarding_widget.step5.campaign_body'),
        'step5.campaign_cta' => __('dashboards/widgets/onboarding_widget.step5.campaign_cta'),
        'step5.campaign_skip' => __('dashboards/widgets/onboarding_widget.step5.campaign_skip'),
        'step5.other_heading' => __('dashboards/widgets/onboarding_widget.step5.other_heading'),
        'step5.other_body' => __('dashboards/widgets/onboarding_widget.step5.other_body'),
        'step5.other_cta' => __('dashboards/widgets/onboarding_widget.step5.other_cta'),
        'step5.other_skip' => __('dashboards/widgets/onboarding_widget.step5.other_skip'),
        'step6.heading' => __('dashboards/widgets/onboarding_widget.step6.heading'),
        'step6.body' => __('dashboards/widgets/onboarding_widget.step6.body'),
        'step6.dismiss' => __('dashboards/widgets/onboarding_widget.step6.dismiss'),
    ]);

    $entityUrls = json_encode([
        'character' => route('entities.index', [$campaign, config('entities.ids.character')]),
        'location' => route('entities.index', [$campaign, config('entities.ids.location')]),
        'organisation' => route('entities.index', [$campaign, config('entities.ids.organisation')]),
    ]);
@endphp
@can('update', $campaign)
<x-box class="widget-welcome" id="dashboard-widget-{{ $widget->id }}">
    <div id="onboarding-widget">
        <onboarding-widget
            widget-id="{{ $widget->id }}"
            state-api="{{ route('campaign.onboarding.widget.state', $campaign) }}"
            intent-api="{{ route('campaign.onboarding.initial', $campaign) }}"
            quick-create-api="{{ route('campaign.onboarding.quick-create', $campaign) }}"
            progress-api="{{ route('campaign.onboarding.widget.progress', $campaign) }}"
            dismiss-api="{{ route('campaign.onboarding.widget.dismiss', $campaign) }}"
            invite-url="{{ route('campaign_invites.create', $campaign) }}"
            entities-urls="{{ $entityUrls }}"
            i18n-json="{{ $i18n }}"
        ></onboarding-widget>
    </div>
</x-box>
@endcan
