@php
    $routeOptions = [
        $campaign,
        'entity' => $entity,
        'init' => 1
    ];
    $routeOptions = Datagrid::initOptions($routeOptions);
    $datagridOptions =
        ['datagridUrl' => route('entities.reminders.index', $routeOptions)]
    ;
@endphp
<div id="datagrid-parent" class="table-responsive">
    @include('layouts.datagrid._table', $datagridOptions)
</div>
