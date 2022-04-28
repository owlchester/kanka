<?php
$filters = [];
if (request()->has('map_id')) {
    $filters['map_id'] = request()->get('map_id');
}
?>
<div class="box box-solid" id="map-maps">
    <div class="box-header with-border">
        <h3 class="box-title">
            {{ __('maps.show.tabs.maps') }}
        </h3>
        <div class="box-tools">
            @if (request()->has('map_id'))
                <a href="{{ route('maps.maps', [$model, '#map-maps']) }}" class="btn btn-default btn-box-tool">
                    <i class="fa fa-filter"></i> {{ __('crud.filters.all') }} ({{ $model->descendants->count() }})
                </a>
            @else
                <a href="{{ route('maps.maps', [$model, 'map_id' => $model->id, '#map-maps']) }}" class="btn btn-default btn-box-tool">
                    <i class="fa fa-filter"></i> {{ __('crud.filters.direct') }} ({{ $model->maps->count() }})
                </a>
            @endif
        </div>
    </div>


    <div id="datagrid-parent" class="table-responsive">
        @include('layouts.datagrid._table')
    </div>
</div>
