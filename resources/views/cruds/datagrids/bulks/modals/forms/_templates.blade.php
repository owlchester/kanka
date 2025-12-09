<x-grid type="1/1">
    <x-forms.field
        field="template"
        required
        :label="__('entities/attributes.fields.template')"
        :helper="__('attributes/templates.pitch', [
            'boosted-campaign' => '<a href=\'https://kanka.io/premium\' class=\'text-link\'>' . __('concept.premium-campaigns') . '</a>',
            'marketplace' => '<a href=\'' . config('marketplace.url') . '/character-sheets\' class=\'text-link\'>' . __('footer.plugins') . '</a>'
        ])">
        <x-forms.select name="template_id" :options="$templates" class="w-full" :placeholder="__('entities/attributes.placeholders.template')" required />
    </x-forms.field>
</x-grid>
