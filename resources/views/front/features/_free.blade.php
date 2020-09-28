<div class="feature-item">
    <i class="fas fa-gift text-primary"></i>
    <h3>{{ __('front.features.free.title') }}</h3>
    <p class="text-muted">{!! __('front.features.free.description', [
        'bonuses' => link_to_route('front.pricing', __('front.features.free.bonuses'), ['#paid-features']),
    ]) !!}</p>
</div>
