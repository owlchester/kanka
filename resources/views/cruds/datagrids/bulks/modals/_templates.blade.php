
<div class="modal-header">
    <x-dialog.close :modal="true" />
    <h4 class="modal-title" id="clickModalLabel">{{ __('crud.bulk_templates.bulk_title') }}</h4>
</div>
<div class="modal-body">
    <x-forms.field field="template"
       :required="true"
       :label="__('entities/attributes.fields.template')"
        :helper="__('attributes/templates.pitch', [
            'boosted-campaign' => link_to('https://kanka.io/premium', __('concept.premium-campaigns')),
            'marketplace' => link_to(config('marketplace.url') . '/attribute-templates', __('footer.marketplace'), ['target' => '_blank'])
        ])">
        {!! Form::select('template_id', $templates, null, ['placeholder' => trans('entities/attributes.placeholders.template'), 'class' => 'form-control']) !!}
    </x-forms.field>


    <x-dialog.footer :modal="true">
        <button class="btn2 btn-primary" type="submit">
            <x-icon class="fa-solid fa-th-list"></x-icon>
            {{ __('crud.actions.apply') }}
        </button>
    </x-dialog.footer>
</div>

<input type="hidden" name="datagrid-action" value="templates" />
