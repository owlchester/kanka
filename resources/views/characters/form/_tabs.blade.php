<li class="{{ (request()->get('tab') == 'traits' ? ' active' : '') }}">
    <a href="#form-traits" title="{{ trans('characters.fields.traits') }}" data-toggle="tooltip">
        {{ trans('characters.fields.traits') }}
    </a>
</li>
@if ($campaign->enabled('organisations'))
<li class="{{ (request()->get('tab') == 'organisations' ? ' active' : '') }}">
    <a href="#form-organisations" title="{{ trans('characters.show.tabs.organisations') }}" data-toggle="tooltip">
        <span class="hidden-xs hidden-sm">{{ trans('characters.show.tabs.organisations') }}</span>
        <i class="visible-xs visible-sm ra ra-hood" title="{{ trans('characters.show.tabs.organisations') }}"></i>
    </a>
</li>
@endif