<?php
/** @var \App\Models\Calendar $model */
/** @var \App\Models\Reminder $event */
?>
<div id="calendar-events">
    @if(Datagrid::hasBulks())
        <x-form :action="['calendars.entity-events.bulk', $campaign, 'calendar' => $model]"> @endif
            <div id="datagrid-parent" class="table-responsive">
                @include('layouts.datagrid._table')
            </div>
            @if(Datagrid::hasBulks()) </x-form>
    @endif
</div>

@section('modals')
    @parent
    @include('layouts.datagrid.delete-forms', ['models' => Datagrid::deleteForms(), 'params' => []])
@endsection
