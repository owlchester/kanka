
<div class="booster-icon">
    <i class="fa-solid fa-rocket fa-2x" aria-hidden="true"></i>
</div>

<h4>{{ __('callouts.booster.title') }}</h4>

@foreach ($texts as $text)
    <p class="mb-5">{!! $text !!}</p>
@endforeach

<p class="mb-5">{{ __('callouts.booster.limitation') }}</p>

@subscriber()
<a href="{{ route('settings.boost', ['campaign' => $campaign]) }}" class="btn bg-maroon rounded-full px-8">
    {!! __('callouts.booster.boost', ['campaign' => $campaign->name]) !!}
</a>
@else
    <a href="{{ route('front.boosters') }}" target="_blank" class="btn bg-maroon rounded-full px-8">
        {!! __('callouts.booster.learn-more') !!}
    </a>
@endif
