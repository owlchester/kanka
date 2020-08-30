<div class="form-group required">
    <label for="config-entity">
        {{ __('crud.fields.entity') }}
    </label>
    {!! Form::select('config[entity]', $entities, (!empty($model) ? $model->conf('entity') : null), ['class' => 'form-control']) !!}
</div>

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

<div class="form-group">
    <label for="config-singular">
        {!! Form::hidden('config[singular]', 0) !!}
        {{ __('dashboard.widgets.recent.singular') }}
        {!! Form::checkbox('config[singular]', 1, (!empty($model) ? $model->conf('singular') : null), ['id' => 'config-singular']) !!}
    </label>
    <p class="help-block">
        {{ __('dashboard.widgets.recent.help') }}
    </p>
</div>
