<?php /** @var \App\Models\Family $family */?>
<div class="box box-solid" id="family-families">
    <div class="box-header">
        <h3 class="box-title">
            {{ __('families.show.tabs.families') }}
        </h3>
    </div>
        <div id="datagrid-parent" class="table-responsive">
            @include('layouts.datagrid._table')
        </div>
    </div>
</div>
