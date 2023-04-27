
<input type="hidden" name="author_id" value="" />
    @include('cruds.fields.character', [
    'name' => 'author_id',
    'preset' => !empty($model) && $model->author ? $model->author : null,
    'label' => __('journals.fields.author'),
])
