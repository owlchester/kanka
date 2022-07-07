<div class="row">
    <div class="col-sm-6">
        <div class="form-group required">
            {!! Form::select2('entity_id', !empty($model) && $model->entity ? $model->entity : null, App\Models\Entity::class, false, 'dashboard.widgets.fields.optional-entity', 'search.entities-with-relations') !!}
        </div>
    </div>
</div>
<div class="form-group">
    <label>{{ __('crud.fields.entry') }}</label>
    {!! Form::textarea('entry', FormCopy::field('entry')->string(), ['class' => 'form-control', 'rows' => 5]) !!}
</div>
@include('cruds.fields.visibility_id')
<div class="form-group">
    <label>
        {{ __('posts.fields.position') }}
    </label>
    {!! Form::select('position', [0 => __('posts.position.last'), 1 => __('posts.position.first')], null, ['class' => 'form-control']) !!}
</div>
