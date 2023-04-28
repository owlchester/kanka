<li class="{{ (request()->get('tab') == 'traits' ? ' active' : '') }}" data-tab="traits">
    <a href="#form-traits" title="{{ trans('characters.fields.traits') }}" data-toggle="tooltip">
        {{ __('characters.fields.traits') }}
    </a>
</li>
@if ($campaignService->enabled('organisations'))
    @php $tabTitle = \App\Facades\Module::plural(config('entities.ids.organisation'), __('entities.organisations')); @endphp
<li class="{{ (request()->get('tab') == 'organisations' ? ' active' : '') }}" data-tab="organisations">
    <a href="#form-organisations" title="{{ $tabTitle }}" data-toggle="tooltip">
        <i class="ra ra-hood" title="{{ $tabTitle }}"></i>

        <span class="hidden-xs hidden-sm">
            {!! $tabTitle !!}
        </span>
    </a>
</li>
@endif
