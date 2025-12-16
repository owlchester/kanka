<x-grid type="1/1">
    <x-forms.field
        field="template"
        :label="__('entities/attributes.fields.template')"
        required>
        <x-forms.select name="template_id" :options="$templates" :placeholder="__('entities/attributes.placeholders.template')" class="w-full" required />
        <x-slot name="helper">
            {!! __('attributes/templates.pitch', [
    'boosted-campaign' => '<a href=\'https://kanka.io/premium\' class="text-link">' . __('concept.premium-campaigns') . '</a>',
    'marketplace' => '<a href=\'' . config('marketplace.url') . '/character-sheets\' class="text-link">' . __('footer.plugins') . '</a>'
    ]) !!}
        </x-slot>
    </x-forms.field>
</x-grid>
