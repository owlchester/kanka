<div class="box box-solid" id="character-organisations">
    <div id="datagrid-parent" class="table-responsive">
        @include('layouts.datagrid._table')
    </div>
</div>

@section('modals')
    @include('layouts.datagrid.delete-forms', ['models' => Datagrid::deleteForms(), 'params' => []])
@endsection
