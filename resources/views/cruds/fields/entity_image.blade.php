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

    <div class="row">
        <div class="col-sm-10">
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

            <p class="help-block">
                {{ __('crud.hints.gallery_image') }}
            </p>
        </div>
        <div class="col-sm-2">
            @if (!empty($model->entity) && !empty($model->entity->image_uuid))
                <div class="preview-v2">
                    <a href="{{ route('campaign.gallery.index', ['folder_id' => $model->entity->image->folder_id]) }}" class="image" style="background-image: url('{{ $model->entity->image->getUrl(80, null, 'header_image') }}')" title="{{ $model->name }}">
                    </a>
                </div>
            @endif
        </div>
    </div>
@endif
