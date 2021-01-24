
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="{{ __('crud.click_modal.close') }}"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title" id="clickModalLabel">{{ __('crud.bulk_templates.bulk_title') }}</h4>
</div>
<div class="modal-body">
    <div class="form-group required">
        <label>{{ trans('crud.attributes.fields.template') }}</label>
        {!! Form::select('template_id', \App\Models\AttributeTemplate::orderBy('name', 'ASC')->pluck('name', 'id'), null, ['placeholder' => trans('crud.attributes.placeholders.template'), 'class' => 'form-control']) !!}
    </div>

    <div class="form-group">
        <label>{{ trans('crud.attributes.fields.community_templates') }}</label>
        {!! Form::select('template', $communityTemplates, null, ['placeholder' => trans('crud.attributes.placeholders.template'), 'class' => 'form-control']) !!}
    </div>
</div>

<div class="modal-footer">
    <a href="#" class="pull-left" data-dismiss="modal">{{ __('crud.cancel') }}</a>
    <button class="btn btn-primary" type="submit" name="datagrid-action" value="templates">{{ __('crud.click_modal.confirm') }}</button>
</div>
