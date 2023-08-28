<x-forms.field field="member" :label="__('races.fields.members')">
    <select multiple="multiple" name="members[]" id="members" class="form-control form-members" style="width: 100%" data-url="{{ route('characters.find', $campaign) }}">

    </select>
</x-forms.field>
