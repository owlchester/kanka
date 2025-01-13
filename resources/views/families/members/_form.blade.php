<x-grid type="1/1">
<x-forms.field field="members" :label="__('families.fields.members')">
    <select multiple="multiple" name="members[]" id="members" class=" form-members" style="width: 100%" data-url="{{ route('search-list', [$campaign, config('entities.ids.character'), 'with-family' => '1']) }}"></select>
</x-forms.field>
</x-grid>
