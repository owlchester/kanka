<?php
$filters = [];
if (request()->has('map_id')) {
    $filters['map_id'] = request()->get('map_id');
}
?>
<div class="" id="map-maps">
    <div id="datagrid-parent" class="table-responsive">
        @include('layouts.datagrid._table')
    </div>
</div>
