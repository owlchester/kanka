<x-tutorial code="map_groups" doc="https://docs.kanka.io/en/latest/entities/maps/groups.html">
    <p>
        {{ __('maps/groups.helper.amount_v3') }}
    </p>
</x-tutorial>

<div class="box box-solid" id="map-groups">
    @if(Datagrid::hasBulks()) {!! Form::open(['route' => ['maps.groups.bulk', 'map' => $model]]) !!} @endif
    <div class="box-header with-border">
        <h3 class="box-title">
            {{ __('maps.panels.groups') }}
        </h3>
    </div>
    <div id="datagrid-parent">
        @include('layouts.datagrid._table', ['responsive' => true])
    </div>
    @if(Datagrid::hasBulks()) {!! Form::close() !!} @endif

</div>

@section('modals')
    @parent
    @include('layouts.datagrid.delete-forms', ['models' => Datagrid::deleteForms(), 'params' => []])
@endsection
