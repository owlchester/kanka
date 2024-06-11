@include('maps.form._markers', ['source' => null])
<h3 class="">
    {{ __('maps.panels.markers') }}
</h3>
<div class="" id="map-markers">
    @if(Datagrid::hasBulks())
        <x-form :action="['maps.markers.bulk', $campaign, 'map' => $model]" direct>
            <div id="datagrid-parent">
                @include('layouts.datagrid._table', ['responsive' => true])
            </div>
        </x-form>
    @else
        <div id="datagrid-parent">
            @include('layouts.datagrid._table', ['responsive' => true])
        </div>
    @endif
</div>

@section('modals')
    @parent
    @include('layouts.datagrid.delete-forms', ['models' => Datagrid::deleteForms(), 'params' => []])
@endsection
