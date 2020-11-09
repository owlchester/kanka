<div class="form-group required">
    {!! Form::select2(
        'entity_id',
        !empty($model) && $model->entity ? $model->entity : null,
        App\Models\Entity::class,
        false,
        'crud.fields.calendar',
        'search.calendars'
    ) !!}
</div>

<div class="form-group">
    <label>{{ __('dashboard.widgets.fields.name') }}</label>
    {!! Form::text('config[text]', null, ['class' => 'form-control', 'placeholder' => __('dashboard.widgets.recent.title')]) !!}
</div>
