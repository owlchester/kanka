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
        @if($campaign->premium())
            <x-dashboards.widgets.selection
                :widget="Widget::Gallery"
                :campaign="$campaign"
                :dashboard="$dashboard"
                icon="fa-images"
            ></x-dashboards.widgets.selection>
        @else
            <a href="@can('boost', auth()->user()){{ route('settings.premium', ['campaign' => $campaign]) }}@else{{ \App\Facades\Domain::toFront('premium') }}@endcan" class="flex gap-4 p-2 px-3 rounded-xl border border-base-300 items-center text-base-content hover:text-boost hover:border-boost hover:shadow-xs">
                <x-icon class="fa-regular fa-images text-xl" />
                <div class="flex flex-col gap-0 flex-grow">
                    <p>{{ __('dashboards/widgets/gallery.name') }}</p>
                    <p class="text-neutral-content text-xs">
                        {{ __('dashboards/widgets/gallery.description') }}
                    </p>
                </div>
                <div class="text-boost">
                    <x-icon class="premium" />
                </div>
            </a>
        @endif
        @if($campaign->isOpen())
            <x-dashboards.widgets.selection
                :widget="Widget::Join"
                :campaign="$campaign"
                :dashboard="$dashboard"
                icon="fa-door-open"
            ></x-dashboards.widgets.selection>
        @endif
        @if(!empty($dashboard))
            <x-dashboards.widgets.selection
                :widget="Widget::Campaign"
                :campaign="$campaign"
                :dashboard="$dashboard"
                icon="fa-th-list"
            ></x-dashboards.widgets.selection>
        @endif
        @if ($withOnboarding)
        <x-dashboards.widgets.selection
            :widget="Widget::Onboarding"
            :campaign="$campaign"
            :dashboard="$dashboard"
            icon="fa-calendar-check"
        ></x-dashboards.widgets.selection>
        @endif
        @if ($withHelp)
        <x-dashboards.widgets.selection
            :widget="Widget::Help"
            :campaign="$campaign"
            :dashboard="$dashboard"
            icon="fa-comments"
        ></x-dashboards.widgets.selection>
        @endif
    </div>
</x-grid>
