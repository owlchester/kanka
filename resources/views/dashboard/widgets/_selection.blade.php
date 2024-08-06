@php $newWidgetListClass = 'btn2 btn-full'; @endphp
<x-grid>
    <a href="#" class="{{ $newWidgetListClass }}" data-url="{{ route('campaign_dashboard_widgets.create', [$campaign, 'widget' => 'recent', 'dashboard' => $dashboard]) }}" data-toggle="dialog" data-target="primary-dialog">
        <x-icon class="fa-solid fa-list" />
        {{ __('dashboard.setup.widgets.recent') }}
    </a>
    <a href="#" class="{{ $newWidgetListClass }}" data-url="{{ route('campaign_dashboard_widgets.create', [$campaign, 'widget' => 'preview', 'dashboard' => $dashboard]) }}" data-toggle="dialog" data-target="primary-dialog">
        <x-icon class="fa-solid fa-align-justify" />
        {{ __('dashboard.setup.widgets.preview') }}
    </a>
    <a  href="#" class="{{ $newWidgetListClass }}" data-url="{{ route('campaign_dashboard_widgets.create', [$campaign, 'widget' => 'calendar', 'dashboard' => $dashboard]) }}" data-toggle="dialog" data-target="primary-dialog">
        <x-icon entity="calendar" />
        {{ __('dashboard.setup.widgets.calendar') }}
    </a>

    <a href="#" class="{{ $newWidgetListClass }}" data-url="{{ route('campaign_dashboard_widgets.create', [$campaign, 'widget' => \App\Enums\Widget::Header->value, 'dashboard' => $dashboard]) }}" data-toggle="dialog" data-target="primary-dialog">
        <x-icon class="fa-solid fa-heading" />
        {{ __('dashboard.setup.widgets.header') }}
    </a>
    <a  href="#" class="{{ $newWidgetListClass }}" data-url="{{ route('campaign_dashboard_widgets.create', [$campaign, 'widget' => 'random', 'dashboard' => $dashboard]) }}" data-toggle="dialog" data-target="primary-dialog">
        <x-icon class="fa-solid fa-dice-d20" />
        {{ __('dashboard.setup.widgets.random') }}
    </a>
    <a  href="#" class="{{ $newWidgetListClass }}" data-url="{{ route('campaign_dashboard_widgets.create', [$campaign, 'widget' => 'welcome', 'dashboard' => $dashboard]) }}" data-toggle="dialog" data-target="primary-dialog">
        <x-icon class="fa-solid fa-party-horn" />
        {{ __('dashboard.setup.widgets.welcome') }}
    </a>
    @if(!empty($dashboard))
        <a  href="#" class="{{ $newWidgetListClass }}" data-url="{{ route('campaign_dashboard_widgets.create', [$campaign, 'widget' => 'campaign', 'dashboard' => $dashboard]) }}" data-toggle="dialog" data-target="primary-dialog">
            <x-icon class="fa-solid fa-th-list" />
            {{ __('dashboard.setup.widgets.campaign') }}
        </a>
    @endif
</x-grid>
