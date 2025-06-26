@if(isset($character))
    @php
        Datagrid::layout(\App\Renderers\Layouts\Character\Organisation::class)
                    ->route('characters.organisations', [$campaign, $character]);

        $rows = $character
            ->organisationMemberships()
            ->with(['organisation', 'organisation.entity', 'organisation.entity.image', 'organisation.entity.tags', 'organisation.entity.tags.entity', 'organisation.entity.entityType'])
            ->rows()
            ->paginate();
        $rows->withPath(route('characters.organisations', [$campaign, $character]));
    @endphp
@endif
<div class="overflow-x-auto" id="character-organisations">
    <div id="datagrid-parent" class="table-responsive">
        @include('layouts.datagrid._table')
    </div>
</div>

@section('modals')
    @parent
    @include('layouts.datagrid.delete-forms', ['models' => Datagrid::deleteForms(), 'params' => []])
    <x-dialog id="edit-dialog" :loading="true" />
@endsection
