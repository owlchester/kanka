<x-tutorial code="map_layers" doc="https://docs.kanka.io/en/latest/entries/maps/layers.html">
    <p>
        {{ __('maps/layers.helper.amount_v2') }}
    </p>
</x-tutorial>

<h3 class="text-xl">
    {{ __('maps.panels.layers') }}
</h3>

<div class="" id="map-layers">
    @if(Datagrid::hasBulks())
        <x-form :action="['maps.layers.bulk', $campaign, 'map' => $model]" direct>
            <div id="datagrid-parent" class="table-responsive">
                @include('layouts.datagrid._table')
            </div>
        </x-form>
    @else
        <div id="datagrid-parent" class="table-responsive">
            @include('layouts.datagrid._table')
        </div>
    @endif

</div>
@includeWhen($layers->count() > 1, 'maps.layers._reorder')


