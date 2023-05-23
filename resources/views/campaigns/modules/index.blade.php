@extends('layouts.app', [
    'title' => __('campaigns.show.tabs.settings') . ' - ' . $campaign->name,
    'breadcrumbs' => [
        ['url' => route('campaign'), 'label' => __('entities.campaign')],
        __('campaigns.show.tabs.settings')
    ],
    'canonical' => true,
    'mainTitle' => false,
])

@section('content')
    @include('partials.errors')
    <div class="flex gap-2 flex-col lg:flex-row lg:gap-5">
        <div class="lg:flex-none lg:w-60">
            @include('campaigns._menu', ['active' => 'settings'])
        </div>
        <div class="grow max-w-7xl" id="campaign-modules">

            @php
                $role = \App\Facades\CampaignCache::adminRole();
            @endphp
            <div class="flex gap-2 mb-5 items-center">
                <h3 class="m-0 inline-block grow">
                    {{ __('campaigns.show.tabs.settings') }}
                </h3>

                @if ($canReset)
                    <a href="#" class="btn btn-default btn-sm" data-toggle="dialog" data-target="reset-confirm">
                        <i class="fa-solid fa-eraser" aria-hidden="true"></i>
                        {{ __('crud.actions.reset') }}
                    </a>
                @endif
                <a href="//docs.kanka.io/en/latest/features/campaigns/modules.html"
                   target="_blank" class="btn btn-default btn-sm">
                    <x-icon class="question"></x-icon>
                    {!! __('campaigns.members.actions.help') !!}
                </a>
            </div>

            <x-tutorial code="campaign_modules">
                <p>
                    {{ __('campaigns/modules.helpers.info') }}
                </p>
            </x-tutorial>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-2 md:gap-4">
                <div class="cell col-span-1 flex">
                    @include('campaigns.modules.box', ['icon' => 'fa-solid fa-user', 'module' => 'characters', 'id' => config('entities.ids.character')])
                </div>
                <div class="cell col-span-1 flex">
                    @include('campaigns.modules.box', ['icon' => 'ra ra-tower', 'module' => 'locations', 'id' => config('entities.ids.location')])
                </div>
                <div class="cell col-span-1 flex">
                    @include('campaigns.modules.box', ['icon' => 'ra ra-wyvern', 'module' => 'races', 'id' => config('entities.ids.race')])
                </div>
                <div class="cell col-span-1 flex">
                    @include('campaigns.modules.box', ['icon' => 'ra ra-raven', 'module' => 'creatures', 'id' => config('entities.ids.creature')])
                </div>
                <div class="cell col-span-1 flex">
                    @include('campaigns.modules.box', ['icon' => 'ra ra-double-team', 'module' => 'families', 'id' => config('entities.ids.family')])
                </div>
                <div class="cell col-span-1 flex">
                    @include('campaigns.modules.box', ['icon' => 'ra ra-gem-pendant', 'module' => 'items', 'id' => config('entities.ids.item')])
                </div>
                <div class="cell col-span-1 flex">
                    @include('campaigns.modules.box', ['icon' => 'fa-solid fa-book-open', 'module' => 'notes', 'id' => config('entities.ids.note')])
                </div>
                <div class="cell col-span-1 flex">
                    @include('campaigns.modules.box', ['icon' => 'fa-solid fa-calendar', 'module' => 'calendars', 'id' => config('entities.ids.calendar')])
                </div>
                <div class="cell col-span-1 flex">
                    @include('campaigns.modules.box', ['icon' => 'fa-solid fa-bolt', 'module' => 'events', 'id' => config('entities.ids.event')])
                </div>
                <div class="cell col-span-1 flex">
                    @include('campaigns.modules.box', ['icon' => 'ra ra-quill-ink', 'module' => 'journals', 'id' => config('entities.ids.journal')])
                </div>
                <div class="cell col-span-1 flex">
                    @include('campaigns.modules.box', ['icon' => 'ra ra-hood', 'module' => 'organisations', 'id' => config('entities.ids.organisation')])
                </div>
                <div class="cell col-span-1 flex">
                    @include('campaigns.modules.box', ['icon' => 'ra ra-wooden-sign', 'module' => 'quests', 'id' => config('entities.ids.quest')])
                </div>
                <div class="cell col-span-1 flex">
                    @include('campaigns.modules.box', ['icon' => 'fa-solid fa-tags', 'module' => 'tags', 'id' => config('entities.ids.tag')])
                </div>
                <div class="cell col-span-1 flex">
                    @include('campaigns.modules.box', ['icon' => 'ra ra-fire-symbol', 'module' => 'abilities', 'id' => config('entities.ids.ability')])
                </div>
                <div class="cell col-span-1 flex">
                    @include('campaigns.modules.box', ['icon' => 'fa-solid fa-map', 'module' => 'maps', 'id' => config('entities.ids.map')])
                </div>
                <div class="cell col-span-1 flex">
                    @include('campaigns.modules.box', ['icon' => 'fa-solid fa-hourglass-half', 'module' => 'timelines', 'id' => config('entities.ids.timeline')])
                </div>
                <div class="cell col-span-1 flex">
                    @include('campaigns.modules.box', ['icon' => 'ra ra-dice-five', 'module' => 'dice_rolls', 'deprecated' => true, 'id' => config('entities.ids.dice_roll')])
                </div>
                <div class="cell col-span-1 flex">
                    @include('campaigns.modules.box', ['icon' => 'fa-solid fa-comment', 'module' => 'conversations', 'deprecated' => true, 'id' => config('entities.ids.conversation')])
                </div>
                <div class="cell col-span-1 flex">
                    @include('campaigns.modules.box', ['icon' => 'fa-solid fa-star', 'module' => 'menu_links', 'id' => config('entities.ids.menu_link')])
                </div>
                <div class="cell col-span-1 flex">
                    @include('campaigns.modules.box', ['icon' => 'fa-solid fa-suitcase', 'module' => 'inventories'])
                </div>
                <div class="cell col-span-1 flex">
                    @include('campaigns.modules.box', ['icon' => 'fa-solid fa-table', 'module' => 'entity_attributes'])
                </div>
            </div>


        </div>
    </div>
@endsection

@section('modals')
    @parent
    <x-dialog id="rename-dialog" title="Loading">

    </x-dialog>


    <x-dialog id="reset-confirm" :title="__('campaigns/modules.reset.title')">
        <p>{{ __('campaigns/modules.reset.warning') }}</p>

        <div class="grid grid-cols-2 gap-2 w-full">
            <x-buttons.confirm type="ghost" full="true" dismiss="dialog">
                {{ __('crud.cancel') }}
            </x-buttons.confirm>

            {!! Form::open([
                'method' => 'DELETE',
                'route' => [
                    'modules.reset',
                ]
            ]) !!}
            <x-buttons.confirm type="danger" full="true" outline="true">
                {{ __('crud.click_modal.confirm') }}
            </x-buttons.confirm>
            {!! Form::close() !!}
        </div>
    </x-dialog>
@endsection
