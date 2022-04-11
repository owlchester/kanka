<li class="{{ $sidebar->active('dashboard') }} section section-dashboard">
    <a href="{{ route('dashboard') }}">
        <i class="fas fa-th-large"></i> <span>{{ __('sidebar.dashboard') }}</span>
    </a>
</li>
@includeWhen($currentCampaign->enabled('menu_links'), 'layouts.sidebars.quick-links')

<li class="{{ $sidebar->active('campaigns') }} section section-world">
    <a href="{{ route('campaign') }}">
        <i class="fa fa-globe"></i>
        <span>{{ __('sidebar.world') }}</span>
    </a>
</li>

@if ($currentCampaign->enabled('characters'))
    <li class="{{ $sidebar->active('characters') }} subsection section-characters">
        <a class="" href="{{ route('characters.index') }}"><i class="fa fa-user"></i> <span>{{ __('sidebar.characters') }}</span></a>
    </li>
@endif
@if ($currentCampaign->enabled('locations'))
    <li class="{{ $sidebar->active('locations') }} subsection  section-locations">
        <a href="{{ route('locations.' . $defaultIndex) }}"><i class="ra ra-tower"></i> <span>{{ __('sidebar.locations') }}</span></a>
    </li>
@endif
@if ($currentCampaign->enabled('maps'))
    <li class="{{ $sidebar->active('maps') }} subsection section-maps">
        <a href="{{ route('maps.' . $defaultIndex) }}"><i class="fas fa-map"></i> <span>{{ __('entities.maps') }}</span></a>
    </li>
@endif
@if ($currentCampaign->enabled('organisations'))
    <li class="{{ $sidebar->active('organisations') }} subsection section-organisations">
        <a href="{{ route('organisations.' . $defaultIndex) }}"><i class="ra ra-hood"></i> <span>{{ __('sidebar.organisations') }}</span></a>
    </li>
@endif
@if ($currentCampaign->enabled('families'))
    <li class="{{ $sidebar->active('families') }} subsection section-families">
        <a href="{{ route('families.' . $defaultIndex) }}"><i class="ra ra-double-team"></i> <span>{{ __('sidebar.families') }}</span></a>
    </li>
@endif
@if ($currentCampaign->enabled('calendars'))
    <li class="{{ $sidebar->active('calendars') }} subsection section-calendars">
        <a href="{{ route('calendars.' . $defaultIndex) }}"><i class="fa fa-calendar"></i> <span>{{ __('sidebar.calendars') }}</span></a>
    </li>
@endif
@if ($currentCampaign->enabled('timelines'))
    <li class="{{ $sidebar->active('timelines') }} subsection section-timelines">
        <a href="{{ route('timelines.' . $defaultIndex) }}"><i class="fas fa-hourglass-half"></i> <span>{{ __('sidebar.timelines') }}</span></a>
    </li>
@endif
@if ($currentCampaign->enabled('races'))
    <li class="{{ $sidebar->active('races') }} subsection section-races">
        <a href="{{ route('races.' . $defaultIndex) }}"><i class="ra ra-wyvern"></i> <span>{{ __('sidebar.races') }}</span></a>
    </li>
@endif

<li class="section section-campaign">
    <a href="{{ route('campaign') }}">
        <i class="fa fa-globe"></i>
        <span>{{ __('sidebar.campaign') }}</span>
    </a>
</li>
@if ($currentCampaign->enabled('quests'))
    <li class="{{ $sidebar->active('quests') }} subsection section-quests">
        <a href="{{ route('quests.' . $defaultIndex) }}"><i class="ra ra-wooden-sign"></i> <span>{{ __('sidebar.quests') }}</span></a>
    </li>
@endif
@if ($currentCampaign->enabled('journals'))
    <li class="{{ $sidebar->active('journals') }} subsection section-journals">
        <a href="{{ route('journals.' . $defaultIndex) }}"><i class="ra ra-quill-ink"></i> <span>{{ __('sidebar.journals') }}</span></a>
    </li>
@endif

@if ($currentCampaign->enabled('items'))
    <li class="{{ $sidebar->active('items') }} subsection section-items">
        <a href="{{ route('items.index') }}"><i class="ra ra-gem-pendant"></i> <span>{{ __('sidebar.items') }}</span></a>
    </li>
@endif
@if ($currentCampaign->enabled('events'))
    <li class="{{ $sidebar->active('events') }} subsection section-events">
        <a href="{{ route('events.' . $defaultIndex) }}"><i class="fa fa-bolt"></i> <span>{{ __('sidebar.events') }}</span></a>
    </li>
@endif
@if ($currentCampaign->enabled('abilities'))
    <li class="{{ $sidebar->active('abilities') }} subsection section-abilities">
        <a href="{{ route('abilities.' . $defaultIndex) }}"><i class="ra ra-fire-symbol"></i> <span>{{ __('sidebar.abilities') }}</span></a>
    </li>
@endif


@if ($currentCampaign->enabled('notes'))
    <li class="{{ $sidebar->active('notes') }} section-notes">
        <a href="{{ route('notes.' . $defaultIndex) }}"><i class="fas fa-book-open"></i> <span>{{ __('sidebar.notes') }}</span></a>
    </li>
@endif

<li class="sidebar-section section-other">
    <div class="sidebar-text">
        <i class="fas fa-cubes"></i>
        <span>{{ __('sidebar.other') }}</span>
    </div>
</li>

@if ($currentCampaign->enabled('tags'))
    <li class="{{ $sidebar->active('tags') }} subsection section-tags">
        <a href="{{ route('tags.' . $defaultIndex) }}"><i class="fa fa-tags"></i> <span>{{ __('sidebar.tags') }}</span></a>
    </li>
@endif
@if ($currentCampaign->enabled('conversations'))
    <li class="{{ $sidebar->active('conversations') }} subsection section-conversations">
        <a href="{{ route('conversations.index') }}"><i class="fa fa-comment"></i> <span>{{ __('sidebar.conversations') }}</span></a>
    </li>
@endif
@if ($currentCampaign->enabled('dice_rolls'))
    <li class="{{ $sidebar->active('dice_rolls') }} subsection section-dice-rolls">
        <a href="{{ route('dice_rolls.index') }}"><i class="ra ra-dice-five"></i> <span>{{ __('sidebar.dice_rolls') }}</span></a>
    </li>
@endif
@can('relations', $currentCampaign)
    <li class="{{ $sidebar->active('relations') }} subsection section-relations">
        <a href="{{ route('relations.index') }}"><i class="fas fa-people-arrows"></i> <span>{{ __('sidebar.relations') }}</span></a>
    </li>
@endcan
@can('gallery', $currentCampaign)
    <li class="{{ $sidebar->active('gallery') }} subsection section-gallery">
        <a href="{{ route('campaign.gallery.index') }}"><i class="fas fa-images"></i> <span>{{ __('sidebar.gallery') }}</span></a>
    </li>
@endcan
<li class="{{ $sidebar->active('attribute_templates') }} subsection section-attribute-templates">
    <a href="{{ route('attribute_templates.index') }}"><i class="fa fa-copy"></i> <span>{{ __('sidebar.attribute_templates') }}</span></a>
</li>
