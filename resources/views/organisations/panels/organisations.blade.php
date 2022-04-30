<div class="box box-solid" id="organisation-suborganisations">
    <div class="box-header">
        <h3 class="box-title">
            {{ __('organisations.show.tabs.organisations') }}
        </h3>

        <div class="box-tools">
            <a href="#" class="btn btn-box-tool" data-toggle="modal" data-target="#help-modal">
                <i class="fa-solid fa-question-circle"></i> {{ __('crud.actions.help') }}
            </a>
        </div>
    </div>

    <div id="datagrid-parent" class="table-responsive">
        @include('layouts.datagrid._table')
    </div>
</div>

