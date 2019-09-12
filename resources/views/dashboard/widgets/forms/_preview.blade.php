<div class="form-group required">
    {!! Form::select2(
        'entity_id',
        !empty($model) && $model->entity ? $model->entity : null,
        App\Models\Entity::class,
        false,
        'crud.fields.entity',
        'search.entities-with-relations'
    ) !!}
</div>


<div class="form-group">
    <label for="config-full">
        {!! Form::hidden('config[full]', 0) !!}
        {{ __('dashboard.widgets.recent.full') }}
        {!! Form::checkbox('config[full]', 1, (!empty($model) ? $model->conf('full') : null), ['id' => 'config-full']) !!}
    </label>
    <p class="help-block">
        {{ __('dashboard.widgets.recent.helpers.full') }}
    </p>
</div>