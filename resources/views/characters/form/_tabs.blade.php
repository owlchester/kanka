<li class="{{ (request()->get('tab') == 'traits' ? ' active' : '') }}">
    <a href="#form-traits" title="{{ trans('characters.fields.traits') }}" data-toggle="tooltip">
        {{ trans('characters.fields.traits') }}
    </a>
</li>
@if ($campaign->enabled('organisations'))
<li class="{{ (request()->get('tab') == 'organisations' ? ' active' : '') }}">
    <a href="#form-organisations" title="{{ trans('characters.show.tabs.organisations') }}" data-toggle="tooltip">
        {{ trans('characters.show.tabs.organisations') }}
    </a>
</li>
@endif