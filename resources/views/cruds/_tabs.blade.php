@if (!isset($relations))
    <li class="{{ (request()->get('tab') == 'relations' ? ' active' : '') }}">
        <a href="#relations" title="{{ trans('crud.tabs.relations') }}" data-toggle="tooltip">
            <i class="fa fa-users"></i> <span class="hidden-sm hidden-xs">{{ trans('crud.tabs.relations') }}</span>
        </a>
    </li>
@endif

@if (!isset($calendars) && $campaign->enabled('calendars'))
    <li class="{{ (request()->get('tab') == 'calendars' ? ' active' : '') }}">
        <a href="#calendars" title="{{ trans('crud.tabs.calendars') }}" data-toggle="tooltip">
            <i class="ra ra-moon-sun"></i> <span class="hidden-sm hidden-xs">{{ trans('crud.tabs.calendars') }}</span>
        </a>
    </li>
@endif

<li class="{{ (request()->get('tab') == 'notes' ? ' active' : '') }}">
    <a href="#notes" title="{{ trans('crud.tabs.notes') }}" data-toggle="tooltip">
        <i class="fa fa-file"></i> <span class="hidden-sm hidden-xs">{{ trans('crud.tabs.notes') }}</span>
    </a>
</li>

<li class="{{ (request()->get('tab') == 'attribute' ? ' active' : '') }}">
    <a href="#attribute" title="{{ trans('crud.tabs.attributes') }}" data-toggle="tooltip">
        <i class="fa fa-th-list"></i> <span class="hidden-sm hidden-xs">{{ trans('crud.tabs.attributes') }}</span>
    </a>
</li>
@can('permission', $model)
    <li class="pull-right" data-toggle="tooltip" title="{{ trans('crud.tabs.permissions') }}">
        <a href="{{ route('entities.permissions', $model->entity) }}" data-toggle="ajax-modal" data-target="#entity-modal" data-url="{{ route('entities.permissions', $model->entity) }}">
            <i class="fa fa-cog"></i>
        </a>
    </li>
@endcan