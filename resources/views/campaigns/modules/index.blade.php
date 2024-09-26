@extends('layouts.app', [
    'title' => __('campaigns.show.tabs.modules') . ' - ' . $campaign->name,
    'breadcrumbs' => [
        __('campaigns.show.tabs.modules')
    ],
    'canonical' => true,
    'mainTitle' => false,
    'sidebar' => 'campaign',
    'centered' => true,
])

@php
    $role = \App\Facades\CampaignCache::adminRole();
@endphp
@section('content')
    @include('ads.top')
    @include('partials.errors')
    <div class="grow flex flex-col gap-5" id="campaign-modules">

        <div class="flex gap-2 items-center">
            <h3 class="inline-block grow">
                {{ __('campaigns.show.tabs.modules') }}
            </h3>

            <a href="//docs.kanka.io/en/latest/features/campaigns/modules.html"
               target="_blank" class="btn2 btn-sm btn-ghost">
                <x-icon class="question" />
                {!! __('crud.actions.help') !!}
            </a>
            @can('update', $campaign)
            @if ($canReset)
                <a href="#" class="btn2 btn-sm" data-toggle="dialog" data-target="reset-confirm">
                    <i class="fa-solid fa-eraser" aria-hidden="true"></i>
                    {{ __('crud.actions.reset') }}
                </a>
            @endif
            @endcan
        </div>

        <x-tutorial code="campaign_modules">
            <p>
                {{ __('campaigns/modules.helpers.info') }}
            </p>
        </x-tutorial>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-2 md:gap-4">
            <div class="cell col-span-1 flex">
                @include('campaigns.modules.box', ['icon' => config('entities.icons.character'), 'module' => 'characters', 'id' => config('entities.ids.character')])
            </div>
            <div class="cell col-span-1 flex">
                @include('campaigns.modules.box', ['icon' => config('entities.icons.location'), 'module' => 'locations', 'id' => config('entities.ids.location')])
            </div>
            <div class="cell col-span-1 flex">
                @include('campaigns.modules.box', ['icon' => config('entities.icons.race'), 'module' => 'races', 'id' => config('entities.ids.race')])
            </div>
            <div class="cell col-span-1 flex">
                @include('campaigns.modules.box', ['icon' => config('entities.icons.creature'), 'module' => 'creatures', 'id' => config('entities.ids.creature')])
            </div>
            <div class="cell col-span-1 flex">
                @include('campaigns.modules.box', ['icon' => config('entities.icons.family'), 'module' => 'families', 'id' => config('entities.ids.family')])
            </div>
            <div class="cell col-span-1 flex">
                @include('campaigns.modules.box', ['icon' => config('entities.icons.item'), 'module' => 'items', 'id' => config('entities.ids.item')])
            </div>
            <div class="cell col-span-1 flex">
                @include('campaigns.modules.box', ['icon' => config('entities.icons.note'), 'module' => 'notes', 'id' => config('entities.ids.note')])
            </div>
            <div class="cell col-span-1 flex">
                @include('campaigns.modules.box', ['icon' => config('entities.icons.calendar'), 'module' => 'calendars', 'id' => config('entities.ids.calendar')])
            </div>
            <div class="cell col-span-1 flex">
                @include('campaigns.modules.box', ['icon' => config('entities.icons.event'), 'module' => 'events', 'id' => config('entities.ids.event')])
            </div>
            <div class="cell col-span-1 flex">
                @include('campaigns.modules.box', ['icon' => config('entities.icons.journal'), 'module' => 'journals', 'id' => config('entities.ids.journal')])
            </div>
            <div class="cell col-span-1 flex">
                @include('campaigns.modules.box', ['icon' => config('entities.icons.organisation'), 'module' => 'organisations', 'id' => config('entities.ids.organisation')])
            </div>
            <div class="cell col-span-1 flex">
                @include('campaigns.modules.box', ['icon' => config('entities.icons.quest'), 'module' => 'quests', 'id' => config('entities.ids.quest')])
            </div>
            <div class="cell col-span-1 flex">
                @include('campaigns.modules.box', ['icon' => config('entities.icons.tag'), 'module' => 'tags', 'id' => config('entities.ids.tag')])
            </div>
            <div class="cell col-span-1 flex">
                @include('campaigns.modules.box', ['icon' => config('entities.icons.ability'), 'module' => 'abilities', 'id' => config('entities.ids.ability')])
            </div>
            <div class="cell col-span-1 flex">
                @include('campaigns.modules.box', ['icon' => config('entities.icons.map'), 'module' => 'maps', 'id' => config('entities.ids.map')])
            </div>
            <div class="cell col-span-1 flex">
                @include('campaigns.modules.box', ['icon' => config('entities.icons.timeline'), 'module' => 'timelines', 'id' => config('entities.ids.timeline')])
            </div>
            <div class="cell col-span-1 flex">
                @include('campaigns.modules.box', ['icon' => config('entities.icons.dice_roll'), 'module' => 'dice_rolls', 'deprecated' => true, 'id' => config('entities.ids.dice_roll')])
            </div>
            <div class="cell col-span-1 flex">
                @include('campaigns.modules.box', ['icon' => config('entities.icons.conversation'), 'module' => 'conversations', 'deprecated' => true, 'id' => config('entities.ids.conversation')])
            </div>
            <div class="cell col-span-1 flex">
                @include('campaigns.modules.box', ['icon' => config('entities.icons.bookmark'), 'module' => 'bookmarks', 'id' => config('entities.ids.bookmarks')])
            </div>
            <div class="cell col-span-1 flex">
                @include('campaigns.modules.box', ['icon' => 'fa-solid fa-suitcase', 'module' => 'inventories'])
            </div>
            <div class="cell col-span-1 flex">
                @include('campaigns.modules.box', ['icon' => 'fa-solid fa-table', 'module' => 'entity_attributes'])
            </div>
            <div class="cell col-span-1 flex">
                @include('campaigns.modules.box', ['icon' => 'fa-solid fa-folder', 'module' => 'assets'])
            </div>
        </div>
    </div>
@endsection

@section('modals')
    @parent
    <x-dialog id="rename-dialog" :loading="true"></x-dialog>

    <x-dialog id="reset-confirm" :title="__('campaigns/modules.reset.title')">
        <p>{{ __('campaigns/modules.reset.warning') }}</p>

        <div class="grid grid-cols-2 gap-2 w-full">
            <x-buttons.confirm type="ghost" full="true" dismiss="dialog">
                {{ __('crud.cancel') }}
            </x-buttons.confirm>

            <x-form method="DELETE" :action="['modules.reset', $campaign]">
            <x-buttons.confirm type="danger" full="true" outline="true">
                {{ __('crud.click_modal.confirm') }}
            </x-buttons.confirm>
            </x-form>
        </div>
    </x-dialog>
@endsection
