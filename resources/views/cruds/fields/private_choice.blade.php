@can('admin', $campaign)
    <x-forms.field
        field="private"
        :label="__('crud.fields.is_private')">
        <select name="is_private" id="private_choice" class="w-full">
            <option value=""></option>
            <option value="0">{{ __('general.yes') }}</option>
            <option value="1">{{ __('general.no') }}</option>
        </select>
    </x-forms.field>
@endif
