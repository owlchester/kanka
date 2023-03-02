<div class="row">
    <div class="col-sm-6">
        <div class="form-group required">
            {!! Form::select2(
                'entity_id',
                !empty($model) && $model->entity ? $model->entity : null,
                App\Models\Entity::class,
                false,
                'crud.fields.entity',
                'search.entities-with-relations',
                null,
                null,
                request()->ajax() ? '#entity-modal' : null,
            ) !!}
        </div>
    </div>
</div>
<div class="form-group">
    <label>{{ __('crud.fields.entry') }}</label>
    {!! Form::textarea('entry', FormCopy::field('entry')->string(), ['class' => 'form-control  resize-y', 'rows' => 5]) !!}
</div>
@include('cruds.fields.visibility_id')
<div class="form-group">
    <label>
        {{ __('entities/notes.fields.position') }}
    </label>
    {!! Form::select('position', [0 => __('posts.position.last'), 1 => __('posts.position.first')], null, ['class' => 'form-control']) !!}
</div>
