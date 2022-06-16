<?php /** @var \App\Datagrids\Datagrid $datagrid */?>
@inject('campaign', 'App\Services\CampaignService')

{!! Form::open(['url' => route('bulk.process'), 'method' => 'POST']) !!}
<div class="modal fade" id="bulk-delete" tabindex="-1" role="dialog" aria-labelledby="clickConfirmLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content rounded-2xl">
            <div class="modal-body text-center">

                <button type="button" class="close" data-dismiss="modal" aria-label="{{ __('crud.click_modal.close') }}"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="clickModalLabel">{{ __('crud.delete_modal.title') }}</h4>

                <p class="mt-5">
                    {{ __('crud.bulk.delete.warning') }}
                    @if(isset($datagrid) && !$datagrid->hasBulkPermissions())
                        <br />{{ __('crud.delete_modal.permanent') }}
                    @endif
                </p>
                <div class="mt-5 recoverable">
                    @includeWhen(!isset($datagrid) || $datagrid->hasBulkPermissions(), 'layouts.callouts.recoverable')
                    @includeWhen(isset($datagrid) && $datagrid instanceof \App\Datagrids\RelationDatagrid, 'cruds.datagrids.bulks.modals.mirrored_checkbox')
                </div>


                <div class="py-5">
                    <button type="button" class="btn px-8 rounded-full mr-5" data-dismiss="modal">{{ __('crud.cancel') }}</button>
                    <button type="submit" class="btn btn-danger px-8 ml-5 rounded-full" name="datagrid-action" value="delete">
                        <span class="fa-solid fa-trash"></span>
                        <span class="remove-button-label">{{ __('crud.remove') }}</span>
                    </button>
                </div>

            </div>
        </div>
    </div>
</div>
{!! Form::hidden('entity', $name) !!}
{!! Form::hidden('models', null, ['id' => 'datagrid-bulk-delete-models']) !!}
{!! Form::close() !!}
