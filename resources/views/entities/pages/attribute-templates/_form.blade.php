<x-grid type="1/1">
    <x-forms.field
        field="template"
        :label="__('entities/attributes.fields.template')"
        :required="true"
    :helper="__('attributes/templates.pitch', [
    'boosted-campaign' => link_to('https://kanka.io/premium', __('concept.premium-campaigns')),
    'marketplace' => link_to(config('marketplace.url') . '/attribute-templates', __('footer.marketplace'), ['target' => '_blank'])
    ])">
        {!! Form::select('template_id', $templates, null, ['placeholder' => __('entities/attributes.placeholders.template'), 'class' => 'form-control', 'required']) !!}
    </x-forms.field>
</x-grid>
