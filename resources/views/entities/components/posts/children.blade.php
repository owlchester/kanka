<?php

$route = 'entities.children';

$routeOptions = [
    $campaign,
    $entity,
    'init' => 1,
];

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
