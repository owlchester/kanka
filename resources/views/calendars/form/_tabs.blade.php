<li class="{{ (request()->get('tab') == 'form-calendar' ? ' active' : '') }}">
    <a href="#form-calendar" title="{{ __('entities.calendar') }}">
        <x-icon class="ra ra-moon-sun"></x-icon>
        <span class="hidden-xs hidden-sm">{{ __('entities.calendar') }}</span>
    </a>
</li>
<li class="{{ (request()->get('tab') == 'form-months' ? ' active' : '') }}">
    <a href="#form-months" title="{{ __('calendars.panels.months') }}">
        {{ __('calendars.panels.months') }}
    </a>
<li class="{{ (request()->get('tab') == 'form-weeks' ? ' active' : '') }}">
    <a href="#form-weeks" title="{{ __('calendars.panels.weeks') }}">
        {{ __('calendars.panels.weeks') }}
    </a>
</li>
<li class="{{ (request()->get('tab') == 'form-moons' ? ' active' : '') }}">
    <a href="#form-moons" title="{{ __('calendars.fields.moons') }}">
        <x-icon class="far fa-moon"></x-icon>
        <span class="hidden-xs hidden-sm">{{ __('calendars.fields.moons') }}</span>
    </a>
</li><li class="{{ (request()->get('tab') == 'form-seasons' ? ' active' : '') }}">
    <a href="#form-seasons" title="{{ __('calendars.fields.seasons') }}">
        {{ __('calendars.fields.seasons') }}
    </a>
</li>
