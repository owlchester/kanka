@if (auth()->user()->isAdmin())
    <x-forms.field
        field="private"
        :label="__('crud.fields.is_private')">
        <select name="is_private" id="private_choice" class="form-control">
            <option value=""></option>
            <option value="0">{{ __('general.yes') }}</option>
            <option value="1">{{ __('general.no') }}</option>
        </select>
    </x-forms.field>
@endif
