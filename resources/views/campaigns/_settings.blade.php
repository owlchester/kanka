
@php
    $role = \App\Facades\CampaignCache::adminRole();
@endphp
<div class="text-right mb-5">

    <button class="btn btn-default" data-toggle="dialog"
            data-target="settings-help">
        <i class="fa-solid fa-question-circle" aria-hidden="true"></i>
        {!! __('campaigns.members.actions.help') !!}
    </button>
</div>

<div class="grid grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
    <div class="cell col-span-1 flex">
        @include('campaigns.settings.box', ['icon' => 'fa-solid fa-user', 'module' => 'characters'])
    </div>
    <div class="cell col-span-1 flex">
        @include('campaigns.settings.box', ['icon' => 'ra ra-tower', 'module' => 'locations'])
    </div>
    <div class="cell col-span-1 flex">
        @include('campaigns.settings.box', ['icon' => 'ra ra-dragon', 'module' => 'races'])
    </div>
    <div class="cell col-span-1 flex">
        @include('campaigns.settings.box', ['icon' => 'ra ra-double-team', 'module' => 'families'])
    </div>
    <div class="cell col-span-1 flex">
        @include('campaigns.settings.box', ['icon' => 'ra ra-gem-pendant', 'module' => 'items'])
    </div>
    <div class="cell col-span-1 flex">
        @include('campaigns.settings.box', ['icon' => 'ra ra-quill-ink', 'module' => 'notes'])
    </div>
    <div class="cell col-span-1 flex">
        @include('campaigns.settings.box', ['icon' => 'ra ra-moon-sun', 'module' => 'calendars'])
    </div>
    <div class="cell col-span-1 flex">
        @include('campaigns.settings.box', ['icon' => 'fa-solid fa-calendar', 'module' => 'events'])
    </div>
    <div class="cell col-span-1 flex">
        @include('campaigns.settings.box', ['icon' => 'ra ra-scroll-unfurled', 'module' => 'journals'])
    </div>
    <div class="cell col-span-1 flex">
        @include('campaigns.settings.box', ['icon' => 'ra ra-hood', 'module' => 'organisations'])
    </div>
    <div class="cell col-span-1 flex">
        @include('campaigns.settings.box', ['icon' => 'ra ra-wooden-sign', 'module' => 'quests'])
    </div>
    <div class="cell col-span-1 flex">
        @include('campaigns.settings.box', ['icon' => 'fa-solid fa-tags', 'module' => 'tags'])
    </div>
    <div class="cell col-span-1 flex">
        @include('campaigns.settings.box', ['icon' => 'ra ra-fire-symbol', 'module' => 'abilities'])
    </div>
    <div class="cell col-span-1 flex">
        @include('campaigns.settings.box', ['icon' => 'fa-solid fa-map', 'module' => 'maps'])
    </div>
    <div class="cell col-span-1 flex">
        @include('campaigns.settings.box', ['icon' => 'fa-solid fa-clock', 'module' => 'timelines'])
    </div>
    <div class="cell col-span-1 flex">
        @include('campaigns.settings.box', ['icon' => 'ra ra-dice-five', 'module' => 'dice_rolls'])
    </div>
    <div class="cell col-span-1 flex">
        @include('campaigns.settings.box', ['icon' => 'ra ra-speech-bubbles', 'module' => 'conversations'])
    </div>
    <div class="cell col-span-1 flex">
        @include('campaigns.settings.box', ['icon' => 'fa-solid fa-link', 'module' => 'menu_links'])
    </div>
    <div class="cell col-span-1 flex">
        @include('campaigns.settings.box', ['icon' => 'fa-solid fa-suitcase', 'module' => 'inventories'])
    </div>
</div>



@section('modals')
    @parent

    @include('partials.helper-modal', [
        'id' => 'settings-help',
        'title' => __('campaigns.show.tabs.settings'),
        'textes' => [
            __('campaigns.settings.helper', ['admin' => link_to_route(
        'campaigns.campaign_roles.admin',
        \Illuminate\Support\Arr::get($role, 'name', __('campaigns.roles.admin_role')),
        null,
        ['target' => '_blank']
)]),
    ]])
@endsection
