@if ($campaign->enabled('tags'))
    @if (isset($bulk) && $bulk)
        <div class="row">
            <div class="col-md-8">
    @endif
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
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="bulk-tagging">{{ __('crud.bulk.edit.tagging') }}</label>
                    <select name="bulk-tagging" class="form-control">
                        <option value="add">{{ __('crud.bulk.edit.tags.add') }}</option>
                        <option value="remove">{{ __('crud.bulk.edit.tags.remove') }}</option>
                    </select>
                </div>
            </div>
        </div>
    @endif
@endif
