<x-tutorial code="map_groups" doc="https://docs.kanka.io/en/latest/entries/maps/groups.html">
    <p>
        {{ __('maps/groups.helper.amount_v3') }}
    </p>
</x-tutorial>

<h3 class="text-xl">
    {{ __('maps.panels.groups') }}
</h3>

<div id="map-groups" class="">
    @if(Datagrid::hasBulks())
        <x-form :action="['maps.groups.bulk', $campaign, 'map' => $model]" direct>
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

@includeWhen($groups->count() > 1, 'maps.groups._reorder')

