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
        :label="__('entities/tooltips.label')">
        @if($campaign->boosted())
            <x-helper>
                <p>{{ __('entities/tooltips.helper') }}</p>
            </x-helper>

            <textarea name="tooltip" class="" id="tooltip" rows="3" placeholder="{{ __('entities/tooltips.placeholder') }}">{!! old('tooltip', FormCopy::field('tooltip')->string() ?: $entity->tooltip ?? null) !!}</textarea>

            <x-slot name="helper">
                @php
                $tooltipTags = [
                    'text' => '<em>b, i, strong, a, h1-6</em>',
                    'layout' => '<em>p, div, span</em>',
];
                @endphp
                {!! __('entities/tooltips.formatting', $tooltipTags) !!}
            </x-slot>
        @else
            @include('cruds.fields.helpers.boosted', ['key' => 'entities/tooltips.premium'])
        @endif
    </x-forms.field>


    <x-forms.field
        field="header"
        :label="__('fields.header-image.title')">
        @if ($campaign->boosted())
            @php
            $headerUrlPreset = null;

            if (!empty($source) && $source->header_image) {
                $headerUrlPreset = Storage::url($source->header_image);
            } elseif (!empty($source) && $source->header) {
                $headerUrlPreset = $source->header->getUrl(192, 144);
            } elseif (isset($entity) && $entity->header) {
                $headerUrlPreset = $entity->header->getUrl(192, 144);
            }
            @endphp
            <p class="text-neutral-content">{{ __('fields.header-image.description') }}</p>

            @if (isset($entity) && $entity->header_image)
                <input type="hidden" name="remove-header_image" />
                <div class="flex flex-row gap-2">
                    <div class="flex flex-col gap-2 col-span-4">

                    </div>

                    <div class="preview w-32">
                    @include('cruds.fields._image_preview', [
                        'image' => $entity->thumbnail(120),
                        'title' => $entity->name,
                        'target' => 'remove-header_image',
                    ])
                    </div>
                </div>
            @else
                <div class="gallery-selection">
                    <gallery-selection
                        file="{{ route('gallery.upload.file', [$campaign]) }}"
                        url="{{ route('gallery.upload.url', [$campaign]) }}"
                        accepts=".jpg, .jpeg, .png, .gif, .webp"
                        uuid="{{ $source->header_uuid ?? $entity->header_uuid ?? null }}"
                        field="entity_header_uuid"
                        thumbnail="{{ $headerUrlPreset }}"
                        browse="{{ route('gallery.browse', [$campaign]) }}"
                        old="false"
                        i18n="{{ $translations }}"
                        premium="true"
                        cta="{{ route('settings.premium', ['campaign' => $campaign->id]) }}"
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
