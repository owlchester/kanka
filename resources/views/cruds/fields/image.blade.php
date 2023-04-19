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
<div class="@if (!empty($imageRequired) && $imageRequired) required @endif">
<label>{{ __($label) }}</label>
{!! Form::hidden('remove-image') !!}
</div>

<div class="row">
    <div class="{{ empty($model->image) && !isset($campaignImage) ? 'col-md-12' : 'col-md-10' }}">
        <div class="form-group">
            {!! Form::file('image', array('class' => 'image form-control')) !!}
        </div>
        <div class="form-group">
        {!! Form::text('image_url', ((!empty($source) && $source->image) ? $source->getOriginalImageUrl() : ''), ['placeholder' => __('crud.placeholders.image_url'), 'class' => 'form-control']) !!}
            <p class="help-block">
                {{ __('crud.hints.image_limitations', ['formats' => $formats, 'size' => (isset($size) ? auth()->user()->mapUploadSize(true) : auth()->user()->maxUploadSize(true))]) }}
                @include('cruds.fields.helpers.share')
            </p>
        </div>
    </div>
    @if (!empty($model->image))
    <div class="col-md-2">
        @include('cruds.fields._image_preview', [
            'image' => $model->thumbnail(120),
            'title' => $model->name,
            'target' => empty($imageRequired) || !$imageRequired ? 'remove-image' : null,
        ])
    </div>
    @elseif (isset($campaignImage) && $campaignImage)
        <div class="col-md-2">
            @include('cruds.fields._image_preview', [
                'image' => 'https://images.kanka.io/app/L5nSYCLgwtxR3wlUGk16fMZ0zAU=/280x210/src/images%2Fbackgrounds%2Fmountain-background-medium.jpg',
                'title' => 'Default',
            ])
        </div>
    @endif
</div>
