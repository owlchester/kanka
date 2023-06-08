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
?>
<div class="field-image">
    <div class="@if (!empty($imageRequired) && $imageRequired) required @endif">
        <label>{{ __($label) }}</label>
        {!! Form::hidden('remove-image') !!}
    </div>

    <x-grid type="3/4">
        <div class="{{ empty($model->image) && !isset($campaignImage) ? 'col-span-4' : 'col-span-3' }} grid flex-row gap-2">
            <div class="image-file">
                {!! Form::file('image', array('class' => 'image form-control')) !!}
            </div>
            <div class="image-url">
            {!! Form::text('image_url', ((!empty($source) && $source->image) ? $source->getOriginalImageUrl() : ''), ['placeholder' => __('crud.placeholders.image_url'), 'class' => 'form-control']) !!}
                <p class="help-block">
                    {{ __('crud.hints.image_limitations', ['formats' => $formats, 'size' => (isset($size) ? auth()->user()->mapUploadSize(true) : auth()->user()->maxUploadSize(true))]) }}
                    @include('cruds.fields.helpers.share')
                </p>
            </div>
        </div>
        @if (!empty($model->image))
            <div class="preview">
                @include('cruds.fields._image_preview', [
                    'image' => $model->thumbnail(120),
                    'title' => $model->name,
                    'target' => empty($imageRequired) || !$imageRequired ? 'remove-image' : null,
                ])
            </div>
        @elseif (isset($campaignImage) && $campaignImage)
            <div class="preview">
                @include('cruds.fields._image_preview', [
                    'image' => 'https://th.kanka.io/TMUEmOVYU-ClCFa8I5B9pKvhsb4=/280x210/smart/app/backgrounds/mountain-background-medium.jpg',
                    'title' => 'Default',
                ])
            </div>
        @endif
    </x-grid>
</div>
