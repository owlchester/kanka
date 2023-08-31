@extends('layouts.app', [
    'title' => __('dashboard.setup.title'),
    'breadcrumbs' => [
        __('dashboard.setup.title')
    ],
    'mainTitle' => '',
    'centered' => true,
])

@php
use App\Enums\Widget;
$widgetClass = 'widget relative rounded text-xl text-center h-40 overflow-hidden shadow-xs hover:shadow-md cursor-pointer bg-box' ;
$overlayClass = 'bg-box opacity-80 rounded flex gap-3 p-2 flex-col justify-center h-full';
$newWidgetListClass = 'btn2 btn-full';
@endphp

@section('content')
    <x-grid type="1/1">
        <div class="flex gap-2 items-center">
            <h4 class="grow">
                @if ($dashboard)
                    {!! $dashboard->name !!}
                @else
                    {{ __('dashboard.dashboards.default.title') }}
                @endif
            </h4>
            <a href="{{ route('dashboard', isset($dashboard) ? [$campaign, 'dashboard' => $dashboard->id] : [$campaign]) }}" class="btn2 btn-sm" title="{{ __('dashboard.setup.actions.back_to_dashboard') }}">
                <x-icon class="fa-solid fa-arrow-left" />
                {{ __('dashboard.setup.actions.back_to_dashboard') }}
            </a>
        </div>

        <x-box>
            @if ($dashboard)
                {!! __('dashboard.dashboards.custom.text', ['name' => $dashboard->name]) !!}
            @else
                {{ __('dashboard.dashboards.default.text') }}
            @endif

            @if ($campaign->boosted())
                <div class="mt-5 flex items-center gap-2">
                    <a class="btn2 btn-primary btn-sm"
                         data-toggle="dialog"
                         data-target="edit-widget"
                         data-url="{{ route('campaign_dashboards.create', $campaign) }}"
                       >
                        <x-icon class="plus"></x-icon>
                        <span class="hidden sm:inline">{{ __('dashboard.dashboards.actions.new') }}</span>
                    </a>

                    @if(!$dashboards->isEmpty() || !empty($dashboard))
                        <div class="dropdown">
                            <button type="button" class="btn2 btn-sm" data-dropdown aria-expanded="false">
                                <span class="hidden md:inline">{{ __('dashboard.dashboards.actions.switch') }}</span>
                                <span class="inline md:hidden">
                                    <i class="fa-solid fa-exchange-alt" aria-hidden="true"></i>
                                </span>
                                <x-icon class="fa-solid fa-caret-down" />
                            </button>
                            <div class="dropdown-menu hidden" role="menu">
                                @if (!empty($dashboard))
                                    <x-dropdowns.item :link="route('dashboard.setup', $campaign)">
                                        {{ __('dashboard.dashboards.default.title')}}
                                    </x-dropdowns.item>
                                @endif
                                @foreach ($dashboards as $dash)
                                    <x-dropdowns.item :link="route('dashboard.setup', [$campaign, 'dashboard' => $dash->id])">
                                        {!! $dash->name !!}
                                    </x-dropdowns.item>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    @if($dashboard)
                        <div class="dropdown">
                            <button type="button" class="btn2 btn-sm" data-dropdown aria-expanded="false">
                                {{ __('crud.actions.actions') }}
                                <x-icon class="fa-solid fa-caret-down" />
                            </button>
                            <div class="dropdown-menu hidden" role="menu">
                                <x-dropdowns.item :link="route('dashboard', [$campaign, 'dashboard' => $dashboard->id])" icon="fa-solid fa-external-link-alt">
                                    {{ __('crud.view') }}
                                </x-dropdowns.item>

                                @php $url = route('campaign_dashboards.edit', [$campaign, $dashboard]); @endphp
                                <x-dropdowns.item link="#" :dialog="$url" icon="edit">
                                    {{ __('dashboard.dashboards.actions.edit') }}
                                </x-dropdowns.item>

                                @php $url = route('campaign_dashboards.create', [$campaign, 'source' => $dashboard]); @endphp
                                <x-dropdowns.item link="#" :dialog="$url" icon="copy">
                                    {{ __('crud.actions.copy') }}
                                </x-dropdowns.item>

                                @php $data = route('confirm-delete', [$campaign, 'route' => route('campaign_dashboards.destroy', [$campaign, $dashboard]), 'name' => $dashboard->name, 'permanent' => true]); @endphp
                                <x-dropdowns.item link="#" css="text-error hover:bg-error hover:text-error-content" :dialog="$data" icon="trash">
                                    {{ __('crud.remove') }}
                                </x-dropdowns.item>
                            </div>
                        </div>
                    @endif
                </div>
            @endif
        </x-box>

    @include('partials.errors')

        <div class="campaign-dashboard-widgets">
            <div class="grid grid-cols-12 gap-2 md:gap-5" id="widgets" data-url="{{ route('dashboard.reorder', $campaign) }}">
                @if (empty($dashboard))
                <div class="col-span-12">
                    <div class="{{ $widgetClass }} border-dashboard widget-campaign cover-background h-auto" @if($campaign->header_image) style="background-image: url({{ Img::crop(1200, 400)->url($campaign->header_image) }})" @endif
                        data-toggle="dialog"
                         data-target="edit-widget"
                         data-url="{{ route('campaigns.dashboard-header.edit', $campaign) }}"
                    >
                        <div class="{{ $overlayClass }}">
                            <span class="widget-type">{{ __('dashboard.setup.widgets.campaign') }}</span>
                        </div>
                    </div>
                </div>
                @endif
                @foreach ($widgets as $widget)
                    @includeWhen($widget->visible(), '.dashboard._widget')
                @endforeach

                <div class="col-span-4 {{ $widgetClass }} cursor-pointer shadow-xs hover:shadow-md" data-toggle="dialog" data-target="new-widget" id="btn-add-widget">
                    <div class="{{ $overlayClass }} text-2xl">
                        <x-icon class="plus"></x-icon>
                        <span class="block">{{ __('dashboard.setup.actions.add') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </x-grid>
    {{ csrf_field() }}

    @include('editors.editor', ['dialogsInBody' => true])
@endsection

@section('modals')
    <x-dialog id="new-widget" :title="__('dashboard.setup.actions.add')">
        <div class="widget-list grid grid-cols-2 gap-5" id="modal-content-buttons">
            <a href="#" class="{{ $newWidgetListClass }}" data-url="{{ route('campaign_dashboard_widgets.create', [$campaign, 'widget' => 'recent', 'dashboard' => $dashboard]) }}">
                <x-icon class="fa-solid fa-list"></x-icon>
                {{ __('dashboard.setup.widgets.recent') }}
            </a>
            <a href="#" class="{{ $newWidgetListClass }}" id="btn-widget-preview" data-url="{{ route('campaign_dashboard_widgets.create', [$campaign, 'widget' => 'preview', 'dashboard' => $dashboard]) }}">
                <x-icon class="fa-solid fa-align-justify"></x-icon>
                {{ __('dashboard.setup.widgets.preview') }}
            </a>
            <a  href="#" class="{{ $newWidgetListClass }}" id="btn-widget-calendar" data-url="{{ route('campaign_dashboard_widgets.create', [$campaign, 'widget' => 'calendar', 'dashboard' => $dashboard]) }}">
                <x-icon entity="calendar" />
                {{ __('dashboard.setup.widgets.calendar') }}
            </a>

            <a href="#" class="{{ $newWidgetListClass }}" id="btn-widget-header" data-url="{{ route('campaign_dashboard_widgets.create', [$campaign, 'widget' => Widget::Header->value, 'dashboard' => $dashboard]) }}">
                <x-icon class="fa-solid fa-heading"></x-icon>
                {{ __('dashboard.setup.widgets.header') }}
            </a>
            <a  href="#" class="{{ $newWidgetListClass }}" id="btn-widget-random" data-url="{{ route('campaign_dashboard_widgets.create', [$campaign, 'widget' => 'random', 'dashboard' => $dashboard]) }}">
                <x-icon class="fa-solid fa-dice-d20"></x-icon>
                {{ __('dashboard.setup.widgets.random') }}
            </a>
            <a  href="#" class="{{ $newWidgetListClass }}" id="btn-widget-welcome" data-url="{{ route('campaign_dashboard_widgets.create', [$campaign, 'widget' => 'welcome', 'dashboard' => $dashboard]) }}">
                <x-icon class="fa-solid fa-party-horn"></x-icon>
                {{ __('dashboard.setup.widgets.welcome') }}
            </a>
            @if(!empty($dashboard))
                <a  href="#" class="{{ $newWidgetListClass }}" id="btn-widget-campaign" data-url="{{ route('campaign_dashboard_widgets.create', [$campaign, 'widget' => 'campaign', 'dashboard' => $dashboard]) }}">
                    <x-icon class="fa-solid fa-th-list"></x-icon>
                    {{ __('dashboard.setup.widgets.campaign') }}
                </a>
            @endif
        </div>
        <div id="modal-content-spinner" style="display: none">
            <div class="text-center">
                <i class="fa-solid fa-spin fa-spinner fa-2x" aria-hidden="true"></i>
            </div>
        </div>

        <div id="modal-content-target"></div>
    </x-dialog>

    <!-- Modal edit widget -->

    <x-dialog id="edit-widget" :loading="true"></x-dialog>
    <div class="modal fade" id="edit-widget-old" role="dialog" aria-labelledby="deleteConfirmLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content bg-base-100 rounded-2xl">
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    @vite('resources/js/dashboard.js')
@endsection

@section('styles')
    @vite('resources/sass/dashboard.scss')
@endsection
