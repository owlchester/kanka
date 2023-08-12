<x-tutorial code="map_layers" doc="https://docs.kanka.io/en/latest/entities/maps/layers.html">
    <p>
        {{ __('maps/layers.helper.amount_v2') }}
    </p>
</x-tutorial>

<h3 class="">
    {{ __('maps.panels.layers') }}
</h3>
<div class="mb-5" id="map-layers">
    @if(Datagrid::hasBulks()) {!! Form::open(['route' => ['maps.layers.bulk', $campaign, 'map' => $model]]) !!} @endif

    <div id="datagrid-parent">
        @include('layouts.datagrid._table', ['responsive' => true])
    </div>
    @if(Datagrid::hasBulks()) {!! Form::close() !!} @endif

</div>

@section('modals')
    @parent
    @include('layouts.datagrid.delete-forms', ['models' => Datagrid::deleteForms(), 'params' => []])
@endsection
