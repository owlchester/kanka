<div class="box box-solid" id="character-organisations">
    <div class="box-header">
        <h3 class="box-title">
            {{ __('characters.show.tabs.organisations') }}
        </h3>
    </div>

    <div id="datagrid-parent" class="table-responsive">
        @include('layouts.datagrid._table')
    </div>
</div>


@section('modals')
    @include('layouts.datagrid.delete-forms', ['models' => Datagrid::deleteForms()])
@endsection
