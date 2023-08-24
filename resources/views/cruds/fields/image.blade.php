<?php
/**
 * Options:
 * bool $imageRequired set to true if the image is required and can't be removed
 */
$formats = 'PNG, JPG, GIF, WebP';
$max = 25;
if (isset($size) && $size == 'map') {
    $formats = 'PNG, JPG, SVG, WebP';
    $max = 50;
}
$label = $imageLabel ?? 'crud.fields.image';

$previewThumbnail = null;
$canDelete = true;
if (!empty($model->entity) && !empty($model->entity->image_uuid) && !empty($model->entity->image)) {
    $previewThumbnail = $model->entity->image->getUrl(240,112);
    $canDelete = false;
    /*
    <div class="preview-v2">
        <a class="h-28 cover-background relative inline-block w-full text-white bg-red-900/50 hover:bg-red-900/90" href="{{ route('campaign.gallery.index', [$campaign, 'folder_id' => $model->entity->image->folder_id]) }}" style="background-image: url('{{ $model->entity->image->getUrl(240,112) }}')" title="{{ $model->name }}">
        </a>
    </div>*/
} elseif (!empty($model->image)) {
    $previewThumbnail = $model->thumbnail(120);
}
?>
<div class="field-image">
    <div class="@if (!empty($imageRequired) && $imageRequired) required @endif">
        <label>{{ __($label) }}</label>
        {!! Form::hidden('remove-image') !!}
    </div>

    <div class="flex gap-2">
        <div class="grow flex flex-col gap-2">
            <div class="image-file">
                {!! Form::file('image', array('class' => 'image form-control')) !!}
            </div>
            <div class="image-url">
                {!! Form::text('image_url', ((!empty($source) && $source->image) ? $source->getOriginalImageUrl() : ''), ['placeholder' => __('crud.placeholders.image_url'), 'class' => 'form-control']) !!}
            </div>

            @php
                $preset = null;
                if (isset($model) && $model->entity && $model->entity->image_uuid) {
                    $preset = $model->entity->image;
                } else {
                    $preset = FormCopy::field('image')->entity()->select();
                }
            @endphp
            <x-forms.foreign
                :campaign="$campaign"
                name="entity_image_uuid"
                label=""
                :allowClear="true"
                :route="route('images.find', $campaign)"
                :placeholder="__('fields.gallery.placeholder')"
                :selected="$preset">
            </x-forms.foreign>
            @if (!empty($model->entity) && !empty($model->entity->image_uuid) && empty($model->entity->image))
                <input type="hidden" name="entity_image_uuid" value="{{ $model->entity->image_uuid }}" />
            @endif

            <p class="help-block">
                {{ __('crud.hints.image_limitations', ['formats' => $formats, 'size' => (isset($size) ? Limit::readable()->map()->upload() : Limit::readable()->upload())]) }}
                @include('cruds.fields.helpers.share')
            </p>
        </div>
        @if (!empty($previewThumbnail))
            <div class="preview w-32">
                @include('cruds.fields._image_preview', [
                    'image' => $previewThumbnail,
                    'title' => $model->name,
                    'target' => $canDelete && (empty($imageRequired) || !$imageRequired) ? 'remove-image' : null,
                ])
            </div>
        @elseif (isset($campaignImage) && $campaignImage)
            <div class="preview w-32">
                @include('cruds.fields._image_preview', [
                    'image' => 'https://th.kanka.io/UngNKwPxKUPKSZ4z_Qjc9QiyeQs=/280x210/smart/src/app/backgrounds/mountain-background-medium.jpg',
                    'title' => 'Default',
                ])
            </div>
        @endif
    </div>
</div>
