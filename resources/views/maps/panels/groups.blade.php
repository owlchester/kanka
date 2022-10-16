<?php
$filters = [];
if (request()->has('map_id')) {
    $filters['map_id'] = request()->get('map_id');
}
?>
<div class="box box-solid" id="map-groups">
    @if(Datagrid::hasBulks()) {!! Form::open(['route' => ['maps.groups.bulk', 'map' => $model]]) !!} @endif
    <div class="box-header with-border">
        <h3 class="box-title">
            {{ __('maps.panels.groups') }}
        </h3>
    </div>
    <div id="datagrid-parent" class="table-responsive">
        @include('layouts.datagrid._table')
    </div>
    @if(Datagrid::hasBulks()) {!! Form::close() !!} @endif

</div>

@section('modals')
    @parent
    @include('layouts.datagrid.delete-forms', ['models' => Datagrid::deleteForms(), 'params' => []])
@endsection
