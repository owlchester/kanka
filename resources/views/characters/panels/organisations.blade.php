@if(isset($character))
    @php
        Datagrid::layout(\App\Renderers\Layouts\Character\Organisation::class)
                    ->route('characters.organisations', [$character]);

        $rows = $character
            ->organisationMemberships()
            ->select('organisation_member.*')
            ->sort(request()->only(['o', 'k']), ['c.name' => 'asc'])
            ->with(['character', 'character.entity', 'organisation', 'organisation.entity', 'organisation.location', 'organisation.location.entity'])
            ->has('organisation')
            ->has('organisation.entity')
            ->leftJoin('organisations as c', 'c.id', 'organisation_member.organisation_id')
            ->paginate();
    @endphp
@endif
<div class="box box-solid" id="character-organisations">
    <div id="datagrid-parent" class="table-responsive">
        @include('layouts.datagrid._table')
    </div>
</div>

@section('modals')
    @include('layouts.datagrid.delete-forms', ['models' => Datagrid::deleteForms(), 'params' => []])
@endsection
