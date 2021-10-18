@if (auth()->user()->isAdmin())
    <div class="form-group">
        <label for="is_private">{{ __('crud.fields.is_private') }}</label>
        <select name="is_private" id="is_private" class="form-control">
            <option value=""></option>
            <option value="0">{{ __('voyager.generic.yes') }}</option>
            <option value="1">{{ __('voyager.generic.no') }}</option>
        </select>
    </div>
@endif
