<?php /** @var \App\Datagrids\Datagrid $datagrid */?>

{!! Form::open(['url' => route('bulk.process', $campaign), 'method' => 'POST']) !!}
<div class="modal fade" id="bulk-delete" tabindex="-1" role="dialog" aria-labelledby="clickConfirmLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content bg-base-100 rounded-2xl">
            <div class="modal-body text-center">

                <x-dialog.close :modal="true" />
                <h4 class="modal-title" id="clickModalLabel">{{ __('crud.delete_modal.title') }}</h4>

                <p class="mt-5">
                    {{ __('crud.bulk.delete.warning') }}
                    @if(isset($datagrid) && !$datagrid->hasBulkPermissions())
                        <br />{{ __('crud.delete_modal.permanent') }}
                    @endif
                </p>
                <div class="mt-5 recoverable">
                    @includeWhen(!isset($datagrid) || $datagrid->hasBulkPermissions(), 'layouts.callouts.recoverable')
                    @includeWhen(isset($datagrid) && $datagrid instanceof \App\Datagrids\Actions\RelationDatagrid, 'cruds.datagrids.bulks.modals._mirrored_checkbox')
                </div>


                <x-dialog.footer :modal="true">
                    <button type="submit" class="btn2 btn-error btn-outline" name="datagrid-action" value="delete">
                        <span class="fa-solid fa-trash" aria-hidden="true"></span>
                        <span class="remove-button-label">{{ __('crud.remove') }}</span>
                    </button>
                </x-dialog.footer>

            </div>
        </div>
    </div>
</div>
{!! Form::hidden('entity', $name) !!}
{!! Form::hidden('models', null, ['id' => 'datagrid-bulk-delete-models']) !!}
{!! Form::hidden('mode', $mode) !!}
{!! Form::close() !!}
