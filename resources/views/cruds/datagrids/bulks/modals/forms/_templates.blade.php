<x-grid type="1/1">
    <x-forms.field field="template"
                   :required="true"
                   :label="__('entities/attributes.fields.template')"
                   :helper="__('attributes/templates.pitch', [
            'boosted-campaign' => link_to('https://kanka.io/premium', __('concept.premium-campaigns')),
            'marketplace' => link_to(config('marketplace.url') . '/attribute-templates', __('footer.marketplace'), ['target' => '_blank'])
        ])">
        {!! Form::select('template_id', $templates, null, ['placeholder' => trans('entities/attributes.placeholders.template'), 'class' => 'w-full']) !!}
    </x-forms.field>
</x-grid>
