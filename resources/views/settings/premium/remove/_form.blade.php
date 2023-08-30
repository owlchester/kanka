<x-grid type="1/1">
    <p class="m-0">
    @if ($boost->inCooldown())
        {!! __('settings/premium.remove.cooldown', [
            'campaign' => '<strong>' . $campaign->name . '</strong>',
            'date' => $boost->created_at->addDays(7)->diffForHumans()
        ])!!}
    @else
        {!! __('settings/premium.remove.warning', [
        'campaign' => '<strong>' . $campaign->name . '</strong>']) !!}
    @endif
    </p>
</x-grid>
