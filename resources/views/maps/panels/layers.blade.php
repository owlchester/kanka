<x-tutorial code="map_layers" doc="https://docs.kanka.io/en/latest/entities/maps/layers.html">
    <p>
        {{ __('maps/layers.helper.amount_v2') }}
    </p>
</x-tutorial>

<div class="box box-solid" id="map-layers">
    @if(Datagrid::hasBulks()) {!! Form::open(['route' => ['maps.layers.bulk', 'map' => $model]]) !!} @endif
    <div class="box-header with-border">
        <h3 class="box-title">
            {{ __('maps.panels.layers') }}
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
