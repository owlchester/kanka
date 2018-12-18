<div class="form-group required">
    <label for="config-entity">
        {{ __('crud.fields.entity') }}
    </label>
    {!! Form::select('config[entity]', $entities, (!empty($model) ? $model->conf('entity') : null), ['class' => 'form-control']) !!}
</div>