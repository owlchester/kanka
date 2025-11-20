<div class="flex flex-col gap-2 items-center">
    <a href="{{ route('settings.subscription', ['f' => 'cta', 'w' => $campaign->id]) }}" class="btn2 btn-primary btn-sm">
        {{ __('callouts.actions.subscription') }}
    </a>

    <a href="https://kanka.io/premium" class="btn2 btn-outline btn-sm">
        {!! __('callouts.premium.learn-more') !!}
    </a>
</div>
