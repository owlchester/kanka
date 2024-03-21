<?php
/** @var \App\Models\Calendar $model */
/** @var \App\Models\EntityEvent $event */
?>
<div id="calendar-events">
    @if(Datagrid::hasBulks()) {!! Form::open(['route' => ['calendars.entity-events.bulk', $campaign, 'calendar' => $model]]) !!} @endif
    <div id="datagrid-parent" class="table-responsive">
        @include('layouts.datagrid._table')
    </div>
    @if(Datagrid::hasBulks()) {!! Form::close() !!} @endif
</div>

@section('modals')
    @parent
    @include('layouts.datagrid.delete-forms', ['models' => Datagrid::deleteForms(), 'params' => []])
@endsection
