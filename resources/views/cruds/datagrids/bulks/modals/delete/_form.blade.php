<x-grid type="1/1">
    <p class="m-0">
        {{ __('crud.bulk.delete.warning') }}
    </p>
    @if(isset($datagrid) && !$datagrid->hasBulkPermissions())
        <p class="m-0 permanent">
        {{ __('crud.delete_modal.permanent') }}
        </p>
    @endif
    <div class="recoverable">
        @includeWhen(!isset($datagrid) || $datagrid->hasBulkPermissions(), 'layouts.callouts.recoverable')
        @includeWhen(isset($datagrid) && $datagrid instanceof \App\Datagrids\Actions\RelationDatagridActions, 'cruds.datagrids.bulks.modals.delete._mirrored')
    </div>
</x-grid>
