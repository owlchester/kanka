<x-dialog.header>
    @if ($campaign->superboosted())
        {{ __('entities/files.call-to-action.max.limit') }}
    @else
        {!! __('entities/files.call-to-action.upgrade.limit', ['limit' => config('limits.campaigns.files.standard')]) !!}
    @endif
</x-dialog.header>
<x-dialog.article class="max-w-3xl">
    @if ($campaign->superboosted())
        <x-helper>
            <p>{{ __('entities/files.call-to-action.max.helper') }}</p>
        </x-helper>
    @else
        <x-helper>
            <p>
                {!! __('entities/files.call-to-action.upgrade.upgrade', ['limit' => '<strong>' . config('limits.campaigns.files.premium') . '</strong>']) !!}
            </p>
        </x-helper>
        <x-premium-cta-footer :campaign="$campaign" />
    @endif
</x-dialog.article>
