<div class="feature-item">
    <i class="fa-solid fa-flask text-primary"></i>
    <h3>{{ __('front.features.api.title') }}</h3>
    <p class="text-muted text-justify">{!! __('front.features.api.description', ['link'
        => link_to('/docs/1.0', __('front.features.api.link')),
        'kanka' => config('app.name')
    ]) !!}</p>
</div>
