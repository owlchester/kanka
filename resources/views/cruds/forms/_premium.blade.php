<?php /** @var \App\Models\Entity $entity */?>

@php
    $translations = json_encode([
        'cancel' => __('crud.actions.cancel'),
        'remove' => __('crud.remove'),
        'url' => __('gallery.actions.url'),
        'gallery' => __('gallery.actions.gallery'),
        'browse' => [
            'title' => __('gallery.browse.title'),
            'layouts' => [
                'small' => __('gallery.browse.layouts.small'),
                'large' => __('gallery.browse.layouts.large'),
            ],
            'search' => [
                'placeholder' => __('gallery.browse.search.placeholder'),
            ],
        ],
    ]);
@endphp

<x-grid type="1/1">
    <x-forms.field
        field="tooltips"
        :label="__('fields.tooltip.name')">
        @if($campaign->boosted())
            <p class="text-neutral-content">
                {{ __('fields.tooltip.description') }}
            </p>

            <textarea name="tooltip" class="" id="tooltip" rows="3" placeholder="{{ __('fields.tooltip.description') }}">{!! FormCopy::entity()->field('tooltip')->string() ?: old('tooltip', $entity->tooltip ?? null) !!}</textarea>

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
        @if ($campaign->boosted())
            @php
            $headerUrlPreset = null;
            if (!empty($source) && $source->entity && $source->entity->header_image) {
                $headerUrlPreset = Storage::url($source->entity->header_image);
            } elseif (!empty($source) && $source->entity && $source->entity->header) {
                $headerUrlPreset = $source->entity->header->getUrl(192, 144);
            } elseif (isset($entity) && $entity->header) {
                $headerUrlPreset = $entity->header->getUrl(192, 144);
            }
            @endphp
            <p class="text-neutral-content">{{ __('fields.header-image.description') }}</p>

            @if (isset($entity) && $entity->header_image)
                <input type="hidden" name="remove-header_image" />
                <div class="flex flex-row gap-2">
                    <div class="flex flex-col gap-2 @if (!empty($headerUrlPreset)) col-span-3 @else col-span-4 @endif">
                        <x-forms.field field="header-file">
                            <input type="file" name="header_image" class="image w-full" id="header_image_{{ rand() }}" accept=".jpg, .jpeg, .png, .gif, .webp" />
                        </x-forms.field>
                        <x-forms.field field="header-url">

                            <input type="text" name="header_image_url" value="{{ old('header_image_url', $headerUrlPreset) }}" maxlength="191" class="w-full"  placeholder="{{ __('crud.placeholders.image_url') }}" />
                            <x-helper>
                                {{ __('crud.hints.image_limitations', ['formats' => 'PNG, JPG, GIF, WebP', 'size' => Limit::readable()->upload()]) }}
                                {{ __('crud.hints.image_dimension', ['dimension' => '1200x400']) }}
                            </x-helper>
                        </x-forms.field>
                    </div>

                    @if (!isset($entity) && !empty($entity->entity->header_image))

                        <div class="preview w-32">
                        @include('cruds.fields._image_preview', [
                            'image' => $entity->thumbnail(120),
                            'title' => $entity->name,
                            'target' => 'remove-header_image',
                        ])
                        </div>
                    @endif
                </div>
                @include('cruds.fields.entity_header')
            @else
                <div class="gallery-selection">
                    <gallery-selection
                        file="{{ route('gallery.upload.file', [$campaign]) }}"
                        url="{{ route('gallery.upload.url', [$campaign]) }}"
                        accepts=".jpg, .jpeg, .png, .gif, .webp"
                        uuid="{{ $source->entity->header_uuid ?? $entity->header_uuid ?? null }}"
                        field="entity_header_uuid"
                        thumbnail="{{ $headerUrlPreset }}"
                        browse="{{ route('gallery.browse', [$campaign]) }}"
                        old="false"
                        i18n="{{ $translations }}"
                    >
                        <x-icon class="load" />
                    </gallery-selection>
                </div>
            @endif
        @else
            @include('cruds.fields.helpers.boosted', ['key' => 'fields.header-image.boosted-description'])
        @endif
    </x-forms.field>
</x-grid>
