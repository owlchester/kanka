<?php
// Only get the data by AJAX if this is included with a 'onload' param
$datagridOptions = [];
    if (!empty($onload)) {
    $routeOptions = [
        $model,
        'init' => 1,
    ];
    $routeOptions = Datagrid::initOptions($routeOptions);
    $datagridOptions =
        ['datagridUrl' => route('abilities.abilities', $routeOptions)]
    ;
}
?>
<div class="box box-solid" id="abilities-abilities">
    <div class="box-header">
        <h3 class="box-title">
            {{ __('abilities.fields.abilities') }}
        </h3>
    </div>

    <div id="datagrid-parent" class="table-responsive">
        @include('layouts.datagrid._table', $datagridOptions)
    </div>
</div>
