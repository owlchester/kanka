@if (!isset($relations))
@can('relation', $model)
    <li class="{{ (request()->get('tab') == 'relations' ? ' active' : '') }}">
        <a href="#relations" title="{{ trans('crud.tabs.relations') }}" data-toggle="tooltip">
            <i class="fa fa-users"></i> <span class="hidden-sm hidden-xs">{{ trans('crud.tabs.relations') }}</span>
        </a>
    </li>
@endcan
@endif

@if (!isset($calendars) && $campaign->enabled('calendars'))
    @can('attribute', $model)
        <li class="{{ (request()->get('tab') == 'events' ? ' active' : '') }}">
            <a href="#events" title="{{ trans('crud.tabs.events') }}" data-toggle="tooltip">
                <i class="fa fa-calendar-o"></i> <span class="hidden-sm hidden-xs">{{ trans('crud.tabs.events') }}</span>
            </a>
        </li>
    @endcan
@endif

@can('attribute', $model)
    <li class="{{ (request()->get('tab') == 'notes' ? ' active' : '') }}">
        <a href="#notes" title="{{ trans('crud.tabs.notes') }}" data-toggle="tooltip">
            <i class="fa fa-file"></i> <span class="hidden-sm hidden-xs">{{ trans('crud.tabs.notes') }}</span>
        </a>
    </li>
@endcan
@can('attribute', $model)
    <li class="{{ (request()->get('tab') == 'attribute' ? ' active' : '') }}">
        <a href="#attribute" title="{{ trans('crud.tabs.attributes') }}" data-toggle="tooltip">
            <i class="fa fa-th-list"></i> <span class="hidden-sm hidden-xs">{{ trans('crud.tabs.attributes') }}</span>
        </a>
    </li>
@endcan
@can('permission', $model)
    <li class="pull-right" data-toggle="tooltip" title="{{ trans('crud.tabs.permissions') }}">
        <a href="{{ route('entities.permissions', $model->entity) }}" data-toggle="modal" data-target="#permissions-modal" data-url="{{ route('entities.permissions', $model->entity) }}">
            <i class="fa fa-cog"></i>
        </a>
    </li>
@endcan