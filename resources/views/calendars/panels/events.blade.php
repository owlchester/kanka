<?php
/** @var \App\Models\Calendar $model */
/** @var \App\Models\EntityEvent $event */
?>
<div class="box box-solid" id="calendar-events">
    <div class="box-header">
        <h3 class="box-title">
            {{ __('calendars.show.tabs.events') }}
        </h3>
        <div class="box-tools">
            @if (!request()->has('before_id'))
                <a href="{{ route('calendars.events', [$model, 'before_id' => 1]) }}" class="btn btn-box-tool">
                    {{ __('calendars.events.filters.show_before') }}
                </a>
            @endif
            @if (!request()->has('after_id'))
                <a href="{{ route('calendars.events', [$model, 'after_id' => 1]) }}" class="btn btn-box-tool">
                    {{ __('calendars.events.filters.show_after') }}
                </a>
            @endif
            @if (request()->has('after_id') || request()->has('before_id'))
                <a href="{{ route('calendars.events', [$model]) }}" class="btn btn-box-tool">
                    {{ __('calendars.events.filters.show_all') }}
                </a>
            @endif
        </div>
    </div>
    <div id="datagrid-parent" class="table-responsive">
        @include('layouts.datagrid._table')
    </div>
</div>
