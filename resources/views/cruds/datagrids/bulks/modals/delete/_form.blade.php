<x-grid type="1/1">
    <p class="text-neutral-content">
        {{ __('confirm.delete.bulk') }}
    </p>
    @if(isset($datagrid) && !$datagrid->hasBulkPermissions())
        <p class="text-neutral-content permanent">
        {{ __('crud.delete_modal.permanent') }}
        </p>
    @endif
    <div class="recoverable">
        @includeWhen(!isset($datagrid) || $datagrid->hasBulkPermissions(), 'layouts.callouts.recoverable')
        @includeWhen(isset($datagrid) && $datagrid instanceof \App\Datagrids\Actions\RelationDatagridActions, 'cruds.datagrids.bulks.modals.delete._mirrored')
    </div>
</x-grid>
