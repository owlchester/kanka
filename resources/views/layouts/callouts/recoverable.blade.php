<p class="text-neutral-content">
    {!! __('confirm.delete.recoverable', [
        'premium-campaign' => '<a href="' . \App\Facades\Domain::toFront('premium') . '">' . __('concept.premium-campaign') . '</a>',
        'day' => '<span class="amount">' . config('entities.hard_delete') . '</span>'
    ])!!}
</p>
