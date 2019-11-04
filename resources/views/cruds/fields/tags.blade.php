@if ($campaign->enabled('tags'))
    <div class="form-group">
        {!! Form::tags(
            'tag_id',
            [
                'model' => isset($model) ? $model : FormCopy::model(),
                'enableNew' => isset($enableNew) ? $enableNew : true
            ]
        ) !!}
    </div>

    @if (isset($bulk) && $bulk)
        <div class="form-group">
            <label for="bulk-tagging">{{ __('crud.bulk.edit.tagging') }}</label>
            <select name="bulk-tagging" class="form-control">
                <option value="add">{{ __('crud.bulk.edit.tags.add') }}</option>
                <option value="remove">{{ __('crud.bulk.edit.tags.remove') }}</option>
            </select>
        </div>
    @endif
@endif