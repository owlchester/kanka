<?php
/**
 * Options:
 * bool $imageRequired set to true if the image is required and can't be removed
 */
$formats = 'PNG, JPG, GIF, WebP';
$inputFileTypes = '.jpg, .jpeg, .png, .gif, .webp';
$max = 25;
if (isset($size) && $size == 'map') {
    $formats = 'PNG, JPG, SVG, WebP';
    $inputFileTypes = '.jpg, .jpeg, .png, .gif, .webp, .svg';
    $max = 50;
}
$label = $imageLabel ?? 'crud.fields.image';

$previewThumbnail = null;
$canDelete = true;
if (!empty($model->entity) && !empty($model->entity->image_uuid) && !empty($model->entity->image)) {
    $previewThumbnail = $model->entity->image->getUrl(192, 144);
    $canDelete = false;
} elseif (!empty($entity) && !empty($entity->image_path)) {
    $previewThumbnail = Avatar::entity($entity)->size(192, 144)->thumbnail();
} elseif (isset($model) && method_exists($model, 'thumbnail') && !empty($model->image)) {
    $previewThumbnail = $model->thumbnail(200, 160);
}

// If the image is from the gallery and the user can't browse or upload, disable the field
$canBrowse = isset($campaign) && auth()->user()->can('browse', [\App\Models\Image::class, $campaign]);
if (!empty($model->entity) && !empty($model->entity->image) && !$canBrowse) {
    ?><input type="hidden" name="entity_image_uuid" value="{{ $model->entity->image_uuid }}" /><?php
                                                                                                   return;
                                                                                               }
                                                                                               ?>
<input type="hidden" name="remove-image" />
<div class="field field-image flex flex-col gap-1 col-span-2 @if (!empty($imageRequired) && $imageRequired) required @endif">

    <label>{{ __($label) }}</label>

    <div class="flex flex-row gap-2">
        <div class="grow flex flex-col gap-2 w-full">
            <div class="image-file field">
                <input type="file" name="image" class="image w-full" id="image_field_{{ rand() }}" accept="{{ $inputFileTypes }}" />
            </div>
            <div class="image-url field">
                <input type="text" name="image_url" value="{{ old('image_url', ((!empty($source) && $source->entity->image_path) ? Avatar::entity($source->entity)->original() : '')) }}" placeholder="{{ __('crud.placeholders.image_url') }}" class="w-full" />
            </div>

            @php
                $preset = null;
                if (isset($model) && $model->entity && $model->entity->image_uuid) {
                    $preset = $model->entity->image;
                } else {
                    $preset = FormCopy::field('image')->select();
                }
            @endphp
            @if (isset($campaign) && (!isset($campaignImage) || !$campaignImage) && !isset($gallery))
                <x-forms.foreign
                    :campaign="$campaign"
                    name="entity_image_uuid"
                    label=""
                    :allowClear="true"
                    :route="route('images.find', $campaign)"
                    :placeholder="__('fields.gallery.placeholder')"
                    :dropdownParent="$dropdownParent ?? null"
                    :selected="$preset">
                </x-forms.foreign>
                @if (!empty($model->entity) && !empty($model->entity->image_uuid) && empty($model->entity->image))
                    <input type="hidden" name="entity_image_uuid" value="{{ $model->entity->image_uuid }}" />
                @endif
            @endif
        </div>
        @if (!empty($previewThumbnail))
            <div class="preview w-32">
                @include('cruds.fields._image_preview', [
                    'image' => $previewThumbnail,
                    'title' => $model->name,
                    'target' => !isset($removable) && $canDelete && (empty($imageRequired) || !$imageRequired) ? 'remove-image' : null,
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

    <x-helper>
        {{ __('crud.hints.image_limitations', ['formats' => $formats, 'size' => (isset($size) ? Limit::readable()->map()->upload() : Limit::readable()->upload())]) }} @if (isset($recommended)) {{ __('crud.hints.image_dimension', ['dimension' => $recommended]) }} @endif
        @includeWhen(config('services.stripe.enabled'), 'cruds.fields.helpers.share')
    </x-helper>
</div>
