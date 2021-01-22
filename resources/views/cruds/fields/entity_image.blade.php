@if ($campaign->campaign()->boosted(true))
    @php
    $preset = null;
    if (isset($model) && $model->entity && $model->entity->image_uuid) {
        $preset = $model->entity->image;
    } elseif (isset($parent) && $parent) {
        $preset = FormCopy::field('entity_image_uuid')->select(true, \App\Models\Image::class);
    } else {
        $preset = FormCopy::field('entity_image_uuid')->select();
    }
    @endphp
    <div class="form-group">
        {!! Form::select2(
            'entity_image_uuid',
            $preset,
            App\Models\Image::class,
            false,
            'crud.fields.gallery_image',
            'images.find',
            'crud.placeholders.gallery_image'
        ) !!}
    </div>
@endif
