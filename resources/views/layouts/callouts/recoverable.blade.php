<p>
    <strong>
        <x-icon class="fa-solid fa-rocket"></x-icon>
        {{ __('crud.delete_modal.callout') }}
    </strong><br />

    {!! __('crud.delete_modal.recoverable', [
'boosted-campaign' => link_to('https://kanka.io/pricing', __('concept.premium-campaign'), '#premium'),
'day' => config('entities.hard_delete')
])!!}
</p>
