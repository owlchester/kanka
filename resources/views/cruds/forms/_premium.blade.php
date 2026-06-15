<?php /** @var \App\Models\Entity $entity */?>

@php
    $formats = 'PNG, JPG, GIF, WebP';
    $max = 25;
    $translations = json_encode([
        'cancel' => __('crud.cancel'),
        'remove' => __('crud.remove'),
        'url' => __('gallery.actions.url'),
        'gallery' => __('gallery.actions.gallery'),
        'upload'    => __('gallery.actions.upload'),
        'add_url'   => __('gallery.actions.add_url'),
        'change'    => __('gallery.actions.change'),
        'url_hint'  => __('gallery.actions.url_hint'),
        'drag_hint' => __('gallery.drop.hint'),
        'drop_hint' => __('gallery.drop.active'),
        'formats'   => $formats . ' · max ' . $max . ' MB',
        'unauthorized' => __('gallery.download.errors.unauthorized'),
        'browse' => [
            'title'        => __('gallery.browse.title'),
            'folder_count'     => __('gallery.browse.folder_count'),
            'folder_count_one' => __('gallery.browse.folder_count_one'),
            'layouts' => [
                'small' => __('gallery.browse.layouts.small'),
                'large' => __('gallery.browse.layouts.large'),
            ],
            'search' => [
                'placeholder' => __('gallery.browse.search.placeholder'),
                'results'     => __('gallery.browse.search.results'),
                'no_results'  => __('gallery.browse.search.no_results'),
                'try_again'   => __('gallery.browse.search.try_again'),
            ],
            'unauthorized' => __('gallery.browse.unauthorized'),
        ],
        'cta_title' => __('gallery.cta.title'),
        'cta_action' => __('gallery.cta.action'),
        'cta_helper' => __('gallery.cta.helper', [
            'premium-campaign' => '<a href="https://kanka.io/premium" class="text-link">' . __('concept.premium-campaign') . '</a>',
            'size' => \Illuminate\Support\Number::format(config('limits.gallery.premium') / (1024 * 1024), 2)
            ]),
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
                @php
                    $canUpload = isset($campaign) && auth()->user()->can('create', [\App\Models\Image::class, $campaign]);
                    $canBrowse = isset($campaign) && auth()->user()->can('browse', [\App\Models\Image::class, $campaign]);

                @endphp
                <div class="gallery-selection w-fit">
                    <gallery-selection
                        file="{{ route('gallery.upload.file', [$campaign]) }}"
                        url="{{ route('gallery.upload.url', [$campaign]) }}"
                        accepts=".jpg, .jpeg, .png, .gif, .webp"
                        uuid="{{ $source->header_uuid ?? $entity->header_uuid ?? null }}"
                        field="entity_header_uuid"
                        thumbnail="{{ $headerUrlPreset }}"
                        browse="{{ route('gallery.browse', [$campaign]) }}"
                        can-upload="{{ $canUpload ? 'true' : 'false' }}"
                        can-browse="{{ $canBrowse ? 'true' : 'false' }}"
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
