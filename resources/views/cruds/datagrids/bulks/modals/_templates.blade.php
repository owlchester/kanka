
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="{{ __('crud.click_modal.close') }}"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title" id="clickModalLabel">{{ __('crud.bulk_templates.bulk_title') }}</h4>
</div>
<div class="modal-body">
    <div class="form-group required">
        <label>{{ __('crud.attributes.fields.template') }}</label>
        {!! Form::select('template_id', $templates, null, ['placeholder' => trans('crud.attributes.placeholders.template'), 'class' => 'form-control']) !!}
    </div>


    <p class="help-block">
        {!! __('attributes/templates.helpers.marketplace', [
    'boosted-campaigns' => link_to_route('front.pricing', __('crud.boosted_campaigns'), '#boost'),
    'marketplace' => link_to('https://marketplace.kanka.io/attribute-templates', __('front.menu.marketplace'), ['target' => '_blank'])
    ]) !!}
    </p>
</div>

<div class="modal-footer">
    <a href="#" class="pull-left" data-dismiss="modal">{{ __('crud.cancel') }}</a>
    <button class="btn btn-primary" type="submit" name="datagrid-action" value="templates">{{ __('crud.actions.apply') }}</button>
</div>
