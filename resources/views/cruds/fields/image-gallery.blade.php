<?php
if (!isset($entity) && isset($model) && !empty($model->entity)) {
    $entity = $model->entity;
}
/**
 * Options:
 * bool $imageRequired set to true if the image is required and can't be removed
 */
$formats = 'PNG, JPG, GIF, WebP';
$inputFileTypes = '.jpg, .jpeg, .png, .gif, .webp';
$max = 25;
$from = null;
if (isset($size) && $size == 'map') {
    $formats = 'PNG, JPG, SVG, WebP';
    $inputFileTypes = '.jpg, .jpeg, .png, .gif, .webp, .svg';
    $max = 50;
    $from = 'map';
}
$label = $imageLabel ?? 'crud.fields.image';

$previewThumbnail = null;
if (!empty($entity) && $entity->hasImage()) {
    $previewThumbnail = Avatar::entity($entity)->size(192, 144)->thumbnail();
} elseif (isset($model) && method_exists($model, 'thumbnail') && !empty($model->image)) {
    $previewThumbnail = $model->thumbnail(192, 144);
} elseif (isset($source) && !empty($source->entity->image_uuid) && !empty($source->entity->image)) {
    $previewThumbnail = $source->entity->image->getUrl(192, 144);
}

// If the image is from the gallery and the user can't browse or upload, disable the field
$canBrowse = isset($campaign) && auth()->user()->can('browse', [\App\Models\Image::class, $campaign]);
if (!empty($entity) && !empty($entity->image) && !$canBrowse) {
    ?><input type="hidden" name="entity_image_uuid" value="{{ $model->entity->image_uuid }}" /><?php
    return;
}

$old = isset($entity) && !empty($entity->image_path)
?>

@php
    $uuid = null;
    if (isset($entity) && $entity->image_uuid) {
        $uuid = $entity->image_uuid;
    }
@endphp

<div class="field field-image">
    <label>{{ __($label) }}</label>
    <div class="gallery-selection col-span-2">
        <gallery-selection
            file="{{ route('gallery.upload.file', [$campaign, $from]) }}"
            url="{{ route('gallery.upload.url', [$campaign]) }}"
            accepts="{{ $inputFileTypes }}"
            uuid="{{ $entity->image_uuid ?? $source->entity->image_uuid ?? null }}"
            field="entity_image_uuid"
            thumbnail="{{ $previewThumbnail }}"
            browse="{{ route('gallery.browse', [$campaign]) }}"
            old="{{ $old ? 'true' : 'false' }}"
        >
            <x-icon class="load" />
        </gallery-selection>
    </div>

    <x-helper>
        {{ __('crud.hints.image_limitations', ['formats' => $formats, 'size' => (isset($size) ? Limit::readable()->map()->upload() : Limit::readable()->upload())]) }} @if (isset($recommended)) {{ __('crud.hints.image_dimension', ['dimension' => $recommended]) }} @endif
        @includeWhen(config('services.stripe.enabled'), 'cruds.fields.helpers.share')
    </x-helper>
</div>

