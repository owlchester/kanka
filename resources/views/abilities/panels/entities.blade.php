<?php /** @var \App\Models\Entity $entity */?>
<div class="box box-solid" id="ability-entities">
    <div class="box-body">
        <p class="help-block">{{ __('abilities.helpers.descendants') }}</p>
    </div>

    <div id="datagrid-parent" class="table-responsive">
        @include('layouts.datagrid._table')
    </div>
</div>
