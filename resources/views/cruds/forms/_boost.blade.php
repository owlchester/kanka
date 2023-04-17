<div class="form-group">
    <label>
        <i class="fa-solid fa-rocket" title="{{ __('crud.tooltips.boosted_feature') }}" data-toggle="tooltip"></i>
        {{ __('fields.tooltip.name') }}
    </label>

    @if($campaignService->campaign()->boosted())
    <p class="help-block">
        {{ __('fields.tooltip.description') }}
    </p>

        {!! Form::textarea('entity_tooltip', FormCopy::entity()->field('tooltip')->string(), ['class' => 'form-control', 'id' => 'tooltip', 'rows' => 3, 'placeholder' => __('fields.tooltip.description')]) !!}

        <p class="help-block">
@php
$tooltipTags = [];
foreach (config('purify.configs.tooltips.allowed') as $tag) {
    $tooltipTags[] = '<code>'. $tag . '</code> ';
}
$tooltipTags = implode(', ', $tooltipTags);
            @endphp
            {!! __('fields.tooltip.helper', ['tags' => $tooltipTags]) !!}
        </p>
    @else
        @include('cruds.fields.helpers.boosted', ['key' => 'fields.tooltip.boosted-description'])
    @endif

</div>


<div class="form-group">
    <label>
        <i class="fa-solid fa-rocket" title="{{ __('crud.tooltips.boosted_feature') }}" data-toggle="tooltip" aria-hidden="true"></i>
        {{ __('fields.header-image.title') }}
    </label>

    @if($campaignService->campaign()->boosted())
        @php
        $headerUrlPreset = null;
        if (!empty($source) && $source->entity && $source->entity->header_image) {
            $headerUrlPreset = Storage::url($source->entity->header_image);
        }
        @endphp
        <div class="row">
            <div class="col-lg-6">
            <p class="help-block">{{ __('fields.header-image.description') }}</p>

            {!! Form::hidden('remove-header_image') !!}

            <div class="row">
                <div class="col-md-10">
                    <div class="form-group">
                        {!! Form::file('header_image', array('class' => 'image form-control')) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::text('header_image_url', $headerUrlPreset, ['placeholder' => __('crud.placeholders.image_url'), 'class' => 'form-control']) !!}

                        <p class="help-block">
                            {{ __('crud.hints.image_limitations', ['formats' => 'PNG, JPG, GIF, WebP', 'size' => auth()->user()->maxUploadSize(true)]) }}
                            {{ __('crud.hints.image_recommendation', ['width' => '1200', 'height' => '400']) }}
                        </p>
                    </div>

                </div>
                <div class="col-md-2">
                    @if (!empty($model->entity) && !empty($model->entity->header_image))

                        @include('cruds.fields._image_preview', [
                            'image' => $model->entity->thumbnail(120),
                            'title' => $model->name,
                            'target' => 'remove-header_image',
                        ])
                    @endif
                </div>
            </div>
            </div>
            <div class="col-lg-6">
                @include('cruds.fields.entity_header')
            </div>
        </div>
    @else
        @include('cruds.fields.helpers.boosted', ['key' => 'fields.header-image.boosted-description'])
    @endif
</div>

@include('cruds.fields.entity_image')

