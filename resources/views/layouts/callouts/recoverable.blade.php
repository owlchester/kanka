<div class="flex flex-col gap-2">
    <div class="text-lg">
        <x-icon class="fa-solid fa-rocket"></x-icon>
        {{ __('crud.delete_modal.callout') }}
    </div>

    <div>{!! __('crud.delete_modal.recoverable', [
'boosted-campaign' => link_to(Domain::toFront('pricing'), __('concept.premium-campaign'), '#premium'),
'day' => config('entities.hard_delete')
])!!}</div>
</div>
