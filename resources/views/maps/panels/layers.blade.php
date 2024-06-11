<x-tutorial code="map_layers" doc="https://docs.kanka.io/en/latest/entities/maps/layers.html">
    <p>
        {{ __('maps/layers.helper.amount_v2') }}
    </p>
</x-tutorial>

<h3 class="">
    {{ __('maps.panels.layers') }}
</h3>

<div class="" id="map-layers">
    @if(Datagrid::hasBulks())
        <x-form :action="['maps.layers.bulk', $campaign, 'map' => $model]" direct>
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
@includeWhen($rows->count() > 1, 'maps.layers._reorder')


