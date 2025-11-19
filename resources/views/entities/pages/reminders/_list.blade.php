<x-tutorial code="events" doc="https://docs.kanka.io/en/latest/features/reminders.html">

    <x-slot name="title">
        {!! __('onboarding/reminders.title') !!}
    </x-slot>

    <p>{!! __('onboarding/reminders.text', ['name' => $entity->name]) !!}</p>
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
