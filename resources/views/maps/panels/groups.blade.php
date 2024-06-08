<x-tutorial code="map_groups" doc="https://docs.kanka.io/en/latest/entities/maps/groups.html">
    <p>
        {{ __('maps/groups.helper.amount_v3') }}
    </p>
</x-tutorial>

<h3 class="">
    {{ __('maps.panels.groups') }}
</h3>

<div id="map-groups" class="">
    @if(Datagrid::hasBulks())
        <x-form :action="['maps.groups.bulk', $campaign, 'map' => $model]">
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

@includeWhen($rows->count() > 1, 'maps.groups._reorder')

