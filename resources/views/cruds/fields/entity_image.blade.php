<label>
    <i class="fas fa-rocket" title="{{ __('crud.tooltips.boosted_feature') }}" data-toggle="tooltip"></i>
    {{ __('fields.gallery-image.title') }}
</label>
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

            <p class="help-block">
                {{ __('fields.gallery-image.description') }}
            </p>

            <div class="form-group">
                {!! Form::select2(
                    'entity_image_uuid',
                    $preset,
                    App\Models\Image::class,
                    false,
                    false,
                    'images.find',
                    'fields.gallery.placeholder'
                ) !!}
            </div>

        </div>
        <div class="col-sm-2">
            @if (!empty($model->entity) && !empty($model->entity->image_uuid) && !empty($model->entity->image))
                <div class="preview-v2">
                    <a href="{{ route('campaign.gallery.index', ['folder_id' => $model->entity->image->folder_id]) }}" class="image" style="background-image: url('{{ $model->entity->image->getUrl(80, null, 'header_image') }}')" title="{{ $model->name }}">
                    </a>
                </div>
            @endif
        </div>
    </div>
    @if (!empty($model->entity) && !empty($model->entity->image_uuid) && empty($model->entity->image))
        <input type="hidden" name="entity_image_uuid" value="{{ $model->entity->image_uuid }}" />
    @endif
@else
    @include('cruds.fields.helpers.superboosted', ['key' => 'fields.gallery-image.boosted-description'])
@endif
