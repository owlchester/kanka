<div class="flex flex-col sm:flex-row gap-3 flex-wrap">
    <a href="https://kanka.io/premium" class="btn2 btn-outline btn-sm">
        {!! __('callouts.premium.learn-more') !!}
    </a>
    <a href="{{ route('settings.subscription', ['f' => 'cta', 'w' => $campaign->id]) }}" class="btn2 bg-boost text-white btn-sm">
        {{ __('callouts.actions.subscription') }}
    </a>
</div>
