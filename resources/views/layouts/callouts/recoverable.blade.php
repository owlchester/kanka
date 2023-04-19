<p>
    <strong>
        <i class="icon fa-solid fa-rocket mr-2" aria-hidden="true"></i> {{ __('crud.delete_modal.callout') }}
    </strong><br />

    {!! __('crud.delete_modal.recoverable', [
'boosted-campaign' => link_to_route('front.pricing', __('concept.premium-campaign'), '#premium'),
'day' => config('entities.hard_delete')
])!!}
</p>
