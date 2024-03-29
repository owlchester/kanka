@include('maps.form._markers', ['source' => null])
<h3 class="">
    {{ __('maps.panels.markers') }}
</h3>
<div class="" id="map-markers">
    @if(Datagrid::hasBulks()) {!! Form::open(['route' => ['maps.markers.bulk', $campaign, 'map' => $model]]) !!} @endif
    <div id="datagrid-parent">
        @include('layouts.datagrid._table', ['responsive' => true])
    </div>
    @if(Datagrid::hasBulks()) {!! Form::close() !!} @endif
</div>

@section('modals')
    @parent
    @include('layouts.datagrid.delete-forms', ['models' => Datagrid::deleteForms(), 'params' => []])
@endsection
