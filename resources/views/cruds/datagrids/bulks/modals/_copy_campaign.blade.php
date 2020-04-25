
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="{{ __('crud.click_modal.close') }}"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title" id="clickModalLabel">{{ __('crud.copy_to_campaign.bulk_title') }}</h4>
</div>
<div class="modal-body">
    <div class="form-group">
        <label>{{ __('crud.move.fields.campaign') }}</label>
        {!! Form::select('campaign', Auth::user()->moveCampaignList(false), null, ['class' => 'form-control']) !!}
    </div>
</div>

<div class="modal-footer">
    <a href="#" class="pull-left" data-dismiss="modal">{{ __('crud.cancel') }}</a>
    <button class="btn btn-primary" type="submit" name="datagrid-action" value="copy-campaign">{{ __('crud.click_modal.confirm') }}</button>
</div>
