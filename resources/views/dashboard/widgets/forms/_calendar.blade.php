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

<div class="row">
    <div class="col-sm-6">
        @include('dashboard.widgets.forms._name')
    </div>
    <div class="col-sm-6">
        @include('dashboard.widgets.forms._width')
    </div>
</div>
