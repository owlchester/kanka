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
<div id="abilities-abilities">
    <div id="datagrid-parent" class="table-responsive">
        @include('layouts.datagrid._table', $datagridOptions)
    </div>
</div>
