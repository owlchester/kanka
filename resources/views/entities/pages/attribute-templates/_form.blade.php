<x-grid type="1/1">
    <x-forms.field
        field="template"
        :label="__('entities/attributes.fields.template')"
        :required="true"
    :helper="__('attributes/templates.pitch', [
    'boosted-campaign' => link_to('https://kanka.io/premium', __('concept.premium-campaigns')),
    'marketplace' => link_to(config('marketplace.url') . '/attribute-templates', __('footer.marketplace'), ['target' => '_blank'])
    ])">
        <x-forms.select name="template_id" :options="$templates" :placeholder="__('entities/attributes.placeholders.template')" class="w-full" required />
    </x-forms.field>
</x-grid>
