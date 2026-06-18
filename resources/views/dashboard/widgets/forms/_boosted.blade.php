<div class="flex flex-col gap-2">
    <p class="">
        {!! __('callouts.premium.multiple', ['campaign' => '<strong>' . $campaign->name . '</strong>']) !!}
    </p>

    
    @can('boost', auth()->user())
        <a href="{{ route('settings.premium', ['campaign' => $campaign]) }}" class="btn2 btn-primary btn-sm">
            {!! __('settings/premium.actions.unlock', ['campaign' => $campaign->name]) !!}
        </a>
    @else
        <a href="{{ route('settings.subscription', ['f' => 'cta', 'w' => $campaign->id]) }}" class="btn2 btn-primary btn-block">
            {{ __('callouts.actions.subscription') }}
        </a>
    @endif

    <a href="https://kanka.io/premium" class="text-neutral-content text-center hover:text-primary text-xs">
        {!! __('callouts.premium.learn-more') !!}
    </a>
    
</div>
