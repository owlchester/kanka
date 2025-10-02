@extends('layouts.whiteboard', [
    'title' => $whiteboard->name,
    'breadcrumbs' => false,
    'mainTitle' => false,
])

@section('content')
    @php
        $translations = json_encode([
            'cancel' => __('crud.cancel'),
            'remove' => __('crud.remove'),
            'url' => __('gallery.actions.url'),
            'gallery' => __('gallery.actions.gallery'),
            'unauthorized' => __('gallery.download.errors.unauthorized'),
            'browse' => [
                'title' => __('gallery.browse.title'),
                'layouts' => [
                    'small' => __('gallery.browse.layouts.small'),
                    'large' => __('gallery.browse.layouts.large'),
                ],
                'search' => [
                    'placeholder' => __('gallery.browse.search.placeholder'),
                ],
                'unauthorized' => __('gallery.browse.unauthorized'),
            ],
            'cta_title' => __('gallery.cta.title'),
            'cta_action' => __('gallery.cta.action'),
            'cta_helper' => __('gallery.cta.helper', [
                'premium-campaign' => '<a href="https://kanka.io/premium" target="_blank">' . __('concept.premium-campaign') . '</a>',
                'size' => number_format(config('limits.gallery.premium') / (1024 * 1024), 2)
                ]),
        ]);
        @endphp
    <div id="whiteboard">
        <whiteboard
            save="{{ route('whiteboards.save-draw', [$campaign, $whiteboard]) }}"
            load="{{ route('whiteboards.api', [$campaign, $whiteboard]) }}"
            gallery="{{ route('gallery.browse', $campaign) }}"
            search="{{ route('search.live', $campaign) }}"
            i18n="{{ $translations }}"
        />
    </div>

@endsection
