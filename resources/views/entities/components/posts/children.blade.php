<?php

$route = 'entities.children';
if ($entity->hasChild()) {
    // Get table name from the model
    $table = $entity->child->getTable();

    // Make the route name.
    $route = $table . '.' . $table;
}

$datagridOptions = [];

$routeOptions = [
    $campaign,
    $entity->child,
    'init' => 1,
];
if (request()->get('m') == \App\Enums\Descendants::All->value || (!request()->has('m') && $campaign->defaultDescendantsMode() === \App\Enums\Descendants::All)) {
    $routeOptions['m'] = \App\Enums\Descendants::All;
}
$routeOptions = Datagrid::initOptions($routeOptions);
$datagridOptions =
    ['datagridUrl' => route($route, $routeOptions)]
;

?>

<div class="overflow-x-auto" id="entity-children">
    <div id="datagrid-parent" class="table-responsive">
        @include('layouts.datagrid._table', $datagridOptions)
    </div>
</div>
