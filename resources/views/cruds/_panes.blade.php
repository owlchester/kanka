
@if (!isset($calendars) && $campaign->enabled('calendars'))
    <div class="tab-pane {{ (request()->get('tab') == 'calendars' ? ' active' : '') }}" id="calendars">
        @include('cruds._events')
    </div>
@endif
<div class="tab-pane {{ (request()->get('tab') == 'notes' ? ' active' : '') }}" id="notes">
    @include('cruds._notes')
</div>
@if (!isset($disableAttributes))
@can('attributes', $model->entity)
<div class="tab-pane {{ (request()->get('tab') == 'attribute' ? ' active' : '') }}" id="attribute">
    @include('cruds._attributes')
</div>
@endcan
@endif
