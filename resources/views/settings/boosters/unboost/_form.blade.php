<x-grid type="1/1">
    <p class="">
        {!! __('settings/boosters.unboost.warning', [
    'action' => $campaign->superboosted() ? __('settings/boosters.unboost.status.superboosting') : __('settings/boosters.unboost.status.boosting'),
    'campaign' => '<strong>' . $campaign->name . '</strong>'])!!}
    </p>
</x-grid>
