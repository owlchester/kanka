<li class="{{ (request()->get('tab') == 'form-moon' ? ' active' : '') }}">
    <a href="#form-calendar" title="{{ trans('crud.fields.calendar') }}" data-toggle="tooltip">
        {{ trans('crud.fields.calendar') }}
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