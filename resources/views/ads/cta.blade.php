<x-ad section="leaderboard" :campaign="isset($campaign) ? $campaign : null">

    @php $amount = auth()->check() && auth()->user()->currency() === 'brl' ? 20 : 5; @endphp
    <p class="italic mb-4 mx-4">
        {!! __('misc.ads.remove_v5', [
        'amount' => $amount,
        'currency' => auth()->check() ? auth()->user()->currencySymbol() : '$',
        'premium' =>  __('concept.premium-campaigns'),
        ]) !!}
        <a href="{{ route('settings.subscription') }}">
            {{ __('misc.ads.member') }}
        </a>
    </p>
</x-ad>
