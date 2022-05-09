<div class="feature-item">
    <i class="fa-solid fa-lock text-primary"></i>
    <h3>{{ __('front.features.public.title') }}</h3>
    <p class="text-muted">{!! __('front.features.public.description', ['url' => route('front.public_campaigns')]) !!}</p>

    <a href="{{ route('front.features.permissions') }}">{{ __('front.features.learn_more_about') }}</a>
</div>
