<div class="box box-solid" id="entity-mentions">
    <div class="box-header">
        <h3 class="box-title">
            {{ __('crud.tabs.mentions') }}
        </h3>
        <p class="help-block">
            {{ __('entities/mentions.helper') }}
        </p>
    </div>
    <div id="datagrid-parent" class="table-responsive">
        @include('layouts.datagrid._table')
    </div>
</div>
