<li class="{{ (request()->get('tab') == 'form-calendar' ? ' active' : '') }}">
    <a href="#form-calendar" title="{{ trans('crud.fields.calendar') }}" data-toggle="tooltip">
        {{ trans('crud.fields.calendar') }}
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
        {{ trans('calendars.fields.moons') }}
    </a>
</li><li class="{{ (request()->get('tab') == 'form-seasons' ? ' active' : '') }}">
    <a href="#form-seasons" title="{{ trans('calendars.fields.seasons') }}" data-toggle="tooltip">
        {{ trans('calendars.fields.seasons') }}
    </a>
</li>