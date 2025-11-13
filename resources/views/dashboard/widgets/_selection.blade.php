<?php use App\Enums\Widget; ?>
@php $newWidgetListClass = 'rounded-xl border cursor-pointer btn-outline flex gap-2 p-2 px-4 items-center'; @endphp
<x-grid type="1/1">
    <x-helper>
        @if ($dashboard)
            <p>{!! __('dashboard.widgets.create.helper', ['name' => $dashboard->name]) !!}</p>
        @else
            <p>{!! __('dashboard.widgets.create.helper-default') !!}</p>
        @endif
    </x-helper>
    <div class="flex flex-col gap-2 xl:gap-4">
        <x-dashboards.widgets.selection
            :widget="Widget::Recent"
            :campaign="$campaign"
            :dashboard="$dashboard"
            icon="fa-list"
        ></x-dashboards.widgets.selection>

        <x-dashboards.widgets.selection
            :widget="Widget::Preview"
            :campaign="$campaign"
            :dashboard="$dashboard"
            icon="fa-align-justify"
        ></x-dashboards.widgets.selection>

        @php $calendarModule = \App\Models\EntityType::default()->where('code', 'calendar')->first(); @endphp
        <x-dashboards.widgets.selection
            :widget="Widget::Calendar"
            :campaign="$campaign"
            :dashboard="$dashboard"
            icon="{{ $calendarModule->icon() }}"
        ></x-dashboards.widgets.selection>

        <x-dashboards.widgets.selection
            :widget="Widget::Header"
            :campaign="$campaign"
            :dashboard="$dashboard"
            icon="fa-heading"
        ></x-dashboards.widgets.selection>

        <x-dashboards.widgets.selection
            :widget="Widget::Random"
            :campaign="$campaign"
            :dashboard="$dashboard"
            icon="fa-dice-d20"
        ></x-dashboards.widgets.selection>

        @if(!empty($dashboard))
            <x-dashboards.widgets.selection
                :widget="Widget::Campaign"
                :campaign="$campaign"
                :dashboard="$dashboard"
                icon="fa-th-list"
            ></x-dashboards.widgets.selection>
        @endif

        <x-dashboards.widgets.selection
            :widget="Widget::Welcome"
            :campaign="$campaign"
            :dashboard="$dashboard"
            icon="fa-party-horn"
        ></x-dashboards.widgets.selection>
        <x-dashboards.widgets.selection
            :widget="Widget::Help"
            :campaign="$campaign"
            :dashboard="$dashboard"
            icon="fa-comments"
        ></x-dashboards.widgets.selection>
    </div>
</x-grid>
