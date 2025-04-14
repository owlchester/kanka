<x-grid type="1/1">
    <x-helper>
        {!! __('races.members.create.helper', ['name' => $model->name]) !!}
    </x-helper>

    <x-forms.field field="member" :label="__('races.fields.members')">
        <select multiple="multiple" name="members[]" id="members" class="form-members" style="width: 100%" data-url="{{ route('search-list', [$campaign, config('entities.ids.character')]) }}" data-placeholder="{{ __('crud.placeholders.character') }}">
        </select>
    </x-forms.field>
</x-grid>
