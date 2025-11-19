<x-box class="widget-welcome" id="dashboard-widget-{{ $widget->id }}">
    <div class="entity-content" id="getting-started">
        <getting-started
            api="{{ route('campaign.widgets.getting-started', [$campaign]) }}"
            name="{{ __('dashboards/widgets/onboarding.name') }}"
        ></getting-started>
    </div>
</x-box>
