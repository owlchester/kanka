<div class="flex flex-col gap-2">
    <div class="text-lg">
        <x-icon class="premium" />
        {{ __('crud.delete_modal.callout') }}
    </div>

    <div>{!! __('crud.delete_modal.recoverable', [
'boosted-campaign' => '<a href="' . \App\Facades\Domain::toFront('premium') . '" target="_blank">' . __('concept.premium-campaigns') . '</a>',
'day' => config('entities.hard_delete')
])!!}</div>
</div>
