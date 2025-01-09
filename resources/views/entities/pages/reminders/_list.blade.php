<x-tutorial code="events" doc="https://docs.kanka.io/en/latest/features/reminders.html">
    <p>{!! __('entities/events.helpers.reminders', ['name' => $entity->name]) !!}</p>
</x-tutorial>

@if ($rows->count() > 0)
    <div id="datagrid-parent" class="table-responsive">
        @include('layouts.datagrid._table')
    </div>
@endif

@section('modals')
    @parent
    <x-dialog id="edit-dialog" :loading="true" />
    @include('layouts.datagrid.delete-forms', ['models' => Datagrid::deleteForms(), 'params' => []])
@endsection
