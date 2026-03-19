<div {{ $attributes->merge(['class' => 'flex flex-col gap-2 w-full' . (request()->ajax() ? ' p-4 md:p-6' : null)]) }}>
    <a href="{{ route('settings.subscription', ['f' => 'cta', 'w' => $campaign->id]) }}" class="btn2 btn-primary btn-block">
        {{ __('callouts.actions.subscription') }}
    </a>

    <div class="text-center">
        <a href="https://kanka.io/premium" class="text-neutral-content hover:text-link text-xs">
            {!! __('callouts.premium.learn-more') !!}
        </a>
    </div>
</div>
