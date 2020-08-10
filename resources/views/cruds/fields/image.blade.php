<?php
/**
 * Options:
 * bool $imageRequired set to true if the image is required and can't be removed
 */
?>
<div class="@if (!empty($imageRequired) && $imageRequired) required @endif">
<label>{{ __('crud.fields.image') }}</label>
{!! Form::hidden('remove-image') !!}
</div>

<div class="row">
    <div class="{{ empty($model->image) ? 'col-md-12' : 'col-md-10' }}">
        <div class="form-group">
            {!! Form::file('image', array('class' => 'image form-control')) !!}
        </div>
        <div class="form-group">
            {!! Form::text('image_url', null, ['placeholder' => __('crud.placeholders.image_url'), 'class' => 'form-control']) !!}

            <p class="help-block">
                {{ __('crud.hints.' . (isset($size) && $size == 'map' ? 'map' : 'image') . '_limitations', ['size' => auth()->user()->maxUploadSize(true, (isset($size) ? $size : 'image'))]) }}
                @if (!auth()->user()->hasRole('patreon') && !\App\Facades\CampaignLocalization::getCampaign()->boosted())
                    <a href="{{ route('settings.subscription') }}">{{ __('crud.hints.image_patreon') }}</a>
                @endif
            </p>
        </div>
    </div>
    @if (!empty($model->image))
    <div class="col-md-2">
        <div class="preview-v2">
            <div class="image" style="background-image: url('{{ $model->getImageUrl(200, 120) }}')" title="{{ $model->name }}">
                @if (empty($imageRequired) || !$imageRequired)
                <a href="#" class="img-delete" data-target="remove-image" title="{{ __('crud.remove') }}">
                    <i class="fa fa-trash"></i> {{ __('crud.remove') }}
                </a>
                @endif
            </div>
        </div>
    </div>
    @endif
</div>
