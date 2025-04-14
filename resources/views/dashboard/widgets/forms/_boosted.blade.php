<div class="flex gap-2 items-center align-center">
    <div class="flex-0">
        @include ('partials.boost_icon')
    </div>
    <div>
        <p class="">{{ __('callouts.premium.multiple') }}</p>

        @if (auth()->user()->hasBoosters())
            <a href="{{ route('settings.premium', ['campaign' => $campaign]) }}" class="btn2 bg-boost text-white btn-sm">
                {!! __('settings/premium.actions.unlock', ['campaign' => $campaign->name]) !!}
            </a>
        @else
            <a href="{{ \App\Facades\Domain::toFront('premium') }}" class="btn2 bg-boost text-white btn-sm">
                {!! __('callouts.premium.learn-more') !!}
            </a>
        @endif
    </div>
</div>
