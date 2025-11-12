@php $newWidgetListClass = 'btn2 btn-full btn-outline'; @endphp
<x-grid type="1/1">
    <x-helper>
        @if ($dashboard)
            <p>{!! __('dashboard.widgets.create.helper', ['name' => $dashboard->name]) !!}</p>
        @else
            <p>{!! __('dashboard.widgets.create.helper-default') !!}</p>
        @endif
    </x-helper>
    <div class="flex flex-col gap-2 md:grid grid-cols-2 md:gap-6">
        <a href="#" class="{{ $newWidgetListClass }}" data-url="{{ route('campaign_dashboard_widgets.create', [$campaign, 'widget' => 'recent', 'dashboard' => $dashboard]) }}" data-toggle="dialog" data-target="primary-dialog">
            <x-icon class="fa-solid fa-list" />
            {{ __('dashboard.setup.widgets.recent') }}
        </a>
        <a href="#" class="{{ $newWidgetListClass }}" data-url="{{ route('campaign_dashboard_widgets.create', [$campaign, 'widget' => 'preview', 'dashboard' => $dashboard]) }}" data-toggle="dialog" data-target="primary-dialog">
            <x-icon class="fa-solid fa-align-justify" />
            {{ __('dashboard.setup.widgets.preview') }}
        </a>
        @php $calendarModule = \App\Models\EntityType::default()->where('code', 'calendar')->first(); @endphp
        <a  href="#" class="{{ $newWidgetListClass }}" data-url="{{ route('campaign_dashboard_widgets.create', [$campaign, 'widget' => 'calendar', 'dashboard' => $dashboard]) }}" data-toggle="dialog" data-target="primary-dialog">
            <x-icon :class="$calendarModule->icon()" />
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
        @if(!empty($dashboard))
            <a  href="#" class="{{ $newWidgetListClass }}" data-url="{{ route('campaign_dashboard_widgets.create', [$campaign, 'widget' => 'campaign', 'dashboard' => $dashboard]) }}" data-toggle="dialog" data-target="primary-dialog">
                <x-icon class="fa-regular fa-th-list" />
                {{ __('dashboard.setup.widgets.campaign') }}
            </a>
        @endif
        <a  href="#" class="{{ $newWidgetListClass }}" data-url="{{ route('campaign_dashboard_widgets.create', [$campaign, 'widget' => 'welcome', 'dashboard' => $dashboard]) }}" data-toggle="dialog" data-target="primary-dialog">
            <x-icon class="fa-solid fa-party-horn" />
            {{ __('dashboard.setup.widgets.welcome') }}
        </a>
        <a  href="#" class="{{ $newWidgetListClass }}" data-url="{{ route('campaign_dashboard_widgets.create', [$campaign, 'widget' => 'help', 'dashboard' => $dashboard]) }}" data-toggle="dialog" data-target="primary-dialog">
            <x-icon class="fa-regular fa-comments" />
            {{ __('dashboard.setup.widgets.help') }}
        </a>
    </div>
</x-grid>
