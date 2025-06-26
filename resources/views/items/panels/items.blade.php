<?php
$datagridOptions = [
    $campaign,
    $entity->child,
    'init' => 1
];
$datagridOptions = Datagrid::initOptions($datagridOptions);
?>

<div class="item-subitems overflow-x-auto" id="subitems">
    <div id="datagrid-parent" class="table-responsive">
        @include('layouts.datagrid._table', ['datagridUrl' => route('items.items', $datagridOptions)])
    </div>
</div>

