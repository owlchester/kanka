<x-forms.field field="members" :label="__('families.fields.members')">
    <select multiple="multiple" name="members[]" id="members" class="form-control form-members" style="width: 100%" data-url="{{ route('characters.find', [$campaign, 'with_family' => '1']) }}"></select>
</x-forms.field>
