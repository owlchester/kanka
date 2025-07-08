@isset($init)
    @php
        $routeOptions = [
            $campaign,
            'location' => $entity->child,
            'init' => 1
        ];
        $routeOptions = Datagrid::initOptions($routeOptions);
        $datagridOptions =
            ['datagridUrl' => route('locations.events', $routeOptions)]
        ;
    @endphp
@endif
<div id="location-events" class="overflow-x-auto">
    <div id="datagrid-parent" class="table-responsive">
        @include('layouts.datagrid._table', $datagridOptions ?? null)
    </div>
</div>
