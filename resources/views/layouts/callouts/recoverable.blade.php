<x-helper>
    @if ($campaign->boosted())
        <p>
            {!! __('confirm.delete.recover', [
                'recover' => '<a href="' . route('recovery', [$campaign]) . '" class="text-link">' . __('campaigns.show.tabs.recovery') . '</a>',
                'day' => '<span class="amount">' . config('entities.hard_delete') . '</span>'
            ])!!}
        </p>
    @else
        <p>
            {!! __('confirm.delete.recoverable', [
                'premium-campaign' => '<a href="' . \App\Facades\Domain::toFront('premium') . '" class="text-link">' . __('concept.premium-campaign') . '</a>',
                'day' => '<span class="amount">' . config('entities.hard_delete') . '</span>'
            ])!!}
        </p>
    @endif
</x-helper>
