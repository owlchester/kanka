<div class="form-group">
<input type="hidden" name="author_id" value="" />
{!! Form::select2(
    'author_id',
    (!empty($model) && $model->author ? $model->author : null),
    App\Models\Entity::class,
    false,
    'journals.fields.author',
    'search.entities-with-relations',
    'crud.placeholders.entity'
) !!}
</div>
