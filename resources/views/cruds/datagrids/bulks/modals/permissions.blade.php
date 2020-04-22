@inject('campaign', 'App\Services\CampaignService')

{!! Form::open(['url' => route('bulk.process'), 'method' => 'POST']) !!}
<div class="modal fade" id="bulk-permissions" tabindex="-1" role="dialog" aria-labelledby="clickConfirmLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
        </div>
    </div>
</div>
{!! Form::hidden('entity', $name) !!}
{!! Form::hidden('models', null, ['id' => 'datagrid-bulk-permission-models']) !!}
{!! Form::close() !!}
