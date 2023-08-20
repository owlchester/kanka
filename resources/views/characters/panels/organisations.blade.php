@if(isset($character))
    @php
        Datagrid::layout(\App\Renderers\Layouts\Character\Organisation::class)
                    ->route('characters.organisations', [$campaign, $character]);

        $rows = $character
            ->organisationMemberships()
            ->rows()
            ->paginate();
    @endphp
@endif
<div class="box box-solid" id="character-organisations">
    <div id="datagrid-parent" class="table-responsive">
        @include('layouts.datagrid._table')
    </div>
</div>

@section('modals')
    @parent
    @include('layouts.datagrid.delete-forms', ['models' => Datagrid::deleteForms(), 'params' => []])
    <x-dialog id="edit-dialog" :loading="true" />
@endsection
