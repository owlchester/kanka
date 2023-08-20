@if (auth()->user()->isAdmin())
    <div class="field-private">
        <label for="private_choice">{{ __('crud.fields.is_private') }}</label>
        <select name="is_private" id="private_choice" class="form-control">
            <option value=""></option>
            <option value="0">{{ __('general.yes') }}</option>
            <option value="1">{{ __('general.no') }}</option>
        </select>
    </div>
@endif
