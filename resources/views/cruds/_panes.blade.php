
@if (!isset($relations))
@can('relation', $model)
    <div class="tab-pane {{ (request()->get('tab') == 'relations' ? ' active' : '') }}" id="relations">
        @include('cruds._relations')
    </div>
@endcan
@endif
@if (!isset($calendars) && $campaign->enabled('calendars'))
    <div class="tab-pane {{ (request()->get('tab') == 'calendars' ? ' active' : '') }}" id="calendars">
        @include('cruds._events')
    </div>
@endif
<div class="tab-pane {{ (request()->get('tab') == 'notes' ? ' active' : '') }}" id="notes">
    @include('cruds._notes')
</div>
<div class="tab-pane {{ (request()->get('tab') == 'attribute' ? ' active' : '') }}" id="attribute">
    @include('cruds._attributes')
</div>
