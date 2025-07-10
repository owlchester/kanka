<?php

$route = 'entities.children';

$routeOptions = [
    $campaign,
    $entity,
    'init' => 1,
];

if ($entity->hasChild()) {
    // Get table name from the model
    $table = $entity->child->getTable();

    $routeOptions = [
        $campaign,
        $entity->child,
        'init' => 1,
    ];

    // Make the route name.
    $route = $table . '.' . $table;
}

$datagridOptions = [];

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
