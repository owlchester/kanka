<?php
/** @var \App\Models\Calendar $model */
?>
<div id="calendar-eras">
    @if(Datagrid::hasBulks())
        <x-form :action="['calendars.calendar_eras.index', $campaign, 'calendar' => $model]">
            <div id="datagrid-parent" class="table-responsive">
                @include('layouts.datagrid._table')
            </div>
        </x-form>
    @else
        <div id="datagrid-parent" class="table-responsive">
            @include('layouts.datagrid._table')
        </div>
    @endif
</div>

@section('modals')
    @parent
    @include('layouts.datagrid.delete-forms', ['models' => Datagrid::deleteForms(), 'params' => []])
@endsection
