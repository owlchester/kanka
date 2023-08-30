<?php /** @var \App\Datagrids\Datagrid $datagrid */?>

{!! Form::open(['url' => route('bulk.process', $campaign), 'method' => 'POST']) !!}
<x-dialog id="bulk-delete" :title="__('crud.delete_modal.title')" footer="cruds.datagrids.bulks.modals._delete-footer">
    <article>
        <p class="m-0">
            {{ __('crud.bulk.delete.warning') }}
            @if(isset($datagrid) && !$datagrid->hasBulkPermissions())
                <br />{{ __('crud.delete_modal.permanent') }}
            @endif
        </p>
        <div class="recoverable">
            @includeWhen(!isset($datagrid) || $datagrid->hasBulkPermissions(), 'layouts.callouts.recoverable')
            @includeWhen(isset($datagrid) && $datagrid instanceof \App\Datagrids\Actions\RelationDatagrid, 'cruds.datagrids.bulks.modals._mirrored_checkbox')
        </div>
    </article>
</x-dialog>
{!! Form::hidden('entity', $name) !!}
{!! Form::hidden('models', null, ['id' => 'datagrid-bulk-delete-models']) !!}
{!! Form::hidden('mode', $mode) !!}
{!! Form::close() !!}
