<li class="{{ (request()->get('tab') == 'traits' ? ' active' : '') }}" data-tab="traits">
    <a href="#form-traits" title="{{ trans('characters.fields.traits') }}" data-toggle="tooltip">
        {{ __('characters.fields.traits') }}
    </a>
</li>
@if ($campaign->enabled('organisations'))
<li class="{{ (request()->get('tab') == 'organisations' ? ' active' : '') }}" data-tab="organisations">
    <a href="#form-organisations" title="{{ __('characters.show.tabs.organisations') }}" data-toggle="tooltip">
        <i class="ra ra-hood" title="{{ __('characters.show.tabs.organisations') }}"></i>

        <span class="hidden-xs hidden-sm">{{ __('characters.show.tabs.organisations') }}</span>
    </a>
</li>
@endif
