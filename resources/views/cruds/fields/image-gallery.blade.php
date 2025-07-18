<?php
if (!isset($entity) && isset($model) && !empty($model->entity)) {
    $entity = $model->entity;
}
elseif (!isset($entity) && isset($source)) {
    $entity = $source instanceof \App\Models\Entity ? $source : $source->child;
}
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
$canBrowse = isset($campaign) && (auth()->user()->can('browse', [\App\Models\Image::class, $campaign]) || auth()->user()->can('create', [\App\Models\Image::class, $campaign]));
$fieldname = $fieldname ?? 'entity_image_uuid';
if (!empty($entity) && !empty($entity->image) && !$canBrowse) {
    ?><input type="hidden" name="{{ $fieldname }}" value="{{ $entity->image_uuid }}" /><?php
    return;
}

$old = isset($entity) && !empty($entity->image_path) || isset($model) && !empty($model->image_path);

?>
@php
    $translations = json_encode([
        'cancel' => __('crud.cancel'),
        'remove' => __('crud.remove'),
        'url' => __('gallery.actions.url'),
        'gallery' => __('gallery.actions.gallery'),
        'unauthorized' => __('gallery.download.errors.unauthorized'),
        'browse' => [
            'title' => __('gallery.browse.title'),
            'layouts' => [
                'small' => __('gallery.browse.layouts.small'),
                'large' => __('gallery.browse.layouts.large'),
            ],
            'search' => [
                'placeholder' => __('gallery.browse.search.placeholder'),
            ],
            'unauthorized' => __('gallery.browse.unauthorized'),
        ],
        'cta_title' => __('gallery.cta.title'),
        'cta_action' => __('gallery.cta.action'),
        'cta_helper' => __('gallery.cta.helper', [
            'premium-campaign' => '<a href="https://kanka.io/premium" target="_blank">' . __('concept.premium-campaign') . '</a>',
            'size' => number_format(config('limits.gallery.premium') / (1024 * 1024), 2)
            ]),
    ]);
@endphp


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
            url="{{ route('gallery.upload.url', [$campaign, $from]) }}"
            accepts="{{ $inputFileTypes }}"
            uuid="{{ $entity->image_uuid ?? $model->image_uuid ??$source->entity->image_uuid ?? null }}"
            field="{{ $fieldname }}"
            thumbnail="{{ $previewThumbnail }}"
            browse="{{ route('gallery.browse', [$campaign]) }}"
            old="{{ $old ? 'true' : 'false' }}"
            i18n="{{ $translations }}"
            premium="{{ $campaign->boosted() ? 'true' : 'false' }}"
            cta="{{ route('settings.premium', ['campaign' => $campaign->id, $from]) }}"
        >
            <x-icon class="load" />
        </gallery-selection>
    </div>

    <x-helper class="text-xs">
        <p>{{ __('crud.hints.image_limitations', ['formats' => $formats, 'size' => (isset($size) ? Limit::readable()->map()->upload() : Limit::readable()->upload())]) }} @if (isset($recommended)) {{ __('crud.hints.image_dimension', ['dimension' => $recommended]) }} @endif
        @includeWhen(config('services.stripe.enabled'), 'cruds.fields.helpers.share')</p>
    </x-helper>
</div>

