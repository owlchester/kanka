@if (isset($model) && $model->entity && !empty($model->entity->image_path))
    @include('cruds.fields.image-old')
@else
    @include('cruds.fields.image-gallery')
@endif
