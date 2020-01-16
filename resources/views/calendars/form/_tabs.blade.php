<li class="{{ (request()->get('tab') == 'form-calendar' ? ' active' : '') }}">
    <a href="#form-calendar" title="{{ trans('crud.fields.calendar') }}" data-toggle="tooltip">
        {{ trans('crud.fields.calendar') }}
    </a>
</li>
<li class="{{ (request()->get('tab') == 'form-weeks' ? ' active' : '') }}">
    <a href="#form-weeks" title="{{ trans('crud.fields.weeks') }}" data-toggle="tooltip">
        {{ trans('crud.fields.weeks') }}
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