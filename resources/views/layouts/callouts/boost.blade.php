
<div class="grid gap-5 grid-cols-1 lg:grid-cols-2 booster-block">
    <div class="">
        <div class="booster-callout">
            <div class="booster-icon">
                <i class="fa-solid fa-rocket fa-2x" aria-hidden="true"></i>
            </div>
            <h4>{{ __('callouts.booster.title') }}</h4>
            @foreach ($texts as $text)
                <p>{!! $text !!}</p>
            @endforeach

            @subscriber()
            <a href="{{ route('settings.boost', ['campaign' => $campaign->campaign()]) }}" class="btn bg-maroon btn-lg">
                {!! __('callouts.booster.actions.boost', ['campaign' => $campaign->campaign()->name]) !!}
            </a>
            @else
                <p>{{ __('callouts.booster.limitation') }}</p>
                <a href="{{ route('front.boosters') }}" target="_blank" class="btn bg-maroon btn-lg">
                    {!! __('callouts.booster.learn-more') !!}
                </a>
            @endif
        </div>
    </div>
    <div class="">
        @include('partials.images.boosted-image')
    </div>
</div>
