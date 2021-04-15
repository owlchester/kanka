<div class="form-group">
    {!! Form::tags(
            'tag_id',
            [
                'model' => isset($model) ? $model : null,
                'enableNew' => false
            ]
        ) !!}
    <p class="help-block">{{ __('dashboard.widgets.recent.tags') }}</p>
    <input type="hidden" name="save_tags" value="1" />
</div>
