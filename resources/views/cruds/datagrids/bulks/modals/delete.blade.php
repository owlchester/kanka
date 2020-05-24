@inject('campaign', 'App\Services\CampaignService')

{!! Form::open(['url' => route('bulk.process'), 'method' => 'POST']) !!}
<div class="modal fade" id="bulk-delete" tabindex="-1" role="dialog" aria-labelledby="clickConfirmLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="{{ __('crud.click_modal.close') }}"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="clickModalLabel">{{ __('crud.bulk.delete.title') }}</h4>
            </div>
            <div class="modal-body">
                {{ __('crud.bulk.delete.warning') }}
            </div>

            <div class="modal-footer">
                <button class="btn btn-danger" type="submit" name="datagrid-action" value="delete">{{ __('crud.click_modal.confirm') }}</button>
            </div>
        </div>
    </div>
</div>
{!! Form::hidden('entity', $name) !!}
{!! Form::hidden('models', null, ['id' => 'datagrid-bulk-delete-models']) !!}
{!! Form::close() !!}
