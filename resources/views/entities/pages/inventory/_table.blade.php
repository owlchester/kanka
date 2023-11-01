<x-box :padding="false" css="box-entity-inventory">
    @includeWhen($inventory->count() > 0, 'entities.pages.inventory._inventory')
</x-box>

@section('modals')
    @parent
    <x-dialog id="inventory-dialog" :loading="true" />
@endsection
