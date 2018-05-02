
@if (!isset($relations))
@can('relation', $model)
    <div class="tab-pane {{ (request()->get('tab') == 'relations' ? ' active' : '') }}" id="relations">
        @include('cruds._relations')
    </div>
@endcan
@endif
@if ($campaign->enabled('calendars'))
    <div class="tab-pane {{ (request()->get('tab') == 'events' ? ' active' : '') }}" id="events">
        @include('cruds._events')
    </div>
@endif
@can('attribute', $model)
    <div class="tab-pane {{ (request()->get('tab') == 'notes' ? ' active' : '') }}" id="notes">
        @include('cruds._notes')
    </div>
@endcan
@can('attribute', $model)
    <div class="tab-pane {{ (request()->get('tab') == 'attribute' ? ' active' : '') }}" id="attribute">
        @include('cruds._attributes')
    </div>
@endcan
@can('permission', $model)
    <div class="tab-pane {{ (request()->get('tab') == 'permissions' ? ' active' : '') }}" id="permissions">
        @include('cruds._permissions')
    </div>
@endcan