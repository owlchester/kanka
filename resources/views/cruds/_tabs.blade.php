
@if (!isset($calendars) && $campaign->enabled('calendars'))
    <li class="{{ (request()->get('tab') == 'calendars' ? ' active' : '') }}">
        <a href="#calendars" title="{{ trans('crud.tabs.reminders') }}" data-toggle="tooltip">
            <i class="ra ra-moon-sun"></i> <span class="hidden-sm hidden-xs">{{ trans('crud.tabs.reminders') }}</span>
        </a>
    </li>
@endif

<li class="{{ (request()->get('tab') == 'notes' ? ' active' : '') }}">
    <a href="#notes" title="{{ trans('crud.tabs.notes') }}" data-toggle="tooltip">
        <i class="fa fa-file"></i> <span class="hidden-sm hidden-xs">{{ trans('crud.tabs.notes') }}</span>
    </a>
</li>

@if (!isset($disableAttributes))
@can('attributes', $model->entity)
<li class="{{ (request()->get('tab') == 'attribute' ? ' active' : '') }}">
    <a href="#attribute" title="{{ trans('crud.tabs.attributes') }}" data-toggle="tooltip">
        <i class="fa fa-th-list"></i> <span class="hidden-sm hidden-xs">{{ trans('crud.tabs.attributes') }}</span>
    </a>
</li>
@endcan
@endif
