<?php
$datagridOptions = [
    $model,
    'init' => 1
];
$datagridOptions = Datagrid::initOptions($datagridOptions);
?>

<div class="box box-solid" id="abilities-abilities">
    <div class="box-header">
        <h3 class="box-title">
            {{ __('abilities.fields.abilities') }}
        </h3>
    </div>

    <div id="datagrid-parent" class="table-responsive">
        @include('layouts.datagrid._table', ['datagridUrl' => route('abilities.abilities', $datagridOptions)])
    </div>
</div>
