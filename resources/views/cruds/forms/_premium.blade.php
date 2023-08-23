<div class="field-tooltips mb-5">
    <label>
        {{ __('fields.tooltip.name') }}
    </label>

    @if($campaign->boosted())
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


<div class="field-header mb-5">
    <label>
        {{ __('fields.header-image.title') }}
    </label>

    @if($campaign->boosted())
        @php
        $headerUrlPreset = null;
        if (!empty($source) && $source->entity && $source->entity->header_image) {
            $headerUrlPreset = Storage::url($source->entity->header_image);
        }
        @endphp
        <p class="help-block">{{ __('fields.header-image.description') }}</p>
        {!! Form::hidden('remove-header_image') !!}
        <x-grid type="3/4">
            <div class="@if ((!empty($model->entity) && !empty($model->entity->header_image))) col-span-3 @else col-span-4 @endif">
                <div class="field-header-file mb-2">
                    {!! Form::file('header_image', array('class' => 'image form-control')) !!}
                </div>
                <div class="field-header-url">
                    {!! Form::text('header_image_url', $headerUrlPreset, ['placeholder' => __('crud.placeholders.image_url'), 'class' => 'form-control']) !!}

                    <p class="help-block">
                        {{ __('crud.hints.image_limitations', ['formats' => 'PNG, JPG, GIF, WebP', 'size' => Limit::readable()->upload()]) }}
                        {{ __('crud.hints.image_recommendation', ['width' => '1200', 'height' => '400']) }}
                    </p>
                </div>
            </div>

            @if (!empty($model->entity) && !empty($model->entity->header_image))

                @include('cruds.fields._image_preview', [
                    'image' => $model->entity->thumbnail(120),
                    'title' => $model->name,
                    'target' => 'remove-header_image',
                ])
            @endif

        </x-grid>

        @include('cruds.fields.entity_header')
    @else
        @include('cruds.fields.helpers.boosted', ['key' => 'fields.header-image.boosted-description'])
    @endif
</div>

