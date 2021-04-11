<div class="form-group required">
    <label for="config-entity">
        {{ __('crud.fields.entity') }}
    </label>
    {!! Form::select('config[entity]', $entities, (!empty($model) ? $model->conf('entity') : null), ['class' => 'form-control']) !!}
</div>


<div class="row">
    <div class="col-sm-6">
        @include('dashboard.widgets.forms._name', ['random' => true])
    </div>
    <div class="col-sm-6">
        @include('dashboard.widgets.forms._width')
    </div>
</div>


@includeWhen(!empty($dashboards), 'dashboard.widgets.forms._dashboard')

<div class="form-group">
    {!! Form::tags(
            'tag_id',
            [
                'model' => isset($model) ? $model : null,
                'enableNew' => false
            ]
        ) !!}
    <input type="hidden" name="save_tags" value="1" />
</div>
