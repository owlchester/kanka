<li class="{{ (request()->get('tab') == 'form-calendar' ? ' active' : '') }}">
    <a href="#form-calendar" title="{{ trans('crud.fields.calendar') }}" data-toggle="tooltip">
        <i class="ra ra-moon-sun visible-xs"></i> <span class="hidden-xs">{{ trans('crud.fields.calendar') }}</span>
    </a>
</li>
<li class="{{ (request()->get('tab') == 'form-months' ? ' active' : '') }}">
    <a href="#form-months" title="{{ trans('calendars.panels.months') }}" data-toggle="tooltip">
        {{ trans('calendars.panels.months') }}
    </a>
<li class="{{ (request()->get('tab') == 'form-weeks' ? ' active' : '') }}">
    <a href="#form-weeks" title="{{ trans('calendars.panels.weeks') }}" data-toggle="tooltip">
        {{ trans('calendars.panels.weeks') }}
    </a>
</li>
<li class="{{ (request()->get('tab') == 'form-moons' ? ' active' : '') }}">
    <a href="#form-moons" title="{{ trans('calendars.fields.moons') }}" data-toggle="tooltip">
        <i class="far fa-moon visible-xs"></i> <span class="hidden-xs">{{ trans('calendars.fields.moons') }}</span>
    </a>
</li><li class="{{ (request()->get('tab') == 'form-seasons' ? ' active' : '') }}">
    <a href="#form-seasons" title="{{ trans('calendars.fields.seasons') }}" data-toggle="tooltip">
        {{ trans('calendars.fields.seasons') }}
    </a>
</li>
