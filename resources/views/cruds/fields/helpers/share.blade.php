@php $currentCampaign = \App\Facades\CampaignLocalization::getCampaign(false); @endphp
@subscriber()
    @if ($currentCampaign && !$currentCampaign->boosted())
        @if (auth()->check() && auth()->user()->hasBoosterNomenclature())
            <p>
                <a href="{{ route('settings.boost', ['campaign' => $currentCampaign]) }}">
                    <x-icon class="premium"></x-icon>
                    {!! __('callouts.subscribe.share-booster', ['campaign' => $currentCampaign->name]) !!}
                </a>
            </p>
        @else
            <p>
                <a href="{{ route('settings.premium', ['campaign' => $currentCampaign]) }}">
                    <x-icon class="premium"></x-icon>
                    {!! __('callouts.subscribe.share-premium', ['campaign' => $currentCampaign->name]) !!}
                </a>
            </p>
        @endif
    @endif
@else
    <a href="{{ route('front.pricing') }}">{{ __('callouts.subscribe.pitch-image', ['max' => $max]) }}</a>
@endif