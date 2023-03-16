
<div class="booster-icon rounded-full">
    <i class="fa-solid fa-rocket fa-2x" aria-hidden="true"></i>
</div>

@if (isset($superboost))
    <h4>{{ __('callouts.booster.titles.superboosted') }}</h4>
@else
    <h4>{{ __('callouts.booster.titles.boosted') }}</h4>
@endif

@foreach ($texts as $text)
    <p class="mb-5">{!! $text !!}</p>
@endforeach

@if (isset($cta))
    <p class="mb-5">{!! $cta !!}</p>
@else
    <p class="mb-5">{{ __('callouts.booster.limitation') }}</p>
@endif


@subscriber()
    @if (isset($superboost))
        <a href="{{ route('settings.boost', ['campaign' => $campaign, 'superboost' => true]) }}" class="btn bg-maroon rounded-full px-8">
            {!! __('callouts.booster.actions.superboost', ['campaign' => $campaign->name]) !!}
        </a>
    @else
        <a href="{{ route('settings.boost', ['campaign' => $campaign]) }}" class="btn bg-maroon rounded-full px-8">
            {!! __('callouts.booster.actions.boost', ['campaign' => $campaign->name]) !!}
        </a>
    @endif
@else
    <a href="{{ route('front.boosters') }}" target="_blank" class="btn bg-maroon rounded-full px-8">
        {!! __('callouts.booster.learn-more') !!}
    </a>
@endif
