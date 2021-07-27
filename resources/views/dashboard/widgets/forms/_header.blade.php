<div class="row">
    <div class="col-sm-6">
        @include('dashboard.widgets.forms._name')
    </div>
    <div class="col-sm-6">
        @include('dashboard.widgets.forms._width')
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <div class="form-group">
            {!! Form::select2('entity_id', !empty($model) && $model->entity ? $model->entity : null, App\Models\Entity::class, false, 'dashboard.widgets.fields.optional-entity', 'search.entities-with-relations') !!}
        </div>
    </div>
</div>
