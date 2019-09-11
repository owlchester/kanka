@if ($campaign->enabled('calendars'))
    <div class="tab-pane {{ (request()->get('tab') == 'form-calendar' ? ' active' : '') }}" id="form-calendar">
        @include('cruds.forms._calendar', ['source' => $source])
    </div>
@endif