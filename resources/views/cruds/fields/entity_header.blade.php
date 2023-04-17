@if ($campaignService->campaign()->superboosted())
    @php
    $preset = null;
    if (isset($model) && $model->entity && $model->entity->header_uuid) {
        $preset = $model->entity->header;
    } else {
        $preset = FormCopy::field('header')->entity()->select();
    }
    @endphp

    <div class="row">
        <p class="help-block">
            {{ __('fields.gallery-header.description') }}
        </p>
        <div class="col-sm-10">
            <div class="form-group">
                {!! Form::select2(
                    'entity_header_uuid',
                    $preset,
                    App\Models\Image::class,
                    false,
                    false,
                    'images.find',
                    'fields.gallery.placeholder',
                ) !!}
            </div>

        </div>
        <div class="col-sm-2">
            @if (!empty($model->entity) && !empty($model->entity->header_uuid) && !empty($model->entity->header))
                @include('cruds.fields._image_preview', [
                    'image' => $model->entity->header->getUrl(80, null, 'header_image'),
                    'title' => $model->name,
                ])
            @endif
        </div>
    </div>
    @if (!empty($model->entity) && !empty($model->entity->image_uuid) && empty($model->entity->image))
        <input type="hidden" name="entity_image_uuid" value="{{ $model->entity->image_uuid }}" />
    @endif
@else
    @include('cruds.fields.helpers.superboosted', ['key' => 'fields.gallery-header.boosted-description'])
@endif
