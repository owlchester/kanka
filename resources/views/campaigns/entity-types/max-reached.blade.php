
@if ($limit >= config('limits.campaigns.modules.elemental'))
    <p class="p-5">{!! __('campaigns/modules.errors.limit', ['max' => '<code>' . $limit . '</code>']) !!}</p>
@else
    <x-dialog.header>
        {{ __('campaigns/modules.errors.limit-title') }}
    </x-dialog.header>
    <x-dialog.article class="max-w-3xl">
        <x-helper>
            @if ($isPremiumUnlocker)
                <p>{{ __('campaigns/modules.errors.subscription-upgrade', [
                    'wyvern' => config('limits.campaigns.modules.wyvern'),
                    'elemental' => config('limits.campaigns.modules.elemental'),
                ]) }}</p>
                <a href="{{ route('settings.subscription') }}" class="text-link">
                    {{ __('callouts.actions.subscription') }}
                </a>
            @else
                <p>{{ __('campaigns/modules.errors.subscription-limit') }}</p>
            @endif
        </x-helper>
    </x-dialog.article>
@endif
