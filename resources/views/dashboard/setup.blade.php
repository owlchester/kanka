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
$widgetClass = 'widget relative rounded text-center h-28 shadow-xs hover:shadow-md cursor-pointer bg-box' ;
$overlayClass = 'bg-box opacity-80 rounded flex gap-2 flex-col p-2 justify-center items-center h-full';
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
            <x-grid type="1/1">
            @if ($dashboard)
                {!! __('dashboard.dashboards.custom.text', ['name' => $dashboard->name]) !!}
            @else
                {!! __('dashboard.dashboards.default.text', ['campaign' => $campaign->name]) !!}
            @endif


                <div class="flex items-center gap-2">
                    <a class="btn2 btn-primary btn-sm"
                         data-toggle="dialog"
                         data-target="primary-dialog"
                         data-url="{{ route('campaign_dashboards.create', $campaign) }}"
                       >
                        <x-icon class="plus" />
                        <span class="hidden sm:inline">{{ __('dashboard.dashboards.actions.new') }}</span>
                    </a>

                    @if(!$dashboards->isEmpty() || !empty($dashboard))
                        <div class="dropdown">
                            <button type="button" class="btn2 btn-sm" data-dropdown aria-expanded="false">
                                <span class="hidden md:inline">{{ __('dashboard.dashboards.actions.switch') }}</span>
                                <span class="inline md:hidden">
                                    <x-icon class="fa-solid fa-exchange-alt" />
                                </span>
                                <x-icon class="fa-solid fa-caret-down" />
                            </button>
                            <div class="dropdown-menu hidden" role="menu">
                                @if (!empty($dashboard))
                                    <x-dropdowns.item :link="route('dashboard.setup', $campaign)" icon="fa-solid fa-home">
                                        {{ __('dashboard.dashboards.default.title')}}
                                    </x-dropdowns.item>
                                @endif
                                @foreach ($dashboards as $dash)
                                    <x-dropdowns.item :link="route('dashboard.setup', [$campaign, 'dashboard' => $dash->id])" icon="fa-solid fa-chevron-right">
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
            </x-grid>
        </x-box>

        @include('partials.errors')

        <x-tutorial code="dashboard-setup">
            <p>
                {!! __('dashboard.setup.tutorial.text', [
'blog' => '<a href="https://blog.kanka.io/2020/09/20/how-to-style-your-kanka-campaign-dashboard/" target="_blank">' . __('dashboard.setup.tutorial.blog') . '</a>',
]) !!}
            </p>
        </x-tutorial>

        <div class="campaign-dashboard-widgets">
            <div class="grid grid-cols-12 gap-2 md:gap-5" id="widgets" data-url="{{ route('dashboard.reorder', $campaign) }}">
                @if (empty($dashboard))
                <div class="col-span-12">
                    <div class="{{ $widgetClass }} border-dashboard widget-campaign cover-background h-auto p-4" @if($campaign->header_image) style="background-image: url({{ Img::crop(1200, 400)->url($campaign->header_image) }})" @endif
                        data-toggle="dialog"
                         data-target="primary-dialog"
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

                <div class="col-span-4 {{ $widgetClass }}" data-toggle="dialog" data-target="primary-dialog" data-url="{{ route('campaign_dashboard_widgets.index', [$campaign, 'dashboard' => $dashboard]) }}">
                    <div class="text-lg flex gap-2 items-center justify-center p-2 talign-middle h-full">
                        <x-icon class="plus" />
                        <span>{{ __('dashboard.setup.actions.add') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </x-grid>
    {{ csrf_field() }}

    @include('editors.editor', ['dialogsInBody' => true])
@endsection

@section('scripts')
    @vite('resources/js/dashboard.js')
@endsection

@section('styles')
    @vite('resources/sass/dashboard.scss')
@endsection
