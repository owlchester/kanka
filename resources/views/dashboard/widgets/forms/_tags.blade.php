<div class="form-group">
    {!! Form::tags(
            'tag_id',
            [
                'model' => isset($model) ? $model : null,
                'enableNew' => false,
                'helper' => __('dashboard.widgets.recent.tags')
            ]
        ) !!}
    <p class="help-block visible-xs visible-sm">
        {{ __('dashboard.widgets.recent.tags') }}
    </p>
    <input type="hidden" name="save_tags" value="1" />
</div>
