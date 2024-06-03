<x-grid type="1/1">
    <x-forms.field
        field="tooltips"
        :label="__('fields.tooltip.name')">
        @if($campaign->boosted())
            <p class="text-neutral-content">
                {{ __('fields.tooltip.description') }}
            </p>

        <textarea name="entity_tooltip" class="" id="tooltip" rows="3" placeholder="{{ __('fields.tooltip.description') }}">{!! FormCopy::entity()->field('tooltip')->string() ?: old('entity_tooltip', $model->entity_tooltip ?? null) !!}</textarea>


            <p class="text-neutral-content">
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
    </x-forms.field>


    <x-forms.field
        field="header"
        :label="__('fields.header-image.title')">
        @if($campaign->boosted())
            @php
            $headerUrlPreset = null;
            if (!empty($source) && $source->entity && $source->entity->header_image) {
                $headerUrlPreset = Storage::url($source->entity->header_image);
            }
            @endphp
            <p class="text-neutral-content">{{ __('fields.header-image.description') }}</p>
            <input type="hidden" name="remove-header_image" />
            <div class="flex flex-row gap-2">
                <div class="flex flex-col gap-2 @if ((!empty($model->entity) && !empty($model->entity->header_image))) col-span-3 @else col-span-4 @endif">
                    <x-forms.field field="header-file">
                        {!! Form::file('header_image', array('class' => 'image')) !!}
                    </x-forms.field>
                    <x-forms.field field="header-url">
                        {!! Form::text('header_image_url', $headerUrlPreset, ['placeholder' => __('crud.placeholders.image_url'), 'class' => '']) !!}

                        <x-helper>
                            {{ __('crud.hints.image_limitations', ['formats' => 'PNG, JPG, GIF, WebP', 'size' => Limit::readable()->upload()]) }}
                            {{ __('crud.hints.image_dimension', ['dimension' => '1200x400']) }}
                        </x-helper>
                    </x-forms.field>
                </div>

                @if (!empty($model->entity) && !empty($model->entity->header_image))

                    <div class="preview w-32">
                    @include('cruds.fields._image_preview', [
                        'image' => $model->entity->thumbnail(120),
                        'title' => $model->name,
                        'target' => 'remove-header_image',
                    ])
                    </div>
                @endif
            </div>
            @include('cruds.fields.entity_header')
        @else
            @include('cruds.fields.helpers.boosted', ['key' => 'fields.header-image.boosted-description'])
        @endif
    </x-forms.field>
</x-grid>
