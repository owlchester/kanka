@if (Auth::user()->isAdmin())
    <div class="form-group">
        <label for="is_private">{{ trans('crud.fields.is_private') }}</label>
        <select name="is_private" class="form-control">
            <option value=""></option>
            <option value="0">{{ trans('voyager.generic.yes') }}</option>
            <option value="1">{{ trans('voyager.generic.no') }}</option>
        </select>
    </div>
@endif